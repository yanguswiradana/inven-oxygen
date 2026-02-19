<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\HistoryLog;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Tampilkan daftar semua client
     */
    public function index() {
        $clients = Client::latest()->get();
        return view('clients.index', compact('clients'));
    }

    /**
     * Tampilkan Form Tambah Client
     */
    public function create() {
        return view('clients.create');
    }

    /**
     * Simpan Client Baru
     */
    public function store(Request $request) {
        $client = Client::create($request->all());
        HistoryLog::record('CREATE CLIENT', "Menambah client: {$client->name}");
        return redirect()->route('clients.index')->with('success', 'Client berhasil ditambahkan');
    }

    /**
     * Tampilkan Detail Client (KARTU RIWAYAT) - INI YANG BARU
     */
    public function show($id)
    {
        // 1. Ambil data client berdasarkan ID
        $client = Client::findOrFail($id);

        // 2. Ambil riwayat transaksi milik client ini
        // Kita load relasi 'cylinder' agar bisa menampilkan nomor seri tabung
        // Urutkan dari transaksi terbaru
        $transactions = $client->transactions()
                               ->with('cylinder')
                               ->orderBy('rent_date', 'desc')
                               ->paginate(10); // Batasi 10 per halaman

        return view('clients.show', compact('client', 'transactions'));
    }

    /**
     * Tampilkan Form Edit Client
     */
    public function edit(Client $client) {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update Data Client
     */
    public function update(Request $request, Client $client) {
        $client->update($request->all());
        HistoryLog::record('UPDATE CLIENT', "Update client: {$client->name}");
        return redirect()->route('clients.index')->with('success', 'Client berhasil diupdate');
    }

    /**
     * Hapus Client (Opsional jika dibutuhkan nanti)
     */
    public function destroy(Client $client) {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client dihapus');
    }
}
