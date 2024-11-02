<?php

namespace Modules\FormBuilder\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\FormBuilder\Entities\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\FormBuilder\DataTables\SubmissionDataTable;
use Throwable;

class MySubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SubmissionDataTable $dataTable)
    {
        $user = auth()->user();

        $submissions = Submission::getForUser($user);

        $pageTitle = __('My Submissions');

        return $dataTable->render('formbuilder::my_submissions.index', compact('submissions', 'pageTitle'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();
        $submission = Submission::where(['id' => $id])
            ->with('form')
            ->firstOrFail();

        $form_headers = $submission->form->getEntriesHeader();

        $pageTitle = __('View Submission');

        return view('formbuilder::my_submissions.show', compact('submission', 'pageTitle', 'form_headers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = auth()->user();
        $submission = Submission::where(['id' => $id])
            ->with('form')
            ->firstOrFail();

        // load up my current submissions into the form json data so that the
        // form is pre-filled with the previous submission we are trying to edit.
        $submission->loadSubmissionIntoFormJson();

        $pageTitle = __('Edit My Submission for :x', ['x' => $submission->form->name]);

        return view('formbuilder::my_submissions.edit', compact('submission', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if ($user->role()->slug == 'super-admin') {
            $submission = Submission::where(['id' => $id])->first();
        } else {
            $submission = Submission::where(['user_id' => $user->id, 'id' => $id])->first();
        }

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

            $submission->update(['content' => $input]);

            DB::commit();

            return redirect()
                ->route('formbuilder::submissions.all')
                ->with('success', __('Submission updated.'));
        } catch (Throwable $e) {
            info($e);

            DB::rollback();

            return back()->withInput()->with('error', Helper::wtf());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();

        if ($user->role()->slug == 'super-admin') {
            $submission = Submission::where(['id' => $id])->first();
        } else {
            $submission = Submission::where(['user_id' => $user->id, 'id' => $id])->first();
        }

        $submission->delete();

        return redirect()
            ->route('formbuilder::submissions.all')
            ->with('success', __('Submission deleted!'));
    }
}
