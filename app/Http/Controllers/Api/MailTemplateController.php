<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 26-05-2021
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\{
    MailTemplateDetailResource,
    MailTemplateResource
};
use App\Models\{
    EmailTemplate,
};
use Illuminate\Http\Request;

class MailTemplateController extends Controller
{
    /**
     * Mail Template List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs        = $this->initialize([], $request->all());
        $mailTemplate           = EmailTemplate::select('email_templates.*')->whereNull('parent_id');
        $name           = isset($request->name) ? $request->name : null;
        if (! empty($name)) {
            $mailTemplate->where('name', strtolower($name));
        }
        $status = isset($request->status) ? $request->status : null;
        if (! empty($status)) {
            $mailTemplate->where('status', strtolower($status));
        }
        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (is_int($keyword)) {
                $mailTemplate->where('id', $keyword);
            } elseif (strlen($keyword) >= 2) {
                $mailTemplate->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('status', $keyword);
                });
            }
        }

        return $this->response([
            'data' => MailTemplateResource::collection($mailTemplate->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($mailTemplate->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Mail Template
     *
     * @return json $data
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            if (isset($request->status) && in_array($request->status, ['Pending', 'Active', 'Inactive'])) {
                $request['status'] = $request->status;
            }
            $request['data'] = json_decode($request->data, true);
            $validator = EmailTemplate::storeValidation($request->all());
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }
            $request['language_id'] = 1;
            if ((new EmailTemplate())->store($request->all())) {
                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Email Template')]));
            }

            return $this->errorResponse();
        }
    }

    /**
     * Detail Email Template
     *
     * @param  Request  $request
     * @return json $data
     */
    public function detail($id)
    {
        $response       = $this->checkExistence($id, 'email_templates');
        $templateData   = EmailTemplate::getAll()->where('id', $id)->whereNull('parent_id')->first();
        if ($response['status'] === true && ! empty($templateData)) {
            return $this->response(['data' => new MailTemplateDetailResource($templateData)]);
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Update Mail Template Information
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $response = $this->checkExistence($id, 'email_templates', ['getData' => true]);
            if ($response['status'] === true) {
                if (isset($request->status) && in_array($request->status, ['Pending', 'Active', 'Inactive'])) {
                    $request['status'] = $request->status;
                }
                $request['data'] = json_decode($request->data, true);
                $validator = EmailTemplate::updateValidation($request->all(), $id);
                if ($validator->fails()) {
                    return $this->unprocessableResponse($validator->messages());
                }
                $templateUpdate = (new EmailTemplate())->updateTemplate($request->all(), $id, $response['data']);

                return $this->okResponse([], $templateUpdate['message']);
            }

            return $this->response([], 204, $response['message']);
        }
    }

    /**
     * Remove the specified Template from db.
     *
     * @return json $data
     */
    public function destroy(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $response = $this->checkExistence($id, 'email_templates');
            if ($response['status'] === true) {
                $result  = (new EmailTemplate())->remove($id);

                return $this->okResponse([], $result['message']);
            }

            return $this->response([], 204, $response['message']);
        }
    }
}
