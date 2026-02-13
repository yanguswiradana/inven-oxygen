@extends('layouts.main')

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('clients.index') }}" class="text-slate-500 hover:text-indigo-600 text-sm flex items-center gap-1 mb-2 transition-colors font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Data Client
            </a>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Kartu Realisasi</h1>
        </div>
        <div>
            <a href="{{ route('clients.edit', $client->id) }}" class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-medium py-2 px-4 rounded-xl text-sm transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Edit Profil
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
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
                    <p class="text-indigo-200 text-xs font-bold uppercase tracking-wider mb-1">Total Transaksi</p>
                    <div class="text-lg font-semibold">{{ $client->transactions()->count() }} <span class="text-sm font-normal text-indigo-200">Kali</span></div>
                </div>
            </div>
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
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
                        <th class="px-6 py-4 font-semibold text-right">Status</th>
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
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span> Dipinjam
                                </span>
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
@endsection
