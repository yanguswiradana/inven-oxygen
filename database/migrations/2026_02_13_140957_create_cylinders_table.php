<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cylinders', function (Blueprint $table) {
            $table->id();
            // TAMBAHAN: Index pada Serial Number
            $table->string('serial_number')->unique()->index();

            // TAMBAHAN: Index pada Tipe Gas
            $table->enum('type', ['O2', 'CO2', 'N2', 'AR', 'C2H2'])->index();

            // TAMBAHAN: Status baru untuk membedakan Penuh vs Kosong
            $table->enum('status', [
                'available_full',  // Di Gudang (Isi Penuh & Siap Kirim)
                'available_empty', // Di Gudang (Kosong & Harus Diisi)
                'at_supplier',     // Di Pabrik (Proses Isi Ulang)
                'rented',          // Di Pelanggan
                'maintenance'      // Rusak / Perbaikan
            ])->default('available_empty');

            $table->timestamps();

            // TAMBAHAN: Mencegah tabung hilang permanen dari sistem
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cylinders');
    }
};
