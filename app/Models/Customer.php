<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';
    public $timestamps = false;

    protected $fillable = [
        'store_id',
        'first_name',
        'last_name',
        'email',
        'address_id',
        'active',
        'create_date',
        'last_update'
    ];

    // Relaciones
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'store_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class, 'customer_id', 'customer_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'customer_id', 'customer_id');
    }

    // Útil para listas
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Scopes prácticos
    public function scopeActive($q)
    {
        return $q->where('active', 1);
    }

    public function activeRentals()
    {
        return $this->hasMany(\App\Models\Rental::class, 'customer_id', 'customer_id')
            ->whereNull('return_date');
    }

    public function getHasDebtAttribute(): bool
    {
        return $this->activeRentals()->exists();
    }
}
