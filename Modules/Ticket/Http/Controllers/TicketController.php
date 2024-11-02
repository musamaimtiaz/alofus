<?php

namespace Modules\Ticket\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Ticket\DataTables\AdminSupportDataTable;
use App\Http\Controllers\EmailController;
use App\Exports\TicketsExport;
use DB;
use Excel;
use Modules\Ticket\Http\Models\{
    Thread,
    ThreadReply,
    ThreadStatus,
    Priority,
    Department
};
use Illuminate\Support\Facades\{
    Auth,
    Session
};
use Modules\Ticket\Http\Requests\{
    AdminTicketRequest,
    ReplyRequest,
    TicketUpdateRequest
};
use App\Models\{
    User,
    Preference
};
use App\Notifications\TicketAssigneeNotification;
use App\Notifications\TicketReplyNotification;
use App\Notifications\VendorTicketNotification;

class TicketController extends Controller
{
    /**
     * Ticket list for admin
     *
     * @return [type]
     */
    public function index(AdminSupportDataTable $adminSupportDataTable)
    {
        $data['status']    = ThreadStatus::get();
        $data['departments'] = Department::get();
        $data['assignees'] = User::has('threads')->with('threads:id,assigned_member_id')->distinct()->get(['id', 'name']);
        $data['from']        = $from        = request('from');
        $data['to']          = $to          = request('to');
        $data['allstatus']   = $allstatus   = request('status');
        $data['alldepartment'] = $alldepartment = request('department_id');
        $data['allassignee'] = $allassignee = request('assignee');
        $data['summary']     = $summary = (new Thread())->getThreadSummary($from, $to, $allstatus, $alldepartment, null, $allassignee);
        if ((isset($from) && ! empty($from)) || (isset($to) && ! empty($to)) || (isset($alldepartment) && ! empty($alldepartment))) {
            $data['exceptClickedStatus'] = $exceptClickedStatus = (new Thread())->getExceptClickedStatus($allstatus);
            if (! empty($data['exceptClickedStatus'])) {
                foreach ($summary as $key => $summ) {
                    foreach ($exceptClickedStatus as $key => $exceptClickedSts) {
                        if ($exceptClickedSts->name == $summ->name) {
                            $summ->total_status = $exceptClickedSts->total_status;
                        }
                    }
                }
            }
        } else {
            $data['filteredStatus'] = $filteredStatus = (new Thread())->getFilteredStatus(['from' => $from, 'to' => $to, 'allstatus' => $allstatus, 'alldepartment' => $alldepartment, 'allassignee' => $allassignee]);
            if (! empty($data['filteredStatus'])) {
                foreach ($summary as $key => $summ) {
                    foreach ($filteredStatus as $key => $filtered) {
                        if ($filtered->name == $summ->name) {
                            $summ->total_status = $filtered->total_status;
                        }
                    }
                }
            }
        }

        return $adminSupportDataTable->render('ticket::admin_index', $data);
    }

    /**
     * Thred Details
     *
     * @param  mixed  $id
     * @return [view]
     */
    public function view($id)
    {
        $ticket_id   = base64_decode($id);
        $data['ticketStatuses']     = ThreadStatus::getAll();
        $data['ticketDetails']      = (new Thread())->getAllTicketDetailsById($ticket_id);

        if (empty($data['ticketDetails'])) {
            return redirect()->back()->with('fail', __('The data you are trying to access is not found.'));
        }
        $data['priority']           = Priority::where('id', '!=', $data['ticketDetails']->priority_id)->get();
        $data['ticketReplies']      = (new Thread())->getAllTicketRepliersById($ticket_id);
        $data['ticketStatus'] = ThreadStatus::where('id', '=', $data['ticketDetails']->threadStatus->id)->orderBy('name')->first();
        $data['filePath'] = 'public/uploads';
        $data['assignee']    = User::whereHas('roleUser', function ($query) {
            $query->where('role_id', 1);
        })->active()->get();

        return view('ticket::admin_reply', $data);
    }

    /**
     * Ticket add
     *
     * @return [view]
     */
    public function add()
    {
        $data['object_type'] = 'TICKET';
        $data['priorities']   = Priority::get();
        $data['assignees']    = User::whereHas('roleUser', function ($query) {
            $query->where('role_id', 1);
        })->active()->get();

        $data['users']    = User::whereHas('roleUser', function ($query) {
            $query->where('role_id', 2); // 2 refered to vendor
        })->active()->get();

        $data['ticketStatus'] = ThreadStatus::get();
        $data['departments']  = Department::get();
        $data['customers']    = User::where('status', 'active')->get();

        return view('ticket::admin.add', $data);
    }

    /**
     * Store Ticket
     */
    public function store(AdminTicketRequest $request)
    {
        try {
            DB::beginTransaction();
            $data['receiver_id']        = $request->receiver_id;
            $data['email']              = $request->email ??  null;
            $data['name']               = isset($request->to) ? $request->to : null;
            $data['department_id']      = $request->department_id;
            $data['priority_id']        = $request->priority_id;
            $data['thread_status_id']   = $request->status_id;
            $data['thread_key']         = 'THRD-' . uniqid();
            $data['subject']            = $request->subject;
            $data['thread_type']        = $request->object_type;
            $data['sender_id']          = Auth::user()->id;
            $data['date']               = date('Y-m-d H:i:s');
            $data['project_id']         = isset($request->project_id) ? $request->project_id : null;
            $data['last_reply']         = date('Y-m-d H:i:s');
            $data['assigned_member_id'] = $request->assign_id;

            // Creating new thread
            $id = (new Thread())->store($data);

            $objectType = '';
            // creating a initial thread reply if the thread is created
            if (! empty($id)) {
                $replyData['thread_id'] = $id;
                $replyData['receiver_id']   = Auth::user()->id;
                $replyData['message']   = $request->message;
                $replyData['date']      = $data['date'];
                $replyData['has_attachment']      = isset($request->file) ? 1 : 0;
                $objectType = (new ThreadReply())->store($replyData);
            }
            DB::commit();
            $attachments = [];
            if (isset($request->file_id) && ! empty($request->file_id)) {
                $fileId = ThreadReply::where('id', $id)->get();

                foreach ($fileId as $key => $file) {
                    $attachments = $file->filesUrlNew(['imageUrl' => 'true']);

                }
            }
            $info['emailInfo'] = (new Thread())->getAllTicketDetailsById($id);
            $info['assignId'] = $request->assign_id;
            $info['receiverId'] = $request->receiver_id;
            $info['files'] = $attachments;

            if ($request->assign_id) {
                User::find($info['assignId'])->notify(new TicketAssigneeNotification($info));
            }
            // Mail to vendor
            if ($request->receiver_id) {
                User::find($request->receiver_id)->vendors()->first()->notify(new VendorTicketNotification($info));
            }
            Session::flash('success', __('Successfully Saved'));

            return redirect('admin/ticket/reply/' . base64_encode($id));
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Edit the ticket
     *
     * @param  mixed  $id
     * @return [type]
     */
    public function edit($id)
    {
        $data['departments']   = Department::get();
        $data['priorities']    = Priority::get();
        $data['assignees']     = User::whereHas('roleUser', function ($query) {
            $query->where('role_id', 1);
        })->active()->get();

        $data['ticketStatus']  = ThreadStatus::get();
        $data['vendors']    = User::whereHas('roleUser', function ($query) {
            $query->where('role_id', 2);
        })->active()->get();
        $data['ticketDetails'] = (new Thread())->getAllTicketDetailsById($id);
        if (empty($data['ticketDetails'])) {
            return redirect()->back()->with('fail', __('The data you are trying to access is not found.'));
        }

        return view('ticket::edit', $data);
    }

    /**
     * Update Ticket
     *
     * @param  Request  $request
     */
    public function update(TicketUpdateRequest $request, EmailController $emailController)
    {
        \DB::beginTransaction();
        $data['sender_id']          = $request->vendor_id;
        $data['email']              = $request->email ?? null;
        $data['name']               = $request->to ?? null;
        $data['department_id']      = $request->department_id;
        $data['priority_id']        = $request->priority_id;
        $data['project_id']         = $request->project_id ?? null;
        $data['thread_status_id']   = $request->status_id;
        $data['thread_key']         = $request->thread_key;
        $data['subject']            = stripBeforeSave($request->subject) ?? null;
        $data['assigned_member_id'] = $request->assign_id ?? null;
        (new Thread())->updateDate($request->ticket_id, $data);

        $info['emailInfo'] = (new Thread())->getAllTicketDetailsById($request->ticket_id);
        $info['assignId'] = 1; // 1 referred to Admin
        $info['receiverId'] = $request->receiver_id;
        $info['files'] = [];

        if ($request->ticket_previous_assigne != $request->assign_id) {
            if ($request->assign_id) {
                User::find($info['assignId'])->notify(new TicketAssigneeNotification($info));
                if ($request->assign_id != 1) {
                    $info['assignId'] = $request->assign_id;
                    User::find($info['assignId'])->notify(new TicketAssigneeNotification($info));
                }
            }
        }

        \DB::commit();
        Session::flash('success', __('Successfully Saved'));

        return redirect()->intended('admin/ticket/reply/' . base64_encode($request->ticket_id));
    }

    /**
     * Delete Ticket
     */
    public function delete(Request $request)
    {
        if (isset($request->id)) {
            $data = Thread::where('id', $request->id)->first();
            if ($data) {
                Thread::where('id', $request->id)->delete();
                ThreadReply::where('thread_id', $request->id)->delete();
                \Session::flash('success', __('Deleted Successfully.'));
            }
        }

        return redirect()->back();
    }

    /**
     * Ticket status
     */
    public function getAllStatus(Request $request)
    {
        $data = ['status' => 0];
        $data['output'] = '';
        $statusName    = $request->statusName;
        $ticketId   = $request->ticketId;
        if (! empty($statusName) && ! empty($ticketId)) {
            $ticketStatus = ThreadStatus::where('name', '!=', $statusName)->orderBy('name')->get();
            foreach ($ticketStatus as $key => $value) {
                $data['output'] .= '<li class="properties"><a class="status_change f-14 color_black" ticket_id="' . $ticketId . '" data-id="' . $value->id . '" data-value="' . $value->name . '">' . $value->name . '</a></li>';
            }
            $data['status'] = 1;
        }

        return $data;
    }

    /**
     * Change ticket assignee
     *
     * @return [type]
     */
    public function changeAssignee(Request $request)
    {
        $ticket_id       = $request->ticket_id;
        $new_assignee_id = $request->user_id;
        $data['status'] = 0;
        if (! empty($ticket_id)) {
            $confirm = Thread::where(['id' => $ticket_id])->update(['assigned_member_id' => $new_assignee_id]);
            if ($confirm) {
                $info['emailInfo'] = (new Thread())->getAllTicketDetailsById($ticket_id);
                $info['assignId'] = $new_assignee_id;
                $info['files'] = [];
                $info['receiverId'] = $info['emailInfo']->sender_id;
                if ($new_assignee_id) {
                    User::find($info['assignId'])->notify(new TicketAssigneeNotification($info));
                }
                $data['status'] = 1;
            }
        }

        return $data;
    }

    /**
     * Store Ticket Reply
     */
    public function replyStore(ReplyRequest $request)
    {
        try {
            DB::beginTransaction();
            if (! empty($request->status_id)) {
                Thread::where('id', $request->ticket_id)
                    ->update([
                        'thread_status_id'     => $request->status_id,
                        'last_reply'    => date('Y-m-d H:i:s'),
                    ]);
            }
            $data['thread_id'] = $request->ticket_id;
            $data['receiver_id']   = Auth::user()->id;
            $data['message']   = $request->message;
            $data['date']      = date('Y-m-d H:i:s');
            $threadReplyId = (new ThreadReply())->store($data);

            $attachments = [];

            if (isset($request->file_id) && ! empty($request->file_id)) {
                $fileId = ThreadReply::where('id', $threadReplyId)->first();
                $attachments = $fileId->filesUrlNew(['imageUrl' => 'true']);
            }

            $info['emailInfo'] = (new Thread())->getAllTicketDetailsById($request->ticket_id);
            $info['files'] = $attachments;
            $info['assignId'] = empty($info['emailInfo']->receiver_id) ? 1 : $info['emailInfo']->receiver_id;

            User::find($info['assignId'])->notify(new TicketReplyNotification($info));

            DB::commit();
            Session::flash('success', __('Successfully Saved'));

            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Delete ticket reply
     */
    public function replyDelete(Request $request)
    {
        if (isset($request->id) && isset($request->ticket_id)) {
            // If file exeist then delete
            $file = File::where(['ticket_reply_id' => $request->id, 'ticket_id' => $request->ticket_id])->first();
            if (! empty($file)) {
                @unlink(public_path() . '/uploads/ticketFile/' . $file->file_name);
                File::where(['ticket_reply_id' => $request->id, 'ticket_id' => $request->ticket_id])->delete();
            }
            // Delete Ticket Reply
            $data = ThreadReply::where(['id' => $request->id, 'ticket_id' => $request->ticket_id])->first();
            if (! empty($data)) {
                ThreadReply::where(['id' => $request->id, 'ticket_id' => $request->ticket_id])->delete();
                \Session::flash('success', __('Deleted Successfully.'));

                return redirect()->back();
            }
        }
    }

    /**
     * Update Reply
     *
     * @param  Request  $request
     */
    public function updateReply(ReplyRequest $request)
    {
        if (isset($request->id)) {
            if ((new ThreadReply())->updateReply($request->message, $request->id)) {
                \Session::flash('success', __('Successfully Updated'));

                return redirect()->back();
            }
        }
        \Session::flash('fail', __('Something went wrong, please try again.'));

        return redirect()->back();
    }

    /**
     * Generate pdf
     *
     * @return [type]
     */
    public function pdf()
    {
        $url_components = parse_url(url()->previous());
        $url_components = explode('/', $url_components['path']);
        $data['from'] = $from     = request('from');
        $data['to'] = $to       = request('to');
        $data['status'] = $status   = request('status');
        $data['departmentId'] = $departmentId = request('department_id');
        $data['assigneeId'] = $assigneeId = request('assignee');
        $data['previousUrl'] = $url_components[2];
        $data['ticketList'] = (new Thread())->getAllData($from, $to, $departmentId, $status, null, null, $assigneeId)->orderBy('last_reply', 'desc')->get();
        $data['company_logo'] = Preference::where('category', 'company')->where('field', 'company_logo')->first('value');
        $data['date_range'] = ! empty($from) && ! empty($to) ? formatDate($from) . ' To ' . formatDate($to) : 'No Date Selected';
        $data['departmentSelected'] = Department::find($departmentId);
        $data['statusSelected'] = ThreadStatus::find($status);
        $data['assigneeSelected'] = User::find($assigneeId);

        return printPDF($data, 'ticket_list_pdf' . time() . '.pdf', 'ticket::admin_ticket', view('ticket::admin_ticket', $data), 'pdf');
    }

    public function csv()
    {
        return Excel::download(new TicketsExport(), 'tickets_list' . time() . '.csv');
    }

    public function changeStatus(Request $request)
    {
        $data = ['status' => 0];
        if (! empty($request->status_id) && ! empty($request->ticketId)) {
            $previousStatus = Thread::where('id', $request->ticketId)->first(['thread_status_id']);
            $data['preStatusName'] = str_replace(' ', '', $previousStatus->threadStatus->name);
            $update = Thread::where(['id' => $request->ticketId])->update([
                'thread_status_id' => $request->status_id,
            ]);

            if ($update) {
                $newStatus = Thread::where('id', $request->ticketId)->first(['thread_status_id']);
                $ticktStatus = ThreadStatus::where('id', $newStatus->thread_status_id)->pluck('color', 'name')->toArray();
                $data['newStatusName'] = str_replace(' ', '', $newStatus->threadStatus->name);
                $data['newName'] = $newStatus->threadStatus->name;
                $data['newStatusColor'] = array_values($ticktStatus)[0];
                $data['status']  = '1';
            }
        }

        return $data;
    }

    public function changePriority(Request $request)
    {
        $data = ['status' => 0];
        $data['output'] = '';
        if (! empty($request->priorityId) && ! empty($request->ticketId)) {
            $update = Thread::where(['id' => $request->ticketId])
                ->update([
                    'priority_id' => $request->priorityId,
                ]);

            if ($update) {
                $ticketStatus = Priority::where('id', '!=', $request->priorityId)->orderBy('name')->get();
                foreach ($ticketStatus as $key => $value) {
                    $data['output'] .= '<li class="properties"><a class="ticket_priority_change f-14 color_black w-100 d-inline-block" ticket_id="' . $request->ticketId . '" data-id="' . $value->id . '" data-value="' . $value->name . '">' . $value->name . '</a></li>';
                }
                $data['status']  = '1';
            }
        }

        return $data;
    }
}
