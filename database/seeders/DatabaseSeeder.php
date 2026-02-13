<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Urutan eksekusi PENTING!
        // User harus duluan -> Client/Tabung -> Baru Transaksi (karena butuh ID Client & Tabung)

        $this->call([
            UserSeeder::class,        // User Admin, Gudang, dll
            ClientSeeder::class,      // Data Pelanggan
            CylinderSeeder::class,    // Data Tabung
            TransactionSeeder::class, // Simulasi Transaksi Sewa
        ]);
    }
}
