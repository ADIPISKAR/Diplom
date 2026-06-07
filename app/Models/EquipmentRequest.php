<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EquipmentRequest extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'storage_location_id',
        'equipment_id',
        'status',
        'user_comment',
        'employee_comment',
        'requested_at',
        'approved_at',
        'completed_at',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }

    public function storageLocation(): BelongsTo
    {
        return $this->belongsTo(StorageLocation::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function issueRecord(): HasOne
    {
        return $this->hasOne(EquipmentIssue::class, 'request_id');
    }

    public function returnRecord(): HasOne
    {
        return $this->hasOne(EquipmentReturn::class, 'request_id');
    }
}
