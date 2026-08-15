@extends('layouts.app')

@section('content')
<style>
    /* --- RESET & VARIABEL GLOBAL --- */
    .pustaka-wrapper * {
        box-sizing: border-box;
    }

    .pustaka-wrapper {
        --font-serif: 'Georgia', 'Times New Roman', serif;
        --font-sans: 'Helvetica Neue', Arial, sans-serif;
        --bg-page: #fdfdfd;
        --purple-card: #ebdfff; /* Ungu untuk bagian dalam kartu galeri */
        --green-border: #bdf271; /* Hijau tajam untuk border pahlawan */
        --red-brand: #e03a3c; /* Merah seragam project */
        --text-dark: #333333;
        --text-gray: #666666;
        
        font-family: var(--font-serif);
        background-color: var(--bg-page);
        color: var(--text-dark);
        line-height: 1.6;
        padding-top: 30px; /* Offset for fixed navbar */
    }

    .pustaka-wrapper .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* =========================================
       BAGIAN ATAS (HERO SECTION)
       ========================================= */
    .pustaka-wrapper .hero-section {
        display: flex;
        width: 100%;
        background-color: #ffffff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 60px;
        overflow: hidden;
        border-radius: 4px;
    }

    /* Visual Gradien Kiri (Skala 65%) */
    .pustaka-wrapper .hero-visual {
        width: 65%;
        position: relative;
        padding: 60px 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: radial-gradient(circle at 20% 20%, #e6a821 0%, transparent 60%),
                    radial-gradient(circle at 80% 80%, #1e3882 0%, transparent 60%),
                    radial-gradient(circle at 50% 50%, #a23565 0%, transparent 60%),
                    linear-gradient(135deg, #e6a821 10%, #a23565 50%, #1e3882 90%);
        overflow: hidden;
    }

    .pustaka-wrapper .hero-visual::before {
        content: '';
        position: absolute;
        inset: -50%; /* Lebarkan area agar saat diputar ujungnya tidak terpotong */
        /* Menggunakan 2 layer untuk membuat efek selang-seling (staggered) */
        background-image: 
            url('{{ asset("img/logo-backround.png") }}'), 
            url('{{ asset("img/logo-backround.png") }}');
        background-size: 600px, 600px; /* Diperbesar drastis agar lebih renggang (sedikit) */
        background-position: 0 0, 300px 300px; /* Menyesuaikan jarak tumpuknya */
        background-repeat: repeat;
        opacity: 0.12; /* Sesuaikan transparansinya */
        transform: rotate(-15deg); /* Putar sedikit agar polanya tidak terlihat kaku/lurus */
        z-index: 1;
    }
    


    /* Grid Buku Pahlawan */
    .pustaka-wrapper .hero-books-wrapper {
        display: flex;
        gap: 25px;
        width: 100%;
        z-index: 2;
        padding: 0 10px;
    }

    .pustaka-wrapper .hero-book-card {
        flex: 1;
        position: relative;
        background-color: var(--green-border);
        padding: 4px;
        box-shadow: 6px 6px 0px var(--green-border); 
        transition: transform 0.3s ease;
        cursor: pointer;
    }

    .pustaka-wrapper .hero-book-card:hover {
        transform: translate(-3px, -3px);
        box-shadow: 9px 9px 0px var(--green-border);
    }

    .pustaka-wrapper .hero-book-inner {
        position: relative;
        width: 100%;
        aspect-ratio: 2/3.2;
        background-color: #ffffffff;
        overflow: hidden;
    }

    .pustaka-wrapper .hero-book-inner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pustaka-wrapper .book-text-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 10px;
        color: #ffffff;
    }

    .pustaka-wrapper .hero-book-card .book-text-overlay h3 {
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 5px;
        text-transform: uppercase;
        line-height: 1.1;
    }

    .pustaka-wrapper .hero-book-card .book-text-overlay p {
        font-size: 0.75rem;
        font-family: var(--font-sans);
        letter-spacing: 0.5px;
    }

    /* Kotak Teks Kanan (Skala 35%) */
    .pustaka-wrapper .hero-text-content {
        width: 35%;
        padding: 50px 60px;
        background-color: #ffffff;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .pustaka-wrapper .hero-title {
        font-family: var(--font-sans);
        font-size: 2.2rem;
        font-weight: 300; 
        color: var(--text-dark);
        line-height: 1.25;
        margin-bottom: 25px;
    }

    .pustaka-wrapper .hero-desc {
        font-family: var(--font-serif);
        font-size: 1.1rem;
        color: var(--text-gray);
        margin-bottom: 35px;
    }

    .pustaka-wrapper .read-more-btn {
        align-self: flex-start;
        padding: 12px 30px;
        border: 2px solid var(--red-brand);
        background-color: transparent;
        color: var(--text-dark);
        font-family: var(--font-sans);
        font-size: 0.85rem;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .pustaka-wrapper .read-more-btn:hover {
        background-color: var(--red-brand);
        color: #ffffff;
    }

    /* =========================================
       FILTER SECTION
       ========================================= */
    .pustaka-wrapper .filter-section {
        margin: 60px 0 40px;
        text-align: center;
    }
    .pustaka-wrapper .filter-title {
        font-family: var(--font-serif);
        font-weight: 300;
        font-size: 2.8rem;
        color: #333;
        margin-bottom: 20px;
    }
    .pustaka-wrapper .filter-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    .pustaka-wrapper .filter-btn {
        background: none;
        border: 2px solid transparent;
        color: #777;
        font-family: var(--font-sans);
        font-weight: bold;
        font-size: 0.9rem;
        padding: 8px 16px;
        cursor: pointer;
        text-transform: uppercase;
        transition: all 0.3s ease;
        border-radius: 4px;
    }
    .pustaka-wrapper .filter-btn:hover {
        color: #333;
        border-color: var(--red-brand);
    }
    .pustaka-wrapper .filter-btn.active {
        border-color: var(--red-brand);
        color: #000;
    }

    /* =========================================
       BAGIAN BAWAH (GALLERY SECTION)
       ========================================= */
    .pustaka-wrapper .gallery-section {
        position: relative;
        padding: 0 50px; /* Ruang untuk tombol panah luar */
    }

    /* Tombol Navigasi SVG Keren */
    .pustaka-wrapper .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 48px;
        height: 48px;
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        z-index: 10;
        transition: all 0.3s ease;
    }

    .pustaka-wrapper .nav-btn:hover {
        background-color: var(--red-brand);
        box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        border-color: var(--red-brand);
    }
    .pustaka-wrapper .nav-btn:hover svg { color: #ffffff; }

    .pustaka-wrapper .nav-btn svg { width: 20px; height: 20px; color: #333333; transition: color 0.3s ease; }
    .pustaka-wrapper .nav-prev { left: 0; }
    .pustaka-wrapper .nav-next { right: 0; }

    /* Track Galeri */
    .pustaka-wrapper .gallery-grid {
        display: flex;
        gap: 20px;
        width: 100%;
    }

    /* Kartu Galeri (Perbaikan Layout Nomor) */
    .pustaka-wrapper .gallery-card {
        flex: 0 0 calc(20% - 16px);
        max-width: calc(20% - 16px);
        background-color: var(--purple-card);
        padding: 20px 20px 25px 20px; /* Padding rapi atas-bawah */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between; /* Menjaga nomor tetap di bawah */
        position: relative;
        transition: transform 0.3s ease, background-color 0.3s ease;
        cursor: pointer;
    }

    .pustaka-wrapper .gallery-card:hover {
        transform: translateY(-8px);
        background-color: #e0cdf7; 
    }

    /* Gambar Buku Galeri */
    .pustaka-wrapper .gallery-book-inner {
        width: 100%;
        aspect-ratio: 2/3.2;
        background-color: #111;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        position: relative;
        overflow: hidden;
        border-radius: 2px;
        margin-bottom: 20px; /* JARAK PENTING: Mendorong nomor ke bawah agar tidak bertabrakan */
    }

    .pustaka-wrapper .gallery-book-inner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.3s ease;
    }


    /* Teks Overlay Galeri */
    .pustaka-wrapper .gallery-card .book-text-overlay h3 {
        font-size: 1rem;
        font-weight: bold;
        margin-bottom: 5px;
        line-height: 1.2;
        color: #fff;
    }
    
    .pustaka-wrapper .gallery-card .book-text-overlay p {
        font-size: 0.75rem;
        font-family: var(--font-sans);
        font-weight: bold;
        color: #fff;
    }

    /* PERBAIKAN: Judul Buku di Bawah Card */
    .pustaka-wrapper .gallery-book-title {
        width: 100%;
        text-align: center;
        font-family: var(--font-serif);
        font-size: 0.9rem;
        font-weight: 500;
        color: #222222;
        margin-top: 10px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Elemen Hover Khusus (Quick View) */
    .pustaka-wrapper .quick-view-btn {
        position: absolute;
        top: 70%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #ffffff;
        color: #333333;
        padding: 10px 5px;
        border: none;
        font-family: var(--font-sans);
        font-size: 0.6rem;
        font-weight: bold;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
        display: flex;
        align-items: center;
        gap: 5px;
        z-index: 5;
    }

    .pustaka-wrapper .gallery-card:hover .quick-view-btn {
        opacity: 1;
        pointer-events: auto;
    }
    .pustaka-wrapper .quick-view-btn:hover {
        background-color: var(--red-brand);
        color: #ffffff;
    }

    /* Slider Nav Buttons */
    .pustaka-wrapper .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background-color: #ffffff;
        border: 1px solid #1c5372;
        color: #1c5372;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
    }
    .pustaka-wrapper .nav-btn svg {
        width: 20px;
        height: 20px;
    }
    .pustaka-wrapper .nav-btn:hover {
        background-color: #1c5372;
        color: #ffffff;
    }
    .pustaka-wrapper .nav-prev { left: 10px; }
    .pustaka-wrapper .nav-next { right: 10px; }

    /* =========================================
       ALL PUSTAKA SECTION
       ========================================= */
    .pustaka-wrapper .all-pustaka-section {
        margin: 80px 0 0 0;
        padding: 60px 0;
        background-color: #fdfdfb;
    }
    .pustaka-wrapper .all-pustaka-title {
        text-align: center;
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.8rem;
        font-weight: 500;
        color: #1c5372; 
        margin-bottom: 40px;
    }

    /* Top Bar (Filter & Sort) */
    .pustaka-wrapper .ap-top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: 'Source Sans 3', sans-serif;
        font-size: 0.9rem;
        color: #558399;
        margin-bottom: 30px;
        font-weight: 500;
    }
    .pustaka-wrapper .custom-dropdown {
        position: relative;
        display: inline-block;
        color: #558399;
        font-weight: 500;
        cursor: pointer;
        margin-left: 6px;
        z-index: 10;
    }
    .pustaka-wrapper .cd-header {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .pustaka-wrapper .cd-list {
        position: absolute;
        top: 100%;
        left: -15px;
        background: #ffffff;
        min-width: 180px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid #f1ede2;
        border-radius: 8px;
        padding: 8px 0;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
        text-align: left;
    }
    .pustaka-wrapper .custom-dropdown.open .cd-list {
        opacity: 1;
        visibility: visible;
        transform: translateY(8px);
    }
    .pustaka-wrapper .cd-item {
        padding: 10px 20px;
        font-size: 0.9rem;
        transition: background 0.2s;
        color: #558399;
    }
    .pustaka-wrapper .cd-item:hover, .pustaka-wrapper .cd-item.active {
        background-color: #fcfbfa;
        color: #1c5372;
    }
    .pustaka-wrapper .ap-sort { display: flex; align-items: center; gap: 20px; }
    .pustaka-wrapper .ap-count { margin-left: 20px; color: #558399; }

    /* Grid & Cards */
    .pustaka-wrapper .ap-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        justify-content: flex-start;
    }
    .pustaka-wrapper .ap-card {
        flex: 0 0 calc(25% - 22.5px);
        max-width: calc(25% - 22.5px);
        display: none; 
        flex-direction: column;
    }
    .pustaka-wrapper .ap-img-wrap {
        background-color: #f1ede2; 
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        margin-bottom: 15px;
        aspect-ratio: 1 / 1; /* Kotak sempurna 1:1 */
        overflow: hidden;
    }
    .pustaka-wrapper .ap-img-wrap img {
        max-height: 65%; /* Dibuat lebih kecil agar tidak terlalu tinggi */
        max-width: 60%;
        width: auto;
        height: auto;
        box-shadow: 2px 5px 15px rgba(0,0,0,0.12);
        object-fit: contain;
        transition: transform 0.3s ease;
    }
    .pustaka-wrapper .ap-img-wrap:hover img {
        transform: scale(1.03);
    }
    .pustaka-wrapper .ap-info {
        padding: 0;
        text-align: left;
    }
    .pustaka-wrapper .ap-judul {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.05rem;
        color: #1c5372;
        text-decoration: none;
        display: block;
        margin-bottom: 8px;
        line-height: 1.4;
    }
    .pustaka-wrapper .ap-judul:hover {
        text-decoration: underline;
    }
    .pustaka-wrapper .ap-harga {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 0.9rem;
        color: #1c5372;
        letter-spacing: 0.5px;
    }

    .pustaka-wrapper .ap-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        margin-top: 60px;
        margin-bottom: 20px;
    }
    .pustaka-wrapper .ap-num-btn {
        background-color: transparent;
        border: none;
        color: #535353ff;
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1.05rem;
        font-weight: 400;
        cursor: pointer;
        padding: 5px 12px;
        position: relative;
        transition: color 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pustaka-wrapper .ap-num-btn.active {
        font-weight: 500;
        color: #b70d0f;
    }
    .pustaka-wrapper .ap-num-btn.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        height: 2px;
        background-color: #b70d0f;
    }
    .pustaka-wrapper .ap-num-btn:hover:not(.active):not(:disabled):not(.ap-dots) {
        color: #b70d0f;
    }
    .pustaka-wrapper .ap-num-btn:disabled {
        color: #ccd5da;
        cursor: not-allowed;
    }
    .pustaka-wrapper .ap-dots {
        cursor: default;
        padding: 5px;
        pointer-events: none;
    }

    /* =========================================
       RESPONSIVITAS MOBILE YANG AESTHETIC
       ========================================= */
    @media (max-width: 1024px) {
        .pustaka-wrapper .hero-section { flex-direction: column; }
        .pustaka-wrapper .hero-visual { width: 100%; padding: 40px 20px; }
        .pustaka-wrapper .hero-text-content { width: 100%; padding: 40px 30px; text-align: center; align-items: center; }
        .pustaka-wrapper .gallery-grid { flex-wrap: wrap; justify-content: center; }
        .pustaka-wrapper .gallery-card { flex: 0 0 calc(33.333% - 20px); }
    }

    @media (max-width: 768px) {
        /* Tipografi & Spacing */
        .pustaka-wrapper .hero-title { font-size: 1.6rem; margin-bottom: 15px; }
        .pustaka-wrapper .hero-desc { font-size: 0.95rem; margin-bottom: 25px; }
        .pustaka-wrapper .filter-title { font-size: 2rem; margin-bottom: 15px; }
        .pustaka-wrapper .filter-btn { font-size: 0.65rem; padding: 4px 6px; letter-spacing: 0; }
        .pustaka-wrapper .filter-buttons { gap: 6px; flex-wrap: nowrap !important; justify-content: center !important; }

        /* Hero Books Grid */
        .pustaka-wrapper .hero-books-wrapper { 
            flex-wrap: wrap; 
            gap: 12px; 
            justify-content: center;
            padding: 0;
        }
        .pustaka-wrapper .hero-book-card { flex: 0 0 calc(50% - 6px); }
        
        /* Gallery Section & Grid */
        .pustaka-wrapper .gallery-section { 
            padding: 0 35px; /* Ruang untuk panah navigasi di kiri-kanan */
            text-align: center; 
        }
        .pustaka-wrapper .gallery-grid { 
            flex-wrap: nowrap; /* Kembali ke satu baris */
            gap: 10px;
            justify-content: flex-start;
            overflow: hidden; /* Sembunyikan yang lebih */
        }
        .pustaka-wrapper .gallery-card { 
            flex: 0 0 calc(33.333% - 7px); /* 3 buku dalam satu baris */
            max-width: calc(33.333% - 7px);
            padding: 10px 6px 12px 6px; /* Padding lebih kecil */
        }
        .pustaka-wrapper .gallery-book-title {
            font-size: 0.75rem;
            margin-top: 6px;
        }

        /* Nav Buttons di Kiri & Kanan */
        .pustaka-wrapper .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            margin: 0;
            display: flex;
        }
        .pustaka-wrapper .nav-prev { left: 0; }
        .pustaka-wrapper .nav-next { right: 0; }

        /* All Pustaka Mobile */
        .pustaka-wrapper .all-pustaka-section { margin: 50px 0 0 0; padding: 40px 15px; }
        .pustaka-wrapper .all-pustaka-title { font-size: 2.2rem; margin-bottom: 25px; }
        .pustaka-wrapper .ap-top-bar { flex-direction: column; gap: 15px; align-items: flex-start; }
        .pustaka-wrapper .ap-grid { gap: 15px; }
        .pustaka-wrapper .ap-card { flex: 0 0 calc(50% - 7.5px); max-width: calc(50% - 7.5px); }
        .pustaka-wrapper .ap-img-wrap { padding: 12%; }
        .pustaka-wrapper .ap-judul { font-size: 0.9rem; }
        .pustaka-wrapper .ap-harga { font-size: 0.8rem; }
    }
</style>

<div class="pustaka-wrapper">
    <div class="container">
        <section class="hero-section">
            <div class="hero-visual">

                <div class="hero-books-wrapper">
                    @foreach($pustakas->where('kategori', 'Buku Baru')->take(4) as $p)
                    <div class="hero-book-card" onclick="window.location='{{ route('pustaka.detail', $p->slug) }}'">
                        <div class="hero-book-inner">
                            @if($p->gambar_1)
                            <img src="{{ asset('img/' . $p->gambar_1) }}" alt="{{ $p->judul }}">
                            @else
                            <img src="https://picsum.photos/seed/{{ $p->id }}/300/450" alt="{{ $p->judul }}">
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="hero-text-content">
                <h1 class="hero-title">'Memikirkan Kata' deciphers one of the greatest writing conundrums: Producing words</h1>
                <p class="hero-desc">I prefer to call Memikirkan Kata a ‘lesson-learned aspects of writing’ book instead of a technical guide.</p>
                <a href="https://www.thejakartapost.com/life/2019/11/26/memikirkan-kata-deciphers-one-of-the-greatest-writing-conundrums-producing-words.html" class="read-more-btn" target="_blank" style="text-decoration: none; display: inline-block; text-align: center;">READ MORE</a>
            </div>
        </section>

        <section class="filter-section text-center">
            <h2 class="filter-title">Shop Your Next Book</h2>
            <div class="filter-buttons d-flex justify-content-center flex-wrap gap-3">
                <button class="filter-btn" data-filter="Buku Baru">BUKU BARU</button>
                <button class="filter-btn" data-filter="Akan Terbit">AKAN TERBIT</button>
                <button class="filter-btn" data-filter="Terlaris">TERLARIS</button>
                <button class="filter-btn" data-filter="Koleksi">KOLEKSI</button>
            </div>
        </section>

        <section class="gallery-section position-relative">
            
            <button class="nav-btn nav-prev" aria-label="Previous">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>

            <div class="gallery-grid" id="galleryGrid">
                @foreach($pustakas as $index => $p)
                <div class="gallery-card book-item" data-kategori="{{ $p->kategori }}" onclick="window.location='{{ route('pustaka.detail', $p->slug) }}'">
                    <div class="gallery-book-inner">
                        @if($p->gambar_1)
                        <img src="{{ asset('img/' . $p->gambar_1) }}" alt="{{ $p->judul }}">
                        @else
                        <img src="https://picsum.photos/seed/{{ $p->id }}/300/450" alt="{{ $p->judul }}">
                        @endif
                        <button class="quick-view-btn">VIEW FULL DETAIL</button>
                    </div>
                    <div class="gallery-book-title">{{ $p->judul }}</div>
                </div>
                @endforeach
            </div>

            <button class="nav-btn nav-next" aria-label="Next">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>

        </section>

        <!-- NEW: All Pustaka Section -->
        <section class="all-pustaka-section">
            <h2 class="all-pustaka-title">All Pustaka</h2>
            
            <div class="ap-top-bar">
                <div class="ap-filter">
                    Filter: 
                    <div class="custom-dropdown" id="apFilterDropdown" data-value="all">
                        <div class="cd-header">
                            <span class="cd-selected">All Category</span>
                            <i class="fal fa-angle-down"></i>
                        </div>
                        <div class="cd-list">
                            <div class="cd-item active" data-value="all">All Category</div>
                            <div class="cd-item" data-value="Buku Baru">Buku Baru</div>
                            <div class="cd-item" data-value="Akan Terbit">Akan Terbit</div>
                            <div class="cd-item" data-value="Terlaris">Terlaris</div>
                            <div class="cd-item" data-value="Koleksi">Koleksi</div>
                        </div>
                    </div>
                </div>
                <div class="ap-sort">
                    <div>
                        Sort by: 
                        <div class="custom-dropdown" id="apSortDropdown" data-value="featured">
                            <div class="cd-header">
                                <span class="cd-selected">Featured</span>
                                <i class="fal fa-angle-down"></i>
                            </div>
                            <div class="cd-list">
                                <div class="cd-item active" data-value="featured">Featured</div>
                                <div class="cd-item" data-value="price_asc">Price, low to high</div>
                                <div class="cd-item" data-value="price_desc">Price, high to low</div>
                                <div class="cd-item" data-value="title_asc">Alphabetically, A-Z</div>
                                <div class="cd-item" data-value="title_desc">Alphabetically, Z-A</div>
                                <div class="cd-item" data-value="date_desc">Date, new to old</div>
                                <div class="cd-item" data-value="date_asc">Date, old to new</div>
                            </div>
                        </div>
                    </div>
                    <div class="ap-count" id="apCountDisplay">{{ count($pustakas) }} products</div>
                </div>
            </div>

            <div class="ap-grid" id="apGrid">
                @foreach($pustakas as $p)
                <div class="ap-card ap-item" 
                     data-kategori="{{ $p->kategori }}" 
                     data-price="{{ $p->harga ?? 0 }}" 
                     data-title="{{ strtolower($p->judul) }}"
                     data-date="{{ $p->tanggal_terbit ?? $p->created_at }}">
                    <div class="ap-img-wrap" onclick="window.location='{{ route('pustaka.detail', $p->slug) }}'">
                        @if($p->gambar_1)
                        <img src="{{ asset('img/' . $p->gambar_1) }}" alt="{{ $p->judul }}">
                        @else
                        <img src="https://picsum.photos/seed/{{ $p->id }}/300/400" alt="{{ $p->judul }}">
                        @endif
                    </div>
                    <div class="ap-info">
                        <a href="{{ route('pustaka.detail', $p->slug) }}" class="ap-judul">{{ $p->judul }}</a>
                        <div class="ap-harga">Rp {{ number_format($p->harga ?? 0, 2, ',', '.') }} IDR</div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination Numbers Container -->
            <div class="ap-pagination" id="apPagination"></div>
        </section>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const bookItems = document.querySelectorAll('.book-item');
    const prevBtn = document.querySelector('.nav-prev');
    const nextBtn = document.querySelector('.nav-next');
    
    let currentIndex = 0;
    let itemsPerPage = window.innerWidth <= 768 ? 3 : 5;
    let currentCategory = null;
    let filteredItems = Array.from(bookItems);

    function renderPagination() {
        // Hide all items first
        bookItems.forEach(item => item.style.display = 'none');
        
        // Show items starting from currentIndex
        const endIndex = currentIndex + itemsPerPage;
        filteredItems.slice(currentIndex, endIndex).forEach(item => {
            item.style.display = 'flex';
        });
        
        // Update nav buttons
        if (currentIndex === 0) {
            prevBtn.style.opacity = '0.3';
            prevBtn.style.pointerEvents = 'none';
        } else {
            prevBtn.style.opacity = '1';
            prevBtn.style.pointerEvents = 'auto';
        }
        
        if (endIndex >= filteredItems.length) {
            nextBtn.style.opacity = '0.3';
            nextBtn.style.pointerEvents = 'none';
        } else {
            nextBtn.style.opacity = '1';
            nextBtn.style.pointerEvents = 'auto';
        }
    }

    function applyFilter() {
        if (currentCategory) {
            filteredItems = Array.from(bookItems).filter(item => item.getAttribute('data-kategori') === currentCategory);
        } else {
            filteredItems = Array.from(bookItems);
        }
        currentIndex = 0;
        renderPagination();
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const isActive = this.classList.contains('active');
            filterBtns.forEach(b => b.classList.remove('active'));

            if (isActive) {
                currentCategory = null;
            } else {
                this.classList.add('active');
                currentCategory = this.getAttribute('data-filter');
            }
            applyFilter();
        });
    });
    
    if(prevBtn) {
        prevBtn.addEventListener('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                renderPagination();
            }
        });
    }
    
    if(nextBtn) {
        nextBtn.addEventListener('click', function() {
            if (currentIndex + itemsPerPage < filteredItems.length) {
                currentIndex++;
                renderPagination();
            }
        });
    }

    // Update items per page on window resize
    window.addEventListener('resize', function() {
        let newItemsPerPage = window.innerWidth <= 768 ? 3 : 5;
        if (newItemsPerPage !== itemsPerPage) {
            itemsPerPage = newItemsPerPage;
            currentIndex = 0; // Reset ke awal agar tidak error hitungan
            renderPagination();
        }
    });

    // Initial render
    renderPagination();

    // =========================================
    // ALL PUSTAKA PAGINATION LOGIC (NUMBERED)
    // =========================================
    const apItemsAll = Array.from(document.querySelectorAll('.ap-item'));
    let apFilteredItems = [...apItemsAll];

    const apPaginationContainer = document.getElementById('apPagination');
    const apFilterDropdown = document.getElementById('apFilterDropdown');
    const apSortDropdown = document.getElementById('apSortDropdown');
    const apCountDisplay = document.getElementById('apCountDisplay');
    const apGrid = document.getElementById('apGrid');
    
    let apCurrentPage = 1;
    let apItemsPerPage = window.innerWidth <= 768 ? 6 : 12;

    // Custom Dropdown UI Logic
    document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
        const header = dropdown.querySelector('.cd-header');
        const items = dropdown.querySelectorAll('.cd-item');
        const selectedText = dropdown.querySelector('.cd-selected');
        
        header.addEventListener('click', (e) => {
            e.stopPropagation();
            document.querySelectorAll('.custom-dropdown').forEach(d => {
                if (d !== dropdown) d.classList.remove('open');
            });
            dropdown.classList.toggle('open');
        });

        items.forEach(item => {
            item.addEventListener('click', () => {
                items.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
                selectedText.textContent = item.textContent;
                dropdown.dataset.value = item.dataset.value;
                dropdown.classList.remove('open');
                applyApFilterAndSort(); // Trigger filtering
            });
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('open'));
    });

    function applyApFilterAndSort() {
        // 1. Filter
        const filterVal = apFilterDropdown ? apFilterDropdown.dataset.value : 'all';
        if (filterVal === 'all') {
            apFilteredItems = [...apItemsAll];
        } else {
            apFilteredItems = apItemsAll.filter(item => item.getAttribute('data-kategori') === filterVal);
        }

        // 2. Sort
        const sortVal = apSortDropdown ? apSortDropdown.dataset.value : 'featured';
        apFilteredItems.sort((a, b) => {
            if (sortVal === 'featured') {
                return apItemsAll.indexOf(a) - apItemsAll.indexOf(b);
            } else if (sortVal === 'price_asc') {
                return parseFloat(a.getAttribute('data-price')) - parseFloat(b.getAttribute('data-price'));
            } else if (sortVal === 'price_desc') {
                return parseFloat(b.getAttribute('data-price')) - parseFloat(a.getAttribute('data-price'));
            } else if (sortVal === 'title_asc') {
                return a.getAttribute('data-title').localeCompare(b.getAttribute('data-title'));
            } else if (sortVal === 'title_desc') {
                return b.getAttribute('data-title').localeCompare(a.getAttribute('data-title'));
            } else if (sortVal === 'date_desc') {
                return new Date(b.getAttribute('data-date')) - new Date(a.getAttribute('data-date'));
            } else if (sortVal === 'date_asc') {
                return new Date(a.getAttribute('data-date')) - new Date(b.getAttribute('data-date'));
            }
            return 0;
        });

        // Update count
        if (apCountDisplay) {
            apCountDisplay.textContent = apFilteredItems.length + (apFilteredItems.length === 1 ? ' product' : ' products');
        }

        // Re-append to grid in sorted order so DOM order matches array order
        apFilteredItems.forEach(item => apGrid.appendChild(item));

        apCurrentPage = 1;
        renderApPagination();
    }

    function renderApPagination() {
        const totalPages = Math.ceil(apFilteredItems.length / apItemsPerPage);
        
        // Hide all
        apItemsAll.forEach(item => item.style.display = 'none');
        
        // Find correct slice
        const startIndex = (apCurrentPage - 1) * apItemsPerPage;
        const endIndex = startIndex + apItemsPerPage;
        
        apFilteredItems.slice(startIndex, endIndex).forEach(item => {
            item.style.display = 'flex';
        });
        
        // Render Numbers
        if (apPaginationContainer) {
            apPaginationContainer.innerHTML = '';
            
            // Arrow Prev
            const prevBtn = document.createElement('button');
            prevBtn.className = 'ap-num-btn';
            prevBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>';
            prevBtn.disabled = apCurrentPage === 1;
            prevBtn.onclick = () => { 
                if(apCurrentPage > 1) { 
                    apCurrentPage--; 
                    renderApPagination(); 
                    document.getElementById('apGrid').scrollIntoView({ behavior: 'smooth', block: 'start' });
                } 
            };
            apPaginationContainer.appendChild(prevBtn);

            let pages = [];
            if (totalPages <= 5) {
                for(let i = 1; i <= totalPages; i++) pages.push(i);
            } else {
                if (apCurrentPage <= 3) {
                    pages = [1, 2, 3, '...', totalPages];
                } else if (apCurrentPage >= totalPages - 2) {
                    pages = [1, '...', totalPages - 2, totalPages - 1, totalPages];
                } else {
                    pages = [1, '...', apCurrentPage, '...', totalPages];
                }
            }

            pages.forEach(p => {
                const pageBtn = document.createElement('button');
                pageBtn.className = 'ap-num-btn' + (p === apCurrentPage ? ' active' : '') + (p === '...' ? ' ap-dots' : '');
                pageBtn.textContent = p;
                if (p !== '...') {
                    pageBtn.onclick = () => { 
                        apCurrentPage = p; 
                        renderApPagination(); 
                        document.getElementById('apGrid').scrollIntoView({ behavior: 'smooth', block: 'start' });
                    };
                }
                apPaginationContainer.appendChild(pageBtn);
            });
            
            // Arrow Next
            const nextBtn = document.createElement('button');
            nextBtn.className = 'ap-num-btn';
            nextBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>';
            nextBtn.disabled = apCurrentPage === totalPages;
            nextBtn.onclick = () => { 
                if(apCurrentPage < totalPages) { 
                    apCurrentPage++; 
                    renderApPagination(); 
                    document.getElementById('apGrid').scrollIntoView({ behavior: 'smooth', block: 'start' });
                } 
            };
            apPaginationContainer.appendChild(nextBtn);
        }
    }

    window.addEventListener('resize', function() {
        let newApItems = window.innerWidth <= 768 ? 6 : 12;
        if(newApItems !== apItemsPerPage) {
            apItemsPerPage = newApItems;
            apCurrentPage = 1;
            renderApPagination();
        }
    });

    renderApPagination();
});
</script>
@endsection
