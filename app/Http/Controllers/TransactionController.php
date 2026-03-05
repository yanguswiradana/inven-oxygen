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
    public function index(Request $request) {
        $query = Transaction::with(['client', 'cylinder'])->where('status', 'open');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('client', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })->orWhereHas('cylinder', function($q2) use ($search) {
                    $q2->where('serial_number', 'like', "%{$search}%")
                      ->orWhere('type', 'like', "%{$search}%");
                });
            });
        }

        $activeTransactions = $query->latest()->paginate(10)->withQueryString();
        $clients = Client::orderBy('name', 'asc')->get();
        $availableCylinders = Cylinder::where('status', 'available')->get();

        $stats = [
            'total'       => Cylinder::count(),
            'available'   => $availableCylinders->count(),
            'rented'      => Cylinder::where('status', 'rented')->count(),
            'maintenance' => Cylinder::where('status', 'maintenance')->count(),
        ];

        $gasTypes = ['O2', 'CO2', 'N2', 'AR', 'C2H2'];
        $stockPerType = [];

        foreach ($gasTypes as $type) {
            $stockPerType[$type] = ['total' => 0, 'available' => 0, 'rented' => 0, 'maintenance' => 0];
        }

        $cylinderStats = Cylinder::selectRaw('type, status, count(*) as count')->groupBy('type', 'status')->get();

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
            'client_id'   => 'required',
            'cylinder_id' => 'required|exists:cylinders,id',
            'category'    => 'required|in:sewa,hak_milik' // Validasi Kategori Baru
        ]);

        DB::transaction(function() use ($request) {
            $cyl = Cylinder::findOrFail($request->cylinder_id);
            if($cyl->status != 'available') throw new \Exception('Tabung tidak tersedia');

            Transaction::create([
                'client_id'   => $request->client_id,
                'cylinder_id' => $request->cylinder_id,
                'category'    => $request->category, // Masukkan Kategori
                'rent_date'   => now(),
                'status'      => 'open'
            ]);

            $cyl->update(['status' => 'rented']);
            $client = Client::findOrFail($request->client_id);

            $label = $request->category == 'sewa' ? 'Sewa Baru' : 'Isi Ulang (Hak Milik)';
            HistoryLog::record('KELUAR', "[$label] Tabung {$cyl->serial_number} keluar ke {$client->name}");
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

    // FUNGSI BARU: LOGIKA 1-CLICK SWAP (TUKAR TABUNG)
    public function swap(Request $request, $id) {
        $request->validate([
            'new_cylinder_id' => 'required|exists:cylinders,id'
        ]);

        DB::transaction(function() use ($request, $id) {
            // 1. Tarik data transaksi & tabung lama
            $oldTrx = Transaction::with('cylinder', 'client')->findOrFail($id);
            $newCyl = Cylinder::findOrFail($request->new_cylinder_id);

            if($newCyl->status != 'available') throw new \Exception('Tabung pengganti tidak tersedia');

            // 2. Tutup Transaksi Lama (Kembalikan ke gudang)
            $oldTrx->update(['return_date' => now(), 'status' => 'closed']);
            $oldTrx->cylinder->update(['status' => 'available']);

            // 3. Buka Transaksi Baru (Kasih tabung yang sudah diisi)
            Transaction::create([
                'client_id'   => $oldTrx->client_id,
                'cylinder_id' => $newCyl->id,
                'category'    => $oldTrx->category, // Kategori otomatis ngikut yang lama
                'rent_date'   => now(),
                'status'      => 'open'
            ]);
            $newCyl->update(['status' => 'rented']);

            // 4. Catat Log
            HistoryLog::record('TUKAR', "Tabung {$oldTrx->cylinder->serial_number} ditukar dengan {$newCyl->serial_number} untuk {$oldTrx->client->name}");
        });

        return redirect()->back()->with('success', 'Tabung berhasil ditukar!');
    }
}
