<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 05-22-2022
 */

namespace Modules\Ticket\Http\Models;

use App\Models\Model;
use App\Traits\ModelTrait;
use App\Traits\ModelTraits\hasFiles;

class Message extends Model
{
    use hasFiles;
    use ModelTrait;

    protected $table = 'thread_replies';

    protected $fillable = [
        'thread_id',
        'sender_id',
        'message',
        'receiver_id',
        'date',
        'has_attachment',
    ];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($message) {
            $message->date = date('Y-m-d H:i:s');
            $message->is_read = 0;
        });
    }

    public function chat()
    {
        return $this->belongsTo('Modules\Ticket\Http\Models\Chat', 'thread_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Models\User', 'receiver_id', 'id');
    }

    public function sendByMe()
    {
        return $this->sender_id == auth()->id();
    }

    public function senderImage($chat)
    {

        if ($this->sender_id == $chat->sender_id) {
            return $this->sender->fileUrl();
        }

        return optional($chat->vendorDetails->logo)->fileUrl();
    }

    public static function totalUnreadMessages()
    {
        return parent::selectRaw("'1' as total")
            ->join('threads', 'thread_replies.thread_id', 'threads.id')
            ->where('threads.thread_type', 'chat')
            ->where('is_read', 0)
            ->where('thread_replies.receiver_id', auth()->id())
            ->groupBy('thread_id')
            ->first()->total ?? 0;
    }
}
