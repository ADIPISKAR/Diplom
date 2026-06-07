<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\StorageLocation;
use Illuminate\Database\Seeder;

class EquipmentRegistrySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Ноутбук', 'description' => 'Переносные компьютеры для работы с учебными материалами.'],
            ['name' => 'Планшет', 'description' => 'Планшетные устройства для чтения, просмотра презентаций и заметок.'],
            ['name' => 'Портативное зарядное устройство', 'description' => 'Пауэрбанки для зарядки мобильных устройств во время самоподготовки.'],
        ];

        foreach ($categories as $category) {
            EquipmentCategory::updateOrCreate(['name' => $category['name']], $category + ['is_active' => true]);
        }

        $locations = [
            ['name' => 'Читальный зал', 'location_type' => 'library', 'building' => 'Главный корпус', 'room' => '201'],
            ['name' => 'Коворкинг института', 'location_type' => 'coworking', 'building' => 'Корпус ИСТ', 'room' => '104'],
            ['name' => 'Кафедра веб-разработки', 'location_type' => 'department', 'building' => 'Корпус ИСТ', 'room' => '315'],
            ['name' => 'Ответственный сотрудник', 'location_type' => 'employee', 'building' => 'Корпус ИСТ', 'room' => '108'],
        ];

        foreach ($locations as $location) {
            StorageLocation::updateOrCreate(
                ['name' => $location['name']],
                $location + ['description' => null, 'is_active' => true]
            );
        }

        $laptop = EquipmentCategory::where('name', 'Ноутбук')->firstOrFail();
        $tablet = EquipmentCategory::where('name', 'Планшет')->firstOrFail();
        $portableCharger = EquipmentCategory::where('name', 'Портативное зарядное устройство')->firstOrFail();
        $library = StorageLocation::where('name', 'Читальный зал')->firstOrFail();
        $coworking = StorageLocation::where('name', 'Коворкинг института')->firstOrFail();
        $department = StorageLocation::where('name', 'Кафедра веб-разработки')->firstOrFail();

        $items = [
            ['name' => 'Ноутбук Lenovo ThinkPad E14', 'inventory_number' => 'DGTU-NB-001', 'category_id' => $laptop->id, 'storage_location_id' => $library->id],
            ['name' => 'Ноутбук ASUS ExpertBook', 'inventory_number' => 'DGTU-NB-002', 'category_id' => $laptop->id, 'storage_location_id' => $department->id],
            ['name' => 'Планшет Samsung Galaxy Tab', 'inventory_number' => 'DGTU-TB-001', 'category_id' => $tablet->id, 'storage_location_id' => $coworking->id],
            ['name' => 'Планшет Lenovo Tab M10', 'inventory_number' => 'DGTU-TB-002', 'category_id' => $tablet->id, 'storage_location_id' => $library->id],
            ['name' => 'Портативное зарядное устройство Xiaomi 20000 mAh', 'inventory_number' => 'DGTU-PC-001', 'category_id' => $portableCharger->id, 'storage_location_id' => $coworking->id],
            ['name' => 'Портативное зарядное устройство Baseus 10000 mAh', 'inventory_number' => 'DGTU-PC-002', 'category_id' => $portableCharger->id, 'storage_location_id' => $department->id],
        ];

        foreach ($items as $item) {
            $equipment = Equipment::updateOrCreate(
                ['inventory_number' => $item['inventory_number']],
                $item + [
                    'technical_condition' => 'good',
                    'status' => 'available',
                    'description' => 'Оборудование для временного использования студентами во время самоподготовки.',
                ]
            );

            if (str_starts_with($equipment->inventory_number, 'DGTU-NB')) {
                $equipment->specification()->updateOrCreate([], [
                    'processor' => 'Intel Core i5',
                    'ram' => '16 ГБ',
                    'storage' => 'SSD 512 ГБ',
                    'screen_size' => '14 дюймов',
                    'operating_system' => 'Windows 11 Pro',
                    'battery_condition' => 'Хорошее',
                    'additional_info' => 'Подходит для работы с офисными документами, браузером и учебными веб-сервисами.',
                ]);

                $equipment->software()->delete();
                foreach ([
                    ['name' => 'Microsoft Office', 'version' => '2021', 'license_type' => 'Корпоративная', 'description' => 'Работа с документами, таблицами и презентациями.'],
                    ['name' => 'Visual Studio Code', 'version' => 'latest', 'license_type' => 'Бесплатная', 'description' => 'Среда для учебной веб-разработки.'],
                    ['name' => 'Google Chrome', 'version' => 'latest', 'license_type' => 'Бесплатная', 'description' => 'Браузер для электронных образовательных ресурсов.'],
                ] as $software) {
                    $equipment->software()->create($software);
                }
            }

            if (str_starts_with($equipment->inventory_number, 'DGTU-TB')) {
                $equipment->specification()->updateOrCreate([], [
                    'processor' => 'ARM Octa-Core',
                    'ram' => '4 ГБ',
                    'storage' => '64 ГБ',
                    'screen_size' => '10 дюймов',
                    'operating_system' => 'Android',
                    'battery_condition' => 'Хорошее',
                    'additional_info' => 'Подходит для чтения материалов, просмотра презентаций и работы с заметками.',
                ]);

                $equipment->software()->delete();
                foreach ([
                    ['name' => 'Google Docs', 'version' => 'latest', 'license_type' => 'Бесплатная', 'description' => 'Работа с текстовыми материалами.'],
                    ['name' => 'Adobe Acrobat Reader', 'version' => 'latest', 'license_type' => 'Бесплатная', 'description' => 'Просмотр PDF-файлов.'],
                ] as $software) {
                    $equipment->software()->create($software);
                }
            }
        }
    }
}
