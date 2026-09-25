<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssociationEvent extends Model
{
    // L'association propriétaire sert à afficher son nom dans les flux publics.
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
        // Le formatage de la date est fait directement dans les cartes et le détail d'événement.
        return [
            'starts_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
