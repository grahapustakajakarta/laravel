<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class DataUserController extends Controller
{
    use LogsActivity;

    public function index()
    {
        // Tandai semua pengguna baru sebagai sudah dibaca
        Pengguna::where('is_read', 0)->update(['is_read' => 1]);

        // Hanya ambil pengguna biasa
        $users = Pengguna::where('role', 'user')->orderBy('created_at', 'desc')->get();
        return view('admin.datauser.index', compact('users'));
    }

    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id);

        if ($pengguna->role !== 'user') {
            return redirect()->route('admin.datauser.index')->with('error', 'Akses ditolak. Hanya bisa menghapus akun pengguna biasa.');
        }

        $nama = $pengguna->nama;
        $pengguna->delete();
        $this->logActivity("Menghapus akun pengguna \"{$nama}\"", 'User Management');
        return redirect()->route('admin.datauser.index')->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
