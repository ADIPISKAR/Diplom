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
            ['description' => 'Студент, оформляющий заявки на оборудование']
        );

        Role::updateOrCreate(
            ['name' => 'employee'],
            ['description' => 'Сотрудник выдачи, обрабатывающий заявки и возвраты']
        );

        Role::updateOrCreate(
            ['name' => 'admin'],
            ['description' => 'Администратор системы']
        );
    }
}
