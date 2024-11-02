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
use App\Models\Vendor;
use App\Models\VendorUser;
use App\Traits\ModelTrait;
use App\Traits\ModelTraits\hasFiles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    use hasFiles;
    use ModelTrait;

    public $timestamps = false;

    protected $table = 'threads';

    protected $attributes = [
        'thread_type' => 'chat',
    ];

    protected $fillable = [
        'thread_type',
        'receiver_id',
        'sender_id',
        'thread_key',
    ];

    public $vendorDetails;

    public static $selectFields = ['id', 'receiver_id', 'sender_id'];

    protected static function booted()
    {
        static::addGlobalScope('chat', function (Builder $builder) {
            $builder->select(self::$selectFields)->where('thread_type', 'chat')->where(function ($query) {
                $query->where('receiver_id', auth()->id())->orWhere('sender_id', auth()->id());
            });
        });

        static::creating(function ($chat) {
            $chat->thread_key = 'THRD-' . uniqid();
        });
    }

    /**
     * Relation with User model as sender
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id', 'id');
    }

    /**
     * Relation with User model as receiver
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo('App\Models\User', 'receiver_id', 'id');
    }

    /**
     * Relation with Message model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'thread_id', 'id');
    }

    /**
     * Relation with Message model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function LastMessage()
    {
        return $this->hasOne(Message::class, 'thread_id', 'id')->orderBy('id', 'desc');
    }

    /**
     * Get all the list of initiated chats with the last message
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function conversations()
    {
        return parent::with('lastMessage')->where('sender_id', Auth::id())->get();
    }

    /**
     * Attach sender and receiver to a chat instance
     *
     * @return \Illuminate\Database\Eloquent\Query
     */
    public function scopeWithUsers($query)
    {
        return $query->with(['sender', 'receiver']);
    }

    /**
     * Attach sender to a chat instance
     *
     * @return \Illuminate\Database\Eloquent\Query
     */
    public function scopeWithSender($query)
    {
        return $query->with('sender');
    }

    /**
     * Attach last message to a chat instance
     *
     * @return \Illuminate\Database\Eloquent\Query
     */
    public function scopeWithLastMessage($query)
    {
        return $query->with('lastMessage');
    }

    /**
     * Attach vendor to a chat instance
     *
     * @return \Illuminate\Database\Eloquent\Query
     */
    public function scopeVendor($query)
    {
        return $query->hasOne(Vendor::class, 'id', 'receiver_id');
    }

    /**
     * Get all the chat instances with last message, sender and receiver details
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getMyContactListWithLastMessage()
    {
        $chats = static::with(['sender:id,name', 'LastMessage'])->select('*')->get()->sortByDesc(function ($chat) {
            return $chat->LastMessage->id;
        });

        $receivers = $chats->pluck('receiver_id')->unique()->toArray();

        $chats->vendors = Vendor::join('vendor_users', 'vendor_users.vendor_id', '=', 'vendors.id')
            ->whereIn('vendor_users.user_id', $receivers)
            ->select('vendors.name', 'vendors.id', 'vendor_users.user_id as user_id')
            ->get();

        return $chats;
    }

    /**
     * Check if the chat has been instantiated by the logged in user
     *
     * @return bool
     */
    public function sendByMe()
    {
        return $this->sender_id == auth()->id();
    }

    /**
     * Get vendor details of the given chat receiver
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getVendor()
    {
        return VendorUser::getVendorDetails($this->receiver_id);
    }

    /**
     * Get vendor name attribute with chat
     *
     * @return mixed
     */
    protected function getVendorNameAttribute()
    {
        return $this->vendorDetails ? $this->vendorDetails->name : $this->receiver->name;
    }
}
