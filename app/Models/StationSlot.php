<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StationSlot extends Model
{
    protected $fillable = ['station_id', 'slot_number', 'status'];

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function powerbank(): HasOne
    {
        return $this->hasOne(Powerbank::class, 'slot_id');
    }

    public function returns(): HasMany
    {
        return $this->hasMany(ReturnModel::class, 'slot_id');
    }
}
