<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Dev (Akses Penuh untukmu)
        User::create([
            'name' => 'Developer',
            'username' => 'dev',
            'password' => bcrypt('123'),
            'role' => 'dev'
        ]);

        // 2. Akun Admin Kantor (Akses ke Semua Data)
        User::create([
            'name' => 'Admin Laptop',
            'username' => 'admin1',
            'password' => bcrypt('123'),
            'role' => 'admin'
        ]);

        // 3. Akun Admin Tablet (Akses ke Semua Data)
        User::create([
            'name' => 'Admin Tablet',
            'username' => 'admin2',
            'password' => bcrypt('123'),
            'role' => 'admin'
        ]);

        // 4. Akun Tim Lapangan/Kurir (HANYA AKSES DASHBOARD & TUKAR TABUNG)
        User::create([
            'name' => 'Tim Lapangan',
            'username' => 'kurir',
            'password' => bcrypt('123'),
            'role' => 'kurir'
        ]);
    }
}
