<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('cylinder_id')->constrained()->onDelete('cascade');

            // INI ADALAH TAMBAHAN BARUNYA
            // Kolom ini akan membedakan tagihan pelanggan nantinya
            $table->enum('category', ['sewa', 'hak_milik'])->default('sewa');

            $table->timestamp('rent_date');
            $table->timestamp('return_date')->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};
