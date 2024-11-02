<?php

namespace Modules\Ticket\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Ticket\DataTables\SupportDataTable;
use App\Exports\VendorTicketsExport;
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
use App\Models\{
    User,
    Preference
};
use App\Notifications\TicketReplyNotification;
use Modules\Ticket\Http\Requests\{
    VendorTicketRequest,
    ReplyRequest
};

class TicketController extends Controller
{
    /**
     * Vendor ticket list
     */
    public function index(SupportDataTable $supportDataTable)
    {
        $data['departments'] = Department::get();
        $data['statuses']    = ThreadStatus::get();
        $data['from'] = request()->input('from');
        $data['to'] = request()->input('to');
        $data['department_id'] = request()->input('department_id');
        $data['status_id'] = request()->input('status_id');
        $data['thread'] = (new Thread())->getAllData($data['from'], $data['to'], $data['department_id'], $data['status_id']);

        return $supportDataTable->render('ticket::index', $data);
    }

    /**
     * Update reply
     */
    public function update(Request $request)
    {
        if (isset($request->id)) {
            if (ThreadReply::updateReply($request->message, $request->id)) {
                \Session::flash('success', __('Successfully Saved'));

                return redirect()->back();
            }
        }
        \Session::flash('fail', __('Something went wrong, please try again.'));

        return redirect()->back();
    }

    /**
     * Create ticket
     */
    public function create()
    {
        $data['projectPanel'] = 0;
        $data['object_type'] = 'TICKET';
        $data['priorities']   = Priority::get();
        $data['threadStatus'] = ThreadStatus::get();
        $data['departments']  = Department::get();

        return view('ticket::add', $data);
    }

    /**
     * Store Ticket
     *
     * @return [type]
     */
    public function store(VendorTicketRequest $request)
    {
        try {
            $user = Auth::user();
            DB::beginTransaction();
            $data['receiver_id']        = $user->id;
            $data['email']              = $user->email ??  null;
            $data['name']               = $user->name ??  null;
            $data['department_id']      = $request->department_id;
            $data['priority_id']        = $request->priority_id;
            $data['thread_status_id']   = 1;
            $data['thread_key']         = 'THRD-' . uniqid();
            $data['subject']            = $request->subject;
            $data['thread_type']        = $request->object_type;
            $data['sender_id']          = 1; // 1 refered to admin
            $data['date']               = date('Y-m-d H:i:s');
            $data['project_id']         = isset($request->project_id) ? $request->project_id : null;
            $data['last_reply']         = date('Y-m-d H:i:s');

            // Creating new thread
            $id = (new Thread())->store($data);
            if (! empty($id)) {
                $replyData['thread_id'] = $id;
                $replyData['sender_id']   = $user->id;
                $replyData['message']   = $request->message;
                $replyData['date']      = $data['date'];
                $replyData['has_attachment']      = isset($request->file) ? 1 : 0;
                $threadReply = (new ThreadReply())->store($replyData);
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
            $info['assignId'] = 1; // Vendor ticket asigned to Admin
            $info['files'] = $attachments;
            User::find($info['assignId'])->notify(new TicketReplyNotification($info));

            Session::flash('success', __('Successfully Saved'));

            return redirect('vendor/ticket/reply/' . base64_encode($id));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function pdf()
    {
        $data['from']       = $from       = request('from');
        $data['to']         = $to         = request('to');
        $status             = request('status');
        $departmentId       = request('department_id');
        $data['customerSelected'] = '';
        $data['departmentSelected'] = Department::find($departmentId);
        $data['statusSelected'] = ThreadStatus::find($status);
        $data['ticketList'] = (new Thread())->getAllData($from, $to, $departmentId, $status, null)->orderBy('date', 'desc')->get();
        $data['company_logo'] = Preference::where('category', 'company')->where('field', 'company_logo')->first('value');
        $data['date_range'] = (! empty($from) && ! empty($to)) ? formatDate($from) . ' To ' . formatDate($to) : 'No date selected';

        return printPDF($data, 'ticket_list_pdf' . time() . '.pdf', 'ticket::vendor_pdf', view('ticket::vendor_pdf', $data), 'pdf');
    }

    public function csv()
    {
        return Excel::download(new VendorTicketsExport(), 'tickets_list' . time() . '.csv');
    }

    public function getAllStatus(Request $request)
    {
        $data = ['status' => 0];
        $data['output'] = '';
        $statusName    = $request->statusName;
        $ticketId   = $request->ticketId;
        if (! empty($statusName) && ! empty($ticketId)) {
            $ticketStatus = DB::table('ticket_statuses')->where('name', '!=', $statusName)->orderBy('name')->get();
            foreach ($ticketStatus as $key => $value) {
                $data['output'] .= '<li class="properties"><a class="status_change f-14 color_black" ticket_id="' . $ticketId . '" data-id="' . $value->id . '" data-value="' . $value->name . '">' . $value->name . '</a></li>';
            }
            $data['status'] = 1;
        }

        return $data;
    }

    public function view($id)
    {
        $data['page_title'] = __('Ticket Reply');
        $ticket_id   = base64_decode($id);
        $previousurl = url()->previous();

        $data['header'] = 'ticket';
        $data['ticketStatuses']      = ThreadStatus::getAll();
        $data['ticketDetails']      = (new Thread())->getAllTicketDetailsById($ticket_id);
        if (empty($data['ticketDetails'])) {
            return redirect()->back()->with('fail', __('The data you are trying to access is not found.'));
        }
        $data['priority']           = Priority::where('id', '=', $data['ticketDetails']->priority_id)->first();

        $data['ticketReplies']      = (new Thread())->getAllTicketRepliersById($ticket_id);
        $data['ticketStatus'] = ThreadStatus::where('id', '!=', $data['ticketDetails']->thread_status_id)->orderBy('name')->get();
        $data['filePath'] = 'public/uploads';
        $data['assignee'] = User::where('status', 'active')->get();

        return view('ticket::reply', $data);
    }

    public function replyStore(ReplyRequest $request)
    {
        try {
            DB::beginTransaction();
            if (! empty($request->ticket_id)) {
                DB::table('threads')
                    ->where('id', $request->ticket_id)
                    ->update([
                        'thread_status_id'    => 6, // 6 refered to open
                        'last_reply'    => date('Y-m-d H:i:s'),
                    ]);
            }
            $data['thread_id'] = $request->ticket_id;
            $data['sender_id']   = Auth::user()->id;
            $data['message']   = $request->message;
            $data['date']      = date('Y-m-d H:i:s');
            $thredReplyId = (new ThreadReply())->store($data);

            $attachments = [];

            if (isset($request->file_id) && ! empty($request->file_id)) {
                $fileId = ThreadReply::where('id', $thredReplyId)->first();
                $attachments = $fileId->filesUrlNew(['imageUrl' => 'true']);
            }

            $info['emailInfo'] = (new Thread())->getAllTicketDetailsById($request->ticket_id);
            $info['assignId'] = empty($info['emailInfo']->assigned_member_id) ? 1 : $info['emailInfo']->assigned_member_id; // Vendor ticket asigned to Admin
            $info['files'] = $attachments;

            User::find($info['assignId'])->notify(new TicketReplyNotification($info));

            DB::commit();
            Session::flash('success', __('Successfully Saved'));

            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function replyDelete(Request $request)
    {
        if (isset($request->id) && isset($request->ticket_id)) {
            // If file exeist then delete
            $file = DB::table('files')->where(['ticket_reply_id' => $request->id, 'ticket_id' => $request->ticket_id])->first();
            if (! empty($file)) {
                @unlink(public_path() . '/uploads/ticketFile/' . $file->file_name);
                DB::table('files')->where(['ticket_reply_id' => $request->id, 'ticket_id' => $request->ticket_id])->delete();
            }
            // Delete Ticket Reply
            $data = DB::table('ticket_replies')->where(['id' => $request->id, 'ticket_id' => $request->ticket_id])->first();
            if (! empty($data)) {
                \DB::table('ticket_replies')->where(['id' => $request->id, 'ticket_id' => $request->ticket_id])->delete();
                \Session::flash('success', __('Deleted Successfully.'));

                return redirect()->back();
            }
        }
    }

    public function customerReply($id)
    {
        $ticket_id             = base64_decode($id);
        $data['menu']          = 'customer-panel-support';
        $data['page_title'] = __('Customer Ticket Reply');
        $data['ticketDetails'] = $this->Ticket->getAllTicketDetailsById($ticket_id);

        if (empty($data['ticketDetails'])) {
            return redirect()->back()->with('fail', __('The data you are trying to access is not found.'));
        }

        $data['assignee'] = User::where('id', $data['ticketDetails']->assigned_member_id)->first();
        if ($data['ticketDetails']['customer_id'] != Auth::guard('customer')->user()->id) {
            Session::flash('fail', __('Invalid Ticket Reply'));

            return redirect('customer/dashboard');
        }
        $data['ticketReplies'] = $this->Ticket->getAllTicketRepliersById($ticket_id);
        $replyFiles = [];
        foreach ($data['ticketReplies'] as $ticketReply) {
            $replyFiles[$ticketReply->id] = (new File())->getFiles('Ticket Reply', $ticketReply->id);
        }
        $data['replyFiles'] = $replyFiles;
        $data['filePath'] = 'public/uploads/tickets';

        return view('admin.customerPanel.ticket.reply', $data);
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
}
