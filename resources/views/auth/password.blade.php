@extends('layouts.main')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Pengaturan Akun</h1>
        <p class="text-slate-500 text-sm mt-1">Ubah password untuk menjaga keamanan akun Anda.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex items-center gap-3">
            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 text-lg">Ubah Password</h2>
                <p class="text-slate-500 text-xs mt-0.5">Akun: {{ auth()->user()->name }} ({{ strtoupper(auth()->user()->role) }})</p>
            </div>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password Saat Ini</label>
                <div class="relative">
                    <input type="password" name="current_password" required placeholder="Masukkan password lama..."
                           class="w-full px-4 py-3 pl-11 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder-slate-400">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password Baru</label>
                <div class="relative">
                    <input type="password" name="new_password" required placeholder="Minimal 4 karakter..."
                           class="w-full px-4 py-3 pl-11 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:bg-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all placeholder-slate-400">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input type="password" name="new_password_confirmation" required placeholder="Ketik ulang password baru..."
                           class="w-full px-4 py-3 pl-11 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-sm focus:bg-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all placeholder-slate-400">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-md flex justify-center items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Password Baru
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
