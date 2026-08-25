@extends('layouts.app')

@section('content')
<style>
    /* =========================================
       PROSA PAGE — Editorial Magazine
       ========================================= */
    #prosa-page {
        width: 100%;
        height: fit-content;
        padding: 100px 0 0;
        background: #fff;
    }

    /* ─── CONTAINER ─── */
    #prosa-page .prosa-wrap {
        width: 88%;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ✨✨✨ PAGE HEADER ✨✨✨ */
    .prosa-page-header {
        border-top: 3px solid #111;
        padding-top: 18px;
        border-bottom: 3px solid #111;
        padding-bottom: 18px;
        margin-bottom: 48px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .prosa-page-header h1 {
        font-family: var(--font-serif);
        font-size: 3rem;
        font-weight: bold;
        color: #111;
        letter-spacing: -1px;
        margin: 0;
        line-height: 1;
    }
    .prosa-page-header p {
        font-family: var(--font-sans);
        font-size: 1rem;
        color: #888;
        margin: 0;
    }

    /* ─── FEATURED (head: 1 artikel utama) ─── */
    .prosa-featured {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
        margin-bottom: 56px;
        border: 1px solid #e8e8e8;
        overflow: hidden;
    }
    .prosa-featured-img {
        position: relative;
        height: 420px;
        overflow: hidden;
    }
    .prosa-featured-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }
    .prosa-featured-img:hover img {
        transform: scale(1.03);
    }
    .prosa-featured-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 48px 40px;
        background: #fff;
    }
    .prosa-label {
        font-family: var(--font-sans);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #e03a3c;
        margin-bottom: 16px;
    }
    .prosa-featured-title {
        font-family: var(--font-serif);
        font-size: 2.4rem;
        font-weight: bold;
        color: #111;
        line-height: 1.15;
        margin-bottom: 18px;
        text-decoration: none;
        display: block;
        transition: color 0.15s;
    }
    .prosa-featured-title:hover { color: #e03a3c; text-decoration: none; }
    .prosa-featured-excerpt {
        font-family: var(--font-sans);
        font-size: 0.95rem;
        color: #666;
        line-height: 1.7;
        margin-bottom: 28px;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .prosa-read-more {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: var(--font-sans);
        font-size: 0.9rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #111;
        text-decoration: none;
        border-bottom: 2px solid #111;
        padding-bottom: 3px;
        width: fit-content;
        transition: color 0.15s, border-color 0.15s;
    }
    .prosa-read-more:hover { color: #e03a3c; border-color: #e03a3c; text-decoration: none; }
    .prosa-read-more i { font-size: 0.75rem; }

    /* ─── AUTHOR meta ─── */
    .prosa-meta {
        font-family: var(--font-sans);
        font-size: 0.85rem;
        color: #aaa;
        margin-bottom: 12px;
    }
    .prosa-meta strong { color: #555; }

    /* ─── SECTION DIVIDER ─── */
    .prosa-section-title {
        font-family: var(--font-sans);
        font-size: 1.1rem;
        font-weight: bold;
        color: #111;
        letter-spacing: 1px;
        text-transform: uppercase;
        border-top: 3px solid #111;
        padding-top: 16px;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .prosa-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e8e8e8;
    }

    /* ─── BODY LAYOUT: main + sidebar ─── */
    .prosa-body-layout {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 48px;
        align-items: start;
        margin-bottom: 60px;
    }

    /* ─── ARTICLE GRID (body) ─── */
    .prosa-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 32px 28px;
    }
    .prosa-card {
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
    }
    .prosa-card:hover { text-decoration: none; color: inherit; }
    .prosa-card-img {
        width: 100%;
        height: 220px;
        overflow: hidden;
        margin-bottom: 16px;
        background: #f5f5f5;
    }
    .prosa-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.35s ease;
    }
    .prosa-card:hover .prosa-card-img img {
        transform: scale(1.05);
    }
    .prosa-card-label {
        font-family: var(--font-sans);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #e03a3c;
        margin-bottom: 8px;
    }
    .prosa-card-title {
        font-family: var(--font-serif);
        font-size: 1.3rem;
        font-weight: bold;
        color: #111;
        line-height: 1.25;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.15s;
    }
    .prosa-card:hover .prosa-card-title { color: #e03a3c; }
    .prosa-card-meta {
        font-family: var(--font-sans);
        font-size: 0.8rem;
        color: #bbb;
        margin-top: 4px;
    }

    /* ─── SIDEBAR ─── */
    .prosa-sidebar {
        position: sticky;
        top: 100px;
    }
    .prosa-sidebar-title {
        font-family: var(--font-sans);
        font-size: 1.2rem;
        font-weight: bold;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #111;
        border-bottom: 1px solid #c4c3c3ff;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .prosa-sidebar-ad {
        display: block;
        text-decoration: none;
        overflow: hidden;
        position: relative;
        background: #fff;
        width: 90%;
        border-left: 5px solid transparent;
        transition: border-color 0.4s ease;
    }
    .prosa-sidebar-ad:hover {
        border-left-color: #e03a3c;
    }
    .prosa-sidebar-ad::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 55%;
        background: linear-gradient(to top, rgba(0,0,0,0.88) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0) 100%);
        opacity: 0;
        transform: translateY(8px);
        transition: opacity 0.4s ease, transform 0.4s ease;
        pointer-events: none;
    }
    .prosa-sidebar-ad:hover::after {
        opacity: 1;
        transform: translateY(0);
    }
    .prosa-sidebar-cta {
        position: absolute;
        bottom: 24px;
        left: 18px;
        color: #fff;
        font-family: var(--font-sans);
        font-size: 0.95rem;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        text-shadow: 0 2px 8px rgba(0,0,0,0.6);
        opacity: 0;
        transform: translateY(14px);
        transition: opacity 0.4s ease 0.05s, transform 0.4s ease 0.05s;
        pointer-events: none;
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 2;
    }
    .prosa-sidebar-cta::after {
        content: '→';
        display: inline-block;
        transition: transform 0.3s ease;
    }
    .prosa-sidebar-ad:hover .prosa-sidebar-cta {
        opacity: 1;
        transform: translateY(0);
    }
    .prosa-sidebar-ad:hover .prosa-sidebar-cta::after {
        transform: translateX(4px);
    }
    .prosa-sidebar-ad img {
        width: 100%;
        height: 450px;
        object-fit: cover;
        display: block;
        transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .prosa-sidebar-ad:hover img {
        transform: scale(1.05);
    }

    /* ─── EMPTY STATE ─── */
    .prosa-empty {
        text-align: center;
        padding: 80px 20px;
        color: #ccc;
        font-family: var(--font-sans);
    }
    .prosa-empty i { font-size: 3rem; display: block; margin-bottom: 16px; }

    /* ─── FOOTER STORIES (list below grid) ─── */
    .prosa-list {
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    .prosa-list-item {
        display: flex;
        gap: 24px;
        align-items: flex-start;
        padding: 24px 0;
        border-top: 1px solid #eee;
        text-decoration: none;
        color: inherit;
    }
    .prosa-list-item:first-child { border-top: none; }
    .prosa-list-item:hover { text-decoration: none; color: inherit; }
    .prosa-list-img {
        flex-shrink: 0;
        width: 400px;
        height: 200px;
        overflow: hidden;
    }
    .prosa-list-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }
    .prosa-list-item:hover .prosa-list-img img { transform: scale(1.05); }
    .prosa-list-body { flex: 1; }
    .prosa-list-title {
        font-family: var(--font-serif);
        font-size: 1.3rem;
        font-weight: bold;
        color: #111;
        line-height: 1.3;
        margin-bottom: 4px;
        max-width: 650px;
        transition: color 0.15s;
    }
    .prosa-list-item:hover .prosa-list-title { color: #e03a3c; }
    .prosa-list-meta {
        font-family: var(--font-sans);
        font-size: 0.8rem;
        color: #bbb;
        margin-top: 4px;
    }

    /* Cerita Kota: layout list + sidebar */
    .prosa-cerita-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 70px;
        align-items: start;
        margin-bottom: 60px;
    }

    /* Cerita Kota: gambar item lebih kecil agar terasa padat */
    .prosa-list-img {
        flex-shrink: 0;
        width: 300px;
        height: 150px;
        overflow: hidden;
    }

    /* ─── PAGINATION ─── */
    .cat-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        padding: 40px 0 20px;
        border-top: 1px solid #eee;
        margin-top: 20px;
    }
    .cat-page-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: var(--font-sans);
        font-size: 0.85rem;
        font-weight: bold;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #111;
        text-decoration: none;
        background: none;
        border: none;
        border-bottom: 2px solid #111;
        padding: 0 0 2px 0;
        cursor: pointer;
        transition: color 0.2s, border-color 0.2s;
    }
    .cat-page-btn:hover {
        color: #e03a3c;
        border-color: #e03a3c;
        text-decoration: none;
    }
    .cat-page-btn.disabled {
        color: #ccc;
        border-color: #eee;
        pointer-events: none;
        cursor: default;
    }
    .cat-page-info {
        font-family: var(--font-sans);
        font-size: 0.8rem;
        color: #888;
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 1024px) {
        .prosa-body-layout { grid-template-columns: 1fr 240px; gap: 32px; }
    }
    @media (max-width: 900px) {
        .prosa-featured { grid-template-columns: 1fr; }
        .prosa-featured-img { height: 280px; }
        .prosa-featured-body { padding: 28px 24px; }
        .prosa-body-layout { grid-template-columns: 1fr; }
        .prosa-sidebar { position: static; }
        .prosa-grid { grid-template-columns: repeat(2, 1fr); gap: 24px 20px; }
    }
    @media (max-width: 600px) {
        #prosa-page { padding: 80px 0 40px; }
        .prosa-page-header h1 { font-size: 2rem; }
        .prosa-grid { grid-template-columns: 1fr; }
        .prosa-list-img { width: 100px; height: 80px; }
    }
</style>

<section id="prosa-page">
    <div class="prosa-wrap">

        {{-- ✨✨✨ PAGE HEADER ✨✨✨ --}}
        <div class="prosa-page-header">
            <h1 style="margin-bottom: 0;">Prosa</h1>
            <div class="prosa-sponsors" style="display: flex; align-items: center; gap: 20px;">
                <img src="{{ asset('img/sponsor/images (1).png') }}" alt="Plan International" style="height: 55px; object-fit: contain;">
                <img src="{{ asset('img/sponsor/PT_Pertamina_Patra_Niaga.svg-1024x576.png') }}" alt="Pertamina" style="height: 55px; object-fit: contain;">
                <img src="{{ asset('img/sponsor/Logo GPJ-04.png') }}" alt="GTI" style="height: 55px; object-fit: contain;">
                <img src="{{ asset('img/sponsor/png LOGO (1).png') }}" alt="Perpustakaan Nasional" style="height: 55px; object-fit: contain;">
            </div>
        </div>

        {{-- ─── FEATURED ARTICLE (head: 1 artikel terbaru) ─── --}}
        @if($head->isNotEmpty())
        @php $featured = $head->first(); @endphp
        <article class="prosa-featured">
            <a href="{{ url('/artikel/'.$featured->slug) }}" class="prosa-featured-img">
                <img src="{{ asset('img/'.$featured->gambar_pertama) }}" alt="{{ $featured->judul }}">
            </a>
            <div class="prosa-featured-body">
                <p class="prosa-label">Prosa</p>
                @if($featured->penulis)
                <p class="prosa-meta">By <strong>{{ $featured->penulis->nama }}</strong></p>
                @endif
                <a href="{{ url('/artikel/'.$featured->slug) }}" class="prosa-featured-title">
                    {{ $featured->judul }}
                </a>
                @if($featured->sinopsis)
                <p class="prosa-featured-excerpt">{{ strip_tags($featured->sinopsis) }}</p>
                @endif
                <a href="{{ url('/artikel/'.$featured->slug) }}" class="prosa-read-more">
                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </article>
        @endif

        {{-- ─── ARTIKEL LAINNYA (body: grid 2 kolom) + SIDEBAR ─── --}}
        @if($body->isNotEmpty())
        <h2 class="prosa-section-title">Artikel Terbaru</h2>
        <div class="prosa-body-layout">

            {{-- Main: Grid 2 Kolom (max 4 artikel) --}}
            <div class="prosa-grid">
                @foreach($body->take(4) as $artikel)
                <a href="{{ url('/artikel/'.$artikel->slug) }}" class="prosa-card">
                    <div class="prosa-card-img">
                        <img src="{{ asset('img/'.$artikel->gambar_pertama) }}" alt="{{ $artikel->judul }}">
                    </div>
                    <p class="prosa-card-label">Prosa</p>
                    <h3 class="prosa-card-title">{{ $artikel->judul }}</h3>
                    @if($artikel->penulis)
                    <p class="prosa-card-meta">{{ $artikel->penulis->nama }}</p>
                    @endif
                </a>
                @endforeach
            </div>

            {{-- Advertisement Column (Sidebar) --}}
            <div class="prosa-advertisement" style="padding-left: 20px; border-left: 1px solid #eee;">
                <p style="font-family: monospace, Courier, sans-serif; color: #888; font-size: 13px; margin-bottom: 15px; letter-spacing: 0.5px;">Advertisement</p>
                <a href="#" target="_blank" style="display: block; width: 100%;">
                    <img src="{{ asset('img/sponsor/sponsor2.jpeg') }}" alt="Advertisement" style="width: 100%; height: auto; border-radius: 4px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                </a>
            </div>

        </div>
        @endif

        {{-- ─── LEBIH BANYAK DARI PROSA ─── --}}
        @if(isset($footer) && $footer->isNotEmpty())
        <style>
            .lbd-container {
                border-top: 1px solid #111;
                padding-top: 40px;
                display: grid;
                grid-template-columns: 250px 1fr;
                gap: 40px;
                margin-bottom: 20px;
            }
            .lbd-left {
                display: flex;
                flex-direction: column;
            }
            .lbd-title {
                font-family: var(--font-sans), 'Arial', sans-serif;
                font-size: 1rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 2px;
                line-height: 1.4;
                margin-bottom: 20px;
                color: #111;
            }
            .lbd-nav-buttons {
                display: flex;
                gap: 12px;
            }
            .lbd-nav-buttons button {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                border: none;
                background: #f4f4f4;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                color: #333;
                transition: background 0.3s;
            }
            .lbd-nav-buttons button:hover {
                background: #e0e0e0;
            }
            .lbd-right {
                display: flex;
                flex-direction: column;
                overflow: hidden;
            }
            .lbd-slider-wrapper {
                overflow: hidden;
                width: 100%;
                margin-bottom: 40px;
            }
            .lbd-slider-track {
                display: flex;
                gap: 20px;
                transition: transform 0.4s ease-in-out;
            }
            .lbd-card {
                flex: 0 0 calc(25% - 15px);
                max-width: calc(25% - 15px);
                box-sizing: border-box;
            }
            .lbd-card img {
                width: 100%;
                aspect-ratio: 4/3;
                object-fit: cover;
                border-radius: 4px;
                margin-bottom: 12px;
                transition: transform 0.3s;
            }
            .lbd-card a:hover img {
                transform: scale(1.05);
            }
            .lbd-card-title {
                font-family: var(--font-serif), 'Georgia', serif;
                font-size: 1.05rem;
                font-weight: 700;
                color: #111;
                margin-bottom: 8px;
                line-height: 1.3;
            }
            .lbd-card-meta {
                font-family: var(--font-sans), 'Arial', sans-serif;
                font-size: 0.65rem;
                font-weight: 700;
                color: #b70d0f;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .lbd-ad {
                width: 100%;
                background: #f8f8f8;
            }
            .lbd-ad img {
                width: 100%;
                height: auto;
            }
            @media (max-width: 992px) {
                .lbd-card { flex: 0 0 calc(33.333% - 13.33px); max-width: calc(33.333% - 13.33px); }
            }
            @media (max-width: 768px) {
                .lbd-container { grid-template-columns: 1fr; gap: 20px; }
                .lbd-nav-buttons { display: none; }
                .lbd-slider-wrapper { overflow-x: auto; scroll-snap-type: x mandatory; padding-bottom: 10px; }
                .lbd-slider-track { gap: 15px; }
                .lbd-card { flex: 0 0 calc(60% - 15px); max-width: calc(60% - 15px); scroll-snap-align: start; }
            }
            @media (max-width: 480px) {
                .lbd-card { flex: 0 0 calc(85% - 15px); max-width: calc(85% - 15px); }
            }
        </style>

        <div class="lbd-container">
            <div class="lbd-left">
                <h2 class="lbd-title">LEBIH BANYAK DARI<br>PROSA</h2>
                <div class="lbd-nav-buttons">
                    <button id="lbd-prev"><i class="fas fa-chevron-left" style="font-size: 12px;"></i></button>
                    <button id="lbd-next"><i class="fas fa-chevron-right" style="font-size: 12px;"></i></button>
                </div>
            </div>
            <div class="lbd-right">
                <div class="lbd-slider-wrapper">
                    <div class="lbd-slider-track" id="lbd-slider-track">
                        @foreach($footer as $story)
                        <div class="lbd-card">
                            <a href="{{ url('/artikel/'.$story->slug) }}" style="text-decoration: none;">
                                <div style="overflow: hidden; border-radius: 4px; margin-bottom: 12px;">
                                    <img src="{{ asset('img/'.$story->gambar_pertama) }}" alt="{{ $story->judul }}">
                                </div>
                                <h3 class="lbd-card-title">{{ $story->judul }}</h3>
                                <p class="lbd-card-meta">BY {{ $story->penulis->nama ?? 'GALERI BUKU JAKARTA' }}</p>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>


            </div>
        </div>
        @endif

        {{-- ─── EMPTY STATE ─── --}}
        @if($head->isEmpty() && $body->isEmpty())
        <div class="prosa-empty">
            <i class="fas fa-book-open"></i>
            <p>Belum ada artikel untuk rubrik Prosa.</p>
        </div>
        @endif

    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const track = document.getElementById("lbd-slider-track");
        const prevBtn = document.getElementById("lbd-prev");
        const nextBtn = document.getElementById("lbd-next");
        
        if(track && prevBtn && nextBtn) {
            let cards = track.querySelectorAll(".lbd-card");
            if (cards.length > 0) {
                let currentIndex = 0;
                
                function updateSlider() {
                    if (window.innerWidth <= 768) return;
                    const cardWidth = cards[0].offsetWidth;
                    const gap = 20;
                    const moveX = currentIndex * (cardWidth + gap);
                    track.style.transform = `translateX(-${moveX}px)`;
                }

                nextBtn.addEventListener("click", () => {
                    if (window.innerWidth <= 768) return;
                    const visibleCards = window.innerWidth > 992 ? 4 : 3;
                    const maxIndex = Math.max(0, cards.length - visibleCards);
                    if (currentIndex < maxIndex) {
                        currentIndex++;
                        updateSlider();
                    }
                });

                prevBtn.addEventListener("click", () => {
                    if (window.innerWidth <= 768) return;
                    if (currentIndex > 0) {
                        currentIndex--;
                        updateSlider();
                    }
                });

                window.addEventListener("resize", () => {
                    if (window.innerWidth <= 768) {
                        track.style.transform = 'none';
                    } else {
                        const visibleCards = window.innerWidth > 992 ? 4 : 3;
                        const maxIndex = Math.max(0, cards.length - visibleCards);
                        if (currentIndex > maxIndex) {
                            currentIndex = maxIndex;
                        }
                        updateSlider();
                    }
                });
            }
        }
    });
</script>
@endpush
