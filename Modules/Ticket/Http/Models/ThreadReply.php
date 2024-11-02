<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 02-15-2021
 */

namespace Modules\Ticket\Http\Models;

use App\Models\Model;
use App\Traits\ModelTrait;
use App\Traits\ModelTraits\hasFiles;
use Illuminate\Support\Facades\Auth;
use Modules\MediaManager\Http\Models\ObjectFile;

class ThreadReply extends Model
{
    use hasFiles;
    use ModelTrait;

    protected $table = 'thread_replies';

    public $timestamps = false;

    public function image()
    {
        return $this->hasOne('App\Models\File', 'object_id', 'thread_id')->where('object_type', 'thread_replies');
    }

    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Models\User', 'receiver_id', 'id');
    }

    public function getMessageCount()
    {
        $ticket = ThreadReply::query();
        if (Auth::user()->vendor()) {
            $ticket = $ticket->where('receiver_id', Auth::user()->id);
        } else {
            $ticket = $ticket->where('sender_id', Auth::user()->id);
        }

        return $ticket->where('is_read', 0)->count();
    }

    /**
     * store
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data = [])
    {
        $info = parent::insertGetId($data);
        if ($info) {
            $fileIds = [];
            if (request()->has('file_id')) {
                foreach (request()->file_id as $data) {
                    $fileIds[] = $data;
                }
            }
            ObjectFile::storeInObjectFiles($this->objectType(), $this->objectId(), $fileIds);

            return $info;
        }

        return false;
    }

    /**
     * Update
     *
     * @param  array  $data
     * @param  int  $id
     * @return array
     */
    public function updateReply($data = null, $id = null)
    {
        $result = ThreadReply::where('id', $id);
        if ($result->exists()) {
            $result->update(['message' => $data]);

            return true;
        }

        return false;
    }

    public function updateMsgReadStatus($threadId = null)
    {
        if (ThreadReply::where('thread_id', $threadId)->update(['is_read' => 1])) {
            return true;
        }

        return false;
    }

    public function getAllTicketRepliersById($ticketId, $id = null)
    {
        $res = ThreadReply::with('image:id', 'sender:id,name,email', 'receiver:id,vendor_id,user_id')->where('thread_id', $ticketId)->orderBy('date', 'desc')->get();

        return $res;
    }

    public function getAllTicketRepliersById1($id, $tableId = null)
    {
        $res = ThreadReply::with('sender:id,name,email', 'receiver:id,vendor_id,user_id')->where('thread_id', $id)->where('id', '<', $tableId)->orderBy('date', 'desc')->get();

        return $res;
    }
}
