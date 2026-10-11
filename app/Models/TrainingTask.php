<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'batch_id',
        'trainee_id',
        'title',
        'description',
        'sport_type',
        'drill_category',
        'due_date',
        'priority',
        'status',
        'player_note',
        'coach_score',
        'coach_feedback',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function getCategoryNameAttribute()
    {
        return match($this->drill_category) {
            'fitness' => 'ফিটনেস ও স্ট্যামিনা ড্রিল',
            'tactical' => 'কৌশলগত প্রশিক্ষণ (Tactical)',
            'technical' => 'টেকনিক্যাল স্কিল অনুশীলন',
            'recovery' => 'রিকভারি ও স্ট্রেচিং',
            default => 'সাধারণ ট্রেনিং ড্রিল',
        };
    }

    public function getDrillNameAttribute()
    {
        return $this->category_name;
    }

    public function getCategoryIconAttribute()
    {
        return match($this->drill_category) {
            'fitness' => '⚡',
            'tactical' => '🧠',
            'technical' => '🎯',
            'recovery' => '🧘',
            default => '🏃',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'reviewed' => 'মূল্যায়িত (Reviewed)',
            'completed' => 'সম্পন্ন (Completed)',
            default => 'চলমান (Pending)',
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'reviewed' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20',
            'completed' => 'bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20',
            default => 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20',
        };
    }

    public function getPriorityLabelAttribute()
    {
        return match($this->priority) {
            'high' => 'জরুরি (High)',
            'low' => 'ঐচ্ছিক (Low)',
            default => 'সাধারণ (Normal)',
        };
    }

    public function getPriorityBadgeClassAttribute()
    {
        return match($this->priority) {
            'high' => 'bg-rose-500/10 text-rose-500 border border-rose-500/20',
            'low' => 'bg-slate-500/10 text-slate-400 border border-slate-500/20',
            default => 'bg-blue-500/10 text-blue-500 border border-blue-500/20',
        };
    }

    public function getIsOverdueAttribute()
    {
        return $this->status === 'pending' && $this->due_date && $this->due_date->isPast();
    }
}
