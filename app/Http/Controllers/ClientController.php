<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\HistoryLog;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Menampilkan daftar semua client
     */
    public function index()
    {
        $clients = Client::latest()->get();
        return view('clients.index', compact('clients'));
    }

    /**
     * Form tambah client baru
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Menyimpan data client baru ke database
     */
    public function store(Request $request)
    {
        // Validasi sederhana (opsional tapi disarankan)
        $request->validate([
            'name' => 'required',
        ]);

        $client = Client::create($request->all());

        HistoryLog::record('CREATE CLIENT', "Menambah client: {$client->name}");

        return redirect()->route('clients.index')->with('success', 'Client berhasil ditambahkan');
    }

    /**
     * Menampilkan Detail Kartu Realisasi (Fitur Baru)
     */
    public function show($id)
    {
        // 1. Ambil data client
        $client = Client::findOrFail($id);

        // 2. Ambil transaksi milik client ini
        // Load data 'cylinder' agar tahu nomor serinya dan urutkan dari yang terbaru
        $transactions = $client->transactions()
                               ->with('cylinder')
                               ->orderBy('rent_date', 'desc')
                               ->paginate(10);

        return view('clients.show', compact('client', 'transactions'));
    }

    /**
     * Form edit data client
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Memperbarui data client di database
     */
    public function update(Request $request, Client $client)
    {
        $client->update($request->all());

        HistoryLog::record('UPDATE CLIENT', "Update client: {$client->name}");

        return redirect()->route('clients.index')->with('success', 'Client berhasil diupdate');
    }

    /**
     * Menghapus data client
     */
    public function destroy(Client $client)
    {
        $clientName = $client->name;
        $client->delete();

        HistoryLog::record('DELETE CLIENT', "Menghapus client: {$clientName}");

        return redirect()->route('clients.index')->with('success', 'Client berhasil dihapus');
    }
}
