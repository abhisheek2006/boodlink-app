<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BloodRequest extends Model
{
    /** @use HasFactory<\Database\Factories\BloodRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'donor_id',
        'blood_group_id',
        'units_required',
        'emergency_level',
        'reason',
        'hospital_name',
        'required_date',
        'additional_notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'units_required' => 'integer',
            'required_date' => 'date',
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

    public function bloodGroup(): BelongsTo
    {
        return $this->belongsTo(BloodGroup::class);
    }

    public function donationSession(): HasOne
    {
        return $this->hasOne(DonationSession::class);
    }

    public function donorDetailShares(): HasMany
    {
        return $this->hasMany(DonorDetailShare::class);
    }
}
