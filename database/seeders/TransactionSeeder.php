<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Cylinder;
use App\Models\Transaction;
use App\Models\HistoryLog;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil beberapa client dan tabung available
        $clients = Client::all();
        $cylinders = Cylinder::where('status', 'available')->take(5)->get(); // Ambil 5 tabung untuk disewakan

        if($clients->isEmpty() || $cylinders->isEmpty()) {
            return;
        }

        foreach ($cylinders as $index => $cyl) {
            // Pilih client secara berurutan atau random
            $client = $clients->get($index % $clients->count());

            // Buat Transaksi Sewa (Status: OPEN)
            Transaction::create([
                'client_id' => $client->id,
                'cylinder_id' => $cyl->id,
                'rent_date' => Carbon::now()->subDays(rand(1, 7)), // Sewa antara 1-7 hari lalu
                'status' => 'open'
            ]);

            // Update status tabung jadi RENTED
            $cyl->update(['status' => 'rented']);

            // Catat Log (Opsional, agar riwayat tidak kosong)
            HistoryLog::create([
                'user_id' => 1, // Asumsi user ID 1 adalah Admin
                'action' => 'SEWA',
                'description' => "Tabung {$cyl->serial_number} keluar ke {$client->name} (Seeder)"
            ]);
        }
    }
}
