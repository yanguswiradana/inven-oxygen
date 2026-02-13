<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cylinders', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->string('type')->default('6m3');
            $table->enum('status', ['available', 'rented', 'maintenance'])->default('available');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('cylinders'); }
};
