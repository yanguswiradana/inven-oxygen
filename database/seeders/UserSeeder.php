<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Dev (Akses Penuh)
        User::create([
            'name' => 'Developer',
            'username' => 'devwira',
            'password' => bcrypt('123'),
            'role' => 'dev'
        ]);

        // 2. Akun Admin Kantor (Akses ke Semua Data Master)
        User::create([
            'name' => 'Admin Laptop',
            'username' => 'adminlaptop',
            'password' => bcrypt('123'),
            'role' => 'admin'
        ]);

        // 3. Akun Admin Tablet (Akses ke Semua Data Master)
        User::create([
            'name' => 'Admin Tablet',
            'username' => 'admintablet',
            'password' => bcrypt('123'),
            'role' => 'admin'
        ]);

        // 4. Akun Tim Lapangan/Kurir (Akses Terbatas)
        User::create([
            'name' => 'Tim Lapangan',
            'username' => 'lapangan',
            'password' => bcrypt('123'),
            'role' => 'kurir'
        ]);
    }
}
