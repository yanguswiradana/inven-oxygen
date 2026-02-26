<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Cylinder;
use App\Models\HistoryLog;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        // LOGIKA PENCARIAN (BARU)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
        }

        // Tambahkan withQueryString() agar pagination tidak mereset hasil pencarian
        $clients = $query->latest()->paginate(10)->withQueryString();

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
