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

        Schema::create('bank_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('card_last_four', 4);
            $table->string('payment_token');
            $table->boolean('is_default')->default(false);
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('building');
            $table->string('floor');
            $table->text('location_description')->nullable();
            $table->string('qr_code')->unique();
            $table->unsignedInteger('total_slots')->default(0);
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('station_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained('stations')->cascadeOnDelete();
            $table->unsignedInteger('slot_number');
            $table->string('status')->default('empty');
            $table->timestamps();
            $table->unique(['station_id', 'slot_number']);
        });

        Schema::create('powerbanks', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->foreignId('station_id')->nullable()->constrained('stations')->nullOnDelete();
            $table->foreignId('slot_id')->nullable()->unique()->constrained('station_slots')->nullOnDelete();
            $table->unsignedTinyInteger('charge_level')->default(100);
            $table->string('status')->default('available');
            $table->string('condition')->default('good');
            $table->timestamps();
        });

        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price_per_30_min', 10, 2);
            $table->decimal('price_per_hour', 10, 2);
            $table->decimal('price_per_day', 10, 2);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
        });

        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('powerbank_id')->constrained('powerbanks')->restrictOnDelete();
            $table->foreignId('start_station_id')->constrained('stations')->restrictOnDelete();
            $table->foreignId('return_station_id')->nullable()->constrained('stations')->nullOnDelete();
            $table->foreignId('tariff_id')->constrained('tariffs')->restrictOnDelete();
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->string('status')->default('active');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->index(['user_id', 'status']);
            $table->index(['powerbank_id', 'status']);
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained('rentals')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->foreignId('payment_method_id')->constrained('payment_methods')->restrictOnDelete();
            $table->string('status')->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->unique()->constrained('rentals')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('powerbank_id')->constrained('powerbanks')->restrictOnDelete();
            $table->foreignId('station_id')->constrained('stations')->restrictOnDelete();
            $table->foreignId('slot_id')->constrained('station_slots')->restrictOnDelete();
            $table->timestamp('returned_at');
            $table->string('status')->default('completed');
            $table->text('comment')->nullable();
        });

        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('rental_id')->nullable()->constrained('rentals')->nullOnDelete();
            $table->foreignId('station_id')->nullable()->constrained('stations')->nullOnDelete();
            $table->foreignId('powerbank_id')->nullable()->constrained('powerbanks')->nullOnDelete();
            $table->string('issue_type');
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
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('issues');
        Schema::dropIfExists('returns');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('rentals');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('tariffs');
        Schema::dropIfExists('powerbanks');
        Schema::dropIfExists('station_slots');
        Schema::dropIfExists('stations');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('bank_cards');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};
