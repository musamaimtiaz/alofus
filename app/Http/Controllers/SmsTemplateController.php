<?php

namespace App\Http\Controllers;

use App\DataTables\SmsTemplateDataTable;
use App\Models\EmailTemplate;
use App\Services\SmsTemplateService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class SmsTemplateController extends Controller
{
    /**
     * Index
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(SmsTemplateDataTable $dataTable)
    {
        return $dataTable->render('admin.sms_templates.index');
    }

    /**
     * Edit
     *
     * @param  string  $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($slug)
    {
        $data['template'] = EmailTemplate::getAll()->where('slug', $slug)->whereNull('parent_id')->first();

        if (empty($data['template'])) {
            return redirect()->route('sms.template.index')->withFails(__(':x does not exist.', ['x' => __('Template')]));
        }

        $childTemplates = EmailTemplate::getAll()->where('parent_id', $data['template']->id);

        $data['childs'] = $childTemplates->mapWithKeys(function ($child) {
            return [$child->language_id => ['subject' => $child->subject, 'sms_body' => $child->sms_body]];
        })->all();

        return view('admin.sms_templates.edit', $data);
    }

    /**
     * Update
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, SmsTemplateService $service, $id)
    {
        DB::beginTransaction();

        try {
            $service->updateParentTemplate($request->sms_body, $id);
            $service->updateChildTemplate($request->data, $id);
            DB::commit();

            return redirect()->back()->withSuccess(__('The :x has been saved successfully.', ['x' => __('SMS Template')]));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
