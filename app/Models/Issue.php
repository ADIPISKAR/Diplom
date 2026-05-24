<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Issue extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'rental_id',
        'station_id',
        'powerbank_id',
        'issue_type',
        'description',
        'status',
        'resolved_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function powerbank(): BelongsTo
    {
        return $this->belongsTo(Powerbank::class);
    }
}
