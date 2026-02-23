<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cylinder;

class CylinderSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 50 Tabung
        for ($i = 1; $i <= 50; $i++) {
            // Format: TB-001, TB-002, dst
            $sn = 'TB-' . str_pad($i, 3, '0', STR_PAD_LEFT);

            // Random status awal (sebagian besar Available)
            $rand = rand(1, 10);
            $status = 'available';
            if ($rand > 8) $status = 'maintenance'; // 20% kemungkinan maintenance

            Cylinder::create([
                'serial_number' => $sn,
                'type' => 'O2', // Ukuran standar
                'status' => $status
            ]);
        }
    }
}
