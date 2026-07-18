<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    /** @use HasFactory<\Database\Factories\ChatMessageFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'sender_id',
        'receiver_id',
        'message',
        'message_type',
        'seen',
    ];

    protected $attributes = [
        'created_at' => null,
    ];

    protected static function booted(): void
    {
        static::creating(function (self $message) {
            $message->created_at ??= now();
        });
    }

    protected function casts(): array
    {
        return [
            'seen' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(DonationSession::class, 'session_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
