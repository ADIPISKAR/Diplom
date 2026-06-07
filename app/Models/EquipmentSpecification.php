<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentSpecification extends Model
{
    protected $fillable = [
        'equipment_id',
        'processor',
        'ram',
        'storage',
        'screen_size',
        'operating_system',
        'battery_condition',
        'additional_info',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
