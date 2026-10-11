<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainee_id',
        'team_player_id',
        'title',
        'description',
        'image_path',
        'category',
        'match_name',
        'event_date',
        'is_featured',
        'uploaded_by',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'event_date' => 'date',
    ];

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function teamPlayer()
    {
        return $this->belongsTo(TeamPlayer::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'match_action' => 'ম্যাচ অ্যাকশন ⚽🏏',
            'training' => 'ট্রেনিং মুহূর্ত 🏃',
            'celebration' => 'উদযাপন ও ট্রফি 🏆',
            'promo' => 'প্রোমো ও পোর্ট্রেট 🌟',
            default => 'অন্যান্য মুহূর্ত 📸',
        };
    }

    public function getCategoryBadgeClassAttribute(): string
    {
        return match ($this->category) {
            'match_action' => 'bg-rose-500/20 text-rose-300 border-rose-500/30',
            'training' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30',
            'celebration' => 'bg-amber-500/20 text-amber-300 border-amber-500/30',
            'promo' => 'bg-cyan-500/20 text-cyan-300 border-cyan-500/30',
            default => 'bg-purple-500/20 text-purple-300 border-purple-500/30',
        };
    }

    public function getImageUrlAttribute(): string
    {
        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }

        return asset('storage/' . $this->image_path);
    }
}

