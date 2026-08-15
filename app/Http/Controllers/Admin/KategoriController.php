<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $kategori = Kategori::orderBy('nama', 'asc')->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori,nama'
        ]);

        $k = Kategori::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama)
        ]);

        $this->logActivity("Menambahkan kategori \"{$k->nama}\"", 'Kategori');

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori,nama,' . $kategori->id
        ]);

        $old = $kategori->nama;
        $kategori->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama)
        ]);

        $this->logActivity("Mengubah kategori \"{$old}\" menjadi \"{$request->nama}\"", 'Kategori');

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        try {
            $nama = $kategori->nama;
            $kategori->delete();
            $this->logActivity("Menghapus kategori \"{$nama}\"", 'Kategori');
            return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan.');
        }
    }
}
