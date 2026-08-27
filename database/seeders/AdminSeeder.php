<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminPassword = (string) config('seed.admin.password');
        $employeePassword = (string) config('seed.employee.password');

        if ($adminPassword === '' || $employeePassword === '') {
            throw new RuntimeException(
                'ADMIN_SEED_PASSWORD and EMPLOYEE_SEED_PASSWORD must be set before seeding users.'
            );
        }

        $role = Role::where('name', 'admin')->firstOrFail();

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'full_name' => 'Администратор',
                'phone' => '+70000000000',
                'password' => Hash::make($adminPassword),
                'role_id' => $role->id,
                'status' => 'active',
            ]
        );

        $employeeRole = Role::where('name', 'employee')->firstOrFail();

        User::updateOrCreate(
            ['email' => 'employee@example.com'],
            [
                'full_name' => 'Сотрудник выдачи',
                'phone' => '+70000000001',
                'password' => Hash::make($employeePassword),
                'role_id' => $employeeRole->id,
                'status' => 'active',
            ]
        );
    }
}
