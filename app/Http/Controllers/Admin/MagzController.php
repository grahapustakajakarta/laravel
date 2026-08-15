<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Magz;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MagzController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = Magz::orderBy('created_at', 'desc');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $magzs = $query->paginate(15)->withQueryString();
        $kategoris = Magz::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('admin.magz.index', compact('magzs', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Magz::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        return view('admin.magz.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'             => 'required|string|max:255',
            'edisi'             => 'nullable|string|max:100',
            'kategori'          => 'required|string|max:100',
            'penulis'           => 'nullable|string|max:255',
            'deskripsi'         => 'nullable|string',
            'isi_preview'       => 'nullable|string',
            'table_of_contents' => 'nullable|array',
            'harga'             => 'nullable|numeric|min:0',
            'cover_gambar'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file_pdf'          => 'required|file|mimes:pdf|max:20480',
        ]);

        // Upload PDF
        $pdfFilename = time() . '_' . Str::random(8) . '.pdf';
        Storage::disk('public_pdf')->put($pdfFilename, file_get_contents($request->file('file_pdf')));

        // Upload Cover (optional)
        $coverFilename = null;
        if ($request->hasFile('cover_gambar')) {
            $coverFilename = time() . '_cover_' . Str::random(8) . '.' . $request->file('cover_gambar')->getClientOriginalExtension();
            Storage::disk('public_img')->put($coverFilename, file_get_contents($request->file('cover_gambar')));
        }

        $status = $request->input('action') === 'draft' ? 'draft' : 'publish';

        $m = Magz::create([
            'judul'             => $request->judul,
            'slug'              => Magz::generateSlug($request->judul),
            'edisi'             => $request->edisi,
            'kategori'          => $request->kategori,
            'penulis'           => $request->penulis,
            'status'            => $status,
            'deskripsi'         => $request->deskripsi,
            'isi_preview'       => $request->isi_preview,
            'table_of_contents' => $request->table_of_contents,
            'harga'             => $request->harga ?: 0,
            'cover_gambar'      => $coverFilename,
            'file_pdf'          => $pdfFilename,
        ]);

        $this->logActivity("Menambahkan MAGZ \"{$m->judul}\"", 'Magz');

        return redirect()->route('admin.magz.index')->with('success', 'MAGZ berhasil ditambahkan.');
    }

    public function edit(Magz $magz)
    {
        $kategoris = Magz::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        return view('admin.magz.edit', compact('magz', 'kategoris'));
    }

    public function update(Request $request, Magz $magz)
    {
        $request->validate([
            'judul'             => 'required|string|max:255',
            'edisi'             => 'nullable|string|max:100',
            'kategori'          => 'required|string|max:100',
            'penulis'           => 'nullable|string|max:255',
            'deskripsi'         => 'nullable|string',
            'isi_preview'       => 'nullable|string',
            'table_of_contents' => 'nullable|array',
            'harga'             => 'nullable|numeric|min:0',
            'cover_gambar'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file_pdf'          => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $status = $request->input('action') === 'draft' ? 'draft' : 'publish';

        $data = [
            'judul'             => $request->judul,
            'edisi'             => $request->edisi,
            'kategori'          => $request->kategori,
            'penulis'           => $request->penulis,
            'status'            => $status,
            'deskripsi'         => $request->deskripsi,
            'isi_preview'       => $request->isi_preview,
            'table_of_contents' => $request->table_of_contents,
            'harga'             => $request->harga ?: 0,
        ];

        // Ganti PDF jika ada upload baru
        if ($request->hasFile('file_pdf')) {
            if (Storage::disk('public_pdf')->exists($magz->file_pdf)) {
                Storage::disk('public_pdf')->delete($magz->file_pdf);
            }
            $pdfFilename = time() . '_' . Str::random(8) . '.pdf';
            Storage::disk('public_pdf')->put($pdfFilename, file_get_contents($request->file('file_pdf')));
            $data['file_pdf'] = $pdfFilename;
        }

        // Ganti Cover jika ada upload baru
        if ($request->hasFile('cover_gambar')) {
            if ($magz->cover_gambar && Storage::disk('public_img')->exists($magz->cover_gambar)) {
                Storage::disk('public_img')->delete($magz->cover_gambar);
            }
            $coverFilename = time() . '_cover_' . Str::random(8) . '.' . $request->file('cover_gambar')->getClientOriginalExtension();
            Storage::disk('public_img')->put($coverFilename, file_get_contents($request->file('cover_gambar')));
            $data['cover_gambar'] = $coverFilename;
        }

        $magz->update($data);
        $this->logActivity("Memperbarui MAGZ \"{$magz->judul}\"", 'Magz');

        return redirect()->route('admin.magz.index')->with('success', 'MAGZ berhasil diperbarui.');
    }

    public function destroy(Magz $magz)
    {
        // Hapus file fisik
        if (Storage::disk('public_pdf')->exists($magz->file_pdf)) {
            Storage::disk('public_pdf')->delete($magz->file_pdf);
        }
        if ($magz->cover_gambar && Storage::disk('public_img')->exists($magz->cover_gambar)) {
            Storage::disk('public_img')->delete($magz->cover_gambar);
        }

        $judul = $magz->judul;
        $magz->delete();
        $this->logActivity("Menghapus MAGZ \"{$judul}\"", 'Magz');

        return redirect()->route('admin.magz.index')->with('success', 'MAGZ berhasil dihapus.');
    }
}
