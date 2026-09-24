<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssociationEvent extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'location',
        'starts_at',
        'capacity',
        'event_type',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
