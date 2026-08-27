<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Magz;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $editorsChoice = Artikel::whereHas('kategori', function($q) {
            $q->where('nama', 'Editor Choice');
        })->orderBy('id', 'desc')->limit(10)->get();

        $coffeeshophia = Artikel::whereHas('kategori', function($q) {
            $q->where('nama', 'Coffeeshophia');
        })->orderBy('id', 'desc')->limit(1)->get();

        $jakartaPlus = Artikel::whereHas('kategori', function($q) {
            $q->where('nama', 'Jakarta+');
        })->orderBy('id', 'desc')->limit(1)->get();

        $puisi = Artikel::whereHas('kategori', function($q) {
            $q->where('nama', 'Puisi');
        })->orderBy('id', 'desc')->limit(4)->get();

        $prosa = Artikel::whereHas('kategori', function($q) {
            $q->where('nama', 'Prosa');
        })->orderBy('id', 'desc')->limit(6)->get();

        $bukuTerbaru = Artikel::whereHas('kategori', function($q) {
            $q->where('nama', 'Buku');
        })->orderBy('id', 'desc')->limit(4)->get();

        $bukuLama = collect();
        if ($bukuTerbaru->isNotEmpty()) {
            $bukuTerbaruIds = $bukuTerbaru->pluck('id')->toArray();
            $bukuLama = Artikel::whereHas('kategori', function($q) {
                $q->where('nama', 'Buku');
            })->whereNotIn('id', $bukuTerbaruIds)
              ->orderBy('id', 'desc')->limit(3)->get();
        }

        $inspirasi = Artikel::whereHas('kategori', function($q) {
            $q->where('nama', 'Inspirasi');
        })->orderBy('id', 'desc')->limit(12)->get();

        $magz = Magz::orderBy('id', 'desc')->limit(2)->get();

        $pemikiran = Artikel::whereHas('kategori', function($q) {
            $q->where('nama', 'Pemikiran');
        })->orderBy('id', 'desc')->limit(12)->get();

        return view('pages.main.home', compact(
            'editorsChoice', 
            'coffeeshophia', 
            'jakartaPlus',
            'puisi',
            'prosa',
            'bukuTerbaru', 
            'bukuLama', 
            'inspirasi',
            'magz',
            'pemikiran'
        ));
    }
}
