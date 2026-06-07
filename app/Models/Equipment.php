<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Equipment extends Model
{
    protected $table = 'equipment';

    protected $fillable = [
        'name',
        'inventory_number',
        'category_id',
        'storage_location_id',
        'technical_condition',
        'status',
        'description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }

    public function storageLocation(): BelongsTo
    {
        return $this->belongsTo(StorageLocation::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(EquipmentRequest::class);
    }

    public function specification(): HasOne
    {
        return $this->hasOne(EquipmentSpecification::class);
    }

    public function software(): HasMany
    {
        return $this->hasMany(EquipmentSoftware::class);
    }

    public function issues(): HasMany
    {
        return $this->hasMany(EquipmentIssue::class);
    }

    public function returns(): HasMany
    {
        return $this->hasMany(EquipmentReturn::class);
    }

    public function problems(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available' && $this->technical_condition === 'good';
    }
}
