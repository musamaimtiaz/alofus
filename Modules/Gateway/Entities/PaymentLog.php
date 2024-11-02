<?php

namespace Modules\Gateway\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentLog extends Model
{
    use HasFactory;

    protected $table = 'payment_logs';

    protected $fillable = ['code', 'total', 'sending_details', 'currency_code', 'status'];

    protected static function newFactory()
    {
        return \Modules\Gateway\Database\factories\PaymentLogFactory::new();
    }

    public function scopeUniqueCode($query, $code)
    {
        return $query->where('unique_code', $code);
    }

    public function getSendingDetailsAttribute()
    {
        return json_decode($this->attributes['sending_details']);
    }
}
