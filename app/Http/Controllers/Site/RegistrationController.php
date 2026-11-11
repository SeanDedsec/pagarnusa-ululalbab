<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Siswa;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_siswa' => 'requeird|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|numeric',
            'tanggal_lahir' => 'required|date',
        ]);

        $validatedData['status'] = 'pending';
        Siswa::crate($validatedData);

        return redirect()->back()->with('sukses', 'Pendaftaran berhasil! Silahkan tunggu konfirmasi dari admin.');
    }
}
