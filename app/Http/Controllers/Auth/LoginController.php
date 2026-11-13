<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

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

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
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