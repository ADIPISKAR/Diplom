<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'password',
        'role_id',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function equipmentRequests(): HasMany
    {
        return $this->hasMany(EquipmentRequest::class);
    }

    public function handledIssues(): HasMany
    {
        return $this->hasMany(EquipmentIssue::class, 'employee_id');
    }

    public function handledReturns(): HasMany
    {
        return $this->hasMany(EquipmentReturn::class, 'employee_id');
    }

    public function problems(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'admin_id');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function isAdmin(): bool
    {
        return $this->role?->name === 'admin';
    }

    public function isEmployee(): bool
    {
        return in_array($this->role?->name, ['employee', 'admin'], true);
    }

    public function activeRequest(): ?EquipmentRequest
    {
        return $this->equipmentRequests()
            ->whereIn('status', ['pending', 'approved', 'issued', 'return_requested'])
            ->latest('requested_at')
            ->first();
    }
}
