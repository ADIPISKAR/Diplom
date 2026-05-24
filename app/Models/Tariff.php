<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tariff extends Model
{
    protected $fillable = [
        'name',
        'price_per_30_min',
        'price_per_hour',
        'price_per_day',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_per_30_min' => 'decimal:2',
        'price_per_hour' => 'decimal:2',
        'price_per_day' => 'decimal:2',
    ];

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
}
