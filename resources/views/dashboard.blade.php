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

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 2a1 1 0 0 1 1 1v1h8V3a1 1 0 0 1 1-1v2.586a1 1 0 0 1-.293.707l-1 1A1 1 0 0 1 15 7h-6a1 1 0 0 1-.707-.293l-1-1A1 1 0 0 1 7 4.586V2z"/><path d="M6 8a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v10a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V8z"/></svg>
        </div>
        <div>
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total Aset</div>
            <div class="text-2xl font-bold text-slate-800">{{ $stats['total'] }} <span class="text-xs font-normal text-slate-400">Unit</span></div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <div>
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">Tersedia</div>
            <div class="text-2xl font-bold text-emerald-600">{{ $stats['available'] }} <span class="text-xs font-normal text-slate-400">Unit</span></div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">Disewa</div>
            <div class="text-2xl font-bold text-amber-600">{{ $stats['rented'] }} <span class="text-xs font-normal text-slate-400">Unit</span></div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </div>
        <div>
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">Perbaikan</div>
            <div class="text-2xl font-bold text-red-600">{{ $stats['maintenance'] }} <span class="text-xs font-normal text-slate-400">Unit</span></div>
        </div>
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
                    <span class="text-slate-500 text-xs font-medium">Ready</span>
                    <span class="font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded text-sm">{{ $data['available'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-500 text-xs font-medium">Disewa</span>
                    <span class="font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded text-sm">{{ $data['rented'] }}</span>
                </div>
                <div class="pt-1.5 mt-1.5 border-t border-slate-50 flex justify-between items-center">
                    <span class="text-slate-400 text-[10px] font-medium uppercase">Rusak</span>
                    <span class="font-bold text-red-600 text-sm">{{ $data['maintenance'] }}</span>
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
                    <h2 class="text-lg font-bold text-slate-800 leading-tight">Transaksi Keluar</h2>
                    <p class="text-slate-400 text-xs">Kirim tabung ke realisasi.</p>
                </div>
            </div>

            <form action="{{ route('transaction.store') }}" method="POST" class="space-y-5">
                @csrf
                <div class="relative" x-data="clientSearch({ data: {{ Js::from($clients) }} })">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Nama Realisasi</label>
                    <input type="hidden" name="client_id" x-model="selectedId">
                    <div class="relative">
                        <input type="text" x-model="search" @focus="open = true" @click.outside="open = false" placeholder="Ketik nama realisasi..." class="w-full px-4 py-3.5 pl-11 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder-slate-400" autocomplete="off">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    <div x-show="open" x-transition.opacity.duration.200ms class="absolute z-30 w-full mt-2 bg-white border border-slate-100 rounded-xl shadow-xl max-h-60 overflow-y-auto" style="display: none;">
                        <ul>
                            <li x-show="filteredItems.length === 0" class="px-4 py-3 text-sm text-slate-400 text-center italic">Realisasi tidak ditemukan.</li>
                            <template x-for="item in filteredItems" :key="item.id">
                                <li @click="selectItem(item)" class="px-4 py-3 hover:bg-indigo-50 cursor-pointer border-b border-slate-50 last:border-0 transition-colors group">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <div class="font-bold text-slate-700 group-hover:text-indigo-700" x-text="item.name"></div>
                                            <div class="text-xs text-slate-400" x-text="item.address ? item.address.substring(0, 30) + '...' : 'Tidak ada alamat'"></div>
                                        </div>
                                    </div>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                <div class="relative" x-data="cylinderSearch({ data: {{ Js::from($availableCylinders) }} })">
                    <label class="flex justify-between items-center text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        <span>Pilih Tabung</span>
                        <span class="text-[10px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-bold">Ready: {{ $availableCylinders->count() }}</span>
                    </label>

                    <input type="hidden" name="cylinder_id" x-model="selectedId">
                    <div class="relative">
                        <input type="text" x-model="search" @focus="open = true" @click.outside="open = false" placeholder="Cari seri atau tipe gas (cth: O2)..." class="w-full px-4 py-3.5 pl-11 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder-slate-400" autocomplete="off">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>

                    <div x-show="open" x-transition.opacity.duration.200ms class="absolute z-20 w-full mt-2 bg-white border border-slate-100 rounded-xl shadow-xl max-h-60 overflow-y-auto" style="display: none;">
                        <ul>
                            <li x-show="filteredItems.length === 0" class="px-4 py-3 text-sm text-slate-400 text-center italic">Tabung tidak ditemukan.</li>
                            <template x-for="item in filteredItems" :key="item.id">
                                <li @click="selectItem(item)" class="px-4 py-3 hover:bg-indigo-50 cursor-pointer border-b border-slate-50 last:border-0 transition-colors group">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <div class="font-bold text-slate-700 group-hover:text-indigo-700" x-text="item.serial_number"></div>
                                            <div class="text-xs text-slate-400 font-semibold text-indigo-500" x-text="item.type"></div>
                                        </div>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-100 text-emerald-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Ready
                                        </span>
                                    </div>
                                </li>
                            </template>
                        </ul>
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
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden min-h-[500px] flex flex-col">

            <div class="p-6 border-b border-slate-50 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-slate-50/30">
                <div>
                    <h2 class="font-bold text-slate-800 text-lg">Sedang Disewa</h2>
                    <p class="text-slate-400 text-xs mt-1">Daftar tabung yang ada di realisasi.</p>
                </div>

                <form action="{{ route('dashboard') }}" method="GET" class="relative w-full sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, seri, tipe..." class="w-full pl-9 pr-8 py-2 rounded-xl border border-slate-200 bg-white text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-shadow shadow-sm">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    @if(request('search'))
                        <a href="{{ route('dashboard') }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-red-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold whitespace-nowrap">Nama Realisasi</th>
                            <th class="px-6 py-4 font-semibold whitespace-nowrap">Tabung & Tipe</th>
                            <th class="px-6 py-4 font-semibold whitespace-nowrap">Tgl Sewa</th>
                            <th class="px-6 py-4 font-semibold text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($activeTransactions as $trx)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-slate-800">{{ $trx->client->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono text-xs font-bold bg-slate-100 text-slate-700 px-2 py-1 rounded-lg border border-slate-200">
                                        {{ $trx->cylinder->serial_number }}
                                    </span>
                                    <span class="text-[10px] font-bold px-2 py-1 bg-indigo-50 text-indigo-600 rounded">
                                        {{ $trx->cylinder->type }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                                <div class="text-xs font-medium">{{ $trx->rent_date->format('d M Y') }}</div>
                                <div class="text-[10px] text-slate-400 mt-0.5">{{ $trx->rent_date->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
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
                                    @if(request('search'))
                                        <h3 class="text-slate-800 font-medium">Pencarian Tidak Ditemukan</h3>
                                        <p class="text-slate-400 text-sm mt-1">Tidak ada tabung atau client yang sesuai dengan "{{ request('search') }}".</p>
                                    @else
                                        <h3 class="text-slate-800 font-medium">Semua Tabung Aman</h3>
                                        <p class="text-slate-400 text-sm mt-1">Tidak ada tabung yang sedang disewa saat ini.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
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

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('cylinderSearch', (config) => ({
            items: config.data,
            search: '',
            selectedId: '',
            open: false,
            get filteredItems() {
                if (this.search === '') { return this.items; }
                const searchTerm = this.search.toLowerCase();
                return this.items.filter(item => {
                    return item.serial_number.toLowerCase().includes(searchTerm) ||
                           item.type.toLowerCase().includes(searchTerm);
                });
            },
            selectItem(item) {
                this.selectedId = item.id;
                this.search = item.serial_number + ' (' + item.type + ')';
                this.open = false;
            }
        }));

        Alpine.data('clientSearch', (config) => ({
            items: config.data,
            search: '',
            selectedId: '',
            open: false,
            get filteredItems() {
                if (this.search === '') { return this.items; }
                return this.items.filter(item => {
                    return item.name.toLowerCase().includes(this.search.toLowerCase());
                });
            },
            selectItem(item) {
                this.selectedId = item.id;
                this.search = item.name;
                this.open = false;
            }
        }));
    })
</script>
@endsection
