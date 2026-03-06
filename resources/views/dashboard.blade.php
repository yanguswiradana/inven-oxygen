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

<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-center">
        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Total Aset</div>
        <div class="text-2xl font-bold text-slate-800">{{ $stats['total'] }}</div>
    </div>
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-center border-b-4 border-b-emerald-500">
        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Gudang (Penuh)</div>
        <div class="text-2xl font-bold text-emerald-600">{{ $stats['full'] }}</div>
    </div>
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-center border-b-4 border-b-slate-400">
        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Gudang (Kosong)</div>
        <div class="text-2xl font-bold text-slate-600">{{ $stats['empty'] }}</div>
    </div>
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-center border-b-4 border-b-blue-500">
        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Di Pabrik (Isi)</div>
        <div class="text-2xl font-bold text-blue-600">{{ $stats['at_supplier'] }}</div>
    </div>
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-center border-b-4 border-b-amber-500">
        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Di Client</div>
        <div class="text-2xl font-bold text-amber-600">{{ $stats['rented'] }}</div>
    </div>
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-center border-b-4 border-b-red-500">
        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Perbaikan</div>
        <div class="text-2xl font-bold text-red-600">{{ $stats['maintenance'] }}</div>
    </div>
</div>

<div class="mb-8">
    <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-3">Rincian per Tipe Gas</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach($stockPerType as $type => $data)
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 relative overflow-hidden group hover:border-indigo-200 transition-colors">
            <div class="flex justify-between items-center mb-3">
                <span class="font-black text-slate-800 text-lg group-hover:text-indigo-600 transition-colors">{{ $type }}</span>
                <span class="text-sm font-bold bg-slate-100 text-slate-600 px-2 py-1 rounded-md">{{ $data['total'] }} Unit</span>
            </div>
            <div class="space-y-1.5 text-sm">
                <div class="flex justify-between items-center">
                    <span class="text-slate-500 text-[11px] font-medium flex items-center gap-1"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Penuh</span>
                    <span class="font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded text-sm">{{ $data['available_full'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-500 text-[11px] font-medium flex items-center gap-1"><span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span> Kosong</span>
                    <span class="font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded text-sm">{{ $data['available_empty'] }}</span>
                </div>
                <div class="pt-1.5 mt-1.5 border-t border-slate-50 flex justify-between items-center">
                    <span class="text-slate-400 text-[10px] font-medium uppercase">Di Client</span>
                    <span class="font-bold text-amber-600 text-sm">{{ $data['rented'] }}</span>
                </div>
            </div>
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </div>
        @endforeach
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
                    <h2 class="text-lg font-bold text-slate-800 leading-tight">Kirim Tabung Baru</h2>
                    <p class="text-slate-400 text-[11px]">Sewa baru atau titip jual.</p>
                </div>
            </div>

            <form action="{{ route('transaction.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Tagihan</label>
                    <div class="relative">
                        <select name="category" required class="appearance-none w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all cursor-pointer">
                            <option value="sewa">Sewa Tabung Bulanan</option>
                            <option value="hak_milik">Hak Milik (Refill Saja)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="relative" x-data="clientSearch({ data: {{ Js::from($clients) }} })">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Nama Realisasi</label>
                    <input type="hidden" name="client_id" x-model="selectedId" required>
                    <div class="relative">
                        <input type="text" x-model="search" @focus="open = true" @click.outside="open = false" placeholder="Ketik nama realisasi..." class="w-full px-4 py-3 pl-10 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all" autocomplete="off">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    <div x-show="open" class="absolute z-30 w-full mt-2 bg-white border border-slate-100 rounded-xl shadow-xl max-h-60 overflow-y-auto" style="display: none;">
                        <ul>
                            <template x-for="item in filteredItems" :key="item.id">
                                <li @click="selectItem(item)" class="px-4 py-3 hover:bg-indigo-50 cursor-pointer border-b border-slate-50 text-sm font-medium text-slate-700">
                                    <span x-text="item.name"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                <div class="relative" x-data="cylinderSearch({ data: {{ Js::from($availableCylinders) }} })">
                    <label class="flex justify-between items-center text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">
                        <span>Pilih Tabung (PENUH)</span>
                        <span class="text-[9px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full">Stok: {{ $availableCylinders->count() }}</span>
                    </label>
                    <input type="hidden" name="cylinder_id" x-model="selectedId" required>
                    <div class="relative">
                        <input type="text" x-model="search" @focus="open = true" @click.outside="open = false" placeholder="Cari seri tabung..." class="w-full px-4 py-3 pl-10 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all" autocomplete="off">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    <div x-show="open" class="absolute z-20 w-full mt-2 bg-white border border-slate-100 rounded-xl shadow-xl max-h-60 overflow-y-auto" style="display: none;">
                        <ul>
                            <template x-for="item in filteredItems" :key="item.id">
                                <li @click="selectItem(item)" class="px-4 py-3 hover:bg-indigo-50 cursor-pointer border-b border-slate-50 flex justify-between items-center">
                                    <div class="font-bold text-slate-700 text-sm" x-text="item.serial_number"></div>
                                    <div class="text-[10px] bg-emerald-50 text-emerald-600 px-1.5 py-0.5 rounded" x-text="item.type"></div>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-md mt-4 text-sm">
                    Kirim Tabung
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden min-h-[500px] flex flex-col">
            <div class="p-6 border-b border-slate-50 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-slate-50/30">
                <div>
                    <h2 class="font-bold text-slate-800 text-lg">Daftar Tabung Di Luar</h2>
                </div>
                <form action="{{ route('dashboard') }}" method="GET" class="relative w-full sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="w-full pl-9 pr-8 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-sm text-left">
                    <thead class="text-[11px] text-slate-400 uppercase bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Nama Realisasi</th>
                            <th class="px-6 py-4 font-semibold">Tabung & Info</th>
                            <th class="px-6 py-4 font-semibold">Tgl Keluar</th>
                            <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($activeTransactions as $trx)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-800">{{ $trx->client->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-mono text-xs font-bold bg-slate-100 px-2 py-1 rounded-lg border">{{ $trx->cylinder->serial_number }}</span>
                                    <span class="text-[10px] font-bold px-2 py-1 bg-indigo-50 text-indigo-600 rounded">{{ $trx->cylinder->type }}</span>
                                </div>
                                @if($trx->category == 'sewa')
                                    <span class="text-[10px] text-slate-500 font-medium flex items-center gap-1"><span class="w-1.5 h-1.5 bg-amber-400 rounded-full"></span> Sewa</span>
                                @else
                                    <span class="text-[10px] text-slate-500 font-medium flex items-center gap-1"><span class="w-1.5 h-1.5 bg-purple-500 rounded-full"></span> Hak Milik</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                                <div class="text-xs font-medium">{{ $trx->rent_date->format('d M Y') }}</div>

                                @if(\Carbon\Carbon::parse($trx->rent_date)->diffInDays(now()) >= 14)
                                    <div class="mt-1.5 inline-flex items-center gap-1 px-2 py-0.5 bg-red-50 text-red-600 text-[10px] font-bold rounded border border-red-200 animate-pulse">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        > 14 Hari
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" @click="$dispatch('open-swap-modal', { trxId: '{{ $trx->id }}', clientName: '{{ $trx->client->name }}', oldCylinder: '{{ $trx->cylinder->serial_number }}', type: '{{ $trx->cylinder->type }}' })" class="text-[11px] font-bold text-blue-600 bg-blue-50 border border-blue-100 hover:bg-blue-600 hover:text-white px-2.5 py-1.5 rounded transition shadow-sm">
                                        Tukar Penuh
                                    </button>
                                    <form action="{{ route('transaction.return', $trx->id) }}" method="POST" onsubmit="return confirm('Tarik tabung ini (Kosong) ke gudang?')">
                                        @csrf @method('PUT')
                                        <button class="text-[11px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 hover:bg-emerald-600 hover:text-white px-2.5 py-1.5 rounded transition shadow-sm">Terima</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-10 text-center text-slate-400">Data Kosong</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-50 bg-slate-50/50">
                {{ $activeTransactions->links() }}
            </div>
        </div>
    </div>
</div>

<div x-data="{ open: false, trxId: '', clientName: '', oldCylinder: '', type: '' }"
     @open-swap-modal.window="open = true; trxId = $event.detail.trxId; clientName = $event.detail.clientName; oldCylinder = $event.detail.oldCylinder; type = $event.detail.type"
     x-show="open" class="fixed inset-0 z-50 flex items-center justify-center px-4" style="display: none;">
    <div x-show="open" @click="open = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
    <div x-show="open" class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 z-50">
        <div class="mb-5 border-b border-slate-100 pb-4">
            <h3 class="text-lg font-bold text-slate-800">Proses Tukar Isi Ulang</h3>
            <p class="text-sm text-slate-500 mt-1">Pelanggan: <span class="font-bold text-slate-700" x-text="clientName"></span></p>
            <p class="text-sm text-slate-500">Kembali: <span class="font-bold text-red-500" x-text="oldCylinder"></span> (Akan jadi KOSONG)</p>
        </div>
        <form :action="`/transaction/${trxId}/swap`" method="POST">
            @csrf
            <div class="relative mb-6" x-data="cylinderSearch({ data: {{ Js::from($availableCylinders) }} })">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kirim Tabung Baru (Penuh)</label>
                <input type="hidden" name="new_cylinder_id" x-model="selectedId" required>
                <div class="relative">
                    <input type="text" x-model="search" @focus="open = true" @click.outside="open = false" placeholder="Ketik nomor seri tabung penuh..." class="w-full px-4 py-3 pl-11 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none" autocomplete="off">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <div x-show="open" class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-xl shadow-xl max-h-48 overflow-y-auto" style="display: none;">
                    <ul>
                        <template x-for="item in filteredItems" :key="item.id">
                            <li @click="selectItem(item)" class="px-4 py-3 hover:bg-blue-50 cursor-pointer border-b border-slate-50 flex justify-between text-sm font-bold text-slate-700">
                                <span x-text="item.serial_number"></span>
                                <span class="text-[10px] text-emerald-600 bg-emerald-50 px-2 py-1 rounded">Penuh</span>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" @click="open = false" class="px-4 py-2 rounded-xl text-slate-600 bg-slate-100 font-bold text-sm">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl text-white bg-blue-600 font-bold text-sm">Tukar Tabung</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('cylinderSearch', (config) => ({
            items: config.data, search: '', selectedId: '', open: false,
            get filteredItems() {
                if (this.search === '') return this.items;
                return this.items.filter(item => item.serial_number.toLowerCase().includes(this.search.toLowerCase()) || item.type.toLowerCase().includes(this.search.toLowerCase()));
            },
            selectItem(item) { this.selectedId = item.id; this.search = item.serial_number + ' (' + item.type + ')'; this.open = false; }
        }));
        Alpine.data('clientSearch', (config) => ({
            items: config.data, search: '', selectedId: '', open: false,
            get filteredItems() {
                if (this.search === '') return this.items;
                return this.items.filter(item => item.name.toLowerCase().includes(this.search.toLowerCase()));
            },
            selectItem(item) { this.selectedId = item.id; this.search = item.name; this.open = false; }
        }));
    })
</script>
@endsection
