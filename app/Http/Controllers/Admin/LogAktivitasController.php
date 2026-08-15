<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        // Tandai semua log aktivitas baru sebagai sudah dibaca
        LogAktivitas::where('is_read', 0)->update(['is_read' => 1]);

        $adminId = $request->input('admin_id');

        $query = LogAktivitas::with('pengguna')->orderBy('created_at', 'desc');

        if ($adminId) {
            $query->where('pengguna_id', $adminId);
        }

        $logs = $query->paginate(25);
        $logs->appends(['admin_id' => $adminId]);

        // Ambil semua admin untuk filter dropdown
        $admins = Pengguna::whereIn('role', ['superadmin', 'admin'])->orderBy('nama')->get();

        return view('admin.log.index', compact('logs', 'admins', 'adminId'));
    }

    public function clear()
    {
        LogAktivitas::truncate();
        return redirect()->route('admin.log.index')->with('success', 'Semua log aktivitas berhasil dihapus.');
    }
}
