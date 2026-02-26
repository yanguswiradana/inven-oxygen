@extends('layouts.main')

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('clients.index') }}" class="text-slate-500 hover:text-indigo-600 text-sm flex items-center gap-1 mb-2 transition-colors font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Data Realisasi
            </a>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Kartu Riwayat Realisasi</h1>
        </div>
        <div>
            <a href="{{ route('clients.edit', $client->id) }}" class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-medium py-2 px-4 rounded-xl text-sm transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Edit Profil
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-center">
            <div class="flex items-start gap-5">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold text-2xl flex-shrink-0 border-4 border-indigo-50">
                    {{ substr($client->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">{{ $client->name }}</h2>
                    <div class="mt-2 space-y-1">
                        <p class="text-slate-500 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ $client->phone ?? 'Tidak ada kontak' }}
                        </p>
                        <p class="text-slate-500 text-sm flex items-start gap-2">
                            <svg class="w-4 h-4 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $client->address ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl shadow-lg shadow-indigo-200 p-6 text-white relative overflow-hidden flex flex-col justify-center">
            <div class="relative z-10">
                <div class="mb-4">
                    <p class="text-indigo-200 text-xs font-bold uppercase tracking-wider mb-1">Tabung Belum Kembali</p>
                    <div class="text-4xl font-bold">{{ $client->transactions()->where('status', 'open')->count() }} <span class="text-lg font-normal text-indigo-200">Unit</span></div>
                </div>
                <div>
                    <p class="text-indigo-200 text-xs font-bold uppercase tracking-wider mb-1">Total Riwayat</p>
                    <div class="text-lg font-semibold">{{ $client->transactions()->count() }} <span class="text-sm font-normal text-indigo-200">Transaksi</span></div>
                </div>
            </div>
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-8 relative z-20">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </div>
            <div>
                <h3 class="font-bold text-slate-800">Transaksi Keluar (Sewa Baru)</h3>
                <p class="text-xs text-slate-400">Pilih tabung yang ingin dibawa oleh realisasi ini.</p>
            </div>
        </div>

        <form action="{{ route('transaction.store') }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-start sm:items-end">
            @csrf
            <input type="hidden" name="client_id" value="{{ $client->id }}">

            <div class="flex-1 w-full relative" x-data="cylinderSearch({ data: {{ Js::from($availableCylinders) }} })">
                <label class="flex justify-between items-center text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                    <span>Cari Nomor Seri Tabung Atau Tipe Gas</span>
                    <span class="text-[10px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-bold">Ready: {{ $availableCylinders->count() }}</span>
                </label>
                <input type="hidden" name="cylinder_id" x-model="selectedId">
                <div class="relative">
                    <input type="text" x-model="search" @focus="open = true" @click.outside="open = false" placeholder="Ketik nomor seri tabung atau tipe gas..." class="w-full px-4 py-3 pl-11 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder-slate-400" autocomplete="off">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <div x-show="open" x-transition.opacity.duration.200ms class="absolute z-30 w-full mt-2 bg-white border border-slate-100 rounded-xl shadow-xl max-h-60 overflow-y-auto" style="display: none;">
                    <ul>
                        <li x-show="filteredItems.length === 0" class="px-4 py-3 text-sm text-slate-400 text-center italic">Tabung tidak ditemukan.</li>
                        <template x-for="item in filteredItems" :key="item.id">
                            <li @click="selectItem(item)" class="px-4 py-3 hover:bg-indigo-50 cursor-pointer border-b border-slate-50 last:border-0 transition-colors group">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="font-bold text-slate-700 group-hover:text-indigo-700" x-text="item.serial_number"></div>
                                        <div class="text-xs text-slate-400" x-text="item.type"></div>
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

            <button type="submit" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-6 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                <span>Proses Kirim</span>
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative z-10">
        <div class="p-6 border-b border-slate-50 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-lg">Aktivitas Peminjaman</h3>
            <p class="text-slate-500 text-xs mt-1">Rekap waktu pengambilan dan pengembalian tabung.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No. Seri Tabung</th>
                        <th class="px-6 py-4 font-semibold">Waktu Pengambilan</th>
                        <th class="px-6 py-4 font-semibold">Waktu Pengembalian</th>
                        <th class="px-6 py-4 font-semibold">Balance Waktu</th>
                        <th class="px-6 py-4 font-semibold text-right">Status / Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-50 transition-colors group">

                        <td class="px-6 py-4">
                            <span class="font-mono text-xs font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1.5 rounded-lg border border-indigo-100 group-hover:bg-indigo-100 transition-colors">
                                {{ $trx->cylinder->serial_number }}
                            </span>
                            <div class="text-[10px] text-slate-400 mt-1.5">{{ $trx->cylinder->type }}</div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                <div>
                                    <div class="font-medium text-slate-700">{{ $trx->rent_date->translatedFormat('d F Y') }}</div>
                                    <div class="text-xs text-slate-400">{{ $trx->rent_date->format('H:i') }} WIB</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            @if($trx->return_date)
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                <div>
                                    <div class="font-medium text-slate-700">{{ $trx->return_date->translatedFormat('d F Y') }}</div>
                                    <div class="text-xs text-slate-400">{{ $trx->return_date->format('H:i') }} WIB</div>
                                </div>
                            </div>
                            @else
                                <span class="text-slate-400 text-xs italic px-2 py-1 bg-slate-100 rounded">Belum Kembali</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if($trx->status == 'open')
                                <div class="text-amber-600 font-bold text-xs bg-amber-50 px-2 py-1 rounded w-fit border border-amber-100">
                                    {{ $trx->rent_date->diffForHumans(now(), ['syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE, 'parts' => 2]) }}
                                </div>
                                <span class="text-[10px] text-slate-400 mt-1 block">Durasi berjalan...</span>
                            @else
                                <div class="text-slate-600 font-bold text-xs bg-slate-100 px-2 py-1 rounded w-fit border border-slate-200">
                                    {{ $trx->rent_date->diffForHumans($trx->return_date, ['syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE, 'parts' => 2]) }}
                                </div>
                                <span class="text-[10px] text-slate-400 mt-1 block">Total durasi sewa</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">
                            @if($trx->status == 'open')
                                <div class="flex flex-col items-end gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span> Dipinjam
                                    </span>

                                    <form action="{{ route('transaction.return', $trx->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button type="submit" class="text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 hover:bg-emerald-600 hover:text-white px-3 py-1.5 rounded-lg transition-colors shadow-sm">
                                            Terima Kembali
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Selesai
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center">
                                <svg class="w-10 h-10 text-slate-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                <span>Belum ada riwayat transaksi untuk client ini.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-50 bg-slate-50/50">
            {{ $transactions->links() }}
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
                    // Cari di Serial Number ATAU cari di Tipe Gas
                    return item.serial_number.toLowerCase().includes(searchTerm) ||
                           item.type.toLowerCase().includes(searchTerm);
                });
            },
            selectItem(item) {
                this.selectedId = item.id;
                // UX: Tampilkan Serial Number dan Tipenya di input setelah dipilih
                this.search = item.serial_number + ' (' + item.type + ')';
                this.open = false;
            }
        }));
    })
</script>
@endsection
