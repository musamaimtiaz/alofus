<?php

namespace Modules\FormBuilder\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\FormBuilder\Entities\Form;
use Modules\FormBuilder\Entities\Submission;
use Modules\FormBuilder\DataTables\SubmissionDataTable;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SubmissionDataTable $dataTable)
    {
        $forms = Form::select('id', 'name')->whereHas('submissions')->notKyc()->get();

        return $dataTable->render('formbuilder::submissions.index', compact('forms'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $form_id
     * @param  int  $submission_id
     * @return \Illuminate\Http\Response
     */
    public function show($form_id, $submission_id)
    {
        $submission = Submission::with('user', 'form')
            ->where([
                'form_id' => $form_id,
                'id' => $submission_id,
            ])
            ->firstOrFail();

        $form_headers = $submission->form->getEntriesHeader();

        return view('formbuilder::submissions.show', compact('submission', 'form_headers'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $form_id
     * @param  int  $submission_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($form_id, $submission_id)
    {
        $submission = Submission::where(['form_id' => $form_id, 'id' => $submission_id])->firstOrFail();
        $submission->delete();

        return redirect()
            ->route('formbuilder::forms.submissions.index', $form_id)
            ->with('success', __('Submission successfully deleted.'));
    }
}
