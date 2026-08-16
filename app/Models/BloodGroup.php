<?php

namespace App\Models;

use Database\Factories\BloodGroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BloodGroup extends Model
{
    /** @use HasFactory<BloodGroupFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function donors(): HasMany
    {
        return $this->hasMany(Donor::class);
    }

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class, 'required_blood_group_id');
    }

    public function bloodRequests(): HasMany
    {
        return $this->hasMany(BloodRequest::class);
    }

    public function bloodStock(): HasOne
    {
        return $this->hasOne(BloodStock::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'Active';
    }

    /** Whether this blood group is referenced anywhere and cannot be deleted. */
    public function isInUse(): bool
    {
        return $this->donors()->exists()
            || $this->patients()->exists()
            || $this->bloodRequests()->exists()
            || $this->bloodStock()->exists();
    }
}
