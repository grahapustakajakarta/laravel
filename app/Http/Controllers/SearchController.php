<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');
        $topicId = $request->input('topic');
        $region  = $request->input('region');

        $query = Artikel::query();

        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'like', '%' . $keyword . '%')
                  ->orWhere('konten', 'like', '%' . $keyword . '%');
            });
        }

        if ($topicId) {
            $query->where('kategori_id', $topicId);
        }

        if ($region) {
            $query->where(function($q) use ($region) {
                $q->where('judul', 'like', '%' . $region . '%')
                  ->orWhere('konten', 'like', '%' . $region . '%')
                  ->orWhere('tempat', 'like', '%' . $region . '%');
            });
        }

        $artikels = $query->latest()->paginate(10);
        $kategoris = \App\Models\Kategori::all();

        return view('pages.main.search', compact('artikels', 'keyword', 'kategoris', 'topicId', 'region'));
    }

    /**
     * Live search — returns JSON for the navbar search overlay.
     */
    public function live(Request $request)
    {
        $keyword = trim($request->input('q', ''));

        if (strlen($keyword) < 2) {
            return response()->json(['artikel' => [], 'pustaka' => []]);
        }

        $artikels = \App\Models\Artikel::with(['kategori', 'penulis'])
            ->where('judul', 'like', '%' . $keyword . '%')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($a) {
                return [
                    'judul'    => $a->judul,
                    'slug'     => $a->slug,
                    'gambar'   => $a->gambar_pertama ? asset('img/' . $a->gambar_pertama) : null,
                    'kategori' => optional($a->kategori)->nama ?? optional($a->rubrik)->nama ?? '',
                    'penulis'  => optional($a->penulis)->nama ?? '',
                    'url'      => url('/artikel/' . $a->slug),
                ];
            });

        $pustakas = \App\Models\Pustaka::where('judul', 'like', '%' . $keyword . '%')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($p) {
                return [
                    'judul'  => $p->judul,
                    'slug'   => $p->slug,
                    'gambar' => $p->gambar_1 ? asset('img/' . $p->gambar_1) : null,
                    'tipe'   => $p->tipe_buku ?? 'Pustaka',
                    'url'    => url('/katalog-pustaka/' . $p->slug),
                ];
            });

        return response()->json([
            'artikel' => $artikels,
            'pustaka' => $pustakas,
        ]);
    }
}
