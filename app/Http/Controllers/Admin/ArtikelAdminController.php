<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Kategori;

class ArtikelAdminController extends Controller
{
    public function index($slug)
    {
        $kategori = Kategori::where('slug', $slug)->firstOrFail();
        $artikel = Artikel::with('penulis')->where('kategori_id', $kategori->id)->orderBy('id', 'desc')->paginate(10);

        return view('admin.kategori.index', compact('kategori', 'artikel'));
    }
}
