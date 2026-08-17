<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pustaka;
use App\Models\Penulis;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\ActivityLogger;
use App\Services\PdfPreviewService;

class PustakaController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = Pustaka::with('penulis')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $pustaka = $query->paginate(15)->withQueryString();

        return view('admin.pustaka.index', compact('pustaka'));
    }

    public function create()
    {
        $penulis = Penulis::orderBy('nama')->get();
        return view('admin.pustaka.create', compact('penulis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tipe_buku' => 'nullable|string|max:100',
            'kategori' => 'nullable|string|max:100',
            'penulis_id' => 'required_without:penulis_manual|nullable|exists:penulis,id',
            'penulis_manual' => 'required_without:penulis_id|nullable|string|max:255',
            'harga' => 'nullable|string|max:100',
            'nomor_wa' => 'nullable|string|max:20',
            'gambar_1' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gambar_2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gambar_3' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file_pdf' => 'nullable|mimes:pdf|max:20480',
        ]);

        $data = $request->except(['_token', 'gambar_1', 'gambar_2', 'gambar_3', 'file_pdf', 'action']);
        $data['slug'] = Pustaka::generateSlug($request->judul);
        $data['is_on_tour'] = $request->has('is_on_tour');
        $data['status'] = $request->input('action') === 'draft' ? 'draft' : 'publish';

        // Handle Image Uploads
        for ($i = 1; $i <= 3; $i++) {
            $field = 'gambar_' . $i;
            if ($request->hasFile($field)) {
                $filename = time() . "_pustaka_{$i}_" . Str::random(8) . '.' . $request->file($field)->getClientOriginalExtension();
                Storage::disk('public_img')->put($filename, file_get_contents($request->file($field)));
                $data[$field] = $filename;
            }
        }

        if ($request->hasFile('file_pdf')) {
            $pdfName = time() . '_pustaka_' . Str::random(8) . '.' . $request->file('file_pdf')->getClientOriginalExtension();
            $pdfPath = public_path('pdf/pustaka/' . $pdfName);
            $request->file('file_pdf')->move(public_path('pdf/pustaka'), $pdfName);
            $data['file_pdf'] = $pdfName;
            
            // Generate Preview PDF
            $previewName = 'preview_' . $pdfName;
            $previewPath = public_path('pdf/pustaka/' . $previewName);
            if (PdfPreviewService::generatePreview($pdfPath, $previewPath, 10)) {
                $data['file_pdf_preview'] = $previewName;
            } else {
                $data['file_pdf_preview'] = null;
            }
        }

        $p = Pustaka::create($data);

        $this->logActivity("Menambahkan buku pustaka \"{$p->judul}\"", 'Pustaka');

        return redirect()->route('admin.pustaka.index')->with('success', 'Buku pustaka berhasil ditambahkan.');
    }

    public function edit(Pustaka $pustaka)
    {
        $penulis = Penulis::orderBy('nama')->get();
        return view('admin.pustaka.edit', compact('pustaka', 'penulis'));
    }

    public function update(Request $request, Pustaka $pustaka)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tipe_buku' => 'nullable|string|max:100',
            'kategori' => 'nullable|string|max:100',
            'penulis_id' => 'required_without:penulis_manual|nullable|exists:penulis,id',
            'penulis_manual' => 'required_without:penulis_id|nullable|string|max:255',
            'harga' => 'nullable|string|max:100',
            'nomor_wa' => 'nullable|string|max:20',
            'gambar_1' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gambar_2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gambar_3' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file_pdf' => 'nullable|mimes:pdf|max:20480',
        ]);

        $data = $request->except(['_token', '_method', 'gambar_1', 'gambar_2', 'gambar_3', 'file_pdf', 'action']);
        $data['is_on_tour'] = $request->has('is_on_tour');
        $data['status'] = $request->input('action') === 'draft' ? 'draft' : 'publish';

        // Handle Image Uploads
        for ($i = 1; $i <= 3; $i++) {
            $field = 'gambar_' . $i;
            if ($request->hasFile($field)) {
                // Delete old image
                if ($pustaka->$field && Storage::disk('public_img')->exists($pustaka->$field)) {
                    Storage::disk('public_img')->delete($pustaka->$field);
                }
                $filename = time() . "_pustaka_{$i}_" . Str::random(8) . '.' . $request->file($field)->getClientOriginalExtension();
                Storage::disk('public_img')->put($filename, file_get_contents($request->file($field)));
                $data[$field] = $filename;
            }
        }

        if ($request->hasFile('file_pdf')) {
            if ($pustaka->file_pdf && file_exists(public_path('pdf/pustaka/' . $pustaka->file_pdf))) {
                unlink(public_path('pdf/pustaka/' . $pustaka->file_pdf));
            }
            if ($pustaka->file_pdf_preview && file_exists(public_path('pdf/pustaka/' . $pustaka->file_pdf_preview))) {
                unlink(public_path('pdf/pustaka/' . $pustaka->file_pdf_preview));
            }
            
            $pdfName = time() . '_pustaka_' . Str::random(8) . '.' . $request->file('file_pdf')->getClientOriginalExtension();
            $pdfPath = public_path('pdf/pustaka/' . $pdfName);
            $request->file('file_pdf')->move(public_path('pdf/pustaka'), $pdfName);
            $data['file_pdf'] = $pdfName;
            
            // Generate Preview PDF
            $previewName = 'preview_' . $pdfName;
            $previewPath = public_path('pdf/pustaka/' . $previewName);
            if (PdfPreviewService::generatePreview($pdfPath, $previewPath, 10)) {
                $data['file_pdf_preview'] = $previewName;
            } else {
                $data['file_pdf_preview'] = null;
            }
        }

        $pustaka->update($data);

        $this->logActivity("Memperbarui buku pustaka \"{$pustaka->judul}\"", 'Pustaka');

        return redirect()->route('admin.pustaka.index')->with('success', 'Buku pustaka berhasil diperbarui.');
    }

    public function destroy(Pustaka $pustaka)
    {
        for ($i = 1; $i <= 3; $i++) {
            $field = 'gambar_' . $i;
            if ($pustaka->$field && Storage::disk('public_img')->exists($pustaka->$field)) {
                Storage::disk('public_img')->delete($pustaka->$field);
            }
        }

        if ($pustaka->file_pdf && file_exists(public_path('pdf/pustaka/' . $pustaka->file_pdf))) {
            unlink(public_path('pdf/pustaka/' . $pustaka->file_pdf));
        }
        if ($pustaka->file_pdf_preview && file_exists(public_path('pdf/pustaka/' . $pustaka->file_pdf_preview))) {
            unlink(public_path('pdf/pustaka/' . $pustaka->file_pdf_preview));
        }

        $judul = $pustaka->judul;
        $pustaka->delete();
        $this->logActivity("Menghapus buku pustaka \"{$judul}\"", 'Pustaka');

        return redirect()->route('admin.pustaka.index')->with('success', 'Buku pustaka berhasil dihapus.');
    }
}
