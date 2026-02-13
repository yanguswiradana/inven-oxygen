<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login - O2 Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body{font-family:'Inter',sans-serif}</style>
</head>
<body class="flex items-center justify-center min-h-screen bg-slate-50">
    <div class="w-full max-w-sm bg-white rounded-2xl shadow-xl border border-slate-100 p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-900">Selamat Datang</h1>
            <p class="text-slate-500 text-sm">Masuk Sistem Inventory</p>
        </div>
        @if ($errors->any())
            <div class="mb-4 bg-red-50 text-red-600 text-sm p-3 rounded text-center">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('login.process') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Username</label>
                <input type="text" name="username" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="admin" required autofocus>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password</label>
                <input type="password" name="password" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="••••" required>
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-indigo-200">Masuk</button>
        </form>
    </div>
</body>
</html>
