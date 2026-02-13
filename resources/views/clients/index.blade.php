@extends('layouts.main')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Data Client</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola data pelanggan/realisasi.</p>
    </div>
    <a href="{{ route('clients.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-3 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Client
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 font-semibold">Nama Realisasi</th>
                    <th class="px-6 py-4 font-semibold">Kontak</th>
                    <th class="px-6 py-4 font-semibold">Alamat</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($clients as $client)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800">{{ $client->name }}</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">Terdaftar: {{ $client->created_at->format('d M Y') }}</div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">
                        @if($client->phone)
                            <div class="flex items-center gap-2 bg-slate-50 w-fit px-2 py-1 rounded text-xs font-mono">
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $client->phone }}
                            </div>
                        @else
                            <span class="text-slate-400 text-xs italic">Tidak ada nomor</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-500 max-w-xs truncate">{{ $client->address ?? '-' }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('clients.edit', $client->id) }}" class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 font-medium text-xs hover:underline bg-indigo-50 px-3 py-1.5 rounded-lg transition-colors">
                            Edit Data
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-slate-400">Belum ada data client.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
