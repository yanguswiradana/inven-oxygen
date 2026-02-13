@extends('layouts.main')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('cylinders.index') }}" class="text-slate-500 hover:text-indigo-600 text-sm flex items-center gap-1 mb-3 transition-colors font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke List
        </a>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Tabung</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <form action="{{ route('cylinders.update', $cylinder->id) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Serial Number</label>
                <input type="text" name="serial_number" value="{{ $cylinder->serial_number }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none font-mono" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Manual</label>
                <div class="relative">
                    <select name="status" class="appearance-none w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none cursor-pointer">
                        <option value="available" {{ $cylinder->status == 'available' ? 'selected' : '' }}>Available (Ready)</option>
                        <option value="rented" {{ $cylinder->status == 'rented' ? 'selected' : '' }}>Rented (Disewa)</option>
                        <option value="maintenance" {{ $cylinder->status == 'maintenance' ? 'selected' : '' }}>Maintenance (Rusak)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                <p class="text-xs text-amber-600 mt-2 font-medium">⚠️ Mengubah status secara manual tidak mencatat transaksi.</p>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end gap-3">
                <a href="{{ route('cylinders.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3 px-6 rounded-xl transition-all">Batal</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-indigo-200 hover:transform hover:-translate-y-0.5">
                    Update Tabung
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
