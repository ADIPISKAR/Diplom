<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\Rental;
use App\Models\Role;
use App\Models\Station;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RentalFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_rent_and_return_powerbank(): void
    {
        $this->seed();

        $user = User::create([
            'full_name' => 'Иван Петров',
            'email' => 'ivan@example.com',
            'phone' => '+79990000001',
            'password' => 'password',
            'role_id' => Role::where('name', 'user')->value('id'),
            'status' => 'active',
        ]);

        $station = Station::firstOrFail();
        $powerbank = $station->availablePowerbanks()->firstOrFail();
        $slot = $powerbank->slot;

        $this->actingAs($user)
            ->post(route('rentals.store', $station))
            ->assertRedirect(route('rentals.current'));

        $rental = Rental::where('user_id', $user->id)->firstOrFail();

        $this->assertSame('active', $rental->status);
        $this->assertDatabaseHas('powerbanks', [
            'id' => $powerbank->id,
            'status' => 'rented',
            'slot_id' => null,
        ]);
        $this->assertDatabaseHas('station_slots', [
            'id' => $slot->id,
            'status' => 'empty',
        ]);

        $this->actingAs($user)
            ->post(route('rentals.return.store', $rental), [
                'station_id' => $station->id,
                'comment' => 'Вернул в свободный слот',
            ])
            ->assertRedirect(route('rentals.history'));

        $this->assertDatabaseHas('rentals', [
            'id' => $rental->id,
            'status' => 'completed',
            'return_station_id' => $station->id,
        ]);
        $this->assertDatabaseHas('returns', [
            'rental_id' => $rental->id,
            'status' => 'completed',
            'slot_id' => $slot->id,
        ]);
        $this->assertDatabaseHas('powerbanks', [
            'id' => $powerbank->id,
            'status' => 'available',
            'slot_id' => $slot->id,
        ]);
        $this->assertDatabaseHas('station_slots', [
            'id' => $slot->id,
            'status' => 'occupied',
        ]);

        $payment = Payment::where('rental_id', $rental->id)->firstOrFail();
        $this->assertSame('paid', $payment->status);
    }
}
