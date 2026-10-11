<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'trainee_id',
        'title',
        'fee_type',
        'amount',
        'month',
        'year',
        'payment_method',
        'transaction_id',
        'sender_number',
        'received_by',
        'status',
        'payment_date',
        'note',
    ];

    public static function paymentMethodNames()
    {
        return [
            'cash' => 'নগদ ক্যাশ (Cash)',
            'bkash' => 'বিকাশ (bKash)',
            'nagad' => 'নগদ (Nagad)',
            'rocket' => 'রকেট (Rocket)',
            'bank' => 'ব্যাংক ট্রান্সফার / চেক (Bank)',
        ];
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }
}

