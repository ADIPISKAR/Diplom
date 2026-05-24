<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(
            ['name' => 'user'],
            ['description' => 'Обычный пользователь сервиса аренды']
        );

        Role::updateOrCreate(
            ['name' => 'admin'],
            ['description' => 'Администратор системы']
        );
    }
}
