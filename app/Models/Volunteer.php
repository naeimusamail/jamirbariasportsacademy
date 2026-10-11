<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'volunteer_no',
        'name',
        'name_en',
        'phone',
        'emergency_phone',
        'email',
        'date_of_birth',
        'gender',
        'blood_group',
        'tshirt_size',
        'department',
        'organization_or_institution',
        'address',
        'experience',
        'photo',
        'tournament_id',
        'assigned_duties',
        'assigned_venue',
        'status',
        'approved_at',
        'admin_notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'approved_at' => 'datetime',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function getTotalAllowancesAttribute(): float
    {
        return (float) $this->expenses()->sum('amount');
    }

    public static function departments(): array
    {
        return [
            'ground' => '🏟️ মাঠ ও পিচ ব্যবস্থাপনা (Ground)',
            'media' => '📸 মিডিয়া ও ফটোগ্রাফি (Media)',
            'medical' => '🚑 প্রাথমিক চিকিৎসা ও ফার্স্ট এইড (Medical)',
            'security' => '🛡️ শৃঙ্খলা ও ক্রাউড কন্ট্রোল (Security)',
            'hospitality' => '🥤 রিফ্রেশমেন্ট ও আপ্যায়ন (Hospitality)',
            'technical' => '📊 টেকনিক্যাল ও স্কোরবোর্ড (Technical)',
            'general' => '🤝 সাধারণ পরিচালনা (General Support)',
        ];
    }

    public static function tshirtSizes(): array
    {
        return ['S', 'M', 'L', 'XL', 'XXL'];
    }

    public function getDepartmentNameAttribute(): string
    {
        return self::departments()[$this->department] ?? ucfirst($this->department);
    }

    public static function generateVolunteerNo(): string
    {
        $year = date('Y');
        $count = self::whereYear('created_at', $year)->count() + 1;
        return 'VOL-' . $year . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}

