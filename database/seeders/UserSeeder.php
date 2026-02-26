<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Akun Developer
        User::create([
            'name' => 'Developer',
            'username' => 'dev',
            'password' => Hash::make('123'),
        ]);

        // 4 Akun Operasional
        User::create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'password' => Hash::make('123'),
        ]);

        User::create([
            'name' => 'Staff Gudang',
            'username' => 'gudang',
            'password' => Hash::make('123'),
        ]);

        User::create([
            'name' => 'Kasir Utama',
            'username' => 'kasir',
            'password' => Hash::make('123'),
        ]);

        User::create([
            'name' => 'Tim Lapangan',
            'username' => 'lapangan',
            'password' => Hash::make('123'),
        ]);
    }
}
