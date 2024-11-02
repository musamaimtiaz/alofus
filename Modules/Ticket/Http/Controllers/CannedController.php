<?php
/**
 * @author tehcvillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 17-06-2021
 */

namespace Modules\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Ticket\Http\Models\CannedLink;
use Modules\Ticket\Http\Models\CannedMessage;
use Illuminate\Http\Request;
use Auth;

class CannedController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function messages(Request $request)
    {
        $data['menu']       = 'setting';
        $data['sub_menu']   = 'general';
        $data['page_title'] = __('Canned Message');
        $data['list_menu']  = 'canned_message';
        $data['cannedMessageData'] = CannedMessage::getAll();

        return view('admin.canned.canned_message_list', $data);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function links(Request $request)
    {
        $data['menu']       = 'setting';
        $data['sub_menu']   = 'general';
        $data['page_title'] = __('Canned Link');
        $data['list_menu']  = 'canned_link';
        $data['cannedLinkData'] = CannedLink::getAll();

        return view('admin.canned.canned_link_list', $data);
    }

    /**
     * @return bool
     */
    public function storeMessage(Request $request)
    {
        $data               = ['status' => 1];
        $message            = $request->array_value['message'];
        $title              = $request->array_value['title'];
        $request['message'] = $message;
        $request['title']   = $title;
        $validator = CannedMessage::messageValidation($request->only('message', 'title'));
        if ($validator->fails()) {
            $data['status'] = 0;
            $data['error'] = $validator->errors()->first();

            return $data;
        }
        if (isset($request->type) && ! empty($request->type)) {
            $request['created_by']   = Auth::user()->id;
            $request['created_type'] = 'customer';
        } else {
            $request['created_by']   = Auth::user()->id;
            $request['created_type'] = 'user';
        }
        if (empty(CannedMessage::getAll()->where('title', $title)->first())) {
            if ((new CannedMessage())->store($request->only('title', 'message', 'created_by', 'created_type'))) {
                $data['status'] = 1;
            }
        }

        return $data;
    }

    /**
     * Remove the specified Canned messgae from storage.
     *
     * @param  int  $id
     * @return redirect Canned List page view
     */
    public function destroyMessage($id)
    {
        $data = ['type' => 'fail', 'message' => __('Something went wrong, please try again.')];
        if ((new CannedMessage())->remove($id)) {
            $data['type'] = 'success';
            $data['message'] = __('Deleted Successfully.');
        }
        \Session::flash($data['type'], $data['message']);

        return redirect()->intended('canned/messages');
    }

    /**
     * Remove the specified Canned link from storage.
     *
     * @param  int  $id
     * @return redirect Canned link page view
     */
    public function destroyLink($id)
    {
        $data = ['type' => 'fail', 'message' => __('Something went wrong, please try again.')];
        if ((new CannedLink())->remove($id)) {
            $data['type'] = 'success';
            $data['message'] = __('Deleted Successfully.');
        }
        \Session::flash($data['type'], $data['message']);

        return redirect()->intended('canned/links');
    }

    /**
     * @return bool
     */
    public function storeLink(Request $request)
    {
        $data        = ['status' => 0];
        $cannedLinks = $request->array_value['editorValue'];
        $title       = $request->array_value['title'];

        $request['created_by']   = Auth::user()->id;
        $request['created_type'] = 'user';

        if (isset($request->array_value['status']) && $request->array_value['status'] == 'link_list') {
            if (empty(CannedLink::getAll()->where('title', $title)->first())) {
                $request['title'] = $title;
                $request['link']  = $cannedLinks;
                $validator = CannedLink::linkaVlidation($request->only('title', 'link'));
                if ($validator->fails()) {
                    $data['status'] = 0;
                    $data['error'] = $validator->errors()->first();

                    return $data;
                }
                (new CannedLink())->store($request->only('title', 'link', 'created_by', 'created_type'));
            }
        } else {
            foreach ($cannedLinks as $key => $link) {
                if (empty(CannedLink::getAll()->where('title', $title[$key])->first())) {
                    $request['title'] = $title[$key];
                    $request['link']  = $link;
                    $validator = CannedLink::linkaVlidation($request->only('title', 'link'));
                    if ($validator->fails()) {
                        $data['status'] = 0;
                        $data['error'] = $validator->errors()->first();

                        return $data;
                    }
                    (new CannedLink())->store($request->only('title', 'link', 'created_by', 'created_type'));
                }
            }
        }
        $data['status'] = 1;

        return $data;
    }

    /**
     * Search message & link from type
     */
    public function search(Request $request, $type)
    {
        if ($type == 'message') {
            (new CannedMessage())->search($request->search);
        } elseif ($type == 'link') {
            (new CannedLink())->search($request->search);
        }
    }

    public function editMessage(Request $request)
    {
        if (! empty($request->id)) {
            $cannedData = CannedMessage::find($request->id);
            $return_arr['title']   = $cannedData->title;
            $return_arr['message'] = $cannedData->message;
            $return_arr['id']      = $cannedData->id;
            echo json_encode($return_arr);
        }
    }

    /**
     * @return int[]
     */
    public function updateMessage(Request $request)
    {
        $data               = ['status' => 0];
        $message            = $request->array_value['editorValue'];
        $id                 = $request->array_value['id'];
        $title              = $request->array_value['title'];
        $request['message'] = $message;
        $request['title']   = $title;
        $validator = CannedMessage::messageValidation($request->only('message', 'title'));
        if ($validator->fails()) {
            $data['status'] = 0;
            $data['error'] = $validator->errors()->first();

            return $data;
        }
        if (isset($request->type) && ! empty($request->type)) {
            $request['created_by']   = Auth::guard('customer')->user()->id;
            $request['created_type'] = 'customer';
        } else {
            $request['created_by']   = Auth::user()->id;
            $request['created_type'] = 'user';
        }
        if (empty(CannedMessage::getAll()->where('id', '!=', $id)->where('title', $title)->first())) {
            if ((new CannedMessage())->updateMessage($id, $request->only('title', 'message', 'created_by', 'created_type'))) {
                $data['status'] = 1;
            }
        }

        return $data;
    }

    public function editLink(Request $request)
    {
        if (! empty($request->id)) {
            $cannedData = CannedLink::find($request->id);
            $return_arr['link']   = $cannedData->link;
            $return_arr['title']  = $cannedData->title;
            $return_arr['id']     = $cannedData->id;
            echo json_encode($return_arr);
        }
    }

    /**
     * @return int[]
     */
    public function updateLink(Request $request)
    {
        $data        = ['status' => 0];
        $cannedLinks = $request->array_value['editorValue'];
        $id          = $request->array_value['id'];
        $title       = $request->array_value['title'];
        if (isset($request->type) && ! empty($request->type)) {
            $request['created_by']   = Auth::guard('customer')->user()->id;
            $request['created_type'] = 'customer';
        } else {
            $request['created_by']   = Auth::user()->id;
            $request['created_type'] = 'user';
        }
        if (isset($request->array_value['status']) && $request->array_value['status'] == 'link_list') {
            if (empty(CannedLink::getAll()->where('id', '!=', $id)->where('title', $title)->first())) {
                $request['link']  = $cannedLinks;
                $request['title'] = $title;
                $validator = CannedLink::linkaVlidation($request->only('title', 'link'));
                if ($validator->fails()) {
                    $data['status'] = 0;
                    $data['error'] = $validator->errors()->first();

                    return $data;
                }
                if ((new CannedLink())->updateLink($id, $request->only('link', 'title', 'created_by', 'created_type'))) {
                    $data['status'] = 1;
                }
            }
        }

        return $data;
    }
}
