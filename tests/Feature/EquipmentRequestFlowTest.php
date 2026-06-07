<?php

namespace Tests\Feature;

use App\Models\Equipment;
use App\Models\EquipmentRequest;
use App\Models\Role;
use App\Models\StorageLocation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipmentRequestFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_request_can_be_issued_and_returned_by_employee(): void
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
        $employee = User::where('email', 'employee@example.com')->firstOrFail();
        $equipment = Equipment::where('status', 'available')->firstOrFail();

        $this->actingAs($user)
            ->post(route('requests.store'), [
                'equipment_id' => $equipment->id,
                'category_id' => $equipment->category_id,
                'storage_location_id' => $equipment->storage_location_id,
                'user_comment' => 'Нужно для самоподготовки',
            ])
            ->assertRedirect(route('requests.index'));

        $equipmentRequest = EquipmentRequest::where('user_id', $user->id)->firstOrFail();

        $this->actingAs($employee)
            ->patch(route('employee.requests.approve', $equipmentRequest), [
                'equipment_id' => $equipment->id,
                'employee_comment' => 'Можно выдать',
            ])
            ->assertRedirect();

        $this->actingAs($employee)
            ->patch(route('employee.requests.issue', $equipmentRequest))
            ->assertRedirect();

        $this->assertDatabaseHas('equipment_requests', [
            'id' => $equipmentRequest->id,
            'status' => 'issued',
            'equipment_id' => $equipment->id,
        ]);
        $this->assertDatabaseHas('equipment', [
            'id' => $equipment->id,
            'status' => 'issued',
        ]);
        $this->assertDatabaseHas('equipment_issues', [
            'request_id' => $equipmentRequest->id,
            'equipment_id' => $equipment->id,
            'employee_id' => $employee->id,
        ]);

        $location = StorageLocation::firstOrFail();

        $this->actingAs($user)
            ->patch(route('requests.return-request', $equipmentRequest))
            ->assertRedirect();

        $this->actingAs($employee)
            ->patch(route('employee.requests.return', $equipmentRequest), [
                'storage_location_id' => $location->id,
                'condition_after_return' => 'good',
                'comment' => 'Возврат без замечаний',
            ])
            ->assertRedirect(route('employee.requests.index'));

        $this->assertDatabaseHas('equipment_requests', [
            'id' => $equipmentRequest->id,
            'status' => 'completed',
        ]);
        $this->assertDatabaseHas('equipment_returns', [
            'request_id' => $equipmentRequest->id,
            'condition_after_return' => 'good',
        ]);
        $this->assertDatabaseHas('equipment', [
            'id' => $equipment->id,
            'status' => 'available',
            'technical_condition' => 'good',
        ]);
    }
}
