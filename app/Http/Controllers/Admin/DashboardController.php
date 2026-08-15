<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index()
    {
        $totalArtikel = Artikel::count();
        $totalKategori = Kategori::count();
        $totalTayang = Artikel::sum('jumlah_tayang');

        return view('admin.dashboard', compact('totalArtikel', 'totalKategori', 'totalTayang'));
    }
}
