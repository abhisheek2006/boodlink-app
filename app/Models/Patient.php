<?php

namespace App\Models;

use Database\Factories\PatientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    /** @use HasFactory<PatientFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'city',
        'state',
        'pincode',
        'emergency_contact',
        'required_blood_group_id',
    ];

    // ── Relationships ────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function requiredBloodGroup(): BelongsTo
    {
        return $this->belongsTo(BloodGroup::class, 'required_blood_group_id');
    }

    public function bloodRequests(): HasMany
    {
        return $this->hasMany(BloodRequest::class);
    }

    public function donationSessions(): HasMany
    {
        return $this->hasMany(DonationSession::class);
    }
}
