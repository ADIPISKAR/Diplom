<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('equipment_specifications')) {
            return;
        }

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
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_software');
        Schema::dropIfExists('equipment_specifications');
    }
};
