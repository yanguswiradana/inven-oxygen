<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            // TAMBAHAN: Index pada nama agar search super cepat
            $table->string('name')->index();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
            // TAMBAHAN: Mencegah data hilang permanen
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('clients');
    }
};
