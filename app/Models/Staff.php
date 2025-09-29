<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';
    protected $primaryKey = 'staff_id';
    public $timestamps = false;

    protected $fillable = [
        'first_name','last_name','address_id','email',
        'store_id','active','username','password','picture','last_update'
    ];

    protected $hidden = ['password']; // por si expones JSON

    // Relaciones
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'store_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class, 'staff_id', 'staff_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'staff_id', 'staff_id');
    }

    // Si este staff es manager de alguna tienda
    public function managesStore()
    {
        return $this->hasOne(Store::class, 'manager_staff_id', 'staff_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
