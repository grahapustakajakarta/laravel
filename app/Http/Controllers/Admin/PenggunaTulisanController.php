<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenggunaTulisan;
use App\Models\Artikel;
use App\Models\Penulis;
use Illuminate\Support\Str;

class PenggunaTulisanController extends Controller
{
    public function index()
    {
        $tulisans = PenggunaTulisan::with(['pengguna', 'kategori'])
            ->orderByRaw("FIELD(status, 'pending') DESC")
            ->latest()
            ->get();
            
        return view('admin.penggunatulisan.index', compact('tulisans'));
    }

    public function show($id)
    {
        $tulisan = PenggunaTulisan::with(['pengguna', 'kategori'])->findOrFail($id);
        return view('admin.penggunatulisan.show', compact('tulisan'));
    }

    public function preview($id)
    {
        $artikel = PenggunaTulisan::findOrFail($id);

        // We simulate the Artikel model logic by renaming/mapping fields dynamically for the view
        // The frontend views usually expect $artikel to have `artikel_gambar` relationship.
        // We will pass the `$artikel` (which is PenggunaTulisan) and a special flag.
        
        $is_preview = true;
        
        // Convert array gambar to an object mimicking `artikel_gambar` relation if needed
        // But since we can't easily mock eloquent relations without advanced tricks, we can pass it directly.
        $gambarArray = collect([]);
        $gambarPertama = null;

        if ($artikel->gambar_array) {
            $gambarData = json_decode($artikel->gambar_array, true);
            foreach($gambarData as $idx => $g) {
                $obj = (object) [
                    'file_gambar' => $g['file_gambar'],
                    'deskripsi' => $g['deskripsi'] ?? '',
                ];
                $gambarArray->push($obj);
                if ($idx === 0) $gambarPertama = $g['file_gambar'];
            }
        } elseif ($artikel->gambar) {
            $obj = (object) [
                'file_gambar' => $artikel->gambar,
                'deskripsi' => 'Cover ' . $artikel->judul,
            ];
            $gambarArray->push($obj);
            $gambarPertama = $artikel->gambar;
        }

        // Mock methods/properties used in the view
        $artikel->mocked_gambar = $gambarArray;
        $artikel->gambar = $gambarArray; // Some views call $artikel->gambar->first()
        $artikel->gambar_pertama = $gambarPertama;
        $artikel->penulis = $artikel->pengguna; // Mock relation `penulis` to `pengguna`

        // Mock popular, latest, relatedSlider so view doesn't crash
        $popular = \App\Models\Artikel::take(5)->get();
        $latest = \App\Models\Artikel::take(4)->get();
        $relatedSlider = \App\Models\Artikel::where('kategori_id', $artikel->kategori_id)
                                            ->orderByRaw('(jumlah_tayang / POW(GREATEST(TIMESTAMPDIFF(HOUR, tanggal_publikasi, NOW()), 0) + 2, 1.5)) DESC')
                                            ->limit(25)
                                            ->get();

        if ($artikel->layout === 'artikel3' || $artikel->layout === 'model3') {
            return view('pages.modelartikel.artikel3', compact('artikel', 'is_preview', 'popular', 'latest', 'relatedSlider'));
        }

        return view('pages.modelartikel.artikel2', compact('artikel', 'is_preview', 'popular', 'latest', 'relatedSlider'));
    }

    public function approve(Request $request, $id)
    {
        $tulisan = PenggunaTulisan::findOrFail($id);
        
        if ($tulisan->status != 'pending') {
            return redirect()->back()->with('error', 'Hanya tulisan pending yang bisa disetujui.');
        }

        // Tweak overrides
        if ($request->has('judul')) {
            $tulisan->judul = $request->judul;
        }
        if ($request->has('kategori_id')) {
            $tulisan->kategori_id = $request->kategori_id;
        }
        if ($request->has('tanggal_publikasi')) {
            $tulisan->tanggal_publikasi = $request->tanggal_publikasi;
        }
        if ($request->has('jenis_artikel')) {
            $tulisan->jenis_artikel = $request->jenis_artikel;
        }
        $tulisan->save();

        $pengguna = $tulisan->pengguna;

        // Cari atau buat Penulis dari Pengguna
        $penulis = Penulis::where('nama', $pengguna->nama)->first();
        if (!$penulis) {
            $penulis = Penulis::create([
                'nama' => $pengguna->nama,
                'biografi' => $pengguna->bio ?? 'Kontributor',
            ]);
        }

        // Cek apakah ini update (revisi) atau buat baru
        if ($tulisan->artikel_id && $artikel = Artikel::find($tulisan->artikel_id)) {
            // Update Artikel yang sudah ada
            $artikel->update([
                'judul' => $tulisan->judul,
                'slug' => Str::slug($tulisan->judul) . '-' . $artikel->id,
                'kategori_id' => $tulisan->kategori_id,
                'tanggal_publikasi' => $tulisan->tanggal_publikasi ?? now(),
                'sponsor' => $tulisan->sponsor,
                'sinopsis' => $tulisan->sinopsis ?? Str::limit(strip_tags($tulisan->konten), 100),
                'konten' => $tulisan->konten,
                'layout' => $tulisan->layout ?? 'artikel1',
                'jenis_artikel' => $tulisan->jenis_artikel ?? 'free',
            ]);

            // Tangani Gambar
            // Jika ada array gambar baru, hapus gambar lama (file tidak dihapus untuk histori, hanya data di DB)
            if ($tulisan->gambar_array) {
                \App\Models\GambarArtikel::where('artikel_id', $artikel->id)->delete();
                $gambarData = json_decode($tulisan->gambar_array, true);
                if(is_array($gambarData)) {
                    foreach ($gambarData as $index => $gbr) {
                        \App\Models\GambarArtikel::create([
                            'artikel_id' => $artikel->id,
                            'file_gambar' => $gbr['file_gambar'],
                            'deskripsi' => $gbr['deskripsi'],
                            'urutan' => $index
                        ]);
                    }
                }
            }
        } else {
            // Buat Artikel Baru
            $artikel = Artikel::create([
                'judul' => $tulisan->judul,
                'kategori_id' => $tulisan->kategori_id,
                'penulis_id' => $penulis->id,
                'tanggal_publikasi' => $tulisan->tanggal_publikasi ?? now(),
                'sponsor' => $tulisan->sponsor,
                'sinopsis' => $tulisan->sinopsis ?? Str::limit(strip_tags($tulisan->konten), 100),
                'konten' => $tulisan->konten,
                'layout' => $tulisan->layout ?? 'artikel1',
                'jenis_artikel' => $tulisan->jenis_artikel ?? 'free',
            ]);

            // Tangani Gambar dari Array
            if ($tulisan->gambar_array) {
                $gambarData = json_decode($tulisan->gambar_array, true);
                if(is_array($gambarData)) {
                    foreach ($gambarData as $index => $gbr) {
                        \App\Models\GambarArtikel::create([
                            'artikel_id' => $artikel->id,
                            'file_gambar' => $gbr['file_gambar'],
                            'deskripsi' => $gbr['deskripsi'],
                            'urutan' => $index
                        ]);
                    }
                }
            } elseif ($tulisan->gambar) { // Fallback untuk data lama
                \App\Models\GambarArtikel::create([
                    'artikel_id' => $artikel->id,
                    'file_gambar' => $tulisan->gambar,
                    'deskripsi' => 'Cover ' . $tulisan->judul,
                    'urutan' => 0
                ]);
            }
        }

        // Update status and save artikel_id
        $tulisan->update([
            'status' => 'disetujui',
            'artikel_id' => $artikel->id
        ]);

        return redirect()->route('admin.penggunatulisan.index')->with('success', 'Tulisan berhasil disetujui dan diterbitkan sebagai artikel.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:500'
        ]);

        $tulisan = PenggunaTulisan::findOrFail($id);
        $tulisan->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan
        ]);

        return redirect()->route('admin.penggunatulisan.index')->with('success', 'Tulisan berhasil ditolak.');
    }

    public function unpublish(Request $request, $id)
    {
        $tulisan = PenggunaTulisan::findOrFail($id);
        
        if ($tulisan->status === 'disetujui') {
            // Soft delete the related article if it exists
            if ($tulisan->artikel_id) {
                $artikel = Artikel::find($tulisan->artikel_id);
                if ($artikel) {
                    $artikel->delete();
                }
            }

            // Reset submission status
            $tulisan->update([
                'status' => 'pending',
                'artikel_id' => null,
                'alasan_penolakan' => $request->alasan_batal ?? null
            ]);

            return redirect()->route('admin.penggunatulisan.index')->with('success', 'Publikasi artikel berhasil dibatalkan. Tulisan kembali menjadi draft (pending).');
        }

        return redirect()->back()->with('error', 'Status tulisan tidak valid untuk tindakan ini.');
    }

    public function approveRevisi($id)
    {
        $tulisan = PenggunaTulisan::findOrFail($id);
        
        if ($tulisan->status === 'disetujui' && $tulisan->pesan_revisi) {
            // Reset submission status to pending and clear pesan_revisi
            // Note: artikel_id is NOT cleared so we know this is an edit of an existing article
            $tulisan->update([
                'status' => 'pending',
                'pesan_revisi' => null,
                'alasan_penolakan' => 'Permintaan edit disetujui. Silakan lakukan perubahan yang Anda inginkan lalu kirim ulang.'
            ]);

            return redirect()->route('admin.penggunatulisan.index')->with('success', 'Permintaan edit disetujui. Artikel telah diturunkan menjadi draft agar Pengguna dapat mengeditnya. Artikel aslinya tetap tayang selama proses edit.');
        }

        return redirect()->back()->with('error', 'Status tulisan tidak valid untuk tindakan ini.');
    }

    public function rejectRevisi($id)
    {
        $tulisan = PenggunaTulisan::findOrFail($id);
        
        if ($tulisan->status === 'disetujui' && $tulisan->pesan_revisi) {
            $tulisan->update([
                'pesan_revisi' => null
            ]);

            return redirect()->route('admin.penggunatulisan.index')->with('success', 'Permintaan edit ditolak. Artikel tetap rilis.');
        }

        return redirect()->back()->with('error', 'Status tulisan tidak valid untuk tindakan ini.');
    }

    public function destroy($id)
    {
        $tulisan = PenggunaTulisan::findOrFail($id);

        // Jika tulisan sudah publish dan terkait artikel, maka hapus juga artikelnya
        if ($tulisan->artikel_id) {
            $artikel = Artikel::find($tulisan->artikel_id);
            if ($artikel) {
                $artikel->delete();
            }
        }

        // Hapus fisik gambarnya? (bisa ditambahkan logika hapus file jika mau hemat storage)

        $tulisan->delete();

        return redirect()->route('admin.penggunatulisan.index')->with('success', 'Tulisan pengguna berhasil dihapus permanen.');
    }
}
