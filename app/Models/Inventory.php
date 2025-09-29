<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';
    protected $primaryKey = 'inventory_id';
    public $timestamps = false;
    protected $fillable = ['film_id','store_id'];

    public function film()   { return $this->belongsTo(Film::class, 'film_id'); }
    public function rentals(){ return $this->hasMany(Rental::class, 'inventory_id'); }
}
