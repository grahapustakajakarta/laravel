<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Penulis;
use App\Models\GambarArtikel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikel = Artikel::with(['kategori', 'penulis'])->orderBy('id', 'desc')->get();
        return view('admin.artikel.index', compact('artikel'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $penulis = Penulis::all();
        return view('admin.artikel.create', compact('kategori', 'penulis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'penulis_id' => 'required_without:penulis_manual|nullable|exists:penulis,id',
            'penulis_manual' => 'required_without:penulis_id|nullable|string|max:255',
            'tanggal_publikasi' => 'required|date',
            'sponsor' => 'nullable|string|max:255',
            'sinopsis' => 'nullable|string',
            'konten' => 'required|string|max:500000',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi_gambar.*' => 'nullable|string|max:255',
            'layout' => 'required|string|in:artikel1,artikel2,artikel3,artikel4',
            'jenis_artikel' => 'required|in:free,premium'
        ]);

        $status = $request->input('action') === 'draft' ? 'draft' : 'publish';

        $artikel = Artikel::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul) . '-' . time(),
            'kategori_id' => $request->kategori_id,
            'penulis_id' => $request->penulis_id,
            'penulis_manual' => $request->penulis_manual,
            'status' => $status,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'sponsor' => $request->sponsor,
            'sinopsis' => $request->sinopsis,
            'konten' => $request->konten,
            'layout' => $request->layout,
            'jenis_artikel' => $request->jenis_artikel,
        ]);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $index => $file) {
                try {
                    $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    // Pastikan folder img ada
                    $imgPath = public_path('img');
                    if (!file_exists($imgPath)) {
                        mkdir($imgPath, 0775, true);
                    }
                    Storage::disk('public_img')->put($filename, file_get_contents($file));

                    GambarArtikel::create([
                        'artikel_id' => $artikel->id,
                        'file_gambar' => $filename,
                        'deskripsi' => $request->deskripsi_gambar[$index] ?? null,
                        'urutan' => $index
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Gagal upload gambar artikel: ' . $e->getMessage());
                    // Lanjut ke gambar berikutnya
                }
            }
        }

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diterbitkan.');
    }

    public function edit($id)
    {
        $artikel = Artikel::with('gambar')->findOrFail($id);
        $kategori = Kategori::all();
        $penulis = Penulis::all();
        return view('admin.artikel.edit', compact('artikel', 'kategori', 'penulis'));
    }

    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'penulis_id' => 'required_without:penulis_manual|nullable|exists:penulis,id',
            'penulis_manual' => 'required_without:penulis_id|nullable|string|max:255',
            'tanggal_publikasi' => 'required|date',
            'sponsor' => 'nullable|string|max:255',
            'sinopsis' => 'nullable|string',
            'konten' => 'required|string',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'ganti_gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi_gambar.*' => 'nullable|string|max:255',
            'existing_deskripsi_gambar.*' => 'nullable|string|max:255',
            'layout' => 'required|string|in:artikel1,artikel2,artikel3,artikel4',
            'jenis_artikel' => 'required|in:free,premium'
        ]);

        $status = $request->input('action') === 'draft' ? 'draft' : 'publish';

        $artikel->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul) . '-' . $artikel->id,
            'kategori_id' => $request->kategori_id,
            'penulis_id' => $request->penulis_id,
            'penulis_manual' => $request->penulis_manual,
            'status' => $status,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'sponsor' => $request->sponsor,
            'sinopsis' => $request->sinopsis,
            'konten' => $request->konten,
            'layout' => $request->layout,
            'jenis_artikel' => $request->jenis_artikel,
        ]);

        // Sync back to PenggunaTulisan if this article originated from a user submission
        $penggunaTulisan = \App\Models\PenggunaTulisan::where('artikel_id', $artikel->id)->first();
        if ($penggunaTulisan) {
            $penggunaTulisan->update([
                'judul' => $request->judul,
                'kategori_id' => $request->kategori_id,
                'sinopsis' => $request->sinopsis,
                'konten' => $request->konten,
                'layout' => $request->layout,
                'jenis_artikel' => $request->jenis_artikel,
            ]);
        }

        // Logic to update existing image descriptions
        if ($request->has('existing_deskripsi_gambar')) {
            foreach ($request->existing_deskripsi_gambar as $gbr_id => $deskripsi) {
                $gbr = GambarArtikel::where('id', $gbr_id)->where('artikel_id', $artikel->id)->first();
                if ($gbr) {
                    $gbr->update(['deskripsi' => $deskripsi]);
                }
            }
        }

        // Logic to replace existing images (Ganti Gambar)
        if ($request->hasFile('ganti_gambar')) {
            foreach ($request->file('ganti_gambar') as $gbr_id => $file) {
                try {
                    $gbr = GambarArtikel::where('id', $gbr_id)->where('artikel_id', $artikel->id)->first();
                    if ($gbr) {
                        // Hapus file fisik lama
                        $oldPath = public_path('img/' . $gbr->file_gambar);
                        if (file_exists($oldPath) && !is_dir($oldPath)) {
                            unlink($oldPath);
                        }

                        $filename = time() . '_ganti_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                        $imgPath = public_path('img');
                        if (!file_exists($imgPath)) {
                            mkdir($imgPath, 0775, true);
                        }
                        Storage::disk('public_img')->put($filename, file_get_contents($file));

                        $gbr->update(['file_gambar' => $filename]);
                    }
                } catch (\Exception $e) {
                    \Log::error('Gagal ganti gambar update artikel: ' . $e->getMessage());
                }
            }
        }

        // Logic to add new images
        if ($request->hasFile('gambar')) {
            $lastOrder = $artikel->gambar()->max('urutan') ?? -1;
            
            foreach ($request->file('gambar') as $index => $file) {
                try {
                    $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    // Pastikan folder img ada
                    $imgPath = public_path('img');
                    if (!file_exists($imgPath)) {
                        mkdir($imgPath, 0775, true);
                    }
                    Storage::disk('public_img')->put($filename, file_get_contents($file));

                    GambarArtikel::create([
                        'artikel_id' => $artikel->id,
                        'file_gambar' => $filename,
                        'deskripsi' => $request->deskripsi_gambar[$index] ?? null,
                        'urutan' => $lastOrder + 1 + $index
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Gagal upload gambar update artikel: ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function livePreview(Request $request)
    {
        \Log::info('livePreview dipanggil', [
            'has_file_gambar' => $request->hasFile('gambar'),
            'all_files' => array_keys($request->allFiles())
        ]);

        $artikel = new Artikel();
        $artikel->judul = $request->input('judul', 'Judul Artikel');
        $artikel->konten = $request->input('konten', '');
        $artikel->layout = $request->input('layout', 'artikel1');
        $artikel->jenis_artikel = $request->input('jenis_artikel', 'free');
        $artikel->tanggal_publikasi = $request->tanggal_publikasi ?? now();
        $artikel->konten = $request->konten ?? '';
        $artikel->kategori_id = $request->kategori_id;
        $artikel->penulis_id = $request->penulis_id;

        $penulis_id = $request->input('penulis_id');
        if ($penulis_id) {
            $artikel->penulis = Penulis::find($penulis_id);
        } else {
            $artikel->penulis = (object)['nama' => 'Nama Penulis', 'slug' => 'nama-penulis', 'foto_profil' => null, 'biografi' => ''];
        }

        $kategori_id = $request->input('kategori_id');
        if ($kategori_id) {
            $artikel->kategori = Kategori::find($kategori_id);
        } else {
            $artikel->kategori = (object)['nama' => 'Kategori', 'slug' => 'kategori-preview'];
        }

        // Mock methods/properties used in the view
        $gambarArray = collect([]);
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $idx => $file) {
                // Konversi langsung ke Base64 (bypasses server file permission/storage symlink issues entirely)
                $base64 = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
                
                $gambarArray->push((object)[
                    'file_gambar' => $base64,
                    'deskripsi' => ''
                ]);
            }
        } else {
            // Default placeholder if no image (gray 1x1 base64)
            $gambarArray->push((object)[
                'file_gambar' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk8A8AAQoAmoQ45XUAAAAASUVORK5CYII=',
                'deskripsi' => 'Preview Image'
            ]);
        }

        $artikel->gambar = $gambarArray;
        $artikel->gambar_pertama = count($gambarArray) > 0 ? $gambarArray[0]->file_gambar : null;

        $is_preview = true;
        $popular = Artikel::take(5)->get();
        $latest = Artikel::take(4)->get();
        $relatedSlider = Artikel::where('kategori_id', $artikel->kategori_id)
                                ->orderByRaw('(jumlah_tayang / POW(GREATEST(TIMESTAMPDIFF(HOUR, tanggal_publikasi, NOW()), 0) + 2, 1.5)) DESC')
                                ->limit(25)
                                ->get();

        $viewName = 'pages.modelartikel.' . $artikel->layout;
        if (!view()->exists($viewName)) {
            $viewName = 'pages.modelartikel.artikel1';
        }

        return view($viewName, compact('artikel', 'is_preview', 'popular', 'latest', 'relatedSlider'));
    }


    public function destroyGambar($id)
    {
        $gambar = GambarArtikel::findOrFail($id);
        
        // Hapus file fisik
        if (Storage::disk('public_img')->exists($gambar->file_gambar) && $gambar->file_gambar !== 'default.jpg') {
            Storage::disk('public_img')->delete($gambar->file_gambar);
        }
        
        $gambar->delete();
        
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $artikel = Artikel::with('gambar')->findOrFail($id);
        $pengguna = auth()->user();

        if (!$pengguna->isSuperAdmin()) {
            // Cek jumlah artikel yang sudah dihapus dalam 24 jam terakhir oleh admin ini
            $recentDeletes = \App\Models\LogAktivitas::where('pengguna_id', $pengguna->id)
                                ->where('aksi', 'Menghapus Artikel')
                                ->where('created_at', '>=', now()->subHours(24))
                                ->count();

            if ($recentDeletes >= 2) {
                // Buat request hapus
                \App\Models\DeletionRequest::create([
                    'pengguna_id' => $pengguna->id,
                    'type' => 'single',
                    'artikel_id' => $artikel->id,
                    'status' => 'pending',
                ]);
                return redirect()->route('admin.artikel.index')->with('warning', 'Batas penghapusan harian tercapai. Permintaan penghapusan telah dikirim ke Super Admin.');
            }
        }

        // Hapus file fisik dari semua gambar terkait
        foreach($artikel->gambar as $gambar) {
            if (Storage::disk('public_img')->exists($gambar->file_gambar) && $gambar->file_gambar !== 'default.jpg') {
                Storage::disk('public_img')->delete($gambar->file_gambar);
            }
            $gambar->delete();
        }

        $artikel->delete();
        
        \App\Models\LogAktivitas::create([
            'pengguna_id' => auth()->id(),
            'aksi' => 'Menghapus Artikel',
            'modul' => 'Manajemen Artikel',
            'ip_address' => request()->ip()
        ]);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel beserta gambarnya berhasil dihapus.');
    }

    public function bulkDestroy(\Illuminate\Http\Request $request)
    {
        $idsString = $request->input('ids');
        if (empty($idsString)) {
            return redirect()->back()->with('error', 'Tidak ada artikel yang dipilih.');
        }

        $ids = explode(',', $idsString);
        $pengguna = auth()->user();
        $isSuperAdmin = $pengguna->isSuperAdmin();
        $deletedDirectly = 0;
        $sentToRequest = 0;

        foreach ($ids as $id) {
            $artikel = Artikel::with('gambar')->find($id);
            if (!$artikel) continue;

            if (!$isSuperAdmin) {
                // Check quota dynamically
                $recentDeletes = \App\Models\LogAktivitas::where('pengguna_id', $pengguna->id)
                                    ->where('aksi', 'Menghapus Artikel')
                                    ->where('created_at', '>=', now()->subHours(24))
                                    ->count();

                if ($recentDeletes >= 2) {
                    \App\Models\DeletionRequest::create([
                        'pengguna_id' => $pengguna->id,
                        'type' => 'single',
                        'artikel_id' => $artikel->id,
                        'status' => 'pending',
                    ]);
                    $sentToRequest++;
                    continue; // Skip actual deletion
                }
            }

            // Perform actual deletion
            foreach($artikel->gambar as $gambar) {
                if (Storage::disk('public_img')->exists($gambar->file_gambar) && $gambar->file_gambar !== 'default.jpg') {
                    Storage::disk('public_img')->delete($gambar->file_gambar);
                }
                $gambar->delete();
            }
            $artikel->delete();
            
            \App\Models\LogAktivitas::create([
                'pengguna_id' => $pengguna->id,
                'aksi' => 'Menghapus Artikel',
                'modul' => 'Manajemen Artikel',
                'ip_address' => request()->ip()
            ]);
            $deletedDirectly++;
        }

        if ($sentToRequest > 0) {
            if ($deletedDirectly > 0) {
                return redirect()->route('admin.artikel.index')->with('warning', "$deletedDirectly artikel berhasil dihapus. Sisa $sentToRequest artikel otomatis diteruskan ke Super Admin karena batas penghapusan harian (2 artikel) telah tercapai.");
            }
            return redirect()->route('admin.artikel.index')->with('warning', "Batas penghapusan harian tercapai. $sentToRequest permohonan penghapusan telah dikirim ke Super Admin.");
        }

        return redirect()->route('admin.artikel.index')->with('success', "$deletedDirectly artikel terpilih beserta gambarnya berhasil dihapus.");
    }
}
