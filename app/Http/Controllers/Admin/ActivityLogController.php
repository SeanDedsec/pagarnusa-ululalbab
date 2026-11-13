<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index()
    {
        if (Auth::user()->peran !== 'super_admin') {
            abort(403, 'Akses Ditolak. Hanya Super Admin yang dapat melihat Log Aktivitas.');
        }

        $logs = LogAktivitas::with('pengguna')->orderBy('created_at', 'desc')->get();
        return view('admin.pages.logs', compact('logs'));
    }
}
