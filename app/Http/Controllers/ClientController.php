<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\HistoryLog;
use Illuminate\Http\Request;

class ClientController extends Controller {
    public function index() { $clients = Client::latest()->get(); return view('clients.index', compact('clients')); }
    public function create() { return view('clients.create'); }

    public function store(Request $request) {
        $client = Client::create($request->all());
        HistoryLog::record('CREATE CLIENT', "Menambah client: {$client->name}");
        return redirect()->route('clients.index')->with('success', 'Client ditambahkan');
    }

    public function edit(Client $client) { return view('clients.edit', compact('client')); }

    public function update(Request $request, Client $client) {
        $client->update($request->all());
        HistoryLog::record('UPDATE CLIENT', "Update client: {$client->name}");
        return redirect()->route('clients.index')->with('success', 'Client diupdate');
    }
}
