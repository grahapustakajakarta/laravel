<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penulis;
use Illuminate\Http\Request;

class PenulisController extends Controller
{
    public function index()
    {
        $penulis = Penulis::orderBy('nama', 'asc')->get();
        return view('admin.penulis.index', compact('penulis'));
    }

    public function create()
    {
        return view('admin.penulis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:penulis,nama',
            'biografi' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $biografi = $request->biografi;
        if ($request->filled('biografi')) {
            $words = preg_split('/\s+/', trim($biografi));
            if (count($words) > 35) {
                $biografi = implode(' ', array_slice($words, 0, 35));
            }
        }

        $data = [
            'nama' => $request->nama,
            'biografi' => $biografi
        ];

        if ($request->hasFile('foto_profil')) {
            try {
                $file = $request->file('foto_profil');
                $filename = time() . '_penulis_' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
                // Pastikan folder penulis ada di storage/app/public
                if (!\Illuminate\Support\Facades\Storage::disk('public')->exists('penulis')) {
                    \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('penulis');
                }
                \Illuminate\Support\Facades\Storage::disk('public')->putFileAs('penulis', $file, $filename);
                $data['foto_profil'] = $filename;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal upload foto penulis: ' . $e->getMessage());
                // Lanjut simpan tanpa foto jika upload gagal
            }
        }

        Penulis::create($data);

        return redirect()->route('admin.penulis.index')->with('success', 'Penulis berhasil ditambahkan.');
    }

    public function edit(Penulis $penuli) // The route parameter is typically singular, but laravel pluralizes 'penulis' as 'penuli' unless explicitly defined. Let's use standard $penulis. Wait, Route::resource('penulis') -> parameter is 'penuli'.
    {
        return view('admin.penulis.edit', ['penulis' => $penuli]);
    }

    public function update(Request $request, Penulis $penuli)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:penulis,nama,' . $penuli->id,
            'biografi' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $biografi = $request->biografi;
        if ($request->filled('biografi')) {
            $words = preg_split('/\s+/', trim($biografi));
            if (count($words) > 35) {
                $biografi = implode(' ', array_slice($words, 0, 35));
            }
        }

        $data = [
            'nama' => $request->nama,
            'biografi' => $biografi
        ];

        if ($request->hasFile('foto_profil')) {
            try {
                // Hapus foto lama jika ada
                if ($penuli->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists('penulis/' . $penuli->foto_profil)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete('penulis/' . $penuli->foto_profil);
                }

                $file = $request->file('foto_profil');
                $filename = time() . '_penulis_' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
                // Pastikan folder ada
                if (!\Illuminate\Support\Facades\Storage::disk('public')->exists('penulis')) {
                    \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('penulis');
                }
                \Illuminate\Support\Facades\Storage::disk('public')->putFileAs('penulis', $file, $filename);
                $data['foto_profil'] = $filename;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal update foto penulis: ' . $e->getMessage());
                // Lanjut update data lain tanpa ganti foto
            }
        }

        $penuli->update($data);

        return redirect()->route('admin.penulis.index')->with('success', 'Data Penulis berhasil diperbarui.');
    }

    public function destroy(Penulis $penuli)
    {
        try {
            $penuli->delete();
            return redirect()->route('admin.penulis.index')->with('success', 'Data Penulis berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.penulis.index')->with('error', 'Penulis tidak dapat dihapus karena masih terhubung dengan artikel.');
        }
    }
}
