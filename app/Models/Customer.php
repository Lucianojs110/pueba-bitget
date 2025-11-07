<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'notes',
    ];

    /**
     * Relación: un cliente puede tener varios vehículos.
     */
    public function assets()
    {
        //     return $this->hasMany(Asset::class);
    }

    /**
     * Relación: un cliente puede tener varias órdenes de trabajo (a través de sus vehículos o directamente).
     */
    public function workOrders()
    {
        //     return $this->hasMany(WorkOrder::class);
    }
}
