@extends('layouts.main')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Dashboard</h1>
        <p class="text-slate-500 text-sm mt-1">Pantau sirkulasi tabung secara real-time.</p>
    </div>
    <div class="bg-white border border-slate-200 text-slate-600 px-4 py-2 rounded-xl text-sm font-medium shadow-sm flex items-center gap-2">
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        {{ now()->format('d F Y') }}
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800 leading-tight">Transaksi Keluar</h2>
                    <p class="text-slate-400 text-xs">Kirim tabung ke client.</p>
                </div>
            </div>

            <form action="{{ route('transaction.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="relative">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Client</label>
                    <div class="relative">
                        <select name="client_id" class="appearance-none w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all cursor-pointer">
                            <option value="" disabled selected>-- Pilih Client --</option>
                            @foreach($clients as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <label class="flex justify-between items-center text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        <span>Pilih Tabung</span>
                        <span class="text-[10px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-bold">Ready: {{ $availableCylinders->count() }}</span>
                    </label>
                    <div class="relative">
                        <select name="cylinder_id" class="appearance-none w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all cursor-pointer">
                            @if($availableCylinders->isEmpty())
                                <option disabled selected>Stok Habis!</option>
                            @else
                                <option value="" disabled selected>-- Pilih Serial Number --</option>
                                @foreach($availableCylinders as $cyl)
                                    <option value="{{ $cyl->id }}">{{ $cyl->serial_number }} ({{ $cyl->type }})</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-200 flex justify-center items-center gap-2 group mt-4">
                    <span>Proses Kirim</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden min-h-[500px]">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                <div>
                    <h2 class="font-bold text-slate-800 text-lg">Sedang Disewa</h2>
                    <p class="text-slate-400 text-xs mt-1">Daftar tabung yang ada di client.</p>
                </div>
                <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200 shadow-sm">
                    {{ $activeTransactions->count() }} Unit Diluar
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Client</th>
                            <th class="px-6 py-4 font-semibold">Tabung</th>
                            <th class="px-6 py-4 font-semibold">Tgl Sewa</th>
                            <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($activeTransactions as $trx)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $trx->client->name }}</div>
                                <div class="text-xs text-slate-400 mt-0.5 group-hover:text-indigo-500 transition-colors">ID: #{{ $trx->client->id }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs font-bold bg-slate-100 text-slate-700 px-2.5 py-1.5 rounded-lg border border-slate-200">
                                    {{ $trx->cylinder->serial_number }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                <div class="text-xs font-medium">{{ $trx->rent_date->format('d M Y') }}</div>
                                <div class="text-[10px] text-slate-400 mt-0.5">{{ $trx->rent_date->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('transaction.return', $trx->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button class="text-xs font-bold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-lg transition-colors border border-emerald-100 hover:border-emerald-200 shadow-sm">
                                        Terima Kembali
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                    </div>
                                    <h3 class="text-slate-800 font-medium">Semua Tabung Aman</h3>
                                    <p class="text-slate-400 text-sm mt-1">Tidak ada tabung yang sedang disewa saat ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
