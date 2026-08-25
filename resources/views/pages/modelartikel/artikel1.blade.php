@extends('layouts.app')

@push('meta')
    <meta property="og:title" content="{{ $artikel->judul }}" />
    <meta property="og:description" content="{{ $artikel->sinopsis ?? Str::limit(strip_tags($artikel->konten), 150) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    @php
        $ogImage = '';
        if(isset($artikel) && $artikel->gambar->first()) {
            $rawFile = $artikel->gambar->first()->file_gambar;
            $ogImage = Str::startsWith($rawFile, 'http') ? $rawFile : asset('img/'.$rawFile);
        }
    @endphp
    <meta property="og:image" content="{{ $ogImage }}" />
    <meta property="og:type" content="article" />
@endpush

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
<style>
    /* ===== NORMALISASI GAMBAR & TEKS — artikel1 (scoped) ===== */

    /* Paksa teks konten artikel selalu terbaca (hitam) */
    #artikel1 {
        color: #1a1a1a;
        background-color: #ffffff;
    }
    #artikel1 .paragraf,
    #artikel1 .paragraf h3,
    #artikel1 .paragraf h6 {
        color: #1a1a1a;
    }

    /* Tipografi Teks Artikel (Enak Dibaca) */
    #artikel1 .paragraf p,
    #artikel1 .paragraf p span,
    #artikel1 .paragraf p a {
        font-family: 'EB Garamond', 'Garamond', Georgia, serif !important;
        font-size: 19px !important;
        line-height: 1.65 !important;
        color: #1a1a1a !important;
    }
    #artikel1 .paragraf p {
        margin-bottom: 10px !important;
        text-align: left !important;
    }
    
    #artikel1 .waktu {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        padding: 10px 0;
        margin: 10px 0 20px 0 !important;
    }
    
    #artikel1 .category {
        text-transform: uppercase;
        font-family: var(--font-sans), 'Arial', sans-serif;
        font-size: 11px;
        font-weight: bold;
        letter-spacing: 1px;
        color: #666;
    }
    
    #artikel1 .date {
        text-transform: uppercase;
        font-family: var(--font-sans), 'Arial', sans-serif;
        font-size: 11px;
        font-weight: bold;
        letter-spacing: 1px;
        color: #666;
        padding-left : 15px;
    }
    
    #artikel1 .penulis {
        text-transform: uppercase;
        font-family: var(--font-sans), 'Arial', sans-serif;
        font-size: 11px;
        letter-spacing: 1px;
        color: #b70d0f;
    }
    #artikel1 .penulis span {
        color: #b70d0f;
        font-weight: 900;
    }

    /* Hover rubrik — penanda bisa diklik */
    #artikel1 .category a {
        cursor: pointer;
        transition: color 0.2s ease, letter-spacing 0.2s ease;
    }
    #artikel1 .category a:hover {
        color: #b70d0f !important;
        letter-spacing: 2px;
        text-decoration: underline;
        text-underline-offset: 3px;
    }
    
    /* Gambar slider readmore */
    .readmore-section {
        position: relative;
        margin-top: 20px; /* Diperkecil agar lebih mepet ke atas */
        padding: 35px 0 0 0;
        background: #fff;
        border-top: 1px solid #000;
    }
    .readmore-section .container {
        padding: 0 5%; /* Memberi jarak dari tepi layar */
        max-width: 100%;
    }
    .readmore-layout {
        display: flex;
        gap: 30px;
        align-items: center;
    }
    .readmore-sidebar {
        flex: 0 0 250px; /* Lebar tetap untuk teks di kiri */
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-right: 1px solid #f0f0f0;
        padding-right: 20px;
    }
    .readmore-section .section-title {
        font-family: var(--font-sans), 'Arial', sans-serif;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #000;
        margin: 0 0 20px 0;
        white-space: normal;
        word-wrap: break-word;
        line-height: 1.4;
    }
    .readmore-nav {
        display: flex;
        gap: 10px;
        flex-shrink: 0;
        position: relative;
        z-index: 10;
    }
    .readmore-btn {
        background: #f0f0f0;
        color: #000;
        border: none;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        outline: none;
    }
    .readmore-btn:hover {
        background: #b70d0f;
        color: #fff;
    }
    .readmore-content {
        flex: 1;
        min-width: 0; /* Penting agar flex child bisa mengecil */
        overflow: hidden;
    }
    .readmore-track {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        scrollbar-width: none;
        -ms-overflow-style: none;
        width: 100%;
        gap: 20px;
        padding-bottom: 10px;
    }
    .readmore-track::-webkit-scrollbar {
        display: none;
    }
    .readmore-card {
        flex: 0 0 calc(25% - 15px); /* 4 items in view */
        scroll-snap-align: start;
    }
    .readmore-card a {
        display: block;
        text-decoration: none;
        color: #1a1a1a;
        background: transparent;
        transition: opacity 0.3s;
    }
    .readmore-card a:hover {
        opacity: 0.7;
    }
    .readmore-card img {
        width: 100%;
        aspect-ratio: 4/3; /* proporsional, tidak terlalu pendek */
        object-fit: cover;
        display: block;
        margin-bottom: 15px;
        border-radius: 4px;
    }
    .readmore-card h3 {
        font-family: var(--font-serif), 'Georgia', serif;
        font-size: 16px;
        font-weight: bold;
        margin: 0 0 8px 0;
        line-height: 1.4;
        color: #000;
    }
    .readmore-card .penulis {
        font-family: var(--font-sans), 'Arial', sans-serif;
        font-size: 11px;
        text-transform: uppercase;
        color: #666;
    }
    .readmore-card .penulis span {
        color: #b70d0f;
        font-weight: bold;
    }
    @media (max-width: 768px) {
        .readmore-layout {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
            width: 100%;
        }
        .readmore-sidebar {
            flex: 0 0 auto;
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #eee;
            padding-right: 0;
            padding-bottom: 20px;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        .readmore-content { width: 100%; max-width: 100%; }
        .readmore-section .section-title { margin: 0; }
        .readmore-card { flex: 0 0 calc(50% - 10px) !important; max-width: calc(50% - 10px) !important; width: calc(50% - 10px) !important; }
    }
    @media (max-width: 480px) {
        .readmore-card { flex: 0 0 calc(50% - 10px) !important; max-width: calc(50% - 10px) !important; width: calc(50% - 10px) !important; }
        .readmore-card h3 { font-size: 13px; margin-bottom: 6px; line-height: 1.35; }
        .readmore-card .penulis { font-size: 9px; }
        .readmore-card img { margin-bottom: 10px; border-radius: 0; width: 100% !important; aspect-ratio: 4/3 !important; object-fit: cover !important; }
    }
    #artikel1 .head {
        position: relative;
        z-index: 1000; /* Ensure header elements stay above content paragraph */
    }
    #artikel1 .head .img {
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        min-height: 420px;
    }

    /* Gambar inline di dalam body artikel */
    #artikel1 .paragraf .img {
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        min-height: 360px;
        margin: 20px 0;
    }

    /* Thumbnail Most Popular */
    #artikel1 .mostPopular .content .img {
        width: 70px !important;
        height: 70px !important;
        min-height: unset;
        background-size: cover !important;
        background-position: center !important;
        flex-shrink: 0;
    }

    /* Image Caption (mengikuti style bio penulis) */
    #artikel1 .img-caption {
        font-family: var(--font-sans), 'Arial', sans-serif !important;
        font-size: 14px;
        font-weight: 300 !important; /* Tipis */
        line-height: 1.6;
        color: #777 !important; /* Agak pudar */
        margin: 10px 0 15px 0 !important; /* Margin atas dan bawah agar ada ruang (tidak terlalu nempel) */
        padding-left: 15px !important; /* Pake padding untuk jarak kiri agar box tetap 100% */
        border-left: 3px solid #b70d0f !important; /* Garis aksen merah di kiri */
        text-transform: none;
        letter-spacing: 0;
        text-align: left !important;
        display: block !important;
        width: 100% !important; /* Paksa lebar penuh agar text-align left berfungsi */
        box-sizing: border-box !important;
    }
    #artikel1 .img-caption i {
        margin-right: 5px;
    }

    #artikel1 .mostPopular .content .tipe {
        color: #b70d0f !important;
        font-family: var(--font-sans), 'Arial', sans-serif !important;
        font-size: 14px !important;
        margin: 0 0 5px 0 !important;
        font-weight: normal;
    }

    #artikel1 .mostPopular .content {
        padding-bottom: 20px !important; /* Jarak antara teks/gambar dengan garis batas bawah */
    }

    /* Font Most Popular disamakan dengan Insight model 2 */
    #artikel1 .mostPopular .content .title {
        font-family: 'Garamond', serif !important;
        font-size: 19px !important;
        font-weight: bold;
        line-height: 1.2;
        margin: 0;
    }

    /* Author Bio Section */
    #artikel1 .author-bio-section {
        margin: 50px 0 50px;
        padding-left: 0;
        max-width: 100%;
        font-family: var(--font-sans), 'Arial', sans-serif;
    }
    #artikel1 .author-bio-divider {
        border: 0;
        border-top: 1px solid #ddd;
        margin: 20px 0;
    }
    #artikel1 .author-bio-content {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    #artikel1 .author-bio-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }
    #artikel1 .author-bio-text {
        flex: 1;
    }
    #artikel1 .author-bio-name {
        font-size: 16px;
        font-weight: 800;
        letter-spacing: 2px;
        color: #000;
        margin-top: 0;
        margin-bottom: 5px;
    }
    #artikel1 .author-bio-desc {
        font-size: 14px;
        line-height: 1.6;
        color: #444;
        margin-bottom: 0;
        font-family: var(--font-sans), 'Arial', sans-serif !important;
    }

    /* Desktop Layout: Persempit artikel, lebarkan Most Popular */
    @media (min-width: 769px) {
        #artikel1 .content-container {
            display: flex !important;
            justify-content: center !important; /* Posisikan ke tengah */
            align-items: flex-start !important;
            gap: 10% !important; /* Jarak antara teks isi dan most popular diatur menjadi 7% */
        }
        #artikel1 .paragraf {
            width: 50% !important; /* Teks isi artikel dikurangi 10% dari 55% menjadi 45% */
            padding: 0 !important; /* Hapus padding agar tidak ada dead-space */
            margin: 0 !important; /* Hapus margin tersembunyi */
            display: block !important;
        }
        #artikel1 .adv {
            width: 28% !important; /* Lebar Most Popular */
            padding: 0 !important;
            margin: 280px 0 0 0 !important; /* Hanya margin atas, paksa kiri-kanan 0 */
        }
        #artikel1 .adv .mostPopular {
            width: 100% !important;
            padding: 0 !important; /* Menghapus padding aneh dari style.css */
        }
        #artikel1 .adv .mostPopular .content {
            width: 100% !important;
            justify-content: flex-start !important; /* Merapatkan gambar dan judul */
            gap: 15px !important; /* Jarak pas antara gambar dan judul */
        }
    }

    /* Share and Save Buttons */
    .action-buttons-container {
        position: relative;
        margin: 20px 0;
        padding-bottom: 20px;
        border-bottom: none;
        z-index: 999; /* Ensure container is above other elements */
    }
    .action-buttons {
        display: flex;
        gap: 15px;
        align-items: center;
    }
    .action-buttons button {
        background: transparent;
        border: 1px solid #ccc;
        padding: 8px 15px;
        border-radius: 20px;
        font-family: var(--font-sans), 'Arial', sans-serif;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        color: #1a1a1a;
    }
    .action-buttons button:hover {
        background: #f0f0f0;
    }
    
    .share-popup {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        padding: 10px;
        z-index: 9999; /* Highest z-index */
        flex-direction: column;
        gap: 10px;
        min-width: 150px;
        margin-top: 10px;
    }
    .share-popup.active {
        display: flex;
    }
    .share-popup a {
        text-decoration: none;
        color: #1a1a1a;
        font-family: var(--font-sans), 'Arial', sans-serif;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px;
        border-radius: 4px;
        transition: background 0.3s;
    }
    .share-popup a:hover {
        background: #f0f0f0;
    }

    /* Penyesuaian Mobile / Responsive */
    @media (max-width: 768px) {
        #artikel1 .container {
            padding-left: 15px !important;
            padding-right: 15px !important;
            overflow: visible !important;
        }
        #artikel1 .head {
            padding-left: 0;
            padding-right: 0;
        }
        #artikel1 .paragraf {
            padding-left: 4% !important;
            padding-right: 10% !important;
            margin: 0 auto;
            width: 100%;
            display: block !important; /* Tambahkan !important agar flex dari style.css tertimpa */
            box-sizing: border-box;
        }
        #artikel1 .lead {
            font-size: 15px !important; /* Perkecil teks sinopsis */
            line-height: 1.5 !important;
        }
        #artikel1 .title {
            font-size: 26px !important;
            line-height: 1.2 !important;
        }
        #artikel1 .paragraf p,
        #artikel1 .paragraf p span,
        #artikel1 .paragraf p a {
            font-family: 'EB Garamond', 'Garamond', Georgia, serif !important;
            font-size: 16px !important;
        }
        .action-buttons-container {
            margin: 15px 0;
            padding-bottom: 15px;
        }
    }
</style>
@endpush

@section('content')
<!-- Half Image -->
<section id="artikel1">
    <div class="container">
        <div class="head">
            @php
                $gbrPertamaUrl = Str::startsWith($artikel->gambar_pertama ?? '', 'data:image') ? $artikel->gambar_pertama : asset('img/'.$artikel->gambar_pertama);
            @endphp
            <div class="img" style="background: url('{{ $gbrPertamaUrl }}');background-size:cover; background-repeat: no-repeat; background-position: center;"></div>
            @php
                $gambar_pertama_obj = $artikel->gambar->first();
                $deskripsi_pertama = $gambar_pertama_obj ? $gambar_pertama_obj->deskripsi : '';
            @endphp
            @if($deskripsi_pertama)
                <div class="img-caption"><i class="fas fa-camera"></i> {{ $deskripsi_pertama }}</div>
            @endif
            <div class="waktu">
                <div class="category">
                    @if(isset($artikel->kategori))
                        <a href="{{ route('page.show', $artikel->kategori->slug) }}" style="text-decoration: none; color: inherit;">{{ strtoupper($artikel->kategori->nama) }}</a>
                    @else
                        POETRY
                    @endif
                </div>
                <div class="date tgl">{{ strtoupper(\Carbon\Carbon::parse($artikel->tanggal_publikasi)->format('M. d, Y')) }}</div>
            </div>
            <h3 style="font-family: var(--font-serif), 'Georgia', serif; font-size: 40px; font-weight: bold; line-height: 1.1; margin-bottom: 20px;" class="title">{{ $artikel->judul }}</h3>
            <p style="font-family: Garamond; font-size: 19px; line-height: 1; font-style: italic;" class="lead">{{ $artikel->sinopsis }}</p>
            
            <div class="action-buttons-container">
                <div class="action-buttons">
                    <button class="btn-share" onclick="document.getElementById('sharePopup').classList.toggle('active')">
                        <i class="fas fa-share"></i> Share
                    </button>
                    <button class="btn-save" id="btnSaveArticle" onclick="saveArticle({{ $artikel->id }})">
                        @php
                            $isSaved = false;
                            if(Auth::guard('pengguna')->check()) {
                                $isSaved = \App\Models\PenggunaSimpanArtikel::where('pengguna_id', Auth::guard('pengguna')->id())
                                    ->where('artikel_id', $artikel->id)->exists();
                            }
                        @endphp
                        <i class="{{ $isSaved ? 'fas' : 'far' }} fa-bookmark"></i> <span id="saveText">{{ $isSaved ? 'Saved' : 'Save' }}</span>
                    </button>
                </div>
                <div class="share-popup" id="sharePopup">
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($artikel->judul . ' ' . url()->current()) }}" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                    <a href="https://x.com/intent/tweet?text={{ urlencode($artikel->judul) }}&url={{ urlencode(url()->current()) }}" target="_blank"><i class="fa-brands fa-x-twitter"></i> X</a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container content-container">    
        <div class="paragraf">
            @php
                $topPhoto = null;
                $topPath = '';
                
                if (isset($artikel->penulis) && $artikel->penulis->foto_profil) {
                    $topPhoto = $artikel->penulis->foto_profil;
                    $topPath = asset('storage/penulis/' . $topPhoto);
                } else {
                    $penggunaTulisan = \App\Models\PenggunaTulisan::where('artikel_id', $artikel->id)->with('pengguna')->first();
                    if ($penggunaTulisan && $penggunaTulisan->pengguna && $penggunaTulisan->pengguna->foto_profil) {
                        $topPhoto = $penggunaTulisan->pengguna->foto_profil;
                        $topPath = asset('storage/profile/' . $topPhoto);
                    }
                }
            @endphp
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #ddd;">
                @if($topPhoto)
                    <img src="{{ $topPath }}" alt="Foto Penulis" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                @endif
                @php
                    $topName = $artikel->penulis_id ? ($artikel->penulis->nama ?? '-') : ($artikel->penulis_manual ?? '-');
                @endphp
                <h3 class="penulis" style="margin: 0; padding: 0; border: none;">By <span>{{ $topName }}</span></h3>
            </div>
            <div style="font-family: var(--font-serif); width: 100%;">
                    @php
                        $gambar_collection = $artikel->gambar;
                        
                        $konten = $artikel->konten;
                        $footnotes = [];
                        $konten = preg_replace_callback('/\[\[(.*?)\]\]/', function($matches) use (&$footnotes) {
                            $footnotes[] = $matches[1];
                            $index = count($footnotes);
                            return '<sup id="ref-'.$index.'"><a href="#fn-'.$index.'" style="text-decoration:none; color:#b70d0f; font-weight:bold;">['.$index.']</a></sup>';
                        }, $konten);
                        $has_p_tags = preg_match('/<p\b[^>]*>/i', $konten);
                        
                        if ($has_p_tags) {
                            $parts = preg_split('#</p>\s*#i', $konten);
                            $paragraf_array = [];
                            foreach($parts as $part) {
                                $trimmed = trim($part);
                                if ($trimmed !== '') {
                                    // Keep all paragraphs, even empty ones like <p><br> or <p>&nbsp;
                                    // to preserve intentional enters from the admin
                                    $paragraf_array[] = $trimmed . '</p>';
                                }
                            }
                        } else {
                            $raw_parts = explode("\n", $konten);
                            $paragraf_array = [];
                            foreach($raw_parts as $p) {
                                $trimmed = trim($p);
                                if ($trimmed !== '') {
                                    $paragraf_array[] = '<p>' . nl2br($trimmed) . '</p>';
                                } else {
                                    // Preserve empty lines as empty paragraphs for spacing
                                    $paragraf_array[] = '<p><br></p>';
                                }
                            }
                        }

                        $total_gambar = $gambar_collection->count();
                        $gambar_index = 1;
                        $paragraf_counter = 0;
                    @endphp

                    @foreach ($paragraf_array as $paragraf)
                        {!! $paragraf !!}
                        @php $paragraf_counter++; @endphp

                            @if ($paragraf_counter % 3 == 0 && $gambar_index < $total_gambar)
                                @php
                                    $gambar_obj = $gambar_collection[$gambar_index];
                                    $gambar = trim($gambar_obj->file_gambar);
                                    $deskripsi = $gambar_obj->deskripsi;
                                @endphp
                                @php
                                    $gbrUrl = Str::startsWith($gambar ?? '', 'data:image') ? $gambar : asset('img/'.$gambar);
                                @endphp
                                <div class="img" style="background: url('{{ $gbrUrl }}');background-size:cover; background-repeat: no-repeat; background-position: center;"></div>
                                @if($deskripsi)
                                <div class="img-caption">
                                    <i class="fas fa-camera"></i> {{ $deskripsi }}
                                </div>
                                @endif
                                @php $gambar_index++; @endphp
                            @endif
                    @endforeach
                    
                    @if(isset($hasAccess) && !$hasAccess)
                        @include('components.paywall')
                    @endif

                    @if(count($footnotes) > 0)
                        <div class="catatan-kaki mt-5 pt-4" style="border-top: 1px solid #ddd; line-height: inherit; text-align: left;">
                            @foreach($footnotes as $idx => $fn)
                                <div id="fn-{{ $idx+1 }}" class="mb-2">
                                    <span style="color:#b70d0f; font-weight:bold;">{{ $idx+1 }}.</span> {!! nl2br(e($fn)) !!} <a href="#ref-{{ $idx+1 }}" style="text-decoration:none; color:#b70d0f; margin-left: 5px;">&#8617;</a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            @php
                $bioName = $artikel->penulis_id ? ($artikel->penulis->nama ?? 'Redaksi') : ($artikel->penulis_manual ?? 'Redaksi');
                $bioDesc = $artikel->sponsor ?? ($artikel->penulis_id ? $artikel->penulis->biografi : '');
            @endphp

            @if(!empty($bioDesc))
            <div class="author-bio-section">
                <hr class="author-bio-divider">
                <div class="author-bio-content">
                    @if(!empty($topPhoto))
                    <img src="{{ $topPath }}" alt="{{ $bioName }}" class="author-bio-img">
                    @endif
                    <div class="author-bio-text">
                        <h4 class="author-bio-name">{{ strtoupper($bioName) }}</h4>
                        <div class="author-bio-desc">{{ $bioDesc }}</div>
                    </div>
                </div>
                <hr class="author-bio-divider">
            </div>
            @endif
        </div>

        <div class="adv">
            <div class="mostPopular">
                <h3 class="judul">MOST POPULAR</h3>
                @foreach ($popular as $index => $r)
                    @if($index >= 5) @break @endif
                    @php
                        $link = ($r->rubrik && $r->rubrik->nama == 'Buku') ? url('/artikel/'.$r->slug.'?layout=artikel2') : url('/artikel/'.$r->slug);
                    @endphp
                    <a href="{{ $link }}" style="text-decoration: none; color: inherit;">
                        <div class="content">
                            <div class="img" style="background: url('{{ asset('img/'.$r->gambar_pertama) }}'); background-size: cover; background-position: center;"></div>
                            <div class="desc">
                                <h3 class="tipe" style="color: #b70d0f !important; font-family: var(--font-sans), 'Arial', sans-serif !important; font-size: 14px !important; margin: 0 0 5px 0 !important; font-weight: normal; text-transform: capitalize;">{{ $r->kategori->nama ?? $r->rubrik->nama ?? '' }}</h3>
                                <h3 class="title">{{ $r->judul }}</h3>
                                <p style="font-family: var(--font-sans), 'Arial', sans-serif; font-size: 11px; color: #888; margin: 5px 0 0 0;">{{ \Carbon\Carbon::parse($r->tanggal_publikasi)->format('d F Y') }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="readmore-section">
    <div class="container">
        <div class="readmore-layout">
            <div class="readmore-sidebar">
                <h3 class="section-title">Lebih Banyak dari<br>{{ $artikel->kategori->nama ?? 'Rubrik Ini' }}</h3>
                <div class="readmore-nav">
                    <button id="rm-prev" class="readmore-btn">&#10094;</button>
                    <button id="rm-next" class="readmore-btn">&#10095;</button>
                </div>
            </div>
            <div class="readmore-content">
                <div class="readmore-track">
                    @foreach ($relatedSlider as $rs)
                    <div class="readmore-card">
                        <a href="{{ url('/artikel/'.$rs->slug) }}">
                            <img src="{{ asset('img/'.$rs->gambar_pertama) }}" alt="{{ $rs->judul }}">
                            <h3>{{ $rs->judul }}</h3>
                            <div class="penulis">By <span>{{ $rs->penulis->nama ?? '-' }}</span></div>
                        </a>
                    </div>
                    @endforeach
                </div>

                {{-- GUARDIAN BANNER ONLY FOR PROSA --}}
                @if(strtolower($artikel->kategori->nama ?? '') === 'prosa')
                <div class="guardian-support-banner" style="background-color: #052962; color: #fff; display: flex; justify-content: space-between; align-items: center; margin-top: 30px; padding: 10px 20px; border-radius: 2px;">
                    <div class="guardian-left" style="display: flex; align-items: center; gap: 20px;">
                        <div>
                            <h4 style="font-family: var(--font-serif), 'Georgia', serif; font-size: 1.6rem; font-weight: 800; margin: 0; line-height: 1;">Support the GBJ</h4>
                            <p style="font-family: var(--font-sans), 'Arial', sans-serif; font-size: 0.9rem; margin: 5px 0 0 0; color: #fff;">Fund independent journalism</p>
                        </div>
                        <a href="#" style="background-color: #ffe500; color: #052962; font-family: var(--font-sans), 'Arial', sans-serif; font-weight: 700; font-size: 0.9rem; padding: 8px 16px; border-radius: 20px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                            Support us <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                        </a>
                    </div>
                    <div class="guardian-right" style="display: flex; align-items: center; font-family: var(--font-sans), 'Arial', sans-serif; font-weight: 700; font-size: 0.9rem;">
                        <a href="#" style="color: #fff; text-decoration: none; padding: 0 15px; border-right: 1px solid rgba(255,255,255,0.3);">Print subscriptions</a>
                        <a href="#" style="color: #fff; text-decoration: none; padding: 0 15px; border-right: 1px solid rgba(255,255,255,0.3);">Search jobs</a>
                        <a href="#" style="color: #fff; text-decoration: none; padding-left: 15px; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="far fa-user-circle" style="font-size: 1.1rem;"></i> Sign in
                        </a>
                    </div>
                </div>
                <style>
                    @media (max-width: 900px) {
                        .guardian-support-banner { flex-direction: column; align-items: flex-start !important; gap: 20px; }
                        .guardian-left { flex-direction: column; align-items: flex-start !important; }
                        .guardian-right { flex-wrap: wrap; gap: 10px; }
                        .guardian-right a { padding: 0 10px 0 0 !important; border-right: none !important; }
                    }
                </style>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const artikelArray = @json($relatedSlider);

    document.addEventListener('DOMContentLoaded', () => {
        const track = document.querySelector('.readmore-track');
        const prevBtn = document.getElementById('rm-prev');
        const nextBtn = document.getElementById('rm-next');

        if (track && prevBtn && nextBtn) {
            nextBtn.addEventListener('click', () => {
                const card = track.querySelector('.readmore-card');
                if (card) {
                    const cardWidth = card.offsetWidth + 20;
                    track.scrollBy({ left: cardWidth, behavior: 'smooth' });
                }
            });
            prevBtn.addEventListener('click', () => {
                const card = track.querySelector('.readmore-card');
                if (card) {
                    const cardWidth = card.offsetWidth + 20;
                    track.scrollBy({ left: -cardWidth, behavior: 'smooth' });
                }
            });
        }
    });

    const articleMeta = document.querySelector('.tgl');
    if (articleMeta) {
        const dateText = articleMeta.textContent;
        const date = new Date(dateText);
        if(!isNaN(date)) {
            function formatDate(date) {
                const months = [
                    "January", "February", "March", "April", "May", "June", 
                    "July", "August", "September", "October", "November", "December"
                ];
                const month = months[date.getMonth()];
                const day = date.getDate();
                const year = date.getFullYear();
                return `${month}, ${day}, ${year}`;
            }
            articleMeta.textContent = formatDate(date);
        }
    }

    // Close share popup when clicking outside
    document.addEventListener('click', function(event) {
        const shareBtn = document.querySelector('.btn-share');
        const popup = document.getElementById('sharePopup');
        if (shareBtn && popup) {
            if (!shareBtn.contains(event.target) && !popup.contains(event.target)) {
                popup.classList.remove('active');
            }
        }
    });
</script>
<script>
function saveArticle(id) {
    @if(!Auth::guard('pengguna')->check())
        window.location.href = "{{ route('user.signin') }}";
        return;
    @endif

    fetch("{{ url('/profile/simpan-artikel') }}/" + id, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        let icon = document.querySelector('#btnSaveArticle i');
        let text = document.querySelector('#saveText');
        if(data.status === 'saved') {
            icon.classList.remove('far');
            icon.classList.add('fas');
            text.textContent = 'Saved';
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            text.textContent = 'Save';
        }
    });
}
</script>
@endpush
