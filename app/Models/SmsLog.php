<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipient_group',
        'recipient_count',
        'sample_recipients',
        'message',
        'sms_parts',
        'gateway_status',
        'sent_by_user_id',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by_user_id');
    }
}

