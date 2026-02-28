<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Client;
use App\Models\Cylinder;
use App\Models\HistoryLog;
use Illuminate\Http\Request; // Pastikan ini ada
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // Tambahkan parameter Request $request di method index
    public function index(Request $request) {

        // 1. DATA TRANSAKSI AKTIF DENGAN SEARCH & PAGINATION SERVER-SIDE
        $query = Transaction::with(['client', 'cylinder'])->where('status', 'open');

        // Jika admin mencari sesuatu di kolom Sedang Disewa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Cari dari nama client ATAU ...
                $q->whereHas('client', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                // ... Cari dari seri/tipe tabung
                ->orWhereHas('cylinder', function($q2) use ($search) {
                    $q2->where('serial_number', 'like', "%{$search}%")
                      ->orWhere('type', 'like', "%{$search}%");
                });
            });
        }

        // Paginate agar dashboard tidak panjang ke bawah
        $activeTransactions = $query->latest()->paginate(10)->withQueryString();

        // 2. Data Dropdown Form
        $clients = Client::orderBy('name', 'asc')->get();
        $availableCylinders = Cylinder::where('status', 'available')->get();

        // 3. Statistik Utama
        $stats = [
            'total'       => Cylinder::count(),
            'available'   => $availableCylinders->count(),
            'rented'      => Cylinder::where('status', 'rented')->count(),
            'maintenance' => Cylinder::where('status', 'maintenance')->count(),
        ];

        // 4. Statistik Per Tipe
        $gasTypes = ['O2', 'CO2', 'N2', 'AR', 'C2H2'];
        $stockPerType = [];

        foreach ($gasTypes as $type) {
            $stockPerType[$type] = ['total' => 0, 'available' => 0, 'rented' => 0, 'maintenance' => 0];
        }

        $cylinderStats = Cylinder::selectRaw('type, status, count(*) as count')
            ->groupBy('type', 'status')
            ->get();

        foreach ($cylinderStats as $stat) {
            if (array_key_exists($stat->type, $stockPerType)) {
                $stockPerType[$stat->type][$stat->status] = $stat->count;
                $stockPerType[$stat->type]['total'] += $stat->count;
            }
        }

        return view('dashboard', compact('activeTransactions', 'clients', 'availableCylinders', 'stats', 'stockPerType'));
    }

    public function store(Request $request) {
        $request->validate([
            'client_id' => 'required',
            'cylinder_id' => 'required|exists:cylinders,id'
        ]);

        DB::transaction(function() use ($request) {
            $cyl = Cylinder::findOrFail($request->cylinder_id);
            if($cyl->status != 'available') throw new \Exception('Tabung tidak tersedia');

            Transaction::create([
                'client_id' => $request->client_id,
                'cylinder_id' => $request->cylinder_id,
                'rent_date' => now(),
                'status' => 'open'
            ]);
            $cyl->update(['status' => 'rented']);
            $client = Client::findOrFail($request->client_id);
            HistoryLog::record('SEWA', "Tabung {$cyl->serial_number} keluar ke {$client->name}");
        });

        return redirect()->back()->with('success', 'Transaksi Keluar Berhasil Dicatat');
    }

    public function returnCylinder($id) {
        DB::transaction(function() use ($id) {
            $trx = Transaction::with('cylinder', 'client')->findOrFail($id);
            $trx->update(['return_date' => now(), 'status' => 'closed']);
            $trx->cylinder->update(['status' => 'available']);
            HistoryLog::record('KEMBALI', "Tabung {$trx->cylinder->serial_number} kembali dari {$trx->client->name}");
        });

        return redirect()->back()->with('success', 'Tabung Berhasil Dikembalikan');
    }
}
