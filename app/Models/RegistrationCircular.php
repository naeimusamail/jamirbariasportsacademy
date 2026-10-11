<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationCircular extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'tournament_id',
        'title',
        'description',
        'fee',
        'is_active',
        'start_date',
        'end_date',
        'upcoming_message',
        'closed_message',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'fee' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Determine if circular is currently open for submissions
     */
    public function isOpen(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->start_date && now()->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && now()->gt($this->end_date)) {
            return false;
        }

        return true;
    }

    /**
     * Determine if circular registration has not started yet
     */
    public function isUpcoming(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        return (bool) ($this->start_date && now()->lt($this->start_date));
    }

    /**
     * Determine if circular registration has ended or is closed
     */
    public function isClosed(): bool
    {
        if (!$this->is_active) {
            return true;
        }

        if ($this->end_date && now()->gt($this->end_date)) {
            return true;
        }

        return false;
    }

    /**
     * Return current registration status key
     */
    public function getStatus(): string
    {
        if (!$this->is_active) {
            return 'paused';
        }

        if ($this->isUpcoming()) {
            return 'upcoming';
        }

        if ($this->isClosed()) {
            return 'closed';
        }

        return 'open';
    }

    /**
     * Human-friendly Bengali status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->getStatus()) {
            'open' => 'চলমান (Open)',
            'upcoming' => 'আসন্ন (Upcoming)',
            'closed' => 'মেয়াদ সমাপ্ত (Closed)',
            'paused' => 'সাময়িক স্থগিত (Paused)',
            default => 'অনির্ধারিত',
        };
    }

    /**
     * Visual styling for badge
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->getStatus()) {
            'open' => [
                'label' => 'উন্মুক্ত / চলমান',
                'bg' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30',
                'dot' => 'bg-emerald-400',
            ],
            'upcoming' => [
                'label' => 'আসন্ন (অপেক্ষমাণ)',
                'bg' => 'bg-amber-500/10 text-amber-400 border-amber-500/30',
                'dot' => 'bg-amber-400',
            ],
            'closed' => [
                'label' => 'সময়সীমা শেষ',
                'bg' => 'bg-rose-500/10 text-rose-400 border-rose-500/30',
                'dot' => 'bg-rose-400',
            ],
            'paused' => [
                'label' => 'সাময়িক স্থগিত',
                'bg' => 'bg-slate-500/10 text-slate-300 border-slate-500/30',
                'dot' => 'bg-slate-400',
            ],
            default => [
                'label' => 'সাধারণ',
                'bg' => 'bg-gray-500/10 text-gray-300 border-gray-500/30',
                'dot' => 'bg-gray-400',
            ],
        };
    }

    /**
     * Relationship to linked Tournament / Event
     */
    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }

    /**
     * Relationship to linked Admission Applications
     */
    public function admissionApplications()
    {
        return $this->hasMany(AdmissionApplication::class, 'registration_circular_id');
    }

    /**
     * Bengali name of the circular type
     */
    public function getTypeNameAttribute(): string
    {
        if ($this->tournament_id || str_starts_with($this->type, 'tournament_')) {
            $name = $this->tournament?->name ?? 'টুর্নামেন্ট';
            return '🏆 ইভেন্ট: ' . $name;
        }

        return match ($this->type) {
            'admission' => 'একাডেমি ভর্তি আবেদন',
            'volunteer' => 'স্বেচ্ছাসেবক (ভলান্টিয়ার) নিবন্ধন',
            'local_player' => 'উন্মুক্ত প্লেয়ার টুর্নামেন্ট ড্রাফট পাস',
            default => ucfirst(str_replace('_', ' ', $this->type)),
        };
    }

    /**
     * Type icon
     */
    public function getTypeIconAttribute(): string
    {
        if ($this->tournament_id || str_starts_with($this->type, 'tournament_')) {
            return '🏆';
        }

        return match ($this->type) {
            'admission' => '🎓',
            'volunteer' => '🤝',
            'local_player' => '⚡',
            default => '📄',
        };
    }

    /**
     * Public application URL for this circular type
     */
    public function getApplyUrlAttribute(): string
    {
        if ($this->tournament_id) {
            $tournament = $this->tournament ?? Tournament::find($this->tournament_id);
            if ($tournament) {
                return route('public.tournaments.register', $tournament->slug);
            }
        }

        return match ($this->type) {
            'admission' => route('admission.create', ['circular_id' => $this->id]),
            'volunteer' => route('volunteer.create'),
            'local_player' => route('public.local-players.create'),
            default => '#',
        };
    }

    /**
     * Public tracking URL for this circular type
     */
    public function getTrackUrlAttribute(): ?string
    {
        return match ($this->type) {
            'admission' => route('admission.track'),
            'volunteer' => route('volunteer.tracking', 'VOL-SEARCH'),
            default => null,
        };
    }

    /**
     * Static helper: Get circular by type with fallback
     */
    public static function ofType(string $type): self
    {
        // For admission or other types, prefer the currently open active circular or the latest active
        $circular = static::where('type', $type)
            ->where('is_active', true)
            ->latest('id')
            ->first();

        if ($circular) {
            return $circular;
        }

        $circular = static::where('type', $type)->latest('id')->first();
        if ($circular) {
            return $circular;
        }

        return static::create([
            'type' => $type,
            'title' => ucfirst($type) . ' Circular',
            'is_active' => true,
        ]);
    }

    /**
     * Static helper: Check if circular is open
     */
    public static function isTypeOpen(string $type): bool
    {
        $circular = static::where('type', $type)->where('is_active', true)->latest('id')->first();
        if (!$circular) {
            return true; // Default open if not set
        }
        return $circular->isOpen();
    }
}

