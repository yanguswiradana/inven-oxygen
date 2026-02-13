<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder {
    public function run(): void {
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
    }
}
