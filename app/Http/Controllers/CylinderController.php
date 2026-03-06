<?php

namespace App\Http\Controllers;

use App\Models\Cylinder;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CylinderController extends Controller
{
    public function index(Request $request)
    {
        $query = Cylinder::with(['activeTransaction.client']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('serial_number', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
        }

        $cylinders = $query->latest()->paginate(15)->withQueryString();

        return view('cylinders.index', compact('cylinders'));
    }

    public function create() { return view('cylinders.create'); }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'serial_number' => 'required|string|unique:cylinders,serial_number',
            'type'          => 'required|in:O2,CO2,N2,AR,C2H2',
            'status'        => 'required|in:available_full,available_empty,at_supplier,maintenance'
        ]);

        $cyl = Cylinder::create($validatedData);
        HistoryLog::record('CREATE TABUNG', "Menambah tabung baru: {$cyl->serial_number} ({$cyl->type})");
        return redirect()->route('cylinders.index')->with('success', 'Tabung berhasil ditambahkan');
    }

    public function edit(Cylinder $cylinder) { return view('cylinders.edit', compact('cylinder')); }

    public function update(Request $request, Cylinder $cylinder) {
        $validatedData = $request->validate([
            'serial_number' => 'required|string|unique:cylinders,serial_number,' . $cylinder->id,
            'type'          => 'required|in:O2,CO2,N2,AR,C2H2',
            'status'        => 'required|in:available_full,available_empty,at_supplier,rented,maintenance'
        ]);

        $cylinder->update($validatedData);
        HistoryLog::record('UPDATE TABUNG', "Update data tabung: {$cylinder->serial_number}");
        return redirect()->route('cylinders.index')->with('success', 'Data Tabung berhasil diupdate');
    }

    // ========================================================================
    // FITUR MANAJEMEN PABRIK (PENGISIAN MASSAL)
    // ========================================================================

    public function factoryIndex() {
        // Ambil semua tabung kosong di gudang
        $emptyCylinders = Cylinder::where('status', 'available_empty')
                                  ->orderBy('type')
                                  ->orderBy('serial_number')
                                  ->get();

        // Ambil semua tabung yang saat ini sedang di pabrik
        $atSupplierCylinders = Cylinder::where('status', 'at_supplier')
                                       ->orderBy('type')
                                       ->orderBy('serial_number')
                                       ->get();

        return view('cylinders.factory', compact('emptyCylinders', 'atSupplierCylinders'));
    }

    public function sendToFactory(Request $request) {
        $request->validate([
            'cylinder_ids'   => 'required|array',
            'cylinder_ids.*' => 'exists:cylinders,id'
        ], [
            'cylinder_ids.required' => 'Pilih minimal satu tabung untuk dikirim.'
        ]);

        DB::transaction(function() use ($request) {
            // Update massal status menjadi di pabrik
            Cylinder::whereIn('id', $request->cylinder_ids)
                    ->where('status', 'available_empty')
                    ->update(['status' => 'at_supplier']);

            // Catat log sejarah
            $count = count($request->cylinder_ids);
            HistoryLog::record('KE PABRIK', "Mengirim {$count} tabung kosong ke pabrik untuk diisi ulang.");
        });

        return redirect()->back()->with('success', count($request->cylinder_ids) . ' Tabung berhasil diberangkatkan ke Pabrik.');
    }

    public function receiveFromFactory(Request $request) {
        $request->validate([
            'cylinder_ids'   => 'required|array',
            'cylinder_ids.*' => 'exists:cylinders,id'
        ], [
            'cylinder_ids.required' => 'Pilih minimal satu tabung untuk diterima.'
        ]);

        DB::transaction(function() use ($request) {
            // Update massal status menjadi penuh dan siap jual
            Cylinder::whereIn('id', $request->cylinder_ids)
                    ->where('status', 'at_supplier')
                    ->update(['status' => 'available_full']);

            // Catat log sejarah
            $count = count($request->cylinder_ids);
            HistoryLog::record('DARI PABRIK', "Menerima {$count} tabung dari pabrik. Status sekarang: Isi Penuh.");
        });

        return redirect()->back()->with('success', count($request->cylinder_ids) . ' Tabung (Isi Penuh) berhasil masuk kembali ke gudang.');
    }
}
