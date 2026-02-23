<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Cylinder; // TAMBAHKAN INI
use App\Models\HistoryLog;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function create() { return view('clients.create'); }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $client = Client::create($validatedData);
        HistoryLog::record('CREATE CLIENT', "Menambah realisasi: {$client->name}");
        return redirect()->route('clients.index')->with('success', 'Data Realisasi ditambahkan');
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);
        $transactions = $client->transactions()
                               ->with('cylinder')
                               ->orderBy('rent_date', 'desc')
                               ->paginate(10);

        // AMBIL DATA TABUNG YANG TERSEDIA UNTUK FORM TRANSAKSI CEPAT
        $availableCylinders = Cylinder::where('status', 'available')->get();

        return view('clients.show', compact('client', 'transactions', 'availableCylinders'));
    }

    public function edit(Client $client) { return view('clients.edit', compact('client')); }

    public function update(Request $request, Client $client)
    {
        $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $client->update($validatedData);
        HistoryLog::record('UPDATE CLIENT', "Update data realisasi: {$client->name}");
        return redirect()->route('clients.index')->with('success', 'Data Realisasi diupdate');
    }
}
