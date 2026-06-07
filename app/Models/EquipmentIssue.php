<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentIssue extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'request_id',
        'user_id',
        'employee_id',
        'equipment_id',
        'storage_location_id',
        'issued_at',
        'comment',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(EquipmentRequest::class, 'request_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function storageLocation(): BelongsTo
    {
        return $this->belongsTo(StorageLocation::class);
    }
}
