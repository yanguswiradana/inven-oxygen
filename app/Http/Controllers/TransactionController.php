<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\Client;
use App\Models\Cylinder;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller {
    public function index() {
        $activeTransactions = Transaction::with(['client', 'cylinder'])->where('status', 'open')->latest()->get();
        $clients = Client::all();
        $availableCylinders = Cylinder::where('status', 'available')->get();
        return view('dashboard', compact('activeTransactions', 'clients', 'availableCylinders'));
    }

    public function store(Request $request) {
        $request->validate(['client_id' => 'required', 'cylinder_id' => 'required|exists:cylinders,id']);
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
        return redirect()->route('dashboard')->with('success', 'Transaksi Berhasil');
    }

    public function returnCylinder($id) {
        DB::transaction(function() use ($id) {
            $trx = Transaction::with('cylinder', 'client')->findOrFail($id);
            $trx->update(['return_date' => now(), 'status' => 'closed']);
            $trx->cylinder->update(['status' => 'available']);
            HistoryLog::record('KEMBALI', "Tabung {$trx->cylinder->serial_number} kembali dari {$trx->client->name}");
        });
        return redirect()->route('dashboard')->with('success', 'Tabung Dikembalikan');
    }
}
