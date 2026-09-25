<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    // Une réservation peut représenter une aide, un bénévolat ou un événement associatif.
    protected $fillable = [
        'user_id',
        'service_key',
        'service_name',
        'slot_date',
        'slot_time',
        'status',
    ];

    protected function casts(): array
    {
        // Les dates sont converties en objets Carbon pour les vues et les contrôles de disponibilité.
        return [
            'slot_date' => 'date',
        ];
    }
}
