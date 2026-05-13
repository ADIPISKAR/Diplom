<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = [
        'user_id',
        'powerbank_id',
        'tariff_id',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function powerbank()
    {
        return $this->belongsTo(Powerbank::class);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
