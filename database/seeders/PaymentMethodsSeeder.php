<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodsSeeder extends Seeder
{
    public function run(): void
    {
        PaymentMethod::updateOrCreate(
            ['name' => 'demo_payment'],
            ['description' => 'Демонстрационная оплата без подключения банка', 'is_active' => true]
        );

        PaymentMethod::updateOrCreate(
            ['name' => 'bank_card'],
            ['description' => 'Банковская карта пользователя', 'is_active' => true]
        );
    }
}
