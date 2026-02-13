@extends('layouts.main')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Riwayat Aktivitas</h1>
    <p class="text-slate-500 text-sm mt-1">Jejak audit penggunaan sistem.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 font-semibold w-48">Waktu</th>
                    <th class="px-6 py-4 font-semibold w-32">Tipe</th>
                    <th class="px-6 py-4 font-semibold">Deskripsi Aktivitas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($logs as $log)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-mono text-xs text-slate-500">{{ $log->created_at->format('d/m/Y') }}</div>
                        <div class="font-bold text-slate-700">{{ $log->created_at->format('H:i') }} WIB</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($log->action == 'SEWA')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100 uppercase tracking-wide">
                                KELUAR
                            </span>
                        @elseif($log->action == 'KEMBALI')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-wide">
                                MASUK
                            </span>
                        @elseif(str_contains($log->action, 'CREATE'))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100 uppercase tracking-wide">
                                BARU
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200 uppercase tracking-wide">
                                {{ $log->action }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-700 font-medium">
                        {{ $log->description }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-10 text-center text-slate-400">Belum ada aktivitas tercatat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t border-slate-50 bg-slate-50/50">
        {{ $logs->links() }}
    </div>
</div>
@endsection
