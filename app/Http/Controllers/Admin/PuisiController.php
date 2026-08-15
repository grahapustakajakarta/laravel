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

class PuisiController extends Controller
{
    private function getpuisiId()
    {
        $kategori = Kategori::where('nama', 'Puisi')->first();
        return $kategori ? $kategori->id : null;
    }

    public function index()
    {
        $puisiId = $this->getpuisiId();
        $artikel = Artikel::with(['penulis'])
            ->where('kategori_id', $puisiId)
            ->orderBy('id', 'desc')
            ->get();
            
        return view('admin.puisi.index', compact('artikel'));
    }

    public function create()
    {
        $penulis = Penulis::all();
        return view('admin.puisi.create', compact('penulis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis_id' => 'required|exists:penulis,id',
            'tanggal_publikasi' => 'required|date',
            'sponsor' => 'nullable|string|max:255',
            'sinopsis' => 'nullable|string',
            'konten' => 'required|string',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi_gambar.*' => 'nullable|string|max:255',
            'layout' => 'required|string|in:artikel1,artikel2,artikel3'
        ]);

        $puisiId = $this->getpuisiId();

        $processedKonten = e($request->konten);
        $processedKonten = preg_replace('/^#\s*(.*?)$/m', '<strong>$1</strong>', $processedKonten);
        $processedKonten = nl2br($processedKonten);

        $artikel = Artikel::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul) . '-' . time(),
            'kategori_id' => $puisiId,
            'penulis_id' => $request->penulis_id,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'sponsor' => $request->sponsor,
            'sinopsis' => $request->sinopsis,
            'konten' => $processedKonten, // Preserve newlines and bold subtitles
            'layout' => $request->layout,
        ]);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $index => $file) {
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                Storage::disk('public_img')->put($filename, file_get_contents($file));

                GambarArtikel::create([
                    'artikel_id' => $artikel->id,
                    'file_gambar' => $filename,
                    'deskripsi' => $request->deskripsi_gambar[$index] ?? null,
                    'urutan' => $index
                ]);
            }
        }

        return redirect()->route('admin.puisi.index')->with('success', 'Artikel puisi berhasil diterbitkan.');
    }

    public function edit($id)
    {
        $puisiId = $this->getpuisiId();
        $artikel = Artikel::with('gambar')->where('kategori_id', $puisiId)->findOrFail($id);
        
        // Reverse nl2br for editing in plain textarea
        $artikel->konten = str_replace('<br />', '', $artikel->konten);
        $artikel->konten = str_replace('<br>', '', $artikel->konten);
        // Reverse <strong> back to #
        $artikel->konten = preg_replace('/<strong>(.*?)<\/strong>/', '# $1', $artikel->konten);
        
        $penulis = Penulis::all();
        return view('admin.puisi.edit', compact('artikel', 'penulis'));
    }

    public function update(Request $request, $id)
    {
        $puisiId = $this->getpuisiId();
        $artikel = Artikel::where('kategori_id', $puisiId)->findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis_id' => 'required|exists:penulis,id',
            'tanggal_publikasi' => 'required|date',
            'sponsor' => 'nullable|string|max:255',
            'sinopsis' => 'nullable|string',
            'konten' => 'required|string',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi_gambar.*' => 'nullable|string|max:255',
            'existing_deskripsi_gambar.*' => 'nullable|string|max:255',
            'layout' => 'required|string|in:artikel1,artikel2,artikel3'
        ]);

        $processedKonten = e($request->konten);
        $processedKonten = preg_replace('/^#\s*(.*?)$/m', '<strong>$1</strong>', $processedKonten);
        $processedKonten = nl2br($processedKonten);

        $artikel->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul) . '-' . $artikel->id,
            'penulis_id' => $request->penulis_id,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'sponsor' => $request->sponsor,
            'sinopsis' => $request->sinopsis,
            'konten' => $processedKonten,
            'layout' => $request->layout,
        ]);

        if ($request->has('existing_deskripsi_gambar')) {
            foreach ($request->existing_deskripsi_gambar as $gbr_id => $deskripsi) {
                $gbr = GambarArtikel::where('id', $gbr_id)->where('artikel_id', $artikel->id)->first();
                if ($gbr) {
                    $gbr->update(['deskripsi' => $deskripsi]);
                }
            }
        }

        if ($request->hasFile('gambar')) {
            $lastOrder = $artikel->gambar()->max('urutan') ?? -1;
            
            foreach ($request->file('gambar') as $index => $file) {
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                Storage::disk('public_img')->put($filename, file_get_contents($file));

                GambarArtikel::create([
                    'artikel_id' => $artikel->id,
                    'file_gambar' => $filename,
                    'deskripsi' => $request->deskripsi_gambar[$index] ?? null,
                    'urutan' => $lastOrder + 1 + $index
                ]);
            }
        }

        return redirect()->route('admin.puisi.index')->with('success', 'Artikel puisi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $puisiId = $this->getpuisiId();
        $artikel = Artikel::with('gambar')->where('kategori_id', $puisiId)->findOrFail($id);
        
        foreach($artikel->gambar as $gambar) {
            if (Storage::disk('public_img')->exists($gambar->file_gambar) && $gambar->file_gambar !== 'default.jpg') {
                Storage::disk('public_img')->delete($gambar->file_gambar);
            }
            $gambar->delete();
        }

        $artikel->delete();
        return redirect()->route('admin.puisi.index')->with('success', 'Artikel puisi berhasil dihapus.');
    }
}
