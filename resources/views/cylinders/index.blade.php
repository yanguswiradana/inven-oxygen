@extends('layouts.main')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Data Tabung</h1>
        <p class="text-slate-500 text-sm mt-1">Master data aset tabung oksigen.</p>
    </div>
    <a href="{{ route('cylinders.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-3 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Tabung
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 font-semibold">Serial Number</th>
                    <th class="px-6 py-4 font-semibold">Tipe / Ukuran</th>
                    <th class="px-6 py-4 font-semibold">Status Saat Ini</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($cylinders as $cyl)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <span class="font-mono text-sm font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">{{ $cyl->serial_number }}</span>
                    </td>
                    <td class="px-6 py-4 text-slate-600 font-medium">{{ $cyl->type }}</td>
                    <td class="px-6 py-4">
                        @if($cyl->status == 'available')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Ready
                            </span>
                        @elseif($cyl->status == 'rented')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> Disewa
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Maintenance
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('cylinders.edit', $cyl->id) }}" class="inline-flex items-center gap-1 text-slate-500 hover:text-indigo-600 font-medium text-xs hover:underline transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-slate-400">Belum ada data tabung.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
