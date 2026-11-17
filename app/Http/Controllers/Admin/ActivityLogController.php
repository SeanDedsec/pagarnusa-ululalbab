<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Satpam: Hanya Super Admin
        if (Auth::user()->peran !== 'super_admin') {
            abort(403, 'Akses Ditolak. Hanya Super Admin yang dapat melihat Log Aktivitas.');
        }

        // UBAH DARI ->get() MENJADI ->paginate(10)
        $logs = LogAktivitas::with('pengguna')->orderBy('created_at', 'desc')->paginate(10); 
        
        return view('admin.pages.logs', compact('logs'));
    }
}