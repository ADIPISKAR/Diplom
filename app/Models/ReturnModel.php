<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnModel extends Model
{
    protected $table = 'returns';

    public $timestamps = false;

    protected $fillable = [
        'rental_id',
        'user_id',
        'powerbank_id',
        'station_id',
        'slot_id',
        'returned_at',
        'status',
        'comment',
    ];

    protected $casts = [
        'returned_at' => 'datetime',
    ];

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function powerbank(): BelongsTo
    {
        return $this->belongsTo(Powerbank::class);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(StationSlot::class, 'slot_id');
    }
}
