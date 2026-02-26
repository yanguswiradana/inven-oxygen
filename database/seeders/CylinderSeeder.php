<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cylinder;

class CylinderSeeder extends Seeder
{
    public function run(): void
    {
        // Tipe gas yang sudah FIX
        $gasTypes = ['O2', 'CO2', 'N2', 'AR', 'C2H2'];

        for ($i = 1; $i <= 50; $i++) {
            $sn = 'TB-' . str_pad($i, 3, '0', STR_PAD_LEFT);

            $rand = rand(1, 10);
            $status = 'available';
            if ($rand > 8) $status = 'maintenance';

            Cylinder::create([
                'serial_number' => $sn,
                'type' => $gasTypes[array_rand($gasTypes)],
                'status' => $status
            ]);
        }
    }
}
