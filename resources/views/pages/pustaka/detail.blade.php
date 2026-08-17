@extends('layouts.app')

@section('content')
<style>
    /* --- RESET & VARIABLES --- */
    .pustaka-detail-wrapper * {
        box-sizing: border-box;
    }

    .pustaka-detail-wrapper {
        --font-serif: 'Georgia', 'Times New Roman', serif;
        --font-sans: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        --bg-page: #ffffff;
        --bg-gray: #f4f4f4;
        --text-dark: #222222;
        --text-light: #555555;
        --border-color: #e0e0e0;
        --red-brand: #e03a3c; /* Warna utama untuk aksi */
        --red-hover: #b70d0f; /* Warna hover */
        
        font-family: var(--font-sans);
        color: var(--text-dark);
        background-color: var(--bg-page);
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
        padding-top: 80px;
    }

    .pustaka-detail-wrapper a {
        color: var(--text-dark);
        text-decoration: underline;
        text-decoration-thickness: 1px;
        text-underline-offset: 3px;
    }

    .pustaka-detail-wrapper .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* --- PRODUCT SECTION (TOP) --- */
    .pustaka-detail-wrapper .product-section {
        display: flex;
        gap: 50px;
        margin-bottom: 80px;
    }

    /* Kolom Kiri (Gambar & Tombol) */
    .pustaka-detail-wrapper .product-left {
        flex: 0 0 45%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .pustaka-detail-wrapper .image-wrapper {
        background-color: var(--bg-gray);
        width: 100%;
        padding: 60px 40px 40px 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        margin-bottom: 25px;
    }

    .pustaka-detail-wrapper .slider-container {
        width: 70%;
        max-width: 320px;
        overflow: hidden;
        position: relative;
    }

    .pustaka-detail-wrapper .slider-track {
        display: flex;
        transition: transform 0.4s ease-in-out;
        width: 300%;
    }

    .pustaka-detail-wrapper .main-book-cover {
        width: 33.3333%;
        flex-shrink: 0;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        display: block;
    }

    .pustaka-detail-wrapper .slider-dots {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 25px;
    }
    
    .pustaka-detail-wrapper .slider-dots .dot {
        width: 10px;
        height: 10px;
        background-color: #ccc;
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    
    .pustaka-detail-wrapper .slider-dots .dot:hover,
    .pustaka-detail-wrapper .slider-dots .dot.active {
        background-color: #b70d0f;
    }

    /* Ikon sudut pada gambar */
    .pustaka-detail-wrapper .icon-corner {
        position: absolute;
        width: 24px;
        height: 24px;
        color: #888;
        cursor: pointer;
    }
    .pustaka-detail-wrapper .icon-bookmark { top: 20px; right: 20px; }
    .pustaka-detail-wrapper .icon-expand { bottom: 20px; right: 20px; }

    /* Tombol Aksi di Bawah Gambar */
    .pustaka-detail-wrapper .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 100%;
        max-width: 400px;
    }

    .pustaka-detail-wrapper .btn-pill {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 16px;
        border: 1px solid var(--border-color);
        border-radius: 17px;
        white-space: nowrap;
        background-color: #fff;
        color: var(--text-dark);
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .pustaka-detail-wrapper .btn-pill:hover { background-color: #f9f9f9; }
    .pustaka-detail-wrapper .btn-pill svg { width: 16px; height: 16px; }

    .pustaka-detail-wrapper .action-row-2 {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    .pustaka-detail-wrapper .action-row-2 .btn-pill { flex: 1 1 auto; }

    /* Kolom Kanan (Detail Info & Accordion) */
    .pustaka-detail-wrapper .product-right {
        flex: 1;
    }

    .pustaka-detail-wrapper .book-title {
        font-family: var(--font-serif);
        font-size: 2.2rem;
        font-weight: normal;
        margin-bottom: 5px;
        line-height: 1.2;
    }

    .pustaka-detail-wrapper .book-type-price-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .pustaka-detail-wrapper .book-type {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-bottom: 0;
    }

    .pustaka-detail-wrapper .book-price {
        font-size: 0.85rem;
        font-family: var(--font-sans);
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0;
    }

    .pustaka-detail-wrapper .book-author-line {
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 25px;
    }

    .pustaka-detail-wrapper .book-description {
        font-size: 0.95rem;
        line-height: 1.6;
        color: var(--text-dark);
        margin-bottom: 40px;
    }

    .pustaka-detail-wrapper .author-name { font-weight: 600; }

    .pustaka-detail-wrapper .badge-tour {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        background-color: #f0f0f0;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .pustaka-detail-wrapper .badge-tour svg { width: 12px; height: 12px; }

    .pustaka-detail-wrapper .divider-line {
        color: #ccc;
        margin: 0 5px;
    }

    .pustaka-detail-wrapper .action-buttons-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .pustaka-detail-wrapper .btn-share {
        background: transparent;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 5px;
        color: var(--text-dark);
        font-family: var(--font-sans);
        transition: color 0.3s;
    }

    .pustaka-detail-wrapper .btn-share:hover {
        color: var(--red-brand);
    }

    .pustaka-detail-wrapper .share-popup {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
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
    .pustaka-detail-wrapper .share-popup.active {
        display: flex;
    }
    .pustaka-detail-wrapper .share-popup a {
        text-decoration: none;
        color: #1a1a1a;
        font-family: var(--font-sans);
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px;
        border-radius: 4px;
        transition: background 0.3s;
    }
    .pustaka-detail-wrapper .share-popup a:hover {
        background: #f0f0f0;
    }

    /* --- ACCORDION (DROPDOWN FORMAT BUKU) --- */
    .pustaka-detail-wrapper .accordion-container {
        border-top: 1px solid var(--border-color);
    }

    .pustaka-detail-wrapper .accordion-item {
        border-bottom: 1px solid var(--border-color);
        background-color: #ffffffff;
        transition: all 0.3s ease;
    }

    /* Saat Aktif (Hardcover) */
    .pustaka-detail-wrapper .accordion-item.active {
        border: 1px solid var(--border-color);
        border-radius: 4px;
        margin: 15px 0; /* Memberi jarak saat terbuka seperti di gambar */
        background-color: #ffffffff; /* Sedikit beda background agar menonjol */
    }

    .pustaka-detail-wrapper .accordion-header {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        background: none;
        border: none;
        font-size: 0.95rem;
        color: var(--text-dark);
        cursor: pointer;
        text-align: left;
    }

    .pustaka-detail-wrapper .accordion-item.active .accordion-header {
        padding: 15px 20px;
        font-weight: 600;
    }

    .pustaka-detail-wrapper .icon-toggle {
        font-size: 1.2rem;
        color: var(--text-light);
        font-weight: 300;
    }

    .pustaka-detail-wrapper .accordion-content {
        display: none;
        padding: 0 20px 20px 20px;
    }

    .pustaka-detail-wrapper .accordion-item.active .accordion-content {
        display: block;
    }
    .accordion-item p{
        font-size: 0.95rem;
        line-height: 1.6;
        color: var(--text-dark);
    }
    

    .pustaka-detail-wrapper .book-detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-top: 15px;
    }
    .pustaka-detail-wrapper .book-detail-grid .detail-item {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 12px 16px;
        background-color: #fcfcfc;
        border: 1px solid #f0f0f0;
        border-radius: 8px;
        transition: all 0.2s ease;
        font-family: var(--font-sans);
    }
    .pustaka-detail-wrapper .book-detail-grid .detail-item:hover {
        background-color: #fff;
        border-color: #e2e2e2;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        transform: translateY(-2px);
    }
    .pustaka-detail-wrapper .book-detail-grid .detail-label {
        font-size: 0.75rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 600;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .pustaka-detail-wrapper .book-detail-grid .detail-value {
        font-size: 0.95rem;
        color: var(--text-dark);
        font-weight: 700;
    }
    @media (max-width: 600px) {
        .pustaka-detail-wrapper .book-detail-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Isi dalam Accordion Hardcover */
    .pustaka-detail-wrapper .format-price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .pustaka-detail-wrapper .format-price-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .pustaka-detail-wrapper .format-name { font-weight: bold; font-size: 1rem; }
    .pustaka-detail-wrapper .format-price { font-size: 1.1rem; }
    
    .pustaka-detail-wrapper .publish-info {
        font-size: 0.8rem;
        color: var(--text-light);
        margin-bottom: 25px;
    }

    .pustaka-detail-wrapper .btn-add-to-cart {
        padding: 10px 25px;
        background-color: transparent;
        border: 2px solid var(--red-brand);
        color: var(--red-brand);
        font-weight: bold;
        font-size: 0.85rem;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .pustaka-detail-wrapper .btn-add-to-cart:hover {
        background-color: var(--red-brand);
        color: #fff;
    }

    .pustaka-detail-wrapper .retailers-section p {
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .pustaka-detail-wrapper .retailers-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .pustaka-detail-wrapper .btn-retailer {
        padding: 8px 14px;
        border: 1px solid var(--border-color);
        background-color: #fff;
        font-size: 0.8rem;
        border-radius: 4px;
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .pustaka-detail-wrapper .btn-retailer:hover { border-color: #aaa; }


    /* --- RECOMMENDATION SECTION (BOTTOM) --- */
    .pustaka-detail-wrapper .recommendation-section {
        border-top: 1px solid var(--border-color);
        padding-top: 60px;
    }

    .pustaka-detail-wrapper .section-title {
        font-family: var(--font-serif);
        font-size: 1.8rem;
        text-align: center;
        margin-bottom: 40px;
        font-weight: normal;
    }

    .pustaka-detail-wrapper .carousel {
        display: flex;
        gap: 20px;
        position: relative;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding-bottom: 20px;
    }

    /* Menyembunyikan scrollbar agar estetis */
    .pustaka-detail-wrapper .carousel::-webkit-scrollbar { display: none; }
    .pustaka-detail-wrapper .carousel { -ms-overflow-style: none; scrollbar-width: none; }

    .pustaka-detail-wrapper .book-card {
        flex: 0 0 calc(25% - 15px); /* Menampilkan 4 item per baris */
        min-width: 200px;
        display: flex;
        flex-direction: column;
    }

    .pustaka-detail-wrapper .book-card-image {
        background-color: var(--bg-gray);
        padding: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 15px;
        aspect-ratio: 3/4;
    }

    .pustaka-detail-wrapper .book-card-image img {
        width: 100%;
        height: auto;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .pustaka-detail-wrapper .book-card-title {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 2px;
        line-height: 1.3;
    }

    .pustaka-detail-wrapper .book-card-author {
        font-size: 0.85rem;
        margin-bottom: 2px;
    }

    .pustaka-detail-wrapper .book-card-format {
        font-size: 0.8rem;
        color: var(--text-light);
    }

    .pustaka-detail-wrapper .book-card-price {
        font-size: 0.9rem;
        font-weight: 600;
        margin-top: 2px;
    }

    /* Tombol Navigasi Carousel */
    .pustaka-detail-wrapper .carousel-nav-left,
    .pustaka-detail-wrapper .carousel-nav-right {
        position: absolute;
        top: 40%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background-color: #fff;
        border: 1px solid var(--border-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        z-index: 10;
        transition: background-color 0.2s;
    }
    .pustaka-detail-wrapper .carousel-nav-left:hover,
    .pustaka-detail-wrapper .carousel-nav-right:hover {
        background-color: #f0f0f0;
    }
    .pustaka-detail-wrapper .carousel-nav-left { left: -15px; }
    .pustaka-detail-wrapper .carousel-nav-right { right: -15px; }

    /* --- RESPONSIVE DESIGN --- */
    @media (max-width: 900px) {
        .pustaka-detail-wrapper .product-section {
            flex-direction: column;
            gap: 30px;
        }
        .pustaka-detail-wrapper .product-left, .pustaka-detail-wrapper .product-right {
            flex: 1;
            width: 100%;
        }
        .pustaka-detail-wrapper .book-card {
            flex: 0 0 calc(33.33% - 15px);
        }
    }

    @media (max-width: 600px) {
        .pustaka-detail-wrapper .book-card {
            flex: 0 0 calc(50% - 10px);
        }
        .pustaka-detail-wrapper .format-price-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        .pustaka-detail-wrapper .btn-add-to-cart { width: 100%; }
    }
</style>

<div class="pustaka-detail-wrapper">
    <div class="container">

        <!-- BAGIAN ATAS: DETAIL PRODUK -->
        <section class="product-section">
            
            <!-- Kolom Kiri: Gambar Utama & Aksi -->
            <div class="product-left">
                <div class="image-wrapper">
                    

                    <div class="slider-container">
                        <div class="slider-track" id="mainBookSlider">
                            @php
                                $images = [];
                                if($pustaka->gambar_1) $images[] = $pustaka->gambar_1;
                                if($pustaka->gambar_2) $images[] = $pustaka->gambar_2;
                                if($pustaka->gambar_3) $images[] = $pustaka->gambar_3;
                            @endphp
                            
                            @if(count($images) > 0)
                                @foreach($images as $img)
                                <img src="{{ asset('img/' . $img) }}" alt="Buku Slide" class="main-book-cover">
                                @endforeach
                            @else
                                <img src="https://picsum.photos/seed/{{ $pustaka->id }}/400/600" alt="Buku Slide" class="main-book-cover">
                            @endif
                        </div>
                    </div>

                    <!-- Dots Pagination -->
                    <div class="slider-dots">
                        @if(count($images) > 0)
                            @foreach($images as $index => $img)
                            <span class="dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})"></span>
                            @endforeach
                        @else
                            <span class="dot active" onclick="goToSlide(0)"></span>
                        @endif
                    </div>
                    
                
                </div>

                <!-- Tombol Aksi -->
                <div class="action-buttons">
                    <div class="action-row-2">
                        @if($pustaka->link_vidio_produk)
                        <a href="{{ $pustaka->link_vidio_produk }}" target="_blank" class="btn-pill" style="text-decoration:none;">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            Vidio Produk
                        </a>
                        @endif
                        
                        @if($pustaka->file_pdf)
                            @if(isset($hasAccess) && $hasAccess)
                            <a href="{{ route('pustaka.baca', $pustaka->slug) }}" target="_blank" class="btn-pill" style="text-decoration:none; background-color: #111; color: #fff; border-color: #111; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#333'; this.style.borderColor='#333';" onmouseout="this.style.backgroundColor='#111'; this.style.borderColor='#111';">
                                UNDUH PDF <i class="fas fa-arrow-down" style="font-size: 0.8rem; margin-left: 4px;"></i>
                            </a>
                            @else
                            <a href="{{ route('pustaka.beli', $pustaka->slug) }}" class="btn-pill" style="text-decoration:none;">
                                Beli
                            </a>
                            @endif
                        @endif

                        @if($pustaka->file_pdf_preview)
                        <a href="{{ asset('pdf/pustaka/' . $pustaka->file_pdf_preview) }}" target="_blank" class="btn-pill" style="text-decoration:none; background-color: transparent; border-color: #111; color: #111;">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                            PREVIEW PDF
                        </a>
                        @endif

                            @php
                                $inCart = false;
                                if(Auth::guard('pengguna')->check()) {
                                    $inCart = \App\Models\CartItem::where('pengguna_id', Auth::guard('pengguna')->id())
                                        ->where('item_type', 'pustaka')
                                        ->where('item_id', $pustaka->id)
                                        ->exists();
                                }
                            @endphp
                            <button class="btn-pill btn-keranjang-pustaka"
                                onclick="addToCart('pustaka', {{ $pustaka->id }})"
                                id="btn-cart-pustaka-{{ $pustaka->id }}"
                                style="background:{{ $inCart ? '#ffebee' : '#fff' }};color:{{ $inCart ? '#dc3545' : '#111' }};border:1.5px solid {{ $inCart ? '#ef9a9a' : '#111' }};cursor:pointer; transition:all 0.3s ease; font-weight:600; box-shadow:0 4px 15px rgba(0,0,0,0.08);">
                                <i class="fas fa-shopping-cart" style="font-size: 0.9rem;"></i> <span class="cart-text">{{ $inCart ? 'Hapus dari Keranjang' : 'Keranjang' }}</span>
                            </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Informasi Produk & Accordion -->
            <div class="product-right">
                <h1 class="book-title">{{ $pustaka->judul }}</h1>
                <div class="book-type-price-wrapper">
                    <p class="book-type">{{ $pustaka->tipe_buku ?? 'A Novel' }}</p>
                    @if($pustaka->harga)
                    <span class="divider-line">|</span>
                    <p class="book-price">Rp {{ number_format($pustaka->harga, 0, ',', '.') }}</p>
                    @endif
                </div>
                
                <div class="book-author-line">
                    <span>By <a href="#" class="author-name">{{ $pustaka->penulis->nama ?? 'Penulis Tidak Diketahui' }}</a></span>
                    @if($pustaka->is_on_tour)
                    <span class="badge-tour">
                        <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                        On Tour
                    </span>
                    @endif
                    
                    <span class="divider-line">|</span>
                    
                    <div class="action-buttons-container">
                        <button class="btn-share" onclick="document.getElementById('sharePopup').classList.toggle('active')">
                            <i class="fas fa-share"></i> Share
                        </button>
                        <div class="share-popup" id="sharePopup">
                            <a href="https://api.whatsapp.com/send?text={{ urlencode(($pustaka->judul) . ' ' . url()->current()) }}" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                            <a href="https://x.com/intent/tweet?text={{ urlencode($pustaka->judul) }}&url={{ urlencode(url()->current()) }}" target="_blank"><i class="fa-brands fa-x-twitter"></i> X</a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a>
                        </div>
                    </div>
                </div>

                <div class="book-description">
                    <p>{!! nl2br(e($pustaka->deskripsi)) !!}</p>
                </div>

                <!-- CONTAINER ACCORDION DROPDOWN -->
                <div class="accordion-container">
                    
                    <!-- Item 1: Paperback -->
                    <div class="accordion-item">
                        <button class="accordion-header">
                            Detail Buku <span class="icon-toggle">+</span>
                        </button>
                        <div class="accordion-content">
                            <div class="book-detail-grid">
                                @if($pustaka->penerbit)
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fal fa-building"></i> Penerbit</span> 
                                    <span class="detail-value">{{ $pustaka->penerbit }}</span>
                                </div>
                                @endif
                                @if($pustaka->isbn)
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fal fa-barcode"></i> ISBN</span> 
                                    <span class="detail-value">{{ $pustaka->isbn }}</span>
                                </div>
                                @endif
                                @if($pustaka->bahasa)
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fal fa-language"></i> Bahasa</span> 
                                    <span class="detail-value">{{ $pustaka->bahasa }}</span>
                                </div>
                                @endif
                                @if($pustaka->tanggal_terbit)
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fal fa-calendar-alt"></i> Tanggal Terbit</span> 
                                    <span class="detail-value">{{ \Carbon\Carbon::parse($pustaka->tanggal_terbit)->translatedFormat('d F Y') }}</span>
                                </div>
                                @endif
                                @if($pustaka->halaman)
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fal fa-file-alt"></i> Halaman</span> 
                                    <span class="detail-value">{{ $pustaka->halaman }} Halaman</span>
                                </div>
                                @endif
                                @if($pustaka->format_buku)
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fal fa-book"></i> Format Buku</span> 
                                    <span class="detail-value">{{ $pustaka->format_buku }}</span>
                                </div>
                                @endif
                                @if($pustaka->ukuran)
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fal fa-ruler-combined"></i> Ukuran</span> 
                                    <span class="detail-value">{{ $pustaka->ukuran }} cm</span>
                                </div>
                                @endif
                                @if($pustaka->berat)
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fal fa-weight"></i> Berat</span> 
                                    <span class="detail-value">{{ $pustaka->berat }} gram</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Item 2: Hardcover (Default Aktif sesuai desain) -->
                    <div class="accordion-item active">
                        <button class="accordion-header">
                            Pembelian <span class="icon-toggle">-</span>
                        </button>
                        <div class="accordion-content">
                            @if($pustaka->tanggal_terbit || $pustaka->halaman)
                            <p class="publish-info">Published on {{ $pustaka->tanggal_terbit ? \Carbon\Carbon::parse($pustaka->tanggal_terbit)->translatedFormat('d F Y') : '-' }} | {{ $pustaka->halaman ?? '-' }} Pages</p>
                            @endif
                            
                            <div class="retailers-section">
                                <p>Buku Tersedia dan Dapat Dibeli:</p>
                                <div class="retailers-grid">
                                    @php
                                        $wa_number = $pustaka->nomor_wa;
                                        if ($wa_number) {
                                            $wa_number = preg_replace('/[^0-9]/', '', $wa_number);
                                            if (str_starts_with($wa_number, '0')) {
                                                $wa_number = '62' . substr($wa_number, 1);
                                            }
                                        }
                                    @endphp
                                    @if($wa_number)
                                    <button class="btn-retailer" onclick="window.open('https://wa.me/{{ $wa_number }}', '_blank')"><i class="fab fa-whatsapp" style="margin-right: 5px;"></i> WhatsApp</button>
                                    @endif
                                    
                                    @if($pustaka->link_tokopedia)
                                    <button class="btn-retailer" onclick="window.open('{{ $pustaka->link_tokopedia }}', '_blank')">Tokopedia</button>
                                    @endif
                                    @if($pustaka->link_shopee)
                                    <button class="btn-retailer" onclick="window.open('{{ $pustaka->link_shopee }}', '_blank')">Shopee</button>
                                    @endif
                                    @if($pustaka->link_instagram)
                                    <button class="btn-retailer" onclick="window.open('{{ $pustaka->link_instagram }}', '_blank')">Instagram</button>
                                    @endif
                                    @if($pustaka->link_tiktok)
                                    <button class="btn-retailer" onclick="window.open('{{ $pustaka->link_tiktok }}', '_blank')">Tiktok</button>
                                    @endif
                                    @if($pustaka->link_coffeesophia)
                                    <button class="btn-retailer" onclick="window.open('{{ $pustaka->link_coffeesophia }}', '_blank')">Coffeesophia</button>
                                    @endif
                                    @if($pustaka->link_togamas)
                                    <button class="btn-retailer" onclick="window.open('{{ $pustaka->link_togamas }}', '_blank')">Togamas</button>
                                    @endif
                                    @if($pustaka->link_ebook)
                                    <button class="btn-retailer" onclick="window.open('{{ $pustaka->link_ebook }}', '_blank')">Ebook</button>
                                    @endif
                                    @if($pustaka->file_pdf)
                                        @if(isset($hasAccess) && $hasAccess)
                                        <button class="btn-retailer" onclick="window.open('{{ route('pustaka.baca', $pustaka->slug) }}', '_blank')">PDF</button>
                                        @else
                                        <button class="btn-retailer" onclick="window.location='{{ route('pustaka.beli', $pustaka->slug) }}'">PDF</button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($pustaka->tentang_pengarang || ($pustaka->penulis && $pustaka->penulis->profil))
                    <div class="accordion-item">
                        <button class="accordion-header">
                            Tentang Pengarang <span class="icon-toggle">+</span>
                        </button>
                        <div class="accordion-content">
                            <p>{!! nl2br(e($pustaka->tentang_pengarang ?: ($pustaka->penulis->profil ?? '')) ) !!}</p>
                        </div>
                    </div>
                    @endif

                    @if($pustaka->ulasan)
                    <div class="accordion-item">
                        <button class="accordion-header">
                            Ulasan <span class="icon-toggle">+</span>
                        </button>
                        <div class="accordion-content">
                            <p>{!! nl2br(e($pustaka->ulasan)) !!}</p>
                        </div>
                    </div>
                    @endif

                </div> <!-- Tutup Accordion Container -->
            </div>

        </section>

        <!-- BAGIAN BAWAH: REKOMENDASI (YOU MAY ALSO LIKE) -->
        <section class="recommendation-section">
            <h2 class="section-title">You May Also Like</h2>
            
            <div style="position: relative;">
                <!-- Tombol Navigasi Kiri -->
                <div class="carousel-nav-left" id="recNavLeft">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </div>

                <!-- Grid/Carousel Container -->
                <div class="carousel" id="recCarousel">
                    @foreach(\App\Models\Pustaka::where('id', '!=', $pustaka->id)->inRandomOrder()->limit(12)->get() as $rec)
                    <div class="book-card" onclick="window.location='{{ route('pustaka.detail', $rec->slug) }}'" style="cursor: pointer;">
                        <div class="book-card-image">
                            @if($rec->gambar_1)
                            <img src="{{ asset('img/' . $rec->gambar_1) }}" alt="{{ $rec->judul }}">
                            @else
                            <img src="https://picsum.photos/seed/{{ $rec->id }}/200/300" alt="{{ $rec->judul }}">
                            @endif
                        </div>
                        <h3 class="book-card-title">{{ Str::limit($rec->judul, 20) }}</h3>
                        <p class="book-card-author">{{ $rec->penulis->nama ?? 'Penulis Tidak Diketahui' }}</p>
                        <p class="book-card-format">{{ $rec->format_buku ?? 'Soft Cover' }}</p>
                        @if($rec->harga)
                        <p class="book-card-price">Rp {{ number_format($rec->harga, 0, ',', '.') }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>

                <!-- Tombol Navigasi Kanan -->
                <div class="carousel-nav-right" id="recNavRight">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </div>
            </div>
        </section>

    </div>
</div>

<!-- --- JAVASCRIPT UNTUK ACCORDION DROPDOWN --- -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const accordionHeaders = document.querySelectorAll('.accordion-header');

        accordionHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const currentItem = this.parentElement;
                const isActive = currentItem.classList.contains('active');
                
                // Tutup semua accordion terlebih dahulu
                document.querySelectorAll('.accordion-item').forEach(item => {
                    item.classList.remove('active');
                    // Reset ikon ke '+'
                    const icon = item.querySelector('.icon-toggle');
                    if(icon) icon.textContent = '+';
                });

                // Jika item yang diklik sebelumnya tidak aktif, buka (tambahkan class active)
                if (!isActive) {
                    currentItem.classList.add('active');
                    // Ubah ikon ke '-'
                    const icon = currentItem.querySelector('.icon-toggle');
                    if(icon) icon.textContent = '-';
                }
            });
        });

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

        // Global slider function
        window.goToSlide = function(index) {
            const track = document.getElementById('mainBookSlider');
            const dots = document.querySelectorAll('.slider-dots .dot');
            if(track) {
                // Move track (-0%, -33.3333%, -66.6666%)
                track.style.transform = `translateX(-${index * 33.3333}%)`;
                // Update dots
                dots.forEach((dot, i) => {
                    if(i === index) dot.classList.add('active');
                    else dot.classList.remove('active');
                });
            }
        };

        // Recommendation Carousel Navigation
        const recCarousel = document.getElementById('recCarousel');
        const recNavLeft = document.getElementById('recNavLeft');
        const recNavRight = document.getElementById('recNavRight');

        if (recCarousel && recNavLeft && recNavRight) {
            recNavRight.addEventListener('click', () => {
                recCarousel.scrollBy({ left: 300, behavior: 'smooth' });
            });
            recNavLeft.addEventListener('click', () => {
                recCarousel.scrollBy({ left: -300, behavior: 'smooth' });
            });
        }
    });
</script>

<script>
function addToCart(itemType, itemId) {
    const btn = document.getElementById('btn-cart-' + itemType + '-' + itemId);
    if (btn) {
        btn.disabled = true;
        let isRemoving = btn.textContent.includes('Hapus');
        btn.querySelector('.cart-text').innerHTML = isRemoving ? 'Menghapus...' : 'Menambahkan...';
        btn.style.transform = 'scale(0.95)';
    }

    fetch('/keranjang/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
        body: JSON.stringify({ item_type: itemType, item_id: itemId })
    })
    .then(r => {
        if (r.status === 401) {
            window.location = '/signin';
            return null;
        }
        return r.json();
    })
    .then(data => {
        if (!data) return;
        if (btn) {
            btn.disabled = false;
            btn.style.transform = 'scale(1)';
        }
        
        if (data.status === 'success') {
            if (data.action === 'added') {
                if (btn) {
                    btn.querySelector('.cart-text').innerHTML = 'Hapus dari Keranjang';
                    btn.style.background = '#ffebee';
                    btn.style.color = '#dc3545';
                    btn.style.borderColor = '#ef9a9a';
                }
            } else if (data.action === 'removed') {
                if (btn) {
                    btn.querySelector('.cart-text').innerHTML = 'Keranjang';
                    btn.style.background = '#fff';
                    btn.style.color = '#111';
                    btn.style.borderColor = '#111';
                }
            }
            updateCartBadge(data.cartCount);
        } else if (data.status === 'owned') {
            if (btn) { btn.querySelector('.cart-text').innerHTML = 'Dimiliki'; btn.disabled = true; }
            setTimeout(() => { window.location.reload(); }, 800);
        } else {
            if (btn) { btn.querySelector('.cart-text').innerHTML = 'Keranjang'; }
        }
    })
    .catch(() => {
        if (btn) { 
            btn.disabled = false; 
            btn.style.transform = 'scale(1)';
            btn.querySelector('.cart-text').innerHTML = 'Keranjang'; 
        }
    });
}

function showCartToast(message, type) {
    let toast = document.getElementById('cart-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'cart-toast';
        toast.style.cssText = 'position:fixed;bottom:30px;right:30px;z-index:9999;padding:14px 22px;border-radius:10px;font-family:Open Sans,sans-serif;font-size:14px;font-weight:600;box-shadow:0 4px 24px rgba(0,0,0,0.15);transition:opacity 0.4s,transform 0.4s;opacity:0;transform:translateY(10px);max-width:320px;';
        document.body.appendChild(toast);
    }
    const colors = { success: ['#e8f5e9','#2e7d32'], info: ['#e3f2fd','#1565c0'], error: ['#ffebee','#b71c1c'] };
    const [bg, color] = colors[type] || colors.info;
    toast.style.background = bg;
    toast.style.color = color;
    toast.innerHTML = message;
    toast.style.opacity = '1';
    toast.style.transform = 'translateY(0)';
    clearTimeout(toast._timeout);
    toast._timeout = setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
    }, 3500);
}

function updateCartBadge(count) {
    const badges = document.querySelectorAll('.cart-badge, #floating-cart-badge');
    badges.forEach(b => {
        b.textContent = count;
        b.style.display = count > 0 ? 'inline-flex' : 'none';
    });
    
    // Also toggle the floating button visibility based on whether we have items
    const floatBtn = document.getElementById('floating-cart-btn');
    if (floatBtn) {
        floatBtn.style.display = count > 0 ? 'flex' : 'none';
    }
}
</script>
@endsection
