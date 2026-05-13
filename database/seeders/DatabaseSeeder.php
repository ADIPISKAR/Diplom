<?php

namespace Database\Seeders;

use App\Models\ErrorLog;
use App\Models\Payment;
use App\Models\Powerbank;
use App\Models\Rental;
use App\Models\Station;
use App\Models\Tariff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Администратор',
            'email' => 'admin@example.com',
            'phone' => '+7 900 000-00-01',
            'role' => 'admin',
        ]);

        $user = User::factory()->create([
            'name' => 'Иван Петров',
            'email' => 'user@example.com',
            'phone' => '+7 900 000-00-02',
            'role' => 'user',
        ]);

        $stationA = Station::create(['location' => 'ТРЦ Центральный, 1 этаж', 'status' => 'active']);
        $stationB = Station::create(['location' => 'Вокзал, зона ожидания', 'status' => 'maintenance']);

        $tariff = Tariff::create([
            'price_per_hour' => 99,
            'description' => 'Базовый тариф аренды повербанка за один час.',
        ]);

        $availablePowerbank = Powerbank::create([
            'station_id' => $stationA->id,
            'code' => 'PB-1001',
            'capacity_mah' => 10000,
            'status' => 'available',
        ]);

        $rentedPowerbank = Powerbank::create([
            'station_id' => $stationA->id,
            'code' => 'PB-1002',
            'capacity_mah' => 20000,
            'status' => 'rented',
        ]);

        Powerbank::create([
            'station_id' => $stationB->id,
            'code' => 'PB-2001',
            'capacity_mah' => 10000,
            'status' => 'maintenance',
        ]);

        $rental = Rental::create([
            'user_id' => $user->id,
            'powerbank_id' => $rentedPowerbank->id,
            'tariff_id' => $tariff->id,
            'start_time' => Carbon::now()->subHour(),
            'status' => 'active',
        ]);

        Payment::create([
            'rental_id' => Rental::create([
                'user_id' => $admin->id,
                'powerbank_id' => $availablePowerbank->id,
                'tariff_id' => $tariff->id,
                'start_time' => Carbon::now()->subHours(4),
                'end_time' => Carbon::now()->subHours(2),
                'status' => 'completed',
            ])->id,
            'amount' => 198,
            'payment_time' => Carbon::now()->subHours(2),
            'status' => 'paid',
        ]);

        ErrorLog::create([
            'description' => 'Тестовая запись журнала: проверка связи со станцией.',
        ]);
    }
}
