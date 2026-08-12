<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

/**
 * Lightweight facade around the audit_logs table.
 *
 * Controllers and services call this to record state-changing actions
 * (request accepted, donation completed, user banned, etc.).
 */
class AuditLogService
{
    /**
     * @param  Model|string  $target  Eloquent model (or null)
     */
    public function log(
        string $action,
        ?string $modelType = null,
        Model|string|null $target = null,
        ?int $userId = null,
        array $metadata = [],
    ): AuditLog {
        $modelType = $modelType ?? ($target ? get_class($target) : null);
        $modelId = $target instanceof Model ? $target->getKey() : ($target ?? null);

        return AuditLog::create([
            'admin_id' => $userId ?? request()->user()?->id,
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'metadata' => $metadata ?: null,
        ]);
    }

    // ── Convenience wrappers ───────────────────────────────────────

    public function logBloodRequestCreated(Model $model, array $metadata = []): AuditLog
    {
        return $this->log('created', null, $model, null, $metadata);
    }

    public function logDonationCompleted(Model $model, array $metadata = []): AuditLog
    {
        return $this->log('donation_completed', null, $model, null, $metadata);
    }

    public function logBloodRequestAccepted(Model $model, array $metadata = []): AuditLog
    {
        return $this->log('accepted', null, $model, null, $metadata);
    }

    public function logRequestRejected(Model $model, array $metadata = []): AuditLog
    {
        return $this->log('rejected', null, $model, null, $metadata);
    }

    public function logRequestCancelled(Model $model, array $metadata = []): AuditLog
    {
        return $this->log('cancelled', null, $model, null, $metadata);
    }
}
