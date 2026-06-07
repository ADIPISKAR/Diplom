<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Issue extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'employee_id',
        'equipment_request_id',
        'equipment_id',
        'issue_type',
        'title',
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

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function equipmentRequest(): BelongsTo
    {
        return $this->belongsTo(EquipmentRequest::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
