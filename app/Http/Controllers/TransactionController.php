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
    public function index()
    {
        // 1. Data Transaksi Aktif (Sewa)
        $activeTransactions = Transaction::with(['client', 'cylinder'])
                             ->where('status', 'open')
                             ->latest()
                             ->get();

        // 2. Data Dropdown
        $clients = Client::orderBy('name', 'asc')->get();
        $availableCylinders = Cylinder::where('status', 'available')->get();

        // 3. Data Statistik Dashboard (BARU)
        $stats = [
            'total'       => Cylinder::count(),
            'available'   => $availableCylinders->count(),
            'rented'      => Cylinder::where('status', 'rented')->count(),
            'maintenance' => Cylinder::where('status', 'maintenance')->count(),
        ];

        return view('dashboard', compact('activeTransactions', 'clients', 'availableCylinders', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'cylinder_id' => 'required|exists:cylinders,id',
        ]);

        DB::transaction(function() use ($request) {
            $cyl = Cylinder::findOrFail($request->cylinder_id);

            // Validasi status tabung
            if($cyl->status != 'available') {
                throw new \Exception('Tabung tidak tersedia (Status: ' . $cyl->status . ')');
            }

            // Buat Transaksi
            Transaction::create([
                'client_id' => $request->client_id,
                'cylinder_id' => $request->cylinder_id,
                'rent_date' => now(),
                'status' => 'open'
            ]);

            // Update Status Tabung
            $cyl->update(['status' => 'rented']);

            // Catat Log
            $client = Client::findOrFail($request->client_id);
            HistoryLog::record('SEWA', "Tabung {$cyl->serial_number} keluar ke {$client->name}");
        });

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil dicatat.');
    }

    public function returnCylinder($id)
    {
        DB::transaction(function() use ($id) {
            $trx = Transaction::with('cylinder', 'client')->findOrFail($id);

            // Update Transaksi
            $trx->update([
                'return_date' => now(),
                'status' => 'closed'
            ]);

            // Update Tabung jadi Available
            $trx->cylinder->update(['status' => 'available']);

            // Log
            HistoryLog::record('KEMBALI', "Tabung {$trx->cylinder->serial_number} kembali dari {$trx->client->name}");
        });

        return redirect()->route('dashboard')->with('success', 'Tabung berhasil dikembalikan.');
    }
}
