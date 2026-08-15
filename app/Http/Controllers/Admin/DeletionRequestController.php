<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeletionRequest;
use App\Models\Artikel;
use App\Models\GambarArtikel;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeletionRequestController extends Controller
{
    public function index()
    {
        $requests = DeletionRequest::with(['pengguna', 'artikel'])->orderBy('created_at', 'desc')->get();
        return view('admin.deletion_requests.index', compact('requests'));
    }

    public function approve($id)
    {
        $req = DeletionRequest::findOrFail($id);
        
        if ($req->type === 'single' && $req->artikel_id) {
            $artikel = Artikel::with('gambar')->find($req->artikel_id);
            if ($artikel) {
                foreach($artikel->gambar as $gambar) {
                    if (Storage::disk('public_img')->exists($gambar->file_gambar) && $gambar->file_gambar !== 'default.jpg') {
                        Storage::disk('public_img')->delete($gambar->file_gambar);
                    }
                    $gambar->delete();
                }
                $artikel->delete();
            }
        } elseif ($req->type === 'all') {
            $artikels = Artikel::with('gambar')->get();
            foreach ($artikels as $artikel) {
                foreach($artikel->gambar as $gambar) {
                    if (Storage::disk('public_img')->exists($gambar->file_gambar) && $gambar->file_gambar !== 'default.jpg') {
                        Storage::disk('public_img')->delete($gambar->file_gambar);
                    }
                    $gambar->delete();
                }
                $artikel->delete();
            }
        }

        $req->update(['status' => 'approved']);

        LogAktivitas::create([
            'pengguna_id' => auth()->id(),
            'aksi' => 'Menyetujui Permintaan Hapus',
            'modul' => 'Persetujuan Hapus (' . $req->pengguna->nama . ')',
            'ip_address' => request()->ip()
        ]);

        return redirect()->route('admin.deletion_requests.index')->with('success', 'Permintaan penghapusan disetujui dan dieksekusi.');
    }

    public function reject($id)
    {
        $req = DeletionRequest::findOrFail($id);
        $req->update(['status' => 'rejected']);

        LogAktivitas::create([
            'pengguna_id' => auth()->id(),
            'aksi' => 'Menolak Permintaan Hapus',
            'modul' => 'Persetujuan Hapus (' . $req->pengguna->nama . ')',
            'ip_address' => request()->ip()
        ]);

        return redirect()->route('admin.deletion_requests.index')->with('success', 'Permintaan penghapusan ditolak.');
    }
}
