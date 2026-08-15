<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $pengguna = Pengguna::whereIn('role', ['superadmin', 'admin'])->orderBy('role', 'asc')->orderBy('nama', 'asc')->get();
        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function create()
    {
        return view('admin.pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'role'  => 'required|in:superadmin,admin',
            'password' => 'required|min:6'
        ]);

        $permissions = null;
        if ($request->role === 'admin') {
            $permissions = $request->permissions ?? [];
        }

        $p = Pengguna::create([
            'nama'        => $request->nama,
            'email'       => $request->email,
            'role'        => $request->role,
            'password'    => Hash::make($request->password),
            'permissions' => $permissions
        ]);

        $this->logActivity("Menambahkan akun admin \"{$p->nama}\" (role: {$p->role})", 'Admin User');

        return redirect()->route('admin.pengguna.index')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function edit(Pengguna $pengguna)
    {
        return view('admin.pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, Pengguna $pengguna)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $pengguna->id,
            'role'  => 'required|in:superadmin,admin',
            'password' => 'nullable|min:6'
        ]);

        // Jangan biarkan super admin menurunkan dirinya sendiri
        if (auth()->id() === $pengguna->id && $request->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Anda tidak bisa mengubah role akun Anda sendiri.');
        }

        $permissions = null;
        if ($request->role === 'admin') {
            $permissions = $request->permissions ?? [];
        }

        $data = [
            'nama'        => $request->nama,
            'email'       => $request->email,
            'role'        => $request->role,
            'permissions' => $permissions
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);
        $this->logActivity("Mengubah data akun admin \"{$pengguna->nama}\"", 'Admin User');

        return redirect()->route('admin.pengguna.index')->with('success', 'Data Admin berhasil diperbarui.');
    }

    public function destroy(Pengguna $pengguna)
    {
        if (Pengguna::count() <= 1) {
            return redirect()->route('admin.pengguna.index')->with('error', 'Tidak dapat menghapus admin terakhir.');
        }

        if (auth()->id() === $pengguna->id) {
            return redirect()->route('admin.pengguna.index')->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        $nama = $pengguna->nama;
        $pengguna->delete();
        $this->logActivity("Menghapus akun admin \"{$nama}\"", 'Admin User');
        return redirect()->route('admin.pengguna.index')->with('success', 'Data Admin berhasil dihapus.');
    }
}
