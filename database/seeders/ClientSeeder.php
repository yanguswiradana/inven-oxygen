<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['name' => 'RSUD Kota Sejahtera', 'phone' => '08111222333', 'address' => 'Jl. Jendral Sudirman No. 1'],
            ['name' => 'Klinik Pratama Medika', 'phone' => '081234567890', 'address' => 'Jl. Kebon Jeruk No. 15'],
            ['name' => 'Bengkel Las Maju Jaya', 'phone' => '085678901234', 'address' => 'Kawasan Industri Blok C-4'],
            ['name' => 'Puskesmas Melati', 'phone' => '081345678901', 'address' => 'Jl. Mawar Indah No. 88'],
            ['name' => 'PT. Oksigen Murni Abadi', 'phone' => '021-5556667', 'address' => 'Jl. Raya Industri Km 12'],
            ['name' => 'Dr. Budi Santoso (Praktek)', 'phone' => '081298765432', 'address' => 'Ruko Grand Wisata B5'],
        ];

        foreach ($clients as $c) {
            Client::create($c);
        }
    }
}
