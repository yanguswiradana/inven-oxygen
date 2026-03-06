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
                $q->whereHas('client', function($q2) use ($search) { $q2->where('name', 'like', "%{$search}%"); })
                  ->orWhereHas('cylinder', function($q2) use ($search) { $q2->where('serial_number', 'like', "%{$search}%"); });
            });
        }

        $activeTransactions = $query->latest()->paginate(10)->withQueryString();
        $clients = Client::orderBy('name', 'asc')->get();

        // HANYA TABUNG PENUH YANG BISA DIKIRIM KE CLIENT
        $availableCylinders = Cylinder::where('status', 'available_full')->get();

        $stats = [
            'total'       => Cylinder::count(),
            'full'        => $availableCylinders->count(),
            'empty'       => Cylinder::where('status', 'available_empty')->count(),
            'at_supplier' => Cylinder::where('status', 'at_supplier')->count(),
            'rented'      => Cylinder::where('status', 'rented')->count(),
            'maintenance' => Cylinder::where('status', 'maintenance')->count(),
        ];

        $gasTypes = ['O2', 'CO2', 'N2', 'AR', 'C2H2'];
        $stockPerType = [];
        foreach ($gasTypes as $type) {
            $stockPerType[$type] = ['total' => 0, 'available_full' => 0, 'available_empty' => 0, 'rented' => 0];
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
            'category'    => 'required|in:sewa,hak_milik'
        ]);

        DB::transaction(function() use ($request) {
            $cyl = Cylinder::findOrFail($request->cylinder_id);
            if($cyl->status != 'available_full') throw new \Exception('Hanya tabung penuh yang bisa dikirim!');

            Transaction::create([
                'client_id'   => $request->client_id,
                'cylinder_id' => $request->cylinder_id,
                'category'    => $request->category,
                'rent_date'   => now(),
                'status'      => 'open'
            ]);

            $cyl->update(['status' => 'rented']);
            HistoryLog::record('KELUAR', "Tabung {$cyl->serial_number} dikirim ke ".Client::find($request->client_id)->name);
        });
        return redirect()->back()->with('success', 'Transaksi berhasil!');
    }

    public function returnCylinder($id) {
        DB::transaction(function() use ($id) {
            $trx = Transaction::with('cylinder', 'client')->findOrFail($id);
            $trx->update(['return_date' => now(), 'status' => 'closed']);

            // TABUNG KEMBALI OTOMATIS MENJADI KOSONG
            $trx->cylinder->update(['status' => 'available_empty']);
            HistoryLog::record('KEMBALI', "Tabung {$trx->cylinder->serial_number} kembali dari {$trx->client->name} (Kosong)");
        });
        return redirect()->back()->with('success', 'Tabung ditarik dan masuk gudang sebagai Kosong.');
    }

    public function swap(Request $request, $id) {
        $request->validate(['new_cylinder_id' => 'required|exists:cylinders,id']);

        DB::transaction(function() use ($request, $id) {
            $oldTrx = Transaction::with('cylinder', 'client')->findOrFail($id);
            $newCyl = Cylinder::findOrFail($request->new_cylinder_id);

            if($newCyl->status != 'available_full') throw new \Exception('Tabung pengganti harus Penuh!');

            // Tabung lama kembali dan jadi KOSONG
            $oldTrx->update(['return_date' => now(), 'status' => 'closed']);
            $oldTrx->cylinder->update(['status' => 'available_empty']);

            // Tabung baru keluar
            Transaction::create([
                'client_id'   => $oldTrx->client_id,
                'cylinder_id' => $newCyl->id,
                'category'    => $oldTrx->category,
                'rent_date'   => now(),
                'status'      => 'open'
            ]);
            $newCyl->update(['status' => 'rented']);

            HistoryLog::record('TUKAR', "Tabung {$oldTrx->cylinder->serial_number} ditukar dengan {$newCyl->serial_number} untuk {$oldTrx->client->name}");
        });
        return redirect()->back()->with('success', 'Berhasil ditukar!');
    }
}
