<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->foreignId('role_id')->constrained('roles')->restrictOnDelete();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('equipment_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('storage_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location_type');
            $table->string('building')->nullable();
            $table->string('room')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('inventory_number')->unique();
            $table->foreignId('category_id')->constrained('equipment_categories')->restrictOnDelete();
            $table->foreignId('storage_location_id')->constrained('storage_locations')->restrictOnDelete();
            $table->string('technical_condition')->default('good');
            $table->string('status')->default('available');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->index(['status', 'technical_condition']);
        });

        Schema::create('equipment_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->unique()->constrained('equipment')->cascadeOnDelete();
            $table->string('processor')->nullable();
            $table->string('ram')->nullable();
            $table->string('storage')->nullable();
            $table->string('screen_size')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('battery_condition')->nullable();
            $table->text('additional_info')->nullable();
            $table->timestamps();
        });

        Schema::create('equipment_software', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipment')->cascadeOnDelete();
            $table->string('name');
            $table->string('version')->nullable();
            $table->string('license_type')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->index(['equipment_id', 'name']);
        });

        Schema::create('equipment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('equipment_categories')->restrictOnDelete();
            $table->foreignId('storage_location_id')->nullable()->constrained('storage_locations')->nullOnDelete();
            $table->foreignId('equipment_id')->nullable()->constrained('equipment')->nullOnDelete();
            $table->string('status')->default('pending');
            $table->text('user_comment')->nullable();
            $table->text('employee_comment')->nullable();
            $table->timestamp('requested_at');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'status']);
            $table->index(['status', 'requested_at']);
        });

        Schema::create('equipment_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->unique()->constrained('equipment_requests')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('equipment_id')->constrained('equipment')->restrictOnDelete();
            $table->foreignId('storage_location_id')->constrained('storage_locations')->restrictOnDelete();
            $table->timestamp('issued_at');
            $table->text('comment')->nullable();
        });

        Schema::create('equipment_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->unique()->constrained('equipment_requests')->cascadeOnDelete();
            $table->foreignId('equipment_id')->constrained('equipment')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('storage_location_id')->constrained('storage_locations')->restrictOnDelete();
            $table->timestamp('returned_at');
            $table->string('condition_after_return')->default('good');
            $table->text('comment')->nullable();
        });

        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('equipment_request_id')->nullable()->constrained('equipment_requests')->nullOnDelete();
            $table->foreignId('equipment_id')->nullable()->constrained('equipment')->nullOnDelete();
            $table->string('issue_type');
            $table->string('title');
            $table->text('description');
            $table->string('status')->default('open');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            $table->string('report_type');
            $table->date('period_start');
            $table->date('period_end');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->text('description')->nullable();
            $table->string('entity_type')->nullable();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->index(['entity_type', 'entity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('issues');
        Schema::dropIfExists('equipment_returns');
        Schema::dropIfExists('equipment_issues');
        Schema::dropIfExists('equipment_requests');
        Schema::dropIfExists('equipment_software');
        Schema::dropIfExists('equipment_specifications');
        Schema::dropIfExists('equipment');
        Schema::dropIfExists('storage_locations');
        Schema::dropIfExists('equipment_categories');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};
