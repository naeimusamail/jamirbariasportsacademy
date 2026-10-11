<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_no',
        'trainee_id',
        'sport_id',
        'title',
        'certificate_type',
        'event_or_course',
        'issue_date',
        'description',
        'grade_or_rank',
        'instructor_name',
        'status',
    ];

    protected $casts = [
        'issue_date' => 'date',
    ];

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function getTypeNameAttribute()
    {
        return match($this->certificate_type) {
            'achievement' => 'অর্জন ও গৌরব সনদ',
            'participation' => 'অংশগ্রহণ সনদপত্র',
            'appreciation' => 'বিশেষ সম্মাননা সনদ',
            default => 'প্রশিক্ষণ সমাপ্তি সনদপত্র',
        };
    }
}

