<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $fillable = [
        'price_per_hour',
        'description',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
