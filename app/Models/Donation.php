<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    // Seuls ces champs peuvent venir directement du formulaire de proposition de don.
    protected $fillable = [
        'user_id',
        'donor_type',
        'donation_type',
        'name',
        'email',
        'organization',
        'amount',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        // Le montant reste précis pour l'affichage et les futurs traitements financiers.
        return [
            'amount' => 'decimal:2',
        ];
    }
}
