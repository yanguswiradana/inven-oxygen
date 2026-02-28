<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use Faker\Factory as Faker;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        // Gunakan Faker bahasa Indonesia
        $faker = Faker::create('id_ID');

        $clients = [];
        for ($i = 1; $i <= 200; $i++) {
            $clients[] = [
                'name' => $faker->company,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert sekaligus agar eksekusi seeder sangat cepat
        foreach (array_chunk($clients, 50) as $chunk) {
            Client::insert($chunk);
        }
    }
}
