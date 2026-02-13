<?php

namespace App\Http\Controllers;
use App\Models\Cylinder;
use App\Models\HistoryLog;
use Illuminate\Http\Request;

class CylinderController extends Controller {
    public function index() { $cylinders = Cylinder::all(); return view('cylinders.index', compact('cylinders')); }
    public function create() { return view('cylinders.create'); }

    public function store(Request $request) {
        $cyl = Cylinder::create($request->all());
        HistoryLog::record('CREATE TABUNG', "Menambah tabung: {$cyl->serial_number}");
        return redirect()->route('cylinders.index')->with('success', 'Tabung ditambahkan');
    }

    public function edit(Cylinder $cylinder) { return view('cylinders.edit', compact('cylinder')); }

    public function update(Request $request, Cylinder $cylinder) {
        $cylinder->update($request->all());
        HistoryLog::record('UPDATE TABUNG', "Update tabung: {$cylinder->serial_number}");
        return redirect()->route('cylinders.index')->with('success', 'Tabung diupdate');
    }
}
