<?php

namespace Database\Seeders;

use App\Models\Tariff;
use Illuminate\Database\Seeder;

class TariffsSeeder extends Seeder
{
    public function run(): void
    {
        Tariff::updateOrCreate(
            ['name' => 'Базовый'],
            [
                'price_per_30_min' => 30,
                'price_per_hour' => 50,
                'price_per_day' => 250,
                'description' => 'Учебный демонстрационный тариф для аренды повербанка.',
                'is_active' => true,
            ]
        );
    }
}
