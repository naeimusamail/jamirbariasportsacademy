<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_no',
        'registration_circular_id',
        'sport_id',
        'sports_applied',
        'name',
        'name_en',
        'guardian_name',
        'phone',
        'emergency_phone',
        'date_of_birth',
        'blood_group',
        'nid_or_birth_cert',
        'category',
        'position',
        'jersey_no',
        'address',
        'organization_or_area',
        'photo',
        'payment_method',
        'payment_amount',
        'transaction_id',
        'sender_number',
        'payment_status',
        'status',
        'admin_notes',
        'trainee_id',
    ];

    protected $casts = [
        'sports_applied' => 'array',
    ];

    public function getAppliedSportsAttribute()
    {
        if (!empty($this->sports_applied) && is_array($this->sports_applied)) {
            return Sport::whereIn('id', $this->sports_applied)->get();
        }
        return $this->sport ? collect([$this->sport]) : collect();
    }

    public static function paymentMethodNames()
    {
        return [
            'cash' => 'অফিস ক্যাশ (Office Cash)',
            'bkash' => 'বিকাশ (bKash Send Money)',
            'nagad' => 'নগদ (Nagad Send Money)',
            'rocket' => 'রকেট (Rocket Send Money)',
            'bank' => 'ব্যাংক ডিপোজিট (Bank Transfer)',
        ];
    }

    public function circular()
    {
        return $this->belongsTo(RegistrationCircular::class, 'registration_circular_id');
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }
}

