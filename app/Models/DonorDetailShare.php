<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Records when a donor shares their contact details with a patient
 * for a specific donation session, and any subsequent revocation.
 *
 * @property int $donation_session_id
 * @property int $donor_id
 * @property int $patient_id
 * @property string $shared_at
 * @property string|null $revoked_at
 */
class DonorDetailShare extends Model
{
    protected $fillable = [
        'donation_session_id',
        'donor_id',
        'patient_id',
        'shared_at',
        'revoked_at',
    ];

    protected $casts = [
        'shared_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function donationSession(): BelongsTo
    {
        return $this->belongsTo(DonationSession::class);
    }

    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function isActive(): bool
    {
        return $this->revoked_at === null;
    }
}
