<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
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
        return [
            'slot_date' => 'date',
        ];
    }
}
