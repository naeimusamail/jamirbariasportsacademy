<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;

    protected $fillable = [
        'sport_id',
        'name',
        'phone',
        'email',
        'designation',
        'experience',
        'status',
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function trainingTasks()
    {
        return $this->hasMany(TrainingTask::class)->latest('due_date');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}

