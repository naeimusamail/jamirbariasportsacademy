<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_no',
        'tournament_id',
        'volunteer_id',
        'title',
        'item_name',
        'category',
        'unit_price',
        'quantity',
        'amount',
        'expense_date',
        'payment_method',
        'paid_to',
        'note',
        'receipt_photo',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'quantity' => 'decimal:2',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }

    public static function categoryNames(): array
    {
        return [
            'volunteer_allowance' => '🤝 ভলান্টিয়ার খরচ (টি-শার্ট, খাবার, যাতায়াত ভাতা)',
            'cricket_balls' => '🔴 বলের খরচ (ক্রিকেট বল / ফুটবল)',
            'sports_gear' => '🏏 ব্যাট ও ক্রীড়া সরঞ্জাম (ব্যাট, প্যাড, গ্লাভস, উইকেট, নেট)',
            'umpire_fees' => '⚖️ আম্পায়ার ও ম্যাচ অফিশিয়াল ফি',
            'ground_maintenance' => '🏟️ মাঠ প্রস্তুতি ও পিচ রক্ষণাবেক্ষণ',
            'prizes_trophies' => '🏆 ট্রফি, মেডেল, ক্রেস্ট ও প্রাইজ মানি',
            'sound_banner' => '📢 সাউন্ড সিস্টেম, মাইক, ব্যানার ও ডেকোরেশন',
            'refreshment' => '☕ নাস্তা, পানি ও রিফ্রেশমেন্ট',
            'medical' => '🚑 ফার্স্ট এইড ও চিকিৎসা সামগ্রী',
            'coach_salary' => 'কোচ ও স্টাফদের বেতন',
            'tournament' => 'সাধারণ টুর্নামেন্ট আয়োজন',
            'utilities' => 'বিদ্যুৎ ও একাডেমি বিল',
            'other' => 'অন্যান্য খরচ',
        ];
    }

    public function getCategoryLabelAttribute(): string
    {
        return static::categoryNames()[$this->category] ?? ucfirst($this->category);
    }

    public function getCategoryBadgeAttribute(): array
    {
        return match ($this->category) {
            'volunteer_allowance' => ['bg' => 'bg-amber-500/10 text-amber-400 border-amber-500/30', 'icon' => '🤝'],
            'cricket_balls' => ['bg' => 'bg-rose-500/10 text-rose-400 border-rose-500/30', 'icon' => '🔴'],
            'sports_gear' => ['bg' => 'bg-blue-500/10 text-blue-400 border-blue-500/30', 'icon' => '🏏'],
            'umpire_fees' => ['bg' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/30', 'icon' => '⚖️'],
            'ground_maintenance' => ['bg' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30', 'icon' => '🏟️'],
            'prizes_trophies' => ['bg' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/30', 'icon' => '🏆'],
            'sound_banner' => ['bg' => 'bg-purple-500/10 text-purple-400 border-purple-500/30', 'icon' => '📢'],
            'refreshment' => ['bg' => 'bg-teal-500/10 text-teal-400 border-teal-500/30', 'icon' => '☕'],
            'medical' => ['bg' => 'bg-red-500/10 text-red-400 border-red-500/30', 'icon' => '🚑'],
            default => ['bg' => 'bg-slate-500/10 text-slate-400 border-slate-500/30', 'icon' => '💸'],
        };
    }
}
