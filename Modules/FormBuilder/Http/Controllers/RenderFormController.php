<?php

namespace Modules\FormBuilder\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\FormBuilder\Entities\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\FormBuilder\Entities\Submission;
use Throwable;

class RenderFormController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('public-form-access');
    }

    /**
     * Render the form so a user can fill it
     *
     * @param  string  $identifier
     * @return Response
     */
    public function render($identifier)
    {
        $form = Form::where('identifier', $identifier)->firstOrFail();
        if ($form->allows_edit == 0) {
            return view('formbuilder::render.index', compact('form'));
        }

        $user = auth()->id();

        if (! $user) {
            return view('formbuilder::render.index', compact('form'));
        }
        $submission = Submission::where('form_id', $form->id)->where('user_id', $user)->first();

        if (! $submission) {
            return view('formbuilder::render.index', compact('form'));
        }
        $form_headers = $submission->form->getEntriesHeader();

        $submission->loadSubmissionIntoFormJson();

        return view('formbuilder::render.edit', compact('submission', 'form_headers', 'form'));
    }

    /**
     * Process the form submission
     *
     * @param  string  $identifier
     * @return Response
     */
    public function submit(Request $request, $identifier)
    {
        $form = Form::where('identifier', $identifier)->firstOrFail();
        $submission = null;
        if (auth()->id() && $form->allows_edit == 0) {
            $submission = Submission::where('form_id', $form->id)->where('user_id', auth()->id())->first();
        }

        DB::beginTransaction();

        try {
            $input = $request->except('_token');
            // check if files were uploaded and process them
            $uploadedFiles = $request->allFiles();
            foreach ($uploadedFiles as $key => $file) {
                // store the file and set it's path to the value of the key holding it
                $validate = \Validator::make($request->all(), [
                    $key => 'max:1024',
                ])->fails();

                if ($validate) {
                    throw new \Exception(__('File size must be less than 1MB'));
                }

                if ($file->isValid()) {
                    $input[$key] = $file->store('form', ['disk' => 'public-folder']);
                }
            }

            if ($submission) {
                $submission->loadSubmissionIntoFormJson();

                $files = $submission->form->form_builder_json->where('type', 'file')->pluck('value', 'name');
                // Fill the empty fields with the existing previous data
                foreach ($files as $key => $value) {
                    if (! isset($input[$key])) {
                        $input[$key] = $value;
                    }
                }
            }

            $user_id = auth()->user()->id ?? null;

            if ($user_id) {
                Submission::updateOrCreate(['form_id' => $form->id, 'user_id' => $user_id], [
                    'user_id' => $user_id,
                    'content' => $input,
                ]);
            } else {
                $form->submissions()->create([
                    'user_id' => $user_id,
                    'content' => $input,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('formbuilder::form.feedback', $identifier)
                ->with('success', __('Form successfully submitted.'));
        } catch (Throwable $e) {
            info($e);
            DB::rollback();

            return back()->withInput()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    /**
     * Display a feedback page
     *
     * @param  string  $identifier
     * @return Response
     */
    public function feedback($identifier)
    {
        $form = Form::where('identifier', $identifier)->firstOrFail();

        $pageTitle = __('Form Submitted!');

        return view('formbuilder::render.feedback', compact('form', 'pageTitle'));
    }
}
