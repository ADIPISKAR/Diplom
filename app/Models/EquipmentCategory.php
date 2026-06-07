<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipmentCategory extends Model
{
    protected $fillable = ['name', 'description', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class, 'category_id');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(EquipmentRequest::class, 'category_id');
    }
}
