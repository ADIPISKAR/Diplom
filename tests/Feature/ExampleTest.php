<?php

namespace Tests\Feature;

use App\Models\Powerbank;
use App\Models\Station;
use App\Models\Tariff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Симулятор пользователя');
    }

    public function test_user_simulation_creates_rental_and_updates_powerbank_status(): void
    {
        $user = User::factory()->create();
        $station = Station::create(['location' => 'Тестовая станция', 'status' => 'active']);
        $tariff = Tariff::create(['price_per_hour' => 99, 'description' => 'Тестовый тариф']);
        $powerbank = Powerbank::create([
            'station_id' => $station->id,
            'code' => 'PB-TEST',
            'capacity_mah' => 10000,
            'status' => 'available',
        ]);

        $this->post(route('simulation.store'), [
            'action' => 'rent',
            'user_id' => $user->id,
            'powerbank_id' => $powerbank->id,
            'tariff_id' => $tariff->id,
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('rentals', [
            'user_id' => $user->id,
            'powerbank_id' => $powerbank->id,
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('powerbanks', [
            'id' => $powerbank->id,
            'status' => 'rented',
        ]);
    }
}
