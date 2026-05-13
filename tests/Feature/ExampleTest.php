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

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/')->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_open_dashboard(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->get('/')
            ->assertStatus(200)
            ->assertSee('Симулятор пользователя');
    }

    public function test_user_simulation_creates_rental_and_updates_powerbank_status(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $user = User::factory()->create();
        $station = Station::create(['location' => 'Тестовая станция', 'status' => 'active']);
        $tariff = Tariff::create(['price_per_hour' => 99, 'description' => 'Тестовый тариф']);
        $powerbank = Powerbank::create([
            'station_id' => $station->id,
            'code' => 'PB-TEST',
            'capacity_mah' => 10000,
            'status' => 'available',
        ]);

        $this->postJson(route('simulation.store'), [
            'action' => 'rent',
            'user_id' => $user->id,
            'powerbank_id' => $powerbank->id,
            'tariff_id' => $tariff->id,
        ])->assertOk()->assertJson(['message' => 'Симуляция: пользователь начал аренду.']);

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

    public function test_simulation_can_create_user(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $this->postJson(route('simulation.store'), [
            'action' => 'create_user',
            'name' => 'Новый пользователь',
            'email' => 'new-user@example.com',
            'phone' => '+7 900 111-22-33',
            'role' => 'user',
            'password' => 'password',
        ])->assertOk()->assertJson(['message' => 'Пользователь добавлен.']);

        $this->assertDatabaseHas('users', [
            'email' => 'new-user@example.com',
            'role' => 'user',
        ]);
    }
}
