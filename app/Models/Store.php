<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'store';
    protected $primaryKey = 'store_id';
    public $timestamps = false;

    protected $fillable = [
        'manager_staff_id', 'address_id', 'last_update'
    ];

    // Relaciones
    public function manager()
    {
        return $this->belongsTo(Staff::class, 'manager_staff_id', 'staff_id');
    }

    public function staff()
    {
        return $this->hasMany(Staff::class, 'store_id', 'store_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'store_id', 'store_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'store_id', 'store_id');
    }

    // Rentals de la tienda (vía inventory)
    public function rentals()
    {
        return $this->hasManyThrough(
            Rental::class,        // Modelo final
            Inventory::class,     // Modelo intermedio
            'store_id',           // FK en Inventory que apunta a Store
            'inventory_id',       // FK en Rental que apunta a Inventory
            'store_id',           // Local key en Store
            'inventory_id'        // Local key en Inventory
        );
    }
}
