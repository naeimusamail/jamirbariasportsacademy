<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainee extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_no',
        'player_type', // academic, local
        'sport_id',
        'batch_id',
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
        'monthly_fee',
        'admission_date',
        'photo',
        'status',
    ];

    public function scopeAcademic($query)
    {
        return $query->where('player_type', 'academic');
    }

    public function scopeLocal($query)
    {
        return $query->where('player_type', 'local');
    }

    public function isLocal(): bool
    {
        return $this->player_type === 'local';
    }

    public function isAcademic(): bool
    {
        return $this->player_type !== 'local';
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function sports()
    {
        return $this->belongsToMany(Sport::class, 'sport_trainee')
            ->withPivot(['position', 'jersey_no', 'is_primary'])
            ->withTimestamps();
    }

    public function teamPlayers()
    {
        return $this->hasMany(TeamPlayer::class);
    }

    public function getSportNamesAttribute()
    {
        $names = $this->sports->pluck('name');
        if ($names->isEmpty() && $this->sport) {
            return $this->sport->name;
        }
        return $names->implode(', ');
    }

    public function hasSport($sportId): bool
    {
        if ($this->sport_id == $sportId) {
            return true;
        }
        return $this->sports->contains('id', $sportId);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function fitnessRecords()
    {
        return $this->hasMany(FitnessRecord::class)->orderBy('test_date', 'desc');
    }

    public function latestFitness()
    {
        return $this->hasOne(FitnessRecord::class)->latestOfMany('test_date');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class)->latest('issue_date');
    }

    public function trainingTasks()
    {
        return $this->hasMany(TrainingTask::class)->latest('due_date');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function galleries()
    {
        return $this->hasMany(PlayerGallery::class)->latest();
    }

    public function featuredGalleries()
    {
        return $this->hasMany(PlayerGallery::class)->where('is_featured', true)->latest();
    }
}

