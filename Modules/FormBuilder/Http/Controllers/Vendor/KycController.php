<?php

namespace Modules\FormBuilder\Http\Controllers\Vendor;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Modules\FormBuilder\Entities\Form;
use Modules\FormBuilder\Entities\Submission;
use Modules\FormBuilder\Services\Helper;
use Throwable;

class KycController extends Controller
{
    /**
     * Show KYC form in vendor dashboard
     *
     * @return Renderable
     */
    public function userKycForm(Request $request)
    {
        $form = Form::kyc()->first();
        $submission = Submission::where('form_id', $form->id)->where('user_id', auth()->id())->first();
        if ($submission && ! $request->edit || $form->allows_edit == 0) {
            $form_headers = $submission->form->getEntriesHeader();

            return view('formbuilder::kyc.submission', compact('submission', 'form_headers', 'form'));
        } elseif ($form->allows_edit == 1 && $submission && $request->edit) {
            $submission->loadSubmissionIntoFormJson();

            return view('formbuilder::kyc.sub-edit', compact('submission'));
        }

        return view('formbuilder::kyc.show', compact('form'));
    }

    /**
     * Process the form submission
     *
     * @param  string  $identifier
     * @return Response
     */
    public function userKycSubmit(Request $request, $identifier)
    {
        $form = Form::where('identifier', $identifier)->firstOrFail();

        DB::beginTransaction();

        try {
            $input = $request->except('_token');

            // check if files were uploaded and process them
            $uploadedFiles = $request->allFiles();
            foreach ($uploadedFiles as $key => $file) {
                $validate = \Validator::make($request->all(), [
                    $key => 'max:1024',
                ])->fails();

                if ($validate) {
                    throw new \Exception(__('File size must be less than 1MB'));
                }

                // store the file and set it's path to the value of the key holding it
                if ($file->isValid()) {
                    $input[$key] = $file->store('form', ['disk' => 'public-folder']);
                }
            }

            $user_id = auth()->user()->id ?? null;

            $form->submissions()->create([
                'user_id' => $user_id,
                'content' => $input,
            ]);

            DB::commit();

            return back()->with('success', __('Form successfully submitted.'));
        } catch (Throwable $e) {
            info($e);

            DB::rollback();

            return back()->withInput()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    /**
     * Update KYC Submission Data
     *
     * @param  Request  $request
     * @param  Submission  $submission
     * @return bool
     */
    public function updateSubmission($request, $submission)
    {
        DB::beginTransaction();

        try {

            $input = $request->except(['_token', '_method']);

            // check if files were uploaded and process them
            $uploadedFiles = $request->allFiles();
            foreach ($uploadedFiles as $key => $file) {
                // store the file and set it's path to the value of the key holding it
                if ($file->isValid()) {
                    $input[$key] = $file->store('form', ['disk' => 'public-folder']);
                }
            }

            $submission->loadSubmissionIntoFormJson();

            $files = $submission->form->form_builder_json->where('type', 'file')->pluck('value', 'name');
            // Fill the empty fields with the existing previous data
            foreach ($files as $key => $value) {
                if (! isset($input[$key])) {
                    $input[$key] = $value;
                }
            }

            $submission->update(['content' => $input]);

            DB::commit();

            return true;
        } catch (Throwable $e) {
            info($e);

            DB::rollback();

            return false;
        }
    }

    /**
     * Update vendor KYC information
     *
     * @param  int  $id
     * @return redirect()
     */
    public function userKycUpdateSubmission(Request $request, $id)
    {
        $submission = Submission::where(['user_id' => auth()->id(), 'id' => $id])->firstOrFail();

        if (! $submission) {
            return back()->withErrors(__('Submission not found.'));
        }

        $form = Form::kyc()->first();

        if ($form->allows_edit == 0) {
            return back()->with('fail', __('Form is not editable.'));
        }

        $update = $this->updateSubmission($request, $submission);

        if ($update) {
            return redirect()->route('kyc.user.show')->with('success', __('Submission updated.'));
        }

        return back()->withInput()->withErrors(Helper::wtf());
    }
}
