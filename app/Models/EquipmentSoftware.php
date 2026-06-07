<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentSoftware extends Model
{
    protected $table = 'equipment_software';

    protected $fillable = [
        'equipment_id',
        'name',
        'version',
        'license_type',
        'description',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
