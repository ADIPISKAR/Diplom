<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    const UPDATED_AT = null;

    protected $fillable = ['user_id', 'action', 'description', 'entity_type', 'entity_id'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function record(
        ?int $userId,
        string $action,
        ?string $description = null,
        ?Model $entity = null
    ): self {
        return self::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'entity_type' => $entity ? $entity::class : null,
            'entity_id' => $entity?->getKey(),
        ]);
    }
}
