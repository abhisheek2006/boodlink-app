<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'role',
        'name',
        'email',
        'password',
        'phone',
        'gender',
        'dob',
        'profile_photo',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'dob' => 'date',
            'suspended_until' => 'datetime',
            'banned_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ── Relationships ────────────────────────────────────────────

    public function donor(): HasOne
    {
        return $this->hasOne(Donor::class);
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /** Moderation actions taken against this user. */
    public function moderationLogs(): HasMany
    {
        return $this->hasMany(UserModerationLog::class, 'user_id');
    }

    /** Moderation actions this user (as admin) performed on others. */
    public function moderationActionsPerformed(): HasMany
    {
        return $this->hasMany(UserModerationLog::class, 'admin_id');
    }

    /** Audit log entries where this user was the admin actor. */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'admin_id');
    }

    /** Donor detail share records involving this user. */
    public function donorDetailShares(): HasMany
    {
        if ($this->isDonor() && $this->donor) {
            return $this->hasMany(DonorDetailShare::class, 'donor_id');
        }

        if ($this->isPatient() && $this->patient) {
            return $this->hasMany(DonorDetailShare::class, 'patient_id');
        }

        return $this->hasMany(DonorDetailShare::class, 'donor_id')
            ->where('donor_id', 0);
    }

    public function bannedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'banned_by');
    }

    // ── Role helpers ─────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    public function isDonor(): bool
    {
        return $this->role === 'Donor';
    }

    public function isPatient(): bool
    {
        return $this->role === 'Patient';
    }

    // ── Status helpers ───────────────────────────────────────────

    public function isActiveAccount(): bool
    {
        return $this->status === 'Active';
    }

    public function isBanned(): bool
    {
        return $this->status === 'Banned';
    }

    public function isSuspended(): bool
    {
        if ($this->status !== 'Suspended') {
            return false;
        }

        // Suspension with an expiry that has passed is effectively over.
        return $this->suspended_until === null || $this->suspended_until->isFuture();
    }

    public function dashboardRoute(): string
    {
        return match ($this->role) {
            'Admin' => 'admin.dashboard',
            'Donor' => 'donor.dashboard',
            'Patient' => 'patient.dashboard',
        };
    }

    /** Send our own branded reset email instead of Laravel's plain default. */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
