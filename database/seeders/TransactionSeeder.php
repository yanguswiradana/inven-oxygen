<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Cylinder;
use App\Models\Client;
use App\Models\HistoryLog;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        if (Client::count() == 0 || Cylinder::count() == 0) return;

        $transactions = [];
        $historyLogs = [];

        $clients = Client::pluck('name', 'id')->toArray();
        $cylinders = Cylinder::pluck('serial_number', 'id')->toArray();
        $allCylinderIds = array_keys($cylinders);
        $totalClients = array_keys($clients);

        // 1. TRANSAKSI AKTIF ('open')
        $rentedCylinders = Cylinder::where('status', 'rented')->get();
        foreach ($rentedCylinders as $cylinder) {
            $rentDate = Carbon::now()->subDays(rand(1, 14))->subHours(rand(1, 23));
            $clientId = $totalClients[array_rand($totalClients)];

            $transactions[] = [
                'client_id'   => $clientId,
                'cylinder_id' => $cylinder->id,

                // TAMBAHAN BARU: Sistem akan mengacak 70% data adalah 'sewa', 30% 'hak_milik'
                'category'    => rand(1, 100) > 30 ? 'sewa' : 'hak_milik',

                'rent_date'   => $rentDate,
                'return_date' => null,
                'status'      => 'open',
                'created_at'  => $rentDate,
                'updated_at'  => $rentDate,
            ];

            $historyLogs[] = [
                'action'      => 'SEWA',
                'description' => "Tabung {$cylinder->serial_number} keluar ke {$clients[$clientId]} (Sistem Auto)",
                'created_at'  => $rentDate,
                'updated_at'  => $rentDate,
            ];
        }

        // 2. TRANSAKSI MASA LALU ('closed')
        for ($i = 0; $i < 1500; $i++) {
            $rentDate = Carbon::now()->subMonths(rand(1, 6))->subDays(rand(1, 28));
            $returnDate = (clone $rentDate)->addDays(rand(1, 14))->addHours(rand(1, 23));
            $clientId = $totalClients[array_rand($totalClients)];
            $cylId = $allCylinderIds[array_rand($allCylinderIds)];

            $transactions[] = [
                'client_id'   => $clientId,
                'cylinder_id' => $cylId,

                // TAMBAHAN BARU DI SINI JUGA
                'category'    => rand(1, 100) > 30 ? 'sewa' : 'hak_milik',

                'rent_date'   => $rentDate,
                'return_date' => $returnDate,
                'status'      => 'closed',
                'created_at'  => $rentDate,
                'updated_at'  => $returnDate,
            ];

            $historyLogs[] = [
                'action'      => 'KEMBALI',
                'description' => "Tabung {$cylinders[$cylId]} kembali dari {$clients[$clientId]} (Sistem Auto)",
                'created_at'  => $returnDate,
                'updated_at'  => $returnDate,
            ];
        }

        foreach (array_chunk($transactions, 500) as $chunk) {
            Transaction::insert($chunk);
        }
        foreach (array_chunk($historyLogs, 500) as $chunk) {
            HistoryLog::insert($chunk);
        }
    }
}
