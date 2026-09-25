<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssociationNeed extends Model
{
    // Les quantités permettent de calculer la barre de progression du besoin en temps réel.
    protected $fillable = [
        'user_id',
        'name',
        'current_quantity',
        'target_quantity',
        'unit',
        'status',
    ];
}
