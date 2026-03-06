<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cylinder;

class CylinderSeeder extends Seeder
{
    public function run(): void
    {
        $gasTypes = ['O2', 'CO2', 'N2', 'AR', 'C2H2'];
        $cylinders = [];

        for ($i = 1; $i <= 1000; $i++) {
            $sn = 'TB-' . str_pad($i, 4, '0', STR_PAD_LEFT);

            // Logika acak baru:
            // 60% Penuh, 25% Kosong, 10% Di Client (Sewa), 5% Rusak
            $rand = rand(1, 100);

            if ($rand <= 60) {
                $status = 'available_full';
            } elseif ($rand <= 85) {
                $status = 'available_empty';
            } elseif ($rand <= 95) {
                $status = 'rented';
            } else {
                $status = 'maintenance';
            }

            $cylinders[] = [
                'serial_number' => $sn,
                'type' => $gasTypes[array_rand($gasTypes)],
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert per 200 baris agar RAM tidak penuh dan eksekusi secepat kilat
        foreach (array_chunk($cylinders, 200) as $chunk) {
            Cylinder::insert($chunk);
        }
    }
}
