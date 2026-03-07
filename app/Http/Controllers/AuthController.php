<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\HistoryLog;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // ==========================================
    // FITUR UBAH PASSWORD
    // ==========================================

    public function editPassword()
    {
        return view('auth.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:4|confirmed', // confirmed mengharuskan ada input new_password_confirmation
        ], [
            'new_password.min' => 'Password baru minimal 4 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.'
        ]);

        $user = Auth::user();

        // Cek apakah password lama yang dimasukkan sesuai dengan di database
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah!']);
        }

        // Update password baru
        $user->update([
            'password' => bcrypt($request->new_password)
        ]);

        HistoryLog::record('AKUN', "User " . strtoupper($user->role) . " ({$user->name}) mengubah password.");

        return back()->with('success', 'Password berhasil diubah! Gunakan password baru untuk login selanjutnya.');
    }
}
