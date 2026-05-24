<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Station extends Model
{
    protected $fillable = [
        'name',
        'building',
        'floor',
        'location_description',
        'qr_code',
        'total_slots',
        'status',
    ];

    public function slots(): HasMany
    {
        return $this->hasMany(StationSlot::class);
    }

    public function powerbanks(): HasMany
    {
        return $this->hasMany(Powerbank::class);
    }

    public function returns(): HasMany
    {
        return $this->hasMany(ReturnModel::class);
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    public function availablePowerbanks(): HasMany
    {
        return $this->powerbanks()->where('status', 'available')->where('condition', 'good');
    }
}
