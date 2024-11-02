<?php

/**
 * @author tehcvillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 05-06-2022
 */

namespace Modules\Ticket\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Ticket\Http\Models\Thread;
use Modules\Ticket\Http\Models\ThreadStatus;

class AdminSupportDataTable extends DataTable
{
    /**
     * Handle the AJAX request for attribute groups.
     *
     * This function queries attribute groups and returns the data in a format suitable
     * for DataTables to consume via AJAX.
     *
      @return \Illuminate\Http\JsonResponse
     */
    public function ajax(): JsonResponse
    {
        $tickets = $this->query();

        return datatables()
            ->of($tickets)
            ->addColumn('id', function ($tickets) {
                return "<a href='" . route('admin.threadReply', ['id' => base64_encode($tickets->id)]) . "'>" . $tickets->id . '</a>';
            })
            ->editColumn('subject', function ($tickets) {
                $priority = '<span class="badge priority-style" id="' . strtolower(optional($tickets->priority)->name) . '-priority">' . trimWords(optional($tickets->priority)->name, 25) . '</span>';
                $id = "<a href='" . route('admin.threadReply', ['id' => base64_encode($tickets->id)]) . "'>" . $tickets->subject . '</a>';

                return $id . '<br>' . $priority;
            })
            ->editColumn('assignee', function ($tickets) {
                return optional($tickets->assignedMember)->name;
            })
            ->addColumn('status', function ($tickets) {
                $allstatus = '';
                $ticketStatus = ThreadStatus::where('id', '!=', $tickets->thread_status_id)->get();
                foreach ($ticketStatus as $key => $value) {
                    $allstatus .= '<li class="properties"><a class="admin_ticket_status_change f-14 class_black" ticket_id="' . $tickets->id . '" data-id="' . $value->id . '" data-value="' . $value->name . '">' . $value->name . '</a></li>';
                }
                $top = '<div class="btn-group">
                <button style="color:' . optional($tickets->threadStatus)->color . ' !important" type="button" class="badge text-white f-12 dropdown-toggle task-status-name" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                ' . optional($tickets->threadStatus)->name . '&nbsp;<span class="caret"></span>
                </button>
                <ul class="dropdown-menu scrollable-menu task-priority-name w-150p" role="menu">';
                $last = '</ul></div>&nbsp';

                return $top . $allstatus . $last;
            })
            ->addColumn('department', function ($tickets) {
                return optional($tickets->department)->name;
            })

            ->addColumn('last_reply', function ($tickets) {
                return $tickets->last_reply && $tickets->last_reply != $tickets->date ? timeZoneFormatDate($tickets->last_reply) . '<br />' . timeZoneGetTime($tickets->last_reply) : __('Not Replied Yet');
            })
            ->addColumn('date', function ($tickets) {
                return $tickets->date ? timeZoneFormatDate($tickets->date) . '<br />' . timeZoneGetTime($tickets->date) : __('Created At');
            })
            ->addColumn('name', function ($tickets) {
                return '<a href="' . route('users.edit', ['id' => $tickets->receiver_id]) . '">' . wrapIt($tickets->receiver->name, 10) . '</a>';
            })

            ->addColumn('action', function ($tickets) {
                $edit = '<a title="' . __('Edit :?', ['?' => __('Ticket')]) . '" href="' . route('admin.threadEdit', ['id' => $tickets->id]) . '" class="action-icon"><i class="feather icon-edit-1 neg-transition-scale-svg "></i></a>&nbsp';

                $delete = '<form method="post" action="' . route('admin.ticketDelete', ['id' => $tickets->id]) . '" id="delete-ticket-' . $tickets->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <a title="' . __('Delete') . '" class="action-icon confirm-delete" type="button" data-id=' . $tickets->id . ' data-delete="ticket" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :?', ['?' => __('Ticket')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';

                $str = '';
                if ($this->hasPermission(['Modules\Ticket\Http\Controllers\TicketController@edit'])) {
                    $str .= $edit;
                }
                if ($this->hasPermission(['Modules\Ticket\Http\Controllers\TicketController@delete'])) {
                    $str .= $delete;
                }

                return $str;
            })

            ->rawColumns(['action', 'id', 'subject', 'assignee', 'status', 'last_reply', 'date', 'name', 'department', 'priority_name'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $threads = Thread::with(['department', 'vendor', 'assignedMember'])
            ->when(request()->thread_status == 'open', function ($query) {
                return $query->whereHas('threadStatus', function ($q) {
                    $q->where('name', 'Open');
                });
            })->filter();

        return $this->applyScopes($threads);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()

            ->addColumn(['data' => 'id', 'name' => 'id', 'visible' => false])
            ->addColumn(['data' => 'last_reply', 'name' => 'last_reply', 'visible' => false, 'className' => 'align-middle'])
            ->addColumn(['data' => 'subject', 'name' => 'subject', 'title' => __('Subject'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'assignee', 'name' => 'assignedMember.name', 'title' => __('Assignee'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'department', 'name' => 'department.name', 'title' => __('Department'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'name', 'name' => 'vendor.name', 'title' => __('Vendor'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'last_reply', 'name' => 'last_reply', 'title' => __('Last reply'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'date', 'name' => 'date', 'title' => __('Created at'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'name', 'title' => __('Status'), 'orderable' => false, 'searchable' => false, 'className' => 'align-middle'])
            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => __('Action'), 'width' => '10%',
                'visible' => $this->hasPermission(['Modules\Ticket\Http\Controllers\TicketController@edit', 'Modules\Ticket\Http\Controllers\TicketController@delete']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle',
            ])

            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }
}
