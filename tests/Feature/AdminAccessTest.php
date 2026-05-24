<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_area_requires_admin_role(): void
    {
        $this->seed();

        $user = User::create([
            'full_name' => 'Обычный пользователь',
            'email' => 'user@example.com',
            'phone' => '+79990000002',
            'password' => 'password',
            'role_id' => Role::where('name', 'user')->value('id'),
            'status' => 'active',
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_can_open_dashboard(): void
    {
        $this->seed();

        $admin = User::where('email', 'admin@example.com')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk();
    }
}
