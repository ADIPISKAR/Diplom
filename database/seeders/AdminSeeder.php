<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::where('name', 'admin')->firstOrFail();

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'full_name' => 'Администратор',
                'phone' => '+70000000000',
                'password' => Hash::make('password'),
                'role_id' => $role->id,
                'status' => 'active',
            ]
        );
    }
}
