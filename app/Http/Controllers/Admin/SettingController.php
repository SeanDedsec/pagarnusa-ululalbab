<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    private function checkSuperAdmin()
    {
        if (Auth::user()->peran !== 'super_admin') {
            abort(403, 'Akses Ditolak. Hanya Super Admin yang dapat mengakses Pengaturan.');
        }
    }

    public function index()
    {
        $this->checkSuperAdmin();
        
        $pengguna = Pengguna::orderBy('created_at', 'desc')->get();
        
        $identitas = [
            'nama_organisasi' => Pengaturan::where('kunci', 'nama_organisasi')->first()->nilai ?? 'Pagar Nusa Ranting Mancar Ulul-Albab',
            'alamat' => Pengaturan::where('kunci', 'alamat')->first()->nilai ?? 'Desa Mancar, Kec. Peterongan, Jombang',
            'no_hp' => Pengaturan::where('kunci', 'no_hp')->first()->nilai ?? '08123456789',
        ];

        return view('admin.pages.settings', compact('pengguna', 'identitas'));
    }
    
    public function storeUser(Request $request)
    {
        $this->checkSuperAdmin();
        
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|unique:pengguna,username',
            'password' => 'required|string|min:6',
            'peran' => 'required|in:super_admin,operator',
        ]);

        Pengguna::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'peran' => $request->peran,
            'status_akun' => 'aktif',
        ]);

        return redirect()->back()->with('sukses', 'Akun pengguna berhasil ditambahkan!');
    }

    public function updateUser(Request $request, $id)
    {
        $this->checkSuperAdmin();
        
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'peran' => 'required|in:super_admin,operator',
            'status_akun' => 'required|in:aktif,nonaktif',
            'password' => 'nullable|string|min:6', // Boleh kosong jika tidak ganti password
        ]);

        $user = Pengguna::findOrFail($id);
        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'peran' => $request->peran,
            'status_akun' => $request->status_akun,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('sukses', 'Data pengguna berhasil diperbarui!');
    }

    public function destroyUser($id)
    {
        $this->checkSuperAdmin();
        
        $user = Pengguna::findOrFail($id);
        
        if ($user->id === Auth::id()) {
            return redirect()->back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri!']);
        }

        $user->delete();
        return redirect()->back()->with('sukses', 'Akun pengguna berhasil dihapus!');
    }


    public function updateIdentitas(Request $request)
    {
        $this->checkSuperAdmin();
        
        $request->validate([
            'nama_organisasi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
        ]);

        Pengaturan::updateOrCreate(['kunci' => 'nama_organisasi'], ['nilai' => $request->nama_organisasi]);
        Pengaturan::updateOrCreate(['kunci' => 'alamat'], ['nilai' => $request->alamat]);
        Pengaturan::updateOrCreate(['kunci' => 'no_hp'], ['nilai' => $request->no_hp]);

        return redirect()->back()->with('sukses', 'Identitas organisasi berhasil diperbarui!');
    }
}