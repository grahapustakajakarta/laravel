<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publikasi;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\ActivityLogger;
use App\Services\PdfPreviewService;

class PublikasiController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = Publikasi::orderBy('created_at', 'desc');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $publikasi   = $query->paginate(15)->withQueryString();
        $kategoris   = Publikasi::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('admin.publikasi.index', compact('publikasi', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Publikasi::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        return view('admin.publikasi.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'kategori'     => 'required|string|max:100',
            'deskripsi'    => 'nullable|string',
            'cover_gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file_pdf'     => 'required|file|mimes:pdf|max:20480',
        ]);

        // Upload PDF
        $pdfFilename = time() . '_' . Str::random(8) . '.pdf';
        $pdfPath = public_path('pdf/' . $pdfFilename);
        $request->file('file_pdf')->move(public_path('pdf'), $pdfFilename);
        
        // Generate Preview PDF
        $previewFilename = 'preview_' . $pdfFilename;
        $previewPath = public_path('pdf/' . $previewFilename);
        if (PdfPreviewService::generatePreview($pdfPath, $previewPath, 10)) {
            $data['file_pdf_preview'] = $previewFilename;
        } else {
            $data['file_pdf_preview'] = null;
        }

        // Upload Cover (optional)
        $coverFilename = null;
        if ($request->hasFile('cover_gambar')) {
            $coverFilename = time() . '_cover_' . Str::random(8) . '.' . $request->file('cover_gambar')->getClientOriginalExtension();
            Storage::disk('public_img')->put($coverFilename, file_get_contents($request->file('cover_gambar')));
        }

        $status = $request->input('action') === 'draft' ? 'draft' : 'publish';
        $slug = Publikasi::generateSlug($request->judul);

        $p = Publikasi::create([
            'judul'            => $request->judul,
            'slug'             => $slug,
            'kategori'         => $request->kategori,
            'deskripsi'        => $request->deskripsi,
            'status'           => $status,
            'cover_gambar'     => $coverFilename,
            'file_pdf'         => $pdfFilename,
            'file_pdf_preview' => $data['file_pdf_preview'] ?? null,
        ]);

        $this->logActivity("Menambahkan publikasi \"{$p->judul}\"", 'Publikasi');

        return redirect()->route('admin.publikasi.index')->with('success', 'Publikasi berhasil ditambahkan.');
    }

    public function edit(Publikasi $publikasi)
    {
        $kategoris = Publikasi::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        return view('admin.publikasi.edit', compact('publikasi', 'kategoris'));
    }

    public function update(Request $request, Publikasi $publikasi)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'kategori'     => 'required|string|max:100',
            'deskripsi'    => 'nullable|string',
            'cover_gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file_pdf'     => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $status = $request->input('action') === 'draft' ? 'draft' : 'publish';

        $data = [
            'judul'     => $request->judul,
            'kategori'  => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'status'    => $status,
        ];

        // Ganti PDF jika ada upload baru
        if ($request->hasFile('file_pdf')) {
            if (Storage::disk('public_pdf')->exists($publikasi->file_pdf)) {
                Storage::disk('public_pdf')->delete($publikasi->file_pdf);
            }
            if ($publikasi->file_pdf_preview && Storage::disk('public_pdf')->exists($publikasi->file_pdf_preview)) {
                Storage::disk('public_pdf')->delete($publikasi->file_pdf_preview);
            }
            
            $pdfFilename = time() . '_' . Str::random(8) . '.pdf';
            $pdfPath = public_path('pdf/' . $pdfFilename);
            $request->file('file_pdf')->move(public_path('pdf'), $pdfFilename);
            $data['file_pdf'] = $pdfFilename;
            
            // Generate Preview PDF
            $previewFilename = 'preview_' . $pdfFilename;
            $previewPath = public_path('pdf/' . $previewFilename);
            if (PdfPreviewService::generatePreview($pdfPath, $previewPath, 10)) {
                $data['file_pdf_preview'] = $previewFilename;
            } else {
                $data['file_pdf_preview'] = null;
            }
        }

        // Ganti Cover jika ada upload baru
        if ($request->hasFile('cover_gambar')) {
            if ($publikasi->cover_gambar && Storage::disk('public_img')->exists($publikasi->cover_gambar)) {
                Storage::disk('public_img')->delete($publikasi->cover_gambar);
            }
            $coverFilename = time() . '_cover_' . Str::random(8) . '.' . $request->file('cover_gambar')->getClientOriginalExtension();
            Storage::disk('public_img')->put($coverFilename, file_get_contents($request->file('cover_gambar')));
            $data['cover_gambar'] = $coverFilename;
        }

        $publikasi->update($data);
        $this->logActivity("Memperbarui publikasi \"{$publikasi->judul}\"", 'Publikasi');

        return redirect()->route('admin.publikasi.index')->with('success', 'Publikasi berhasil diperbarui.');
    }

    public function destroy(Publikasi $publikasi)
    {
        // Hapus file fisik
        if (Storage::disk('public_pdf')->exists($publikasi->file_pdf)) {
            Storage::disk('public_pdf')->delete($publikasi->file_pdf);
        }
        if ($publikasi->file_pdf_preview && Storage::disk('public_pdf')->exists($publikasi->file_pdf_preview)) {
            Storage::disk('public_pdf')->delete($publikasi->file_pdf_preview);
        }
        
        if ($publikasi->cover_gambar && Storage::disk('public_img')->exists($publikasi->cover_gambar)) {
            Storage::disk('public_img')->delete($publikasi->cover_gambar);
        }

        $judul = $publikasi->judul;
        $publikasi->delete();
        $this->logActivity("Menghapus publikasi \"{$judul}\"", 'Publikasi');

        return redirect()->route('admin.publikasi.index')->with('success', 'Publikasi berhasil dihapus.');
    }
}
