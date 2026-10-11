<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'coach_id',
        'trainee_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin' || empty($this->role);
    }

    public function isCoach(): bool
    {
        return $this->role === 'coach';
    }

    public function isPlayer(): bool
    {
        return $this->role === 'player';
    }

    public function isScorer(): bool
    {
        return $this->role === 'scorer';
    }

    public function getDashboardRoute(): string
    {
        if ($this->isPlayer()) {
            return route('dashboard.player');
        }
        if ($this->isCoach()) {
            return route('dashboard.coach');
        }
        if ($this->isScorer()) {
            return route('dashboard.scorer');
        }
        return route('dashboard.admin');
    }

    public function assignedMatches()
    {
        return $this->hasMany(LiveMatch::class, 'scorer_id');
    }
}
