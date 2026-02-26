<?php

namespace App\Http\Controllers;

use App\Models\Cylinder;
use App\Models\HistoryLog;
use Illuminate\Http\Request;

class CylinderController extends Controller
{
    public function index() {
        $cylinders = Cylinder::latest()->paginate(15);
        return view('cylinders.index', compact('cylinders'));
    }

    public function create() { return view('cylinders.create'); }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'serial_number' => 'required|string|unique:cylinders,serial_number',
            // VALIDASI STRICT HANYA 5 TIPE INI:
            'type'          => 'required|in:O2,CO2,N2,AR,C2H2',
            'status'        => 'required|in:available,rented,maintenance'
        ]);

        $cyl = Cylinder::create($validatedData);
        HistoryLog::record('CREATE TABUNG', "Menambah tabung baru: {$cyl->serial_number} ({$cyl->type})");
        return redirect()->route('cylinders.index')->with('success', 'Tabung berhasil ditambahkan');
    }

    public function edit(Cylinder $cylinder) { return view('cylinders.edit', compact('cylinder')); }

    public function update(Request $request, Cylinder $cylinder) {
        $validatedData = $request->validate([
            'serial_number' => 'required|string|unique:cylinders,serial_number,' . $cylinder->id,
            // VALIDASI STRICT HANYA 5 TIPE INI:
            'type'          => 'required|in:O2,CO2,N2,AR,C2H2',
            'status'        => 'required|in:available,rented,maintenance'
        ]);

        $cylinder->update($validatedData);
        HistoryLog::record('UPDATE TABUNG', "Update data tabung: {$cylinder->serial_number}");
        return redirect()->route('cylinders.index')->with('success', 'Data Tabung berhasil diupdate');
    }
}
