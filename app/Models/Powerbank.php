<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Powerbank extends Model
{
    protected $fillable = [
        'serial_number',
        'station_id',
        'slot_id',
        'charge_level',
        'status',
        'condition',
    ];

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(StationSlot::class, 'slot_id');
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function returns(): HasMany
    {
        return $this->hasMany(ReturnModel::class);
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }
}
