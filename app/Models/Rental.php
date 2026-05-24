<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rental extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'powerbank_id',
        'start_station_id',
        'return_station_id',
        'tariff_id',
        'started_at',
        'ended_at',
        'status',
        'total_price',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function powerbank(): BelongsTo
    {
        return $this->belongsTo(Powerbank::class);
    }

    public function startStation(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'start_station_id');
    }

    public function returnStation(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'return_station_id');
    }

    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function returnRecord(): HasOne
    {
        return $this->hasOne(ReturnModel::class);
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    public function calculatePrice(?CarbonInterface $until = null): float
    {
        $until ??= now();
        $minutes = max(1, $this->started_at->diffInMinutes($until));
        $tariff = $this->tariff;

        if ($minutes <= 30) {
            return (float) $tariff->price_per_30_min;
        }

        if ($minutes <= 60) {
            return (float) $tariff->price_per_hour;
        }

        $days = (int) ceil($minutes / 1440);

        return $days * (float) $tariff->price_per_day;
    }
}
