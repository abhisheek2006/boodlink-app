<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DonationSession extends Model
{
    /** @use HasFactory<\Database\Factories\DonationSessionFactory> */
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'donor_id',
        'blood_request_id',
        'started_at',
        'expires_at',
        'ended_at',
        'status',
        'contact_shared',
        'session_duration',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'expires_at' => 'datetime',
            'ended_at' => 'datetime',
            'contact_shared' => 'boolean',
            'session_duration' => 'integer',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    public function bloodRequest(): BelongsTo
    {
        return $this->belongsTo(BloodRequest::class);
    }

    public function chatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'session_id');
    }

    public function isExpired(): bool
    {
        return $this->status === 'Active' && $this->expires_at->isPast();
    }
}
