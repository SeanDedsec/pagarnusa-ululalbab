<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter; // Tambahkan ini
use App\Models\LogAktivitas;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // 1. Cek apakah IP ini sudah diblokir
        $key = 'login.'.$request->ip();
        $maxAttempts = 3;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            $menit = ceil($seconds / 60);
            return back()->with('blocked', "IP Anda diblokir sementara karena terlalu banyak percobaan. Silakan coba lagi dalam $menit menit.")->onlyInput('username');
        }

        // 2. Proses Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            RateLimiter::clear($key); // Hapus hitungan jika berhasil login

            if (Auth::user()->status_akun !== 'aktif') {
                Auth::logout();
                return back()->withErrors(['username' => 'Akun Anda dinonaktifkan.']);
            }

            LogAktivitas::create([
                'pengguna_id' => Auth::id(),
                'aksi' => 'Login',
                'modul' => 'Autentikasi',
                'keterangan' => 'Berhasil masuk ke sistem',
            ]);

            return redirect()->intended('/admin/dashboard')->with('sukses', 'Selamat datang, ' . Auth::user()->nama_lengkap);
        }

        // 3. Jika Gagal Login, tambah hitungan rate limit (15 menit / 900 detik)
        RateLimiter::hit($key, 900); 
        $attemptsLeft = $maxAttempts - RateLimiter::attempts($key);

        if ($attemptsLeft > 0) {
            return back()->with('warning_attempt', "Username atau password salah. Sisa percobaan: $attemptsLeft. Jika gagal lagi, IP Anda akan diblokir.")->onlyInput('username');
        } else {
            return back()->with('blocked', "Login gagal 3 kali. IP Anda telah diblokir selama 15 menit.")->onlyInput('username');
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            LogAktivitas::create([
                'pengguna_id' => Auth::id(),
                'aksi' => 'Logout',
                'modul' => 'Autentikasi',
                'keterangan' => 'Keluar dari sistem',
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}