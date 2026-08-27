<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($category)
    {
        // Halaman statis yang tidak butuh query artikel
        $staticPages = ['penerbitan', 'sponsor', 'disclaimer', 'submission', 'memikirkan', 'siapakahjkt', 'redaksi', 'advetorial'];
        if (in_array($category, $staticPages) && view()->exists('pages.info.' . $category)) {
            return view('pages.info.' . $category);
        }

        // Map category slug to exact Rubrik nama
        $mapping = [
            'buku'          => 'Buku',
            'katankota'     => 'Puisi',
            'kata-kota'     => 'Puisi',
            'puisi'         => 'Puisi',
            'fiksinpuisi'   => 'Fiksi',
            'fiksi-puisi'   => 'Fiksi',
            'fiksi'         => 'Fiksi',
            'gairah'        => 'Gairah',
            'inspirasi'     => 'Inspirasi',
            'pemikiran'     => 'Pemikiran',
            'coffeeshophia' => 'Coffeeshophia',
            'writingTips'   => 'Writing Tips',
            'writing-tips'  => 'Writing Tips',
            'thebrief'      => 'The Brief',
            'the-brief'     => 'The Brief',
            'editorschoice'  => 'Editor\'s Choice',
            'editors-choice' => 'Editor\'s Choice',
            'jktplus'       => 'Jakarta+',
            'jakarta'       => 'Jakarta+',
            'katalog'       => 'Pustaka',
            'pustaka'       => 'Pustaka',
            'sponsor'       => 'Sponsor',
            'disclaimer'    => 'Disclaimer',
            'submission'    => 'Submission',
            'prosa'         => 'Prosa',
        ];

        $rubrikNama = $mapping[$category] ?? ucfirst(str_replace('-', ' ', $category));

        // For fiksinpuisi layout (head = 4 slider, body = all remaining for JS slider)
        if (in_array($rubrikNama, ['Fiksi', 'Writing Tips', 'The Brief', 'Coffeeshophia'])) {
            $head = Artikel::whereHas('kategori', fn($q) => $q->where('nama', $rubrikNama))->orderBy('id', 'desc')->limit(4)->get();
            $body = Artikel::whereHas('kategori', fn($q) => $q->where('nama', $rubrikNama))->orderBy('id', 'desc')->skip(4)->take(100)->get();
            $footer = collect();
        } else {
            // For knkhead layout: head=1 featured, body=5 popular, footer=paginated
            $head = Artikel::whereHas('kategori', fn($q) => $q->where('nama', $rubrikNama))->orderBy('id', 'desc')->limit(1)->get();
            $body = Artikel::whereHas('kategori', fn($q) => $q->where('nama', $rubrikNama))->orderBy('id', 'desc')->skip(1)->take(5)->get();
            $footer = Artikel::whereHas('kategori', fn($q) => $q->where('nama', $rubrikNama))->orderBy('id', 'desc')->skip(6)->take(100)->get();
        }

        // Return specific shared views
        if (in_array($rubrikNama, ['Fiksi', 'Writing Tips', 'The Brief', 'Coffeeshophia'])) {
            return view('pages.category.fiksi', compact('head', 'body', 'footer', 'rubrikNama'));
        }

        $viewMap = [
            'Buku'          => 'pages.category.buku',
            'Puisi'         => 'pages.category.puisi',
            'Prosa'         => 'pages.category.prosa',
            'Jakarta+'      => 'pages.category.jktplus',
            'Pustaka'       => 'pages.pustaka.index',
            'Gairah'        => 'pages.category.gairah',
            'Pemikiran'     => 'pages.category.pemikiran',
            'Inspirasi'     => 'pages.category.inspirasi',
        ];

        if (isset($viewMap[$rubrikNama]) && view()->exists($viewMap[$rubrikNama])) {
            return view($viewMap[$rubrikNama], compact('head', 'body', 'footer', 'rubrikNama'));
        }

        return view('pages.category.default', compact('head', 'body', 'footer', 'rubrikNama'));
    }
}
