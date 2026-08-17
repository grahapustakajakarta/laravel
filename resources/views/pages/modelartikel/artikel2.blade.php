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
    /* ===== NORMALISASI GAMBAR & TEKS — artikel2 (scoped) ===== */

    /* Paksa teks konten artikel selalu terbaca */
    #artikel2 {
        color: #1a1a1a;
        background-color: #ffffff;
    }
    #artikel2 .content,
    #artikel2 .header h1,
    #artikel2 .header h2,
    #artikel2 .header p,
    #artikel2 .author {
        color: #1a1a1a;
    }

    #artikel2 .content p,
    #artikel2 .content p span,
    #artikel2 .content p a {
        font-family: 'EB Garamond', 'Garamond', Georgia, serif !important;
        font-size: 20px !important;
        line-height: 1.7 !important;
        color: #1a1a1a !important;
    }
    #artikel2 .content p {
        margin-bottom: 10px !important;
        text-align: left !important;
    }

    #artikel2 .category-date-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        padding: 25px 0;
        margin: 0 0 30px 0;
    }
    #artikel2 .category, #artikel2 .date {
        text-transform: uppercase;
        font-family: var(--font-sans), 'Arial', sans-serif;
        font-size: 11px;
        font-weight: bold;
        letter-spacing: 1px;
        color: #666;
    }

    /* Hover rubrik — penanda bisa diklik */
    #artikel2 .category a {
        cursor: pointer;
        transition: color 0.2s ease, letter-spacing 0.2s ease;
    }
    #artikel2 .category a:hover {
        color: #b70d0f !important;
        letter-spacing: 2px;
        text-decoration: underline;
        text-underline-offset: 3px;
    }
    #artikel2 .header h1 {
        font-family: var(--font-serif), 'Georgia', serif;
        font-size: 40px;
        font-weight: bold;
        line-height: 1.1;
        margin-bottom: 25px;
        padding-bottom: 25px;
        position: relative;
    }
    /* Judul & sinopsis: rata kiri (desktop) */
    #artikel2 .header h1 {
        padding-bottom: 0 !important;
        position: static !important;
        text-align: left;
    }
    #artikel2 .header h1::after {
        content: none !important;
    }
    /* Garis merah: di kiri, lurus dengan tepi judul dan sinopsis */
    #artikel2 .title-divider {
        display: block;
        width: 60px;
        height: 4px;
        background-color: #b70d0f;
        margin: 18px 0;      /* kiri: 0 → lurus dengan tepi teks */
    }
    #artikel2 .header p {
        font-family: Garamond, serif;
        font-size: 19px;
        line-height: 1;
        font-style: italic;
        color: #333;
        margin-top: 0;
        margin-bottom: 30px;
        text-align: left;    /* rata kiri di desktop */
    }

    /* Tanggal di bawah gambar — hanya sebagai referensi class */
    #artikel2 .image-date {
        font-family: var(--font-sans), 'Arial', sans-serif;
        font-size: 11px;
        font-weight: bold;
        letter-spacing: 1px;
        color: #666;
        text-transform: uppercase;
        margin: 10px 0 5px 0;
    }

    /* Share & Save buttons — sama dengan artikel1 */
    #artikel2 .action-buttons-container {
        position: relative;
        margin: 15px 0 25px 0;
        padding-bottom: 20px;
        border-bottom: none;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    #artikel2 .action-buttons {
        display: flex;
        gap: 15px;
        align-items: center;
        justify-content: center;
    }
    #artikel2 .action-buttons button {
        background: transparent;
        border: 1px solid #ccc;
        padding: 8px 18px;
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
    #artikel2 .action-buttons button:hover {
        background: #f0f0f0;
    }
    #artikel2 .share-popup2 {
        display: none;
        position: absolute;
        top: 50px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        padding: 10px;
        z-index: 100;
        flex-direction: column;
        gap: 10px;
        min-width: 160px;
    }
    #artikel2 .share-popup2.active {
        display: flex;
    }
    #artikel2 .share-popup2 a {
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
    #artikel2 .share-popup2 a:hover {
        background: #f0f0f0;
    }
    
    /* Author Bio Section */
    #artikel2 .author-bio-section {
        margin: 50px 0 50px;
        padding-left: 0;
        max-width: 100%;
        font-family: var(--font-sans), 'Arial', sans-serif;
    }
    #artikel2 .author-bio-divider {
        border: 0;
        border-top: 1px solid #ddd;
        margin: 20px 0;
    }
    #artikel2 .author-bio-content {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    #artikel2 .author-bio-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }
    #artikel2 .author-bio-text {
        flex: 1;
    }
    #artikel2 .author-bio-name {
        font-size: 16px;
        font-weight: 800;
        letter-spacing: 2px;
        color: #000;
        margin-top: 0;
        margin-bottom: 5px;
    }
    #artikel2 .author-bio-desc {
        font-size: 14px;
        line-height: 1.6;
        color: #444;
        margin-bottom: 0;
    }
    
    /* Mencegah drop cap global dari app.css/style.css dengan cara mengganti p menjadi div di HTML-nya */
    
    .readmore-section {
        position: relative;
        margin-top: 20px; /* Diperkecil agar lebih mepet ke atas */
        padding: 40px 0;
        background: #fff;
        border-top: 2px solid #000;
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
        border-right: 2px solid #f0f0f0;
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
    
    #artikel2 .author {
        text-transform: uppercase;
        font-family: var(--font-sans), 'Arial', sans-serif;
        font-size: 11px;
        letter-spacing: 1px;
        color: #555;
        margin-bottom: 20px;
    }
    #artikel2 .author strong {
        color: #000;
        font-weight: 900;
    }
    #artikel2 .related-articles a {
        color: #1a1a1a;
    }
    #artikel2 .related-articles a:hover {
        color: #b70d0f;
    }

    /* Gambar utama artikel */
    #artikel2 .image-wrapper .image {
        width: 100% !important; /* Gambar dikembalikan penuh */
        height: 800px;
        max-height: 800px;
        object-fit: cover;
        object-position: center;
        display: block;
        margin: 0 auto !important;
    }
    #artikel2 .image-wrapper .image-caption, #artikel2 .image-caption {
        font-family: var(--font-serif), 'Georgia', serif !important;
        width: 100% !important;
        margin: 15px 0 20px 0 !important; /* Lurus dengan tepi gambar */
        font-size: 11px !important;
        color: #888 !important;
        text-transform: none !important;
        letter-spacing: 0 !important;
        text-align: left !important;
        display: block !important;
    }
    #artikel2 .image-caption i {
        margin-right: 5px;
    }
    
    /* Pelurusan Judul dan Header dengan Gambar */
    #artikel2 .header {
        width: 100% !important; /* Sejajar dengan gambar di sebelah kiri */
        margin: 0 auto !important;
        padding-left: 0 !important; 
        padding-right: 0 !important;
    }
    #artikel2 .header h1 {
        max-width: 70% !important; /* Teks dibatasi 80% agar turun baris (enter) otomatis */
    }
    #artikel2 .header p {
        max-width: 60% !important; /* Teks dibatasi 80% agar turun baris (enter) otomatis */
    }

    /* Override Khusus Desktop (Laptop) */
    @media (min-width: 769px) {
        #artikel2 .content-wrapper {
            width: 85% !important; /* Lebarkan keseluruhan ruang content-wrapper */
        }
        #artikel2 .related-articles {
            flex: 1.5 !important; /* Beri porsi lebih lebar untuk bagian Insight */
            margin-right: 30px !important; /* Kurangi jarak kosong yang berlebihan */
        }
        #artikel2 .content {
            margin-left: 50px !important; /* Geser teks artikel ke kanan */
        }
    }

    /* ===== MOBILE RESPONSIVE — artikel2 ===== */
    @media (max-width: 768px) {

        /* Container: padding simetris kiri-kanan */
        #artikel2 .container {
            padding-left: 16px !important;
            padding-right: 16px !important;
            box-sizing: border-box !important;
            overflow-x: hidden;
        }

        /* Header: hilangkan batasan lebar agar penuh di mobile */
        #artikel2 .header {
            width: 100% !important;
        }
        #artikel2 .header h1 {
            font-size: 26px !important;
            max-width: 100% !important;
            text-align: center !important;
        }
        #artikel2 .header p {
            font-size: 15px !important;
            line-height: 1.5 !important;
            max-width: 100% !important;
            margin-bottom: 20px !important;
            text-align: center !important;
        }
        /* Garis merah: tengah di mobile */
        #artikel2 .title-divider {
            margin: 15px auto !important;
        }

        /* Category & date bar */
        #artikel2 .category-date-wrapper {
            padding: 12px 0 !important;
            margin-bottom: 16px !important;
        }

        /* Gambar utama: penuh layar */
        #artikel2 .image-wrapper .image {
            max-height: 350px !important;
        }

        /* Meta wrapper: susun vertikal, simetris, tengah */
        #artikel2 .meta-wrapper {
            flex-direction: column !important;
            align-items: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            gap: 10% !important;
        }
        #artikel2 .meta-wrapper .article-meta {
            width: 100% !important;
            text-align: center !important;
            margin-top: 0 !important;
        }

        /* Content wrapper: satu kolom, tanpa indent */
        #artikel2 .content-wrapper {
            display: block !important;
            width: 100% !important;
            padding-left: 0 !important;
            box-sizing: border-box !important;
        }

        /* Sembunyikan sidebar related articles di mobile */
        #artikel2 .related-articles {
            display: none !important;
        }

        /* Kecilkan tombol action (Share / Save) di mobile */
        #artikel2 .action-buttons button {
            padding: 6px 12px !important;
            font-size: 12px !important;
        }

        /* Kecilkan deskripsi gambar (caption) di mobile dihapus agar seragam dengan model 3 */

        /* Konten artikel: full-width, tanpa margin asimetris dari responsive.css lama, diberi jarak 10% di hp */
        #artikel2 .content {
            width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-left: 4% !important;
            padding-right: 10% !important;
            box-sizing: border-box !important;
        }
        #artikel2 .content p,
        #artikel2 .content p span,
        #artikel2 .content p a {
            font-family: 'EB Garamond', 'Garamond', Georgia, serif !important;
            width: 100% !important;
            font-size: 16px !important;
        }
        #artikel2 .content .author {
            width: 100% !important;
            margin-top: 16px !important;
            margin-bottom: 12px !important;
        }
    }
</style>
@endpush

@section('content')
<!-- Half Image -->
<section id="artikel2">
    <div class="container">
        <div class="header">
            <div class="category-date-wrapper">
                <div class="category">
                    @if(isset($artikel->kategori))
                        <a href="{{ route('page.show', $artikel->kategori->slug) }}" style="text-decoration: none; color: inherit;">{{ strtoupper($artikel->kategori->nama) }}</a>
                    @else
                        POETRY
                    @endif
                </div>
                <div class="date tgl">{{ strtoupper(\Carbon\Carbon::parse($artikel->tanggal_publikasi)->format('M. d, Y')) }}</div>
            </div>
            <h1>{{ $artikel->judul }}</h1>
            <span class="title-divider"></span>
            <p>{{ $artikel->sinopsis }}</p>
        </div>
        <div class="image-wrapper">
            @php
                $gbrPertamaUrl = Str::startsWith($artikel->gambar_pertama ?? '', 'data:image') ? $artikel->gambar_pertama : asset('img/'.$artikel->gambar_pertama);
            @endphp
            <img src="{{ $gbrPertamaUrl }}" alt="Image" class="image">
            @php
                $gambar_pertama_obj = $artikel->gambar->first();
                $deskripsi_pertama = $gambar_pertama_obj ? $gambar_pertama_obj->deskripsi : '';
            @endphp
            @if($deskripsi_pertama)
            <div class="image-caption">
                <i class="fas fa-camera"></i> {{ $deskripsi_pertama }}
            </div>
            @endif
        </div>
        <div class="meta-wrapper">
            <div class="article-meta">{{ htmlspecialchars($artikel->tanggal_publikasi, ENT_QUOTES, 'UTF-8') }}</div>
            <div class="action-buttons-container">
                <div class="action-buttons">
                    <button class="btn-share2" onclick="document.getElementById('sharePopup2').classList.toggle('active')">
                        <i class="fas fa-share"></i> Share
                    </button>
                    <button class="btn-save2" id="btnSaveArticle" onclick="saveArticle({{ $artikel->id }})">
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
                <div class="share-popup2" id="sharePopup2">
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($artikel->judul . ' ' . url()->current()) }}" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                    <a href="https://x.com/intent/tweet?text={{ urlencode($artikel->judul) }}&url={{ urlencode(url()->current()) }}" target="_blank"><i class="fa-brands fa-x-twitter"></i> X / Twitter</a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="related-articles">
                <h3>EDITOR'S CHOICE</h3>
                <hr class="long-line-related">
                @foreach ($relatedSlider->take(5) as $row)
                    <p style="font-family: var(--font-sans), 'Arial', sans-serif !important; font-size: 17px !important;"><a href="{{ url('/artikel/'.$row->slug) }}">{{ htmlspecialchars($row->judul, ENT_QUOTES, 'UTF-8') }}</a></p>
                    <hr class="long-line-related">
                @endforeach
            </div>
            <div class="content">
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
                    <div class="author" style="margin: 0; padding: 0; border: none; text-transform: uppercase; font-family: var(--font-sans), 'Arial', sans-serif; font-size: 11px; letter-spacing: 1px; color: #b70d0f;">By <span style="font-weight: 900; color: #b70d0f;">{{ htmlspecialchars($topName, ENT_QUOTES, 'UTF-8') }}</span></div>
                </div>
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
                            $gbrUrl = Str::startsWith($gambar ?? '', 'data:image') ? $gambar : asset('img/'.$gambar);
                        @endphp
                        <div class="image-wrapper" style="margin: 30px 0;">
                            <img src="{{ $gbrUrl }}" alt="Image" class="image"
                                 style="max-width:100%; width:auto; height:auto; display:block;">
                            @if($deskripsi)
                            <div class="image-caption" style="margin-top: 10px;">
                                <i class="fas fa-camera"></i> {{ $deskripsi }}
                            </div>
                            @endif
                        </div>
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

                @php
                    $bioPhoto = null;
                    $bioPath = '';
                    
                    if (isset($artikel->penulis) && $artikel->penulis->foto_profil) {
                        $bioPhoto = $artikel->penulis->foto_profil;
                        $bioPath = asset('storage/penulis/' . $bioPhoto);
                    } else {
                        $penggunaTulisan = \App\Models\PenggunaTulisan::where('artikel_id', $artikel->id)->with('pengguna')->first();
                        if ($penggunaTulisan && $penggunaTulisan->pengguna && $penggunaTulisan->pengguna->foto_profil) {
                            $bioPhoto = $penggunaTulisan->pengguna->foto_profil;
                            $bioPath = asset('storage/profile/' . $bioPhoto);
                        }
                    }

                    $bioName = $artikel->penulis_id ? ($artikel->penulis->nama ?? 'Redaksi') : ($artikel->penulis_manual ?? 'Redaksi');
                    $bioDesc = $artikel->sponsor ?? ($artikel->penulis_id ? $artikel->penulis->biografi : '');
                @endphp

                @if(!empty($bioDesc))
                <div class="author-bio-section">
                    <hr class="author-bio-divider">
                    <div class="author-bio-content">
                        @if(!empty($bioPhoto))
                        <img src="{{ $bioPath }}" alt="{{ $bioName }}" class="author-bio-img">
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
                    @foreach ($relatedSlider as $artikel_related)
                    <div class="readmore-card">
                        <a href="{{ url('/artikel/'.$artikel_related->slug) }}">
                            <img src="{{ asset('img/'.$artikel_related->gambar_pertama) }}" alt="{{ $artikel_related->judul }}">
                            <h3>{{ $artikel_related->judul }}</h3>
                            <div class="penulis">By <span>{{ $artikel_related->penulis->nama ?? '-' }}</span></div>
                        </a>
                    </div>
                    @endforeach
                </div>
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

    const articleMeta = document.querySelector('.article-meta');
    if (articleMeta) {
        const dateText = articleMeta.textContent;
        const date = new Date(dateText);

        if(!isNaN(date)) {
            function formatDate(date) {
                const months = [
                    "JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", 
                    "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"
                ];
                const month = months[date.getMonth()];
                const day = date.getDate();
                const year = date.getFullYear();
                let hours = date.getHours();
                const minutes = date.getMinutes().toString().padStart(2, '0');
                const ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; 

                return `${month} ${day}, ${year}, ${hours}:${minutes} ${ampm}`;
            }

            articleMeta.textContent = formatDate(date);
        }
    }

    // Close share popup when clicking outside
    document.addEventListener('click', function(event) {
        const shareBtn2 = document.querySelector('.btn-share2');
        const popup2 = document.getElementById('sharePopup2');
        if (shareBtn2 && popup2) {
            if (!shareBtn2.contains(event.target) && !popup2.contains(event.target)) {
                popup2.classList.remove('active');
            }
        }
    });

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
        .then(response => response.json())
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
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endpush
