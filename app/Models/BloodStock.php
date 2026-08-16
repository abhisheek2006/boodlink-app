<?php

namespace App\Models;

use Database\Factories\BloodStockFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloodStock extends Model
{
    /** @use HasFactory<BloodStockFactory> */
    use HasFactory;

    protected $fillable = [
        'blood_group_id',
        'units',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'units' => 'integer',
        ];
    }

    public function bloodGroup(): BelongsTo
    {
        return $this->belongsTo(BloodGroup::class);
    }

    public function refreshStatus(): void
    {
        $this->status = match (true) {
            $this->units <= 5 => 'Critical',
            $this->units <= 20 => 'Low',
            default => 'Sufficient',
        };
    }
}
