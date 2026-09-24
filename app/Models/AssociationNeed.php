<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssociationNeed extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'current_quantity',
        'target_quantity',
        'unit',
        'status',
    ];
}
