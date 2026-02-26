@extends('layouts.main')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('cylinders.index') }}" class="text-slate-500 hover:text-indigo-600 text-sm flex items-center gap-1 mb-2 transition-colors font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Data Tabung
            </a>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Tabung Baru</h1>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        <form action="{{ route('cylinders.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Seri Tabung</label>
                <input type="text" name="serial_number" required placeholder="Contoh: TB-001" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Gas</label>
                <div class="relative">
                    <select name="type" required class="appearance-none w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all cursor-pointer">
                        <option value="" disabled selected>-- Pilih Tipe Gas --</option>
                        <option value="O2">O2 (Oksigen)</option>
                        <option value="CO2">CO2 (Karbon Dioksida)</option>
                        <option value="N2">N2 (Nitrogen)</option>
                        <option value="AR">AR (Argon)</option>
                        <option value="C2H2">C2H2 (Acetylene)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Awal</label>
                <div class="relative">
                    <select name="status" required class="appearance-none w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all cursor-pointer">
                        <option value="available" selected>Tersedia (Ready)</option>
                        <option value="maintenance">Perbaikan (Maintenance)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-md">
                    Simpan Tabung
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
