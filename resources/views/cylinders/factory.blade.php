@extends('layouts.main')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Manajemen Pengisian Pabrik</h1>
    <p class="text-slate-500 text-sm mt-1">Kirim tabung kosong dan terima tabung penuh secara massal.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col h-full">
        <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
            <div>
                <h2 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Gudang (Tabung Kosong)
                </h2>
                <p class="text-slate-500 text-xs mt-1">Pilih tabung yang dibawa truk ke pabrik.</p>
            </div>
            <span class="bg-slate-200 text-slate-700 px-3 py-1 rounded-full text-xs font-bold">{{ $emptyCylinders->count() }} Stok</span>
        </div>

        <form action="{{ route('cylinders.send_factory') }}" method="POST" class="flex flex-col flex-1"
              x-data="{
                  selected: [],
                  allIds: {{ $emptyCylinders->pluck('id') }},
                  get allSelected() { return this.selected.length === this.allIds.length && this.allIds.length > 0; },
                  toggleAll() { this.selected = this.allSelected ? [] : [...this.allIds]; }
              }">
            @csrf

            <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-[11px] text-slate-400 uppercase bg-slate-50 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th class="px-6 py-4 font-semibold w-12">
                                <input type="checkbox" :checked="allSelected" @change="toggleAll" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500 cursor-pointer">
                            </th>
                            <th class="px-6 py-4 font-semibold">Nomor Seri</th>
                            <th class="px-6 py-4 font-semibold">Tipe Gas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($emptyCylinders as $cyl)
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" @click="if($event.target.tagName !== 'INPUT') { const idx = selected.indexOf({{ $cyl->id }}); if(idx > -1) selected.splice(idx, 1); else selected.push({{ $cyl->id }}); }">
                            <td class="px-6 py-3">
                                <input type="checkbox" name="cylinder_ids[]" value="{{ $cyl->id }}" x-model="selected" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500 cursor-pointer">
                            </td>
                            <td class="px-6 py-3 font-mono font-bold text-slate-700">{{ $cyl->serial_number }}</td>
                            <td class="px-6 py-3">
                                <span class="text-[10px] font-bold px-2 py-1 bg-slate-100 text-slate-600 rounded">{{ $cyl->type }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-6 py-12 text-center text-slate-400">Tidak ada tabung kosong di gudang saat ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-slate-100 bg-slate-50 mt-auto">
                <button type="submit" :disabled="selected.length === 0" :class="selected.length === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-indigo-700 hover:shadow-lg'" class="w-full bg-indigo-600 text-white font-bold py-3.5 rounded-xl transition-all flex items-center justify-center gap-2">
                    <span>Berangkatkan ke Pabrik</span>
                    <span x-show="selected.length > 0" x-text="`(${selected.length} Tabung)`" class="bg-white/20 px-2 py-0.5 rounded text-xs"></span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col h-full">
        <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
            <div>
                <h2 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    Sedang Di Pabrik
                </h2>
                <p class="text-slate-500 text-xs mt-1">Pilih tabung yang sudah selesai diisi (Penuh).</p>
            </div>
            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">{{ $atSupplierCylinders->count() }} Antri</span>
        </div>

        <form action="{{ route('cylinders.receive_factory') }}" method="POST" class="flex flex-col flex-1"
              x-data="{
                  selected: [],
                  allIds: {{ $atSupplierCylinders->pluck('id') }},
                  get allSelected() { return this.selected.length === this.allIds.length && this.allIds.length > 0; },
                  toggleAll() { this.selected = this.allSelected ? [] : [...this.allIds]; }
              }">
            @csrf

            <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-[11px] text-slate-400 uppercase bg-slate-50 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th class="px-6 py-4 font-semibold w-12">
                                <input type="checkbox" :checked="allSelected" @change="toggleAll" class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500 cursor-pointer">
                            </th>
                            <th class="px-6 py-4 font-semibold">Nomor Seri</th>
                            <th class="px-6 py-4 font-semibold">Tipe Gas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($atSupplierCylinders as $cyl)
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" @click="if($event.target.tagName !== 'INPUT') { const idx = selected.indexOf({{ $cyl->id }}); if(idx > -1) selected.splice(idx, 1); else selected.push({{ $cyl->id }}); }">
                            <td class="px-6 py-3">
                                <input type="checkbox" name="cylinder_ids[]" value="{{ $cyl->id }}" x-model="selected" class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500 cursor-pointer">
                            </td>
                            <td class="px-6 py-3 font-mono font-bold text-slate-700">{{ $cyl->serial_number }}</td>
                            <td class="px-6 py-3">
                                <span class="text-[10px] font-bold px-2 py-1 bg-blue-50 text-blue-600 rounded">{{ $cyl->type }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-6 py-12 text-center text-slate-400">Tidak ada tabung di pabrik saat ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-slate-100 bg-slate-50 mt-auto">
                <button type="submit" :disabled="selected.length === 0" :class="selected.length === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-emerald-600 hover:shadow-lg'" class="w-full bg-emerald-500 text-white font-bold py-3.5 rounded-xl transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Terima ke Gudang (Isi Penuh)</span>
                    <span x-show="selected.length > 0" x-text="`(${selected.length} Tabung)`" class="bg-white/20 px-2 py-0.5 rounded text-xs"></span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
