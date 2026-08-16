<?php

namespace App\Models;

use App\Events\NotificationCreated;
use Database\Factories\NotificationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App-level notification record (distinct from Illuminate\Notifications).
 * Backed by the `app_notifications` table.
 */
class Notification extends Model
{
    /** @use HasFactory<NotificationFactory> */
    use HasFactory;

    protected $table = 'app_notifications';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'is_read',
    ];

    protected $attributes = [
        'created_at' => null,
    ];

    protected static function booted(): void
    {
        static::creating(function (self $notification) {
            $notification->created_at ??= now();
        });

        static::created(function (self $notification) {
            try {
                broadcast(new NotificationCreated($notification));
            } catch (\Throwable $e) {
                // Broadcasting (Reverb/WebSocket) is best-effort.
                // If the WS server is not running the notification is still
                // persisted to the database, so listeners will pick it up
                // on the next page load / poll cycle.
            }
        });
    }

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }
}
