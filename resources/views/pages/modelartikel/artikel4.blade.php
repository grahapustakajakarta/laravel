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
    /* ===== ARTIKEL MODEL 4 — Layout Dua Kolom (Gambar Kiri, Teks Kanan) ===== */

    #artikel4 {
        color: #1a1a1a;
        background-color: #ffffff;
    }

    /* ── Wrapper utama dua kolom ── */
    #artikel4 .layout-wrapper {
        display: flex;
        align-items: flex-start;
        gap: 0;
        max-width: 1100px;
        margin: 0 auto;
        padding: 0;
    }

    /* ── Kolom Kiri: Gambar ── */
    #artikel4 .col-gambar {
        flex: 0 0 35%;
        max-width: 35%;
        position: sticky;
        top: 80px;
        align-self: flex-start;
    }

    /* Wrapper gambar utama */
    #artikel4 .main-photo-wrapper {
        position: relative;
        cursor: crosshair;
    }

    /* Overlay gelap */
    #artikel4 .main-photo-wrapper::after {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.6);
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
    }
    #artikel4 .main-photo-wrapper:hover::after {
        opacity: 1;
    }

    #artikel4 .col-gambar img.main-photo {
        width: 100%;
        height: auto;
        display: block;
        box-shadow: -3px 3px 10px rgba(0,0,0,0.1), 12px 18px 35px rgba(0,0,0,0.25);
        border-radius: 3px;
    }

    /* Lingkaran lensa zoom */
    #artikel4 .zoom-overlay {
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.7);
        box-shadow: 0 4px 15px rgba(0,0,0,0.5);
        background-repeat: no-repeat;
        opacity: 0;
        pointer-events: none;
        transform: translate(-50%, -50%);
        transition: opacity 0.3s ease;
        z-index: 10;
    }
    
    #artikel4 .main-photo-wrapper:hover .zoom-overlay {
        opacity: 1;
    }

    #artikel4 .img-caption {
        font-family: var(--font-sans), 'Arial', sans-serif !important;
        font-size: 14px;
        font-weight: 300 !important;
        line-height: 1.6;
        color: #777 !important;
        margin: 10px 0 15px 0 !important;
        padding: 0;
        font-style: normal;
    }
    #artikel4 .img-caption i {
        margin-right: 5px;
    }

    /* ── Kolom Kanan: Konten ── */
    #artikel4 .col-konten {
        flex: 1;
        padding-left: 50px;
        max-width: 65%;
    }

    /* ── Header (kategori + tanggal) ── */
    #artikel4 .meta-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
    }

    #artikel4 .kategori-label {
        font-family: var(--font-sans), 'Arial', sans-serif;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.5px;
        color: #b70d0f;
        text-transform: uppercase;
        text-decoration: none;
    }

    #artikel4 .kategori-label:hover {
        text-decoration: underline;
    }

    #artikel4 .meta-dot {
        width: 3px;
        height: 3px;
        background: #aaa;
        border-radius: 50%;
    }

    #artikel4 .tanggal-label {
        font-family: var(--font-sans), 'Arial', sans-serif;
        font-size: 11px;
        color: #888;
        letter-spacing: 0.5px;
    }

    /* ── Judul ── */
    #artikel4 .judul-artikel {
        font-family: var(--font-serif), 'Georgia', serif;
        font-size: 36px;
        font-weight: bold;
        line-height: 1.15;
        color: #111;
        margin-bottom: 14px;
    }

    /* ── Sinopsis ── */
    #artikel4 .sinopsis-artikel {
        font-family: var(--font-serif), 'Georgia', serif;
        font-size: 16px;
        line-height: 1.5;
        color: #555;
        font-style: italic;
        margin-bottom: 18px;
    }

    /* ── Garis pemisah tipis ── */
    #artikel4 .divider-tipis {
        border: none;
        border-top: 1px solid #e0e0e0;
        margin: 0 0 16px 0;
    }

    /* ── Info Penulis + Share ── */
    #artikel4 .penulis-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    #artikel4 .penulis-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    #artikel4 .penulis-foto {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }

    #artikel4 .penulis-nama {
        font-family: var(--font-sans), 'Arial', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 1px;
        color: #444;
        text-transform: uppercase;
    }

    /* ── Action Buttons (Share & Save) dari Artikel 1 ── */
    #artikel4 .action-buttons-container {
        position: relative;
        display: inline-block;
    }
    #artikel4 .action-buttons {
        display: flex;
        gap: 15px;
        align-items: center;
    }
    #artikel4 .action-buttons button {
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
    #artikel4 .action-buttons button:hover {
        background: #f0f0f0;
    }

    /* ── Konten Artikel ── */
    #artikel4 .konten-artikel p,
    #artikel4 .konten-artikel p span,
    #artikel4 .konten-artikel p a {
        font-family: 'EB Garamond', 'Garamond', Georgia, serif;
        font-size: 19px !important;
        line-height: 1.65 !important;
        color: #1a1a1a !important;
    }

    #artikel4 .konten-artikel p {
        margin-bottom: 10px !important;
        text-align: left !important;
    }

    /* Dropcap hanya paragraf pertama */
    #artikel4 .konten-artikel > p:first-of-type::first-letter {
        font-size: 4.5em;
        font-weight: bold;
        float: left;
        line-height: 0.75;
        margin-right: 8px;
        margin-top: 4px;
        font-family: var(--font-serif), 'Georgia', serif;
        color: #111;
    }

    #artikel4 .konten-artikel h2,
    #artikel4 .konten-artikel h3 {
        font-family: var(--font-serif), 'Georgia', serif;
        font-weight: bold;
        margin-top: 32px;
        margin-bottom: 12px;
    }

    #artikel4 .konten-artikel h2 { font-size: 26px; }
    #artikel4 .konten-artikel h3 { font-size: 22px; }

    #artikel4 .konten-artikel img {
        max-width: 100%;
        height: auto;
        margin: 20px 0;
        display: block;
    }

    /* ── Catatan Kaki ── */
    #artikel4 .catatan-kaki {
        border-top: 1px solid #ddd;
        font-size: 0.85em;
        color: #555;
        font-family: var(--font-sans), sans-serif;
        line-height: 1.6;
        text-align: left;
        margin-top: 40px;
        padding-top: 16px;
    }

    /* ── Share Popup dari Artikel 1 ── */
    #artikel4 .share-popup {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        padding: 10px;
        z-index: 9999;
        flex-direction: column;
        gap: 10px;
        min-width: 150px;
        margin-top: 10px;
    }
    #artikel4 .share-popup.active {
        display: flex;
    }
    #artikel4 .share-popup a {
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
    #artikel4 .share-popup a:hover {
        background: #f0f0f0;
    }

    /* ── Slider Artikel Terkait (sama dengan artikel1) ── */
    .readmore-section {
        position: relative;
        margin-top: 20px;
        padding: 35px 0 0 0;
        background: #fff;
        border-top: 2px solid #000;
    }
    .readmore-section .container {
        padding: 0 5%;
        max-width: 100%;
    }
    .readmore-layout {
        display: flex;
        gap: 30px;
        align-items: center;
    }
    .readmore-sidebar {
        flex: 0 0 250px;
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
    .readmore-nav { display: flex; gap: 10px; flex-shrink: 0; position: relative; z-index: 10; }
    .readmore-btn {
        background: #f0f0f0; color: #000; border: none;
        width: 35px; height: 35px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; cursor: pointer; transition: all 0.3s; outline: none;
    }
    .readmore-btn:hover { background: #b70d0f; color: #fff; }
    .readmore-content { flex: 1; min-width: 0; overflow: hidden; }
    .readmore-track {
        display: flex; overflow-x: auto; scroll-snap-type: x mandatory;
        scroll-behavior: smooth; scrollbar-width: none; -ms-overflow-style: none;
        width: 100%; gap: 20px; padding-bottom: 10px;
    }
    .readmore-track::-webkit-scrollbar { display: none; }
    .readmore-card { flex: 0 0 calc(25% - 15px); scroll-snap-align: start; }
    .readmore-card a { display: block; text-decoration: none; color: #1a1a1a; background: transparent; transition: opacity 0.3s; }
    .readmore-card a:hover { opacity: 0.7; }
    .readmore-card img {
        width: 100%;
        aspect-ratio: 2/3;
        object-fit: contain;
        background: #f5f5f5;
        display: block;
        margin-bottom: 15px;
        border-radius: 0;
    }
    .readmore-card h3 { font-family: var(--font-serif), 'Georgia', serif; font-size: 16px; font-weight: bold; margin: 0 0 8px 0; line-height: 1.4; color: #000; }
    .readmore-card .penulis { font-family: var(--font-sans), 'Arial', sans-serif; font-size: 11px; text-transform: uppercase; color: #666; }
    .readmore-card .penulis span { color: #b70d0f; font-weight: bold; }
    @media (max-width: 768px) {
        .readmore-layout { flex-direction: column; align-items: flex-start; gap: 20px; width: 100%; }
        .readmore-sidebar { flex: 0 0 auto; width: 100%; border-right: none; border-bottom: 1px solid #eee; padding-right: 0; padding-bottom: 20px; flex-direction: row; justify-content: space-between; align-items: center; }
        .readmore-content { width: 100%; max-width: 100%; }
        .readmore-section .section-title { margin: 0; }
        .readmore-card { flex: 0 0 calc(50% - 10px) !important; max-width: calc(50% - 10px) !important; width: calc(50% - 10px) !important; }
    }
    @media (max-width: 480px) {
        .readmore-card { flex: 0 0 calc(50% - 10px) !important; max-width: calc(50% - 10px) !important; width: calc(50% - 10px) !important; }
        .readmore-card h3 { font-size: 13px; margin-bottom: 6px; line-height: 1.35; }
        .readmore-card .penulis { font-size: 9px; }
        .readmore-card img { margin-bottom: 10px; border-radius: 0; width: 100% !important; aspect-ratio: 2/3 !important; object-fit: contain !important; }
    }

    /* ── RESPONSIVE MOBILE ── */
    @media (max-width: 768px) {
        #artikel4 .layout-wrapper {
            flex-direction: column;
        }

        #artikel4 .col-gambar {
            flex: 0 0 100%;
            max-width: 100%;
            position: static;
            margin: 0;
            width: 100%;
        }

        #artikel4 .col-gambar img.main-photo {
            width: 100%;
            height: auto;
            max-height: none;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        #artikel4 .col-konten {
            width: 100%;
            max-width: 100%;
            padding-left: 0;
            padding-top: 24px;
            box-sizing: border-box;
        }

        #artikel4 .judul-artikel {
            font-size: 22px;
        }

        #artikel4 .sinopsis-artikel {
            font-size: 16px !important;
            line-height: 1.4 !important;
        }

        #artikel4 .action-buttons button {
            padding: 6px 10px;
            font-size: 12px;
            gap: 5px;
        }

        #artikel4 .konten-artikel p,
        #artikel4 .konten-artikel p span,
        #artikel4 .konten-artikel p a {
            font-size: 16px !important;
        }
    }
</style>
@endpush

@section('content')
<section id="artikel4">
    <div class="container" style="max-width: 1100px; margin: 30px auto; padding: 0 20px;">

        {{-- ── LAYOUT DUA KOLOM ── --}}
        <div class="layout-wrapper">

            {{-- ── KOLOM KIRI: GAMBAR ── --}}
            <div class="col-gambar">
                @php
                    $gambarUtama = $artikel->gambar->first();
                    $captionUtama = $gambarUtama ? $gambarUtama->deskripsi : '';
                    $imgSrc = null;

                    if ($gambarUtama) {
                        $rawFile = $gambarUtama->file_gambar ?? '';
                        if (str_starts_with($rawFile, 'data:')) {
                            $imgSrc = $rawFile; // base64 preview
                        } elseif (str_starts_with($rawFile, 'http')) {
                            $imgSrc = $rawFile;
                        } else {
                            $imgSrc = asset('img/' . $rawFile);
                        }
                    }
                @endphp

                @if($imgSrc)
                    <div class="main-photo-wrapper">
                        <img src="{{ $imgSrc }}" alt="{{ $artikel->judul }}" class="main-photo">
                        <div class="zoom-overlay" style="background-image: url('{{ $imgSrc }}')"></div>
                    </div>
                @else
                    <div style="width:100%; height:520px; background:#f0f0f0; display:flex; align-items:center; justify-content:center; color:#aaa; font-size:14px;">
                        Tidak ada gambar
                    </div>
                @endif

                @if($captionUtama)
                    <p class="img-caption"><i class="fas fa-camera"></i> {{ $captionUtama }}</p>
                @endif
            </div>

            {{-- ── KOLOM KANAN: KONTEN ── --}}
            <div class="col-konten">

                {{-- Meta: Kategori + Tanggal --}}
                <div class="meta-row">
                    <a href="{{ isset($artikel->kategori) ? route('page.show', $artikel->kategori->slug) : '#' }}" class="kategori-label">
                        {{ strtoupper($artikel->kategori->nama ?? 'BUKU') }}
                    </a>
                    <div class="meta-dot"></div>
                    <span class="tanggal-label">
                        {{ \Carbon\Carbon::parse($artikel->tanggal_publikasi)->translatedFormat('F j, Y') }}
                    </span>
                </div>

                {{-- Judul --}}
                <h1 class="judul-artikel">{{ $artikel->judul }}</h1>

                {{-- Sinopsis --}}
                @if($artikel->sinopsis)
                    <p class="sinopsis-artikel">{{ $artikel->sinopsis }}</p>
                @endif

                <hr class="divider-tipis">

                {{-- Penulis + Share --}}
                @php
                    $topPhoto = null;
                    $topPath = '';
                    
                    if (isset($artikel->penulis) && !empty($artikel->penulis->foto_profil)) {
                        $topPhoto = $artikel->penulis->foto_profil;
                        $topPath = asset('storage/penulis/' . $topPhoto);
                    } else {
                        $penggunaTulisan = \App\Models\PenggunaTulisan::where('artikel_id', $artikel->id)->with('pengguna')->first();
                        if ($penggunaTulisan && $penggunaTulisan->pengguna && !empty($penggunaTulisan->pengguna->foto_profil)) {
                            $topPhoto = $penggunaTulisan->pengguna->foto_profil;
                            $topPath = asset('storage/profile/' . $topPhoto);
                        }
                    }
                @endphp
                <div class="penulis-row">
                    <div class="penulis-info">
                        @if(!empty($topPhoto))
                            <img src="{{ $topPath }}" alt="Foto Penulis" class="penulis-foto">
                        @endif
                        @php
                            $topName = $artikel->penulis_id ? ($artikel->penulis->nama ?? 'Redaksi') : ($artikel->penulis_manual ?? 'Redaksi');
                        @endphp
                        <span class="penulis-nama">BY {{ strtoupper($topName) }}</span>
                    </div>

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

                {{-- Konten Artikel --}}
                <div class="konten-artikel">
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
                                if ($trimmed !== '') { $paragraf_array[] = $trimmed . '</p>'; }
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

                        $total_gambar   = $gambar_collection->count();
                        $gambar_index   = 1;
                        $paragraf_counter = 0;
                    @endphp

                    @foreach ($paragraf_array as $paragraf)
                        {!! $paragraf !!}
                        @php $paragraf_counter++; @endphp

                        @if ($paragraf_counter % 3 == 0 && $gambar_index < $total_gambar)
                            @php
                                $gambar_obj = $gambar_collection[$gambar_index];
                                $gambar     = trim($gambar_obj->file_gambar);
                                $deskripsi  = $gambar_obj->deskripsi;
                                $gbrUrl     = Str::startsWith($gambar ?? '', 'data:image') ? $gambar : asset('img/'.$gambar);
                            @endphp
                            {{-- Gambar portrait 1000×1500 — tampil di tengah teks --}}
                            <div style="margin: 32px auto; text-align:center;">
                                <img src="{{ $gbrUrl }}"
                                     alt="{{ $deskripsi ?? $artikel->judul }}"
                                     style="max-width: 100%; width: auto; height: auto;
                                            max-height: 550px; object-fit: contain;
                                            box-shadow: 4px 8px 24px rgba(0,0,0,0.18), -2px 2px 8px rgba(0,0,0,0.08);
                                            border-radius:3px; display:inline-block;">
                                @if($deskripsi)
                                <p style="font-family:var(--font-sans),'Arial',sans-serif;font-size:12px;
                                          color:#999;margin-top:8px;text-align:center;">
                                    <i class="fas fa-camera"></i> {{ $deskripsi }}
                                </p>
                                @endif
                            </div>
                            @php $gambar_index++; @endphp
                        @endif
                    @endforeach

                    @if(isset($hasAccess) && !$hasAccess)
                        @include('components.paywall')
                    @endif

                    {{-- Catatan Kaki --}}
                    @if(count($footnotes) > 0)
                        <div class="catatan-kaki">
                            @foreach($footnotes as $idx => $fn)
                                <div id="fn-{{ $idx+1 }}" class="mb-2">
                                    <span style="color:#b70d0f; font-weight:bold;">{{ $idx+1 }}.</span>
                                    {!! nl2br(e($fn)) !!}
                                    <a href="#ref-{{ $idx+1 }}" style="text-decoration:none; color:#b70d0f; margin-left: 5px;">&#8617;</a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>


                {{-- Bio Penulis / Sponsor --}}
                @php
                    $bioPhoto = null;
                    $bioPath = '';
                    
                    if (isset($artikel->penulis) && !empty($artikel->penulis->foto_profil)) {
                        $bioPhoto = $artikel->penulis->foto_profil;
                        $bioPath = asset('storage/penulis/' . $bioPhoto);
                    } else {
                        $penggunaTulisan = \App\Models\PenggunaTulisan::where('artikel_id', $artikel->id)->with('pengguna')->first();
                        if ($penggunaTulisan && $penggunaTulisan->pengguna && !empty($penggunaTulisan->pengguna->foto_profil)) {
                            $bioPhoto = $penggunaTulisan->pengguna->foto_profil;
                            $bioPath = asset('storage/profile/' . $bioPhoto);
                        }
                    }

                    $bioName = $artikel->penulis_id ? ($artikel->penulis->nama ?? 'Redaksi') : ($artikel->penulis_manual ?? 'Redaksi');
                    $bioDesc = $artikel->sponsor ?? ($artikel->penulis_id ? $artikel->penulis->biografi : '');
                @endphp
                @if(!empty($bioDesc))
                <div style="display:flex; align-items:flex-start; gap:16px; margin-top:40px; padding-top:20px; border-top: 1px solid #e0e0e0;">
                    @if(!empty($bioPhoto))
                        <img src="{{ $bioPath }}" alt="{{ $bioName }}" style="width:55px; height:55px; border-radius:50%; object-fit:cover; flex-shrink:0;">
                    @endif
                    <div>
                        <div style="font-family:var(--font-sans),'Arial',sans-serif; font-size:11px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase; color:#222; margin-bottom:6px;">
                            {{ strtoupper($bioName) }}
                        </div>
                        <p style="font-family:var(--font-sans),'Arial',sans-serif; font-size:13px; color:#555; line-height:1.6; margin:0;">
                            {{ $bioDesc }}
                        </p>
                    </div>
                </div>
                @endif

                {{-- ── Slider Artikel Terkait (Model Artikel 1) ── --}}
            </div>{{-- end col-konten --}}
        </div>{{-- end layout-wrapper --}}
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
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Tutup share popup saat klik di luar
document.addEventListener('click', function(event) {
    const shareBtn = document.querySelector('.btn-share');
    const popup = document.getElementById('sharePopup');
    if (shareBtn && popup) {
        if (!shareBtn.contains(event.target) && !popup.contains(event.target)) {
            popup.classList.remove('active');
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

// Slider artikel terkait (sama dengan artikel1)
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

    // Efek Image Zoom pada Hover
    const zoomWrapper = document.querySelector('#artikel4 .main-photo-wrapper');
    const zoomOverlay = document.querySelector('#artikel4 .zoom-overlay');
    
    if (zoomWrapper && zoomOverlay) {
        zoomWrapper.addEventListener('mouseenter', function() {
            const rect = this.getBoundingClientRect();
            // Ukuran gambar di dalam lensa diperbesar 2x (zoom 200%)
            zoomOverlay.style.backgroundSize = (rect.width * 2) + "px " + (rect.height * 2) + "px";
        });

        zoomWrapper.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            // Pindahkan lensa tepat di kursor
            zoomOverlay.style.left = x + "px";
            zoomOverlay.style.top = y + "px";
            
            // Konversi ke persentase untuk background
            const xPercent = (x / rect.width) * 100;
            const yPercent = (y / rect.height) * 100;
            
            zoomOverlay.style.backgroundPosition = `${xPercent}% ${yPercent}%`;
        });
    }
});
</script>
@endpush
