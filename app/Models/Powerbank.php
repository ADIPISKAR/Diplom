<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Powerbank extends Model
{
    protected $fillable = [
        'station_id',
        'code',
        'capacity_mah',
        'status',
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
