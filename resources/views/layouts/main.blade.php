<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>O2 Inventory System</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        /* Smooth Scroll & Custom Scrollbar */
        html { scroll-behavior: smooth; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="md:hidden flex items-center justify-between bg-white border-b border-slate-200 p-4 sticky top-0 z-30 shadow-sm">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold shadow-indigo-200 shadow-md">O2</div>
            <span class="font-bold text-slate-800 tracking-tight">Inventory</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-indigo-600 focus:outline-none p-1 rounded-md hover:bg-slate-100 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-slate-200 transform transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-auto md:h-screen md:flex md:flex-col shadow-xl md:shadow-none">

        <div class="hidden md:flex items-center gap-3 px-6 h-20 border-b border-slate-100">
            <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-indigo-300 shadow-lg">O2</div>
            <span class="font-bold text-xl text-slate-800 tracking-tight">Inventory</span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            <p class="px-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Menu Utama</p>

            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>

            <a href="{{ route('clients.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('clients.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('clients.*') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Data Client
            </a>

            <a href="{{ route('cylinders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('cylinders.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('cylinders.*') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                Data Tabung
            </a>

            <a href="{{ route('history.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('history.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('history.*') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Riwayat Transaksi
            </a>
        </nav>

        <div class="p-4 border-t border-slate-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-slate-900/50 z-30 md:hidden backdrop-blur-sm"></div>

    <main class="flex-1 min-w-0 overflow-hidden">
        <div class="h-[calc(100vh-4rem)] md:h-screen overflow-y-auto p-4 md:p-8">
            <div class="max-w-7xl mx-auto pb-12">

                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition class="mb-6 flex items-center p-4 bg-emerald-50 border border-emerald-100 rounded-xl shadow-sm text-emerald-700">
                        <div class="p-1 bg-emerald-100 rounded-full mr-3"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                        <span class="font-medium text-sm">{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-100 rounded-xl p-4 shadow-sm">
                        <div class="flex items-center mb-2 text-red-700 font-bold text-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Terjadi Kesalahan
                        </div>
                        <ul class="list-disc list-inside text-sm text-red-600 pl-2">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </main>

</body>
</html>
