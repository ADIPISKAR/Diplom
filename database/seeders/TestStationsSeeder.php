<?php

namespace Database\Seeders;

use App\Models\Powerbank;
use App\Models\Station;
use App\Models\StationSlot;
use Illuminate\Database\Seeder;

class TestStationsSeeder extends Seeder
{
    public function run(): void
    {
        $stations = [
            ['Главный корпус', 'А', '1', 'Холл рядом с охраной', 'QR-ST-A-1', 6],
            ['Библиотека', 'Б', '2', 'Зона ожидания у читального зала', 'QR-ST-B-2', 4],
            ['Столовая', 'В', '1', 'Входная зона столовой', 'QR-ST-C-1', 5],
        ];

        foreach ($stations as [$name, $building, $floor, $description, $qr, $slotsCount]) {
            $station = Station::updateOrCreate(
                ['qr_code' => $qr],
                [
                    'name' => $name,
                    'building' => $building,
                    'floor' => $floor,
                    'location_description' => $description,
                    'total_slots' => $slotsCount,
                    'status' => 'active',
                ]
            );

            for ($slotNumber = 1; $slotNumber <= $slotsCount; $slotNumber++) {
                $slot = StationSlot::updateOrCreate(
                    ['station_id' => $station->id, 'slot_number' => $slotNumber],
                    ['status' => 'occupied']
                );

                Powerbank::updateOrCreate(
                    ['serial_number' => sprintf('PB-%s-%02d', str_replace('QR-ST-', '', $qr), $slotNumber)],
                    [
                        'station_id' => $station->id,
                        'slot_id' => $slot->id,
                        'charge_level' => max(55, 100 - ($slotNumber * 5)),
                        'status' => 'available',
                        'condition' => 'good',
                    ]
                );
            }
        }
    }
}
