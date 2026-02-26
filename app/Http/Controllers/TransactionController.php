<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Client;
use App\Models\Cylinder;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index() {
        // 1. Data Transaksi Aktif (Yang sedang dipinjam)
        $activeTransactions = Transaction::with(['client', 'cylinder'])
                                         ->where('status', 'open')
                                         ->latest()
                                         ->get();

        // 2. Data untuk Dropdown Form
        $clients = Client::orderBy('name', 'asc')->get();
        $availableCylinders = Cylinder::where('status', 'available')->get();

        // 3. Statistik Utama (Kartu Besar)
        $stats = [
            'total'       => Cylinder::count(),
            'available'   => $availableCylinders->count(),
            'rented'      => Cylinder::where('status', 'rented')->count(),
            'maintenance' => Cylinder::where('status', 'maintenance')->count(),
        ];

        // ====================================================
        // 4. LOGIKA BARU: Hitung Stok per Tipe Gas (O2, CO2, dll)
        // ====================================================
        $gasTypes = ['O2', 'CO2', 'N2', 'AR', 'C2H2'];
        $stockPerType = [];

        // Siapkan array kosong agar tidak error jika data kosong
        foreach ($gasTypes as $type) {
            $stockPerType[$type] = [
                'total' => 0,
                'available' => 0,
                'rented' => 0,
                'maintenance' => 0,
            ];
        }

        // Ambil hitungan dari database dalam 1 kali query (Cepat & Ringan)
        $cylinderStats = Cylinder::selectRaw('type, status, count(*) as count')
            ->groupBy('type', 'status')
            ->get();

        // Masukkan data dari database ke array yang sudah disiapkan
        foreach ($cylinderStats as $stat) {
            // Pastikan tipe gas ada dalam daftar yang kita pantau
            if (array_key_exists($stat->type, $stockPerType)) {
                $stockPerType[$stat->type][$stat->status] = $stat->count;
                $stockPerType[$stat->type]['total'] += $stat->count;
            }
        }

        // Kirim semua variabel ke View, TERMASUK $stockPerType
        return view('dashboard', compact(
            'activeTransactions',
            'clients',
            'availableCylinders',
            'stats',
            'stockPerType' // <-- Ini yang sebelumnya hilang
        ));
    }

    public function store(Request $request) {
        $request->validate([
            'client_id' => 'required',
            'cylinder_id' => 'required|exists:cylinders,id'
        ]);

        DB::transaction(function() use ($request) {
            $cyl = Cylinder::findOrFail($request->cylinder_id);

            // Validasi: Tabung harus available
            if($cyl->status != 'available') {
                throw new \Exception('Tabung tidak tersedia (Status: ' . $cyl->status . ')');
            }

            Transaction::create([
                'client_id' => $request->client_id,
                'cylinder_id' => $request->cylinder_id,
                'rent_date' => now(),
                'status' => 'open'
            ]);

            // Update status tabung jadi rented
            $cyl->update(['status' => 'rented']);

            // Catat Log
            $client = Client::findOrFail($request->client_id);
            HistoryLog::record('SEWA', "Tabung {$cyl->serial_number} keluar ke {$client->name}");
        });

        // Kembali ke halaman sebelumnya (bisa Dashboard atau Detail Realisasi)
        return redirect()->back()->with('success', 'Transaksi Keluar Berhasil Dicatat');
    }

    public function returnCylinder($id) {
        DB::transaction(function() use ($id) {
            $trx = Transaction::with('cylinder', 'client')->findOrFail($id);

            // Tutup transaksi
            $trx->update([
                'return_date' => now(),
                'status' => 'closed'
            ]);

            // Kembalikan status tabung jadi available
            $trx->cylinder->update(['status' => 'available']);

            // Catat Log
            HistoryLog::record('KEMBALI', "Tabung {$trx->cylinder->serial_number} kembali dari {$trx->client->name}");
        });

        return redirect()->back()->with('success', 'Tabung Berhasil Dikembalikan');
    }
}
