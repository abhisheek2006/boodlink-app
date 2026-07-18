<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

/**
 * Broadcast on the recipient's private user channel so the notification
 * bell updates and chimes instantly, without a page reload or polling.
 */
class NotificationCreated implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(public Notification $notification)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->notification->user_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'notification.created';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->notification->id,
            'title' => $this->notification->title,
            'message' => $this->notification->message,
            'created_at_human' => $this->notification->created_at->diffForHumans(),
        ];
    }
}
