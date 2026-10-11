<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon', 'description'];

    public function coaches()
    {
        return $this->hasMany(Coach::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function trainees()
    {
        return $this->belongsToMany(Trainee::class, 'sport_trainee')
            ->withPivot(['position', 'jersey_no', 'is_primary'])
            ->withTimestamps();
    }

    public function primaryTrainees()
    {
        return $this->hasMany(Trainee::class);
    }

    public function notices()
    {
        return $this->hasMany(Notice::class);
    }
}

