    @extends('layouts.app')

    @section('content')
        <section id="head">
            <div class="container">
                <div class="slide">
                    @foreach ($editorsChoice as $r)
                        <div class="item" style="background-image: url('{{ asset('img/'.$r->gambar_pertama) }}');">
                            <div class="content">
                                <a style="font-family: var(--font-serif);" class="name" href="{{ url('/artikel/'.$r->slug) }}">{{ $r->judul }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="button">
                    <a class="prev previous round"><i class="fa-solid fa-chevron-left"></i></a>
                    <a class="next round"><i class="fa-solid fa-chevron-right"></i></a>
                </div>
            </div>
        </section>

        <!-- content -->
        <section id="content">
            <div class="row">
                <ul>
                    <li><a style="font-family: var(--font-sans);" href="{{ route('home') }}">Home</a></li>
                    <li><a style="font-family: var(--font-sans);" href="{{ url('/page/buku') }}">Buku</a></li>
                    <li><a style="font-family: var(--font-sans);" href="{{ url('/page/fiksi') }}">Fiksi</a></li>
                    <li><a style="font-family: var(--font-sans);" href="{{ url('/page/gairah') }}">Gairah</a></li>
                    <li><a style="font-family: var(--font-sans);" href="{{ url('/page/pemikiran') }}">Pemikiran</a></li>
                    <li><a style="font-family: var(--font-sans);" href="{{ url('/page/coffeeshophia') }}">Coffeesophia</a></li>
                    <li><a style="font-family: var(--font-sans);" href="{{ url('/page/writingTips') }}">Writing Tips</a></li>
                    <li><a style="font-family: var(--font-sans);" href="{{ url('/page/inspirasi') }}">Inspirasi</a></li>
                    <li><a style="font-family: var(--font-sans);" href="{{ url('/page/jktplus') }}">Jakarta+</a></li>
                    <li><a style="font-family: var(--font-sans);" href="{{ url('/page/puisi') }}">Puisi</a></li>
                    <li><a style="font-family: var(--font-sans);" href="{{ url('/page/prosa') }}">Prosa</a></li>
                    <li><a style="font-family: var(--font-sans); color: red; font-weight: bold;" href="{{ route('donate') }}">Support us</a></li>
                </ul>
            </div>
            {{-- ===== INTERNAL CSS TERISOLASI (prefix bj-) ===== --}}
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=Source+Sans+3:wght@400;600;700&display=swap');

                /* ---- HERO Fiksi ---- */
                .bj-hero {
                    display: grid;
                    grid-template-columns: 46% 54%;
                    gap: 0;
                    width: 100%;
                    margin: 0;
                    padding: 16px 40px 16px 40px;
                    background: #F9F8F6;
                }
                .bj-hero-left {
                    display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                    padding-right: 44px;
                    margin-left: 10%;
                    border-right: 0.5px solid #d8d3cc;
                }
                .bj-cat {
                    font-family: var(--font-sans);
                    font-size: 8px;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: 2.5px;
                    color: #666;
                    margin: 0 0 10px 0;
                    text-align: center;
                }
                .bj-title {
                    font-family: var(--font-serif);
                    font-size: 2.6rem;
                    font-weight: 900;
                    line-height: 1.1;
                    text-align: center;
                    color: #1a1a1a;
                    text-decoration: none;
                    display: block;
                    margin: 0 0 20px 0;
                }
                .bj-title:hover { color: #444; }
                .bj-img-link { display: block; width: 100%; text-align: center; }
                .bj-portrait {
                    width: 100%;
                    max-width: 320px;
                    aspect-ratio: 2 / 3;
                    object-fit: cover;
                    display: block;
                    margin: 0 auto;
                }
                .bj-author {
                    font-family: var(--font-sans);
                    font-size: 11px;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: 2px;
                    color: #1a1a1a;
                    text-align: center;
                    margin: 14px 0 2px 0;
                }
                .bj-illustrator {
                    font-family: var(--font-sans);
                    font-size: 11px;
                    color: #888;
                    text-align: center;
                    margin: 0;
                }

                .bj-landscape {
                    width: 100%;
                    aspect-ratio: 16 / 9;
                    object-fit: cover;
                    display: block;
                }

                /* ---- KOLOM KANAN ---- */
                .bj-hero-right {
                    padding-left: 44px;
                    margin-right: 10%;
                    display: flex;
                    flex-direction: column;
                }
                .bj-hero-main-title {
                    font-family: var(--font-serif);
                    font-size: 2.6rem;
                    font-weight: 700;
                    line-height: 1.15;
                    color: #101010ff;
                    text-decoration: none;
                    margin-top: 30px;
                    margin-bottom: 20px;
                    display: block;
                    letter-spacing: -0.5px;
                }
                .bj-hero-main-title:hover {
                    color: #b70d0f;
                }
                .bj-hero-text {
                    font-family: var(--font-serif);
                    font-size: 0.9rem;
                    line-height: 1.78;
                    color: #2c2c2c;
                    margin: 16px 0 0 0;
                }
                .bj-dropcap {
                    font-family: var(--font-serif);
                    font-size: 0.9rem;
                    line-height: 1.78;
                    color: #2c2c2c;
                    margin: 0;
                }
                .bj-dropcap::first-letter {
                    font-family: var(--font-serif);
                    font-size: 4.4rem;
                    font-weight: 900;
                    float: left;
                    line-height: 0.76;
                    margin-right: 7px;
                    margin-top: 5px;
                    color: #1a1a1a;
                }
                .bj-continue {
                    color: #5b9bd5;
                    text-decoration: none;
                    font-style: italic;
                }
                .bj-continue:hover { text-decoration: underline; }

                /* ---- SUB-ARTIKEL (kanan bawah) ---- */
                .bj-sub-grid {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 18px;
                    padding-top: 18px;
                    border-top: 0.5px solid #d8d3cc;
                }
                .bj-sub-item {
                    display: flex;
                    gap: 12px;
                    align-items: flex-start;
                    justify-content: space-between;
                    text-decoration: none;
                    color: #1a1a1a;
                }
                .bj-sub-text {
                    flex: 1;
                }
                .bj-sub-item:hover .bj-sub-h { color: #b70d0f; }
                .bj-sub-cat {
                    font-family: var(--font-sans);
                    font-size: 9px;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: 1.5px;
                    color: #b70d0f;
                    margin: 0 0 4px 0;
                }
                .bj-sub-h {
                    font-family: var(--font-serif);
                    font-size: 0.9rem;
                    font-weight: 700;
                    line-height: 1.35;
                    margin: 0;
                    transition: color 0.2s;
                }
                .bj-sub-thumb {
                    width: 68px;
                    height: 68px;
                    aspect-ratio: 1 / 1;
                    object-fit: cover;
                    object-position: center;
                    flex-shrink: 0;
                }

                /* ---- WRAPPER SECTION 2 (border full-width, konten berpadding) ---- */
                .bj-section2 {
                    width: 100%;
                    margin-top: 40px;
                    background: #ffffff;
                }

                /* ---- DIVIDER Puisi ---- */
                .bj-divider {
                    display: flex;
                    align-items: center;
                    width: 100%;
                    margin: 0 0 36px 0;
                    padding: 0;
                    gap: 18px;
                    box-sizing: border-box;
                }
                .bj-divider::before,
                .bj-divider::after {
                    content: '';
                    flex: 1;
                    border-top: 0.5px solid #bbb;
                }
                .bj-divider-title {
                    font-family: var(--font-serif);
                    font-size: 1.55rem;
                    font-weight: 400;
                    font-style: italic;
                    color: #1a1a1a;
                    white-space: nowrap;
                    text-decoration: none;
                }
                .bj-divider-title:hover { color: #b70d0f; }

                /* ---- GRID Puisi (4 kolom) ---- */
                .bj-kk-grid {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    width: 100%;
                    box-sizing: border-box;
                    margin: 0 0 56px 0;
                    padding: 0 40px;
                    background: #ffffff;
                }
                .bj-kk-item {
                    padding: 0 18px;
                    border-right: 0.5px solid #d8d3cc;
                }
                .bj-kk-item:first-child { padding-left: 0; }
                .bj-kk-item:last-child  { border-right: none; padding-right: 0; }
                .bj-kk-link {
                    display: flex;
                    flex-direction: row;
                    justify-content: space-between;
                    align-items: flex-start;
                    gap: 10px;
                    text-decoration: none;
                    color: #1a1a1a;
                }
                .bj-kk-link:hover .bj-kk-title { color: #b70d0f; }
                .bj-kk-text  { flex: 1; }
                .bj-kk-cat {
                    font-family: var(--font-sans);
                    font-size: 9px;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: 1.5px;
                    color: #b70d0f;
                    margin: 0 0 6px 0;
                }
                .bj-kk-title {
                    font-family: var(--font-serif);
                    font-size: 0.92rem;
                    font-weight: 700;
                    line-height: 1.4;
                    margin: 0 0 7px 0;
                    transition: color 0.2s;
                }
                .bj-kk-author {
                    font-family: var(--font-sans);
                    font-size: 11.5px;
                    font-weight: 700;
                    color: #1a1a1a;
                    margin: 0;
                    text-transform: uppercase;
                }
                .bj-kk-thumb {
                    width: 80px;
                    height: 80px;
                    object-fit: cover;
                    flex-shrink: 0;
                }

                /* ---- GRID Prosa (Time style) ---- */
                .time-grid {
                    display: grid;
                    grid-template-columns: repeat(6, 1fr);
                    width: 100%;
                    box-sizing: border-box;
                    margin: 0 0 56px 0;
                    padding: 0 40px;
                    background: #ffffff;
                }
                .time-item {
                    padding: 0 20px 10px;
                    border-left: 1px solid #eee;
                }
                .time-link {
                    text-decoration: none;
                    display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                }
                .time-badge {
                    font-family: var(--font-sans);
                    font-size: 10px;
                    text-transform: uppercase;
                    color: #444;
                    border: 1px solid #ddd;
                    padding: 3px 6px;
                    margin-bottom: 12px;
                    letter-spacing: 0.5px;
                    transition: background-color 0.2s, color 0.2s, border-color 0.2s;
                }
                .time-link:hover .time-badge {
                    background-color: #b70d0f;
                    color: #ffffff;
                    border-color: #b70d0f;
                }
                .time-title {
                    font-family: var(--font-serif);
                    font-size: 1.15rem;
                    font-weight: bold;
                    color: #1a1a1a;
                    line-height: 1.25;
                    margin: 0 0 2px 0;
                    transition: color 0.2s;
                }
                .time-title:hover {
                    color: #b70d0f;
                }

                /* ---- NAVIGASI KATEGORI: Horizontal Scroll ---- */
                #content .row:first-child {
                    overflow: hidden;
                }
                #content .row:first-child ul {
                    overflow-x: auto;
                    overflow-y: hidden;
                    -webkit-overflow-scrolling: touch;
                    scrollbar-width: none;
                    flex-wrap: nowrap;
                    justify-content: flex-start !important;
                    padding: 0 16px;
                    gap: 0;
                }
                #content .row:first-child ul::-webkit-scrollbar { display: none; }
                #content .row:first-child ul li {
                    flex-shrink: 0;
                }

                /* ---- RESPONSIF: TABLET (≤860px) ---- */
                @media (max-width: 860px) {
                    /* Hero: kolom kiri (Magz) tetap tampil, tapi layout berubah */
                    .bj-hero {
                        grid-template-columns: 1fr;
                        padding: 0 !important;
                        gap: 0;
                    }
                    .bj-hero-left {
                        display: flex !important;
                        border-right: none;
                        padding: 16px 20px;
                        margin: 0;
                        order: 2; /* Magz di bawah hero utama */
                        background: #f5f4f1;
                    }
                    .bj-hero-left > div {
                        gap: 16px !important;
                    }
                    .bj-hero-right {
                        padding: 0;
                        margin: 0;
                        order: 1;
                    }
                    /* Gambar landscape full-width tanpa margin */
                    .bj-hero-right > a:first-child {
                        margin: 0;
                    }
                    .bj-landscape {
                        border-radius: 0;
                    }
                    /* Judul hero & sub-grid diberi padding horizontal */
                    .bj-hero-main-title {
                        padding: 0 20px;
                        font-size: 2rem;
                        margin-top: 20px;
                        margin-bottom: 16px;
                    }
                    .bj-hero-text,
                    .bj-dropcap {
                        padding: 0 20px;
                    }
                    .bj-sub-grid {
                        padding: 0 20px;
                        margin-bottom: 20px;
                    }

                    /* Puisi grid: 2 kolom */
                    .bj-kk-grid {
                        grid-template-columns: repeat(2, 1fr);
                        gap: 18px;
                        padding: 0 20px;
                    }
                    .bj-kk-item {
                        border-right: none;
                        padding: 0;
                        padding-bottom: 16px;
                        border-bottom: 0.5px solid #e8e4de;
                    }
                    .bj-kk-item:last-child { border-bottom: none; }

                    /* Prosa grid: 3 kolom */
                    .time-grid {
                        grid-template-columns: repeat(3, 1fr);
                        gap: 0;
                        padding: 0 20px;
                    }
                    .time-item {
                        padding: 0 16px 16px;
                        margin-bottom: 0;
                    }
                }

                /* ---- RESPONSIF: MOBILE (≤540px) ---- */
                @media (max-width: 540px) {
                    /* Hero */
                    .bj-hero-main-title {
                        font-size: 1.65rem;
                        padding: 0 16px;
                        margin-top: 16px;
                        margin-bottom: 12px;
                    }
                    .bj-hero-text,
                    .bj-dropcap {
                        padding: 0 16px;
                        font-size: 0.85rem;
                    }
                    .bj-title { font-size: 1.5rem; }

                    /* Magz grid: tetap 2 kolom, lebih kompak */
                    .bj-hero-left {
                        padding: 14px 16px;
                    }
                    .bj-hero-left > div {
                        gap: 12px !important;
                    }
                    .bj-hero-left h3 {
                        font-size: 13px !important;
                    }
                    .bj-hero-left p[style*="font-size: 11px"] {
                        font-size: 10px !important;
                    }

                    /* Sub-artikel: 1 kolom, card-style */
                    .bj-sub-grid {
                        grid-template-columns: 1fr;
                        gap: 14px;
                        padding: 0 16px;
                        border-top-color: #e8e4de;
                    }
                    .bj-sub-item {
                        padding: 12px 0;
                        border-bottom: 0.5px solid #e8e4de;
                    }
                    .bj-sub-item:last-child { border-bottom: none; }
                    .bj-sub-thumb {
                        width: 72px;
                        height: 72px;
                    }
                    .bj-sub-h {
                        font-size: 0.95rem;
                    }

                    /* Puisi grid: 1 kolom (model row), max 3 di mobile */
                    .bj-kk-grid {
                        grid-template-columns: 1fr;
                        gap: 14px;
                        padding: 0 16px;
                        margin-bottom: 32px;
                    }
                    .bj-kk-item:nth-child(n+4) {
                        display: none !important;
                    }
                    .bj-kk-thumb {
                        width: 68px;
                        height: 68px;
                    }
                    .bj-kk-title {
                        font-size: 0.95rem;
                    }

                    /* Prosa grid: Slider layout, 3 baris per slide */
                    .time-grid {
                        display: grid;
                        grid-template-rows: repeat(3, auto);
                        grid-auto-flow: column;
                        grid-auto-columns: 100%;
                        overflow-x: auto;
                        scroll-snap-type: x mandatory;
                        scrollbar-width: none;
                        -webkit-overflow-scrolling: touch;
                        padding: 0;
                        gap: 0;
                    }
                    .time-grid::-webkit-scrollbar { display: none; }
                    .time-item {
                        scroll-snap-align: start;
                        width: 100%;
                        border-left: none;
                        padding: 0 16px 16px;
                        margin-bottom: 8px;
                        border-bottom: 0.5px solid #eee;
                    }
                    .time-item:nth-child(n+7) {
                        display: none !important;
                    }
                    .time-title {
                        font-size: 1rem;
                    }
                    .time-badge {
                        font-size: 9px;
                        padding: 2px 5px;
                        margin-bottom: 8px;
                    }

                    /* Divider */
                    .bj-divider {
                        margin-bottom: 24px;
                        padding: 0 16px;
                    }
                    .bj-divider-title {
                        font-size: 1.3rem;
                    }

                    /* Section 2 spacing */
                    .bj-section2 {
                        margin-top: 24px;
                    }
                }

                /* ---- RESPONSIF: SMALL PHONE (≤400px) ---- */
                @media (max-width: 400px) {
                    .bj-hero-main-title {
                        font-size: 1.45rem;
                    }
                    .bj-kk-grid {
                        gap: 10px;
                    }
                    .bj-kk-thumb {
                        width: 52px;
                        height: 52px;
                    }
                    .bj-kk-title {
                        font-size: 0.8rem;
                    }
                    .bj-sub-thumb {
                        width: 60px;
                        height: 60px;
                    }
                }
            </style>

            {{-- ===== CSS GAMBAR TERISOLASI — khusus halaman ini ===== --}}
            <style>
                /* Scope ke #head: slide carousel */
                #head .item {
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                }

                /* Scope ke #content .bj-hero: gambar portrait artikel utama */
                #content .bj-portrait {
                    aspect-ratio: 3 / 4;
                    width: 100%;
                    max-width: 320px;
                    object-fit: cover;
                    object-position: center;
                    display: block;
                }

                /* Scope ke #content .bj-kk-thumb: thumbnail Puisi */
                #content .bj-kk-thumb {
                    width: 80px;
                    height: 80px;
                    aspect-ratio: 1 / 1;
                    object-fit: cover;
                    object-position: center;
                    flex-shrink: 0;
                }

                /* Scope ke #review: gambar buku utama (bukuTerbaru) */
                #review .col > img {
                    width: 100%;
                    height: 400px;
                    object-fit: cover;
                    object-position: center;
                    display: block;
                }

                /* Scope ke #review: gambar thumbnail daftar buku lama */
                #review .content > img {
                    width: 72px;
                    height: 90px;
                    aspect-ratio: 4 / 5;
                    object-fit: cover;
                    object-position: center;
                    flex-shrink: 0;
                    display: block;
                }

                /* Scope ke #review: pastikan .content row jadi flex */
                #review .content {
                    display: flex;
                    align-items: flex-start;
                    gap: 12px;
                    margin-bottom: 16px;
                }

                /* Responsive class untuk grid Review Book */
                .review-main-grid {
                    display: flex; 
                    gap: 6px; 
                    border-right: 1px solid #d8d3cc; 
                    padding-right: 16px;
                }
                .review-side-grid {
                    padding-left: 16px;
                }
                @media (max-width: 768px) {
                    .review-main-grid {
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        gap: 16px;
                        border-right: none;
                        padding-right: 0;
                        margin-bottom: 24px;
                    }
                    .review-side-grid {
                        padding-left: 0;
                        border-top: 0.5px solid #e0ddd8;
                        padding-top: 20px;
                    }
                }
                @media (max-width: 480px) {
                    .review-main-grid {
                        grid-template-columns: repeat(2, 1fr);
                        gap: 12px;
                    }
                    .buku-terbaru-item:nth-child(n+5) {
                        display: none !important;
                    }
                    /* Buku judul & penulis di review section */
                    .review-main-grid .desc h3 {
                        font-size: 0.85rem !important;
                        line-height: 1.3 !important;
                    }
                    .review-main-grid .desc p {
                        font-size: 0.5rem !important;
                    }
                    /* Side list buku lama: kembalikan ke list baris, max 3 item */
                    .review-side-grid {
                        display: flex;
                        flex-direction: column;
                        border-top: 1px solid #d8d3cc;
                        padding-top: 24px;
                    }
                    .buku-lama-item:nth-child(n+4) {
                        display: none !important;
                    }
                    .buku-lama-item {
                        display: flex !important;
                        flex-direction: row !important;
                        align-items: flex-start !important;
                        justify-content: space-between !important;
                        margin-bottom: 16px !important;
                        padding-bottom: 16px !important;
                        border-bottom: 0.5px solid #eee !important;
                        width: 100% !important;
                    }
                    .buku-lama-item:last-child {
                        border-bottom: none !important;
                        margin-bottom: 0 !important;
                        padding-bottom: 0 !important;
                    }
                    .buku-lama-item img {
                        width: 72px !important;
                        height: 90px !important;
                        aspect-ratio: 4/5;
                        margin-bottom: 0 !important;
                        box-shadow: none !important;
                        border-radius: 2px !important;
                        flex-shrink: 0;
                    }
                    .buku-lama-item .desc {
                        flex: 1;
                        padding-right: 15px !important;
                    }
                    .buku-lama-item .desc h6 {
                        font-size: 0.9rem !important;
                        line-height: 1.35 !important;
                        margin-bottom: 6px !important;
                    }
                    .buku-lama-item .desc p {
                        font-size: 0.56rem !important;
                        margin: 0 !important;
                    }
                    #review .container .row:first-child h3 a {
                        font-size: 14px;
                    }
                }

                /* Dots untuk slider Prosa di mobile */
                .prosa-dots-container {
                    display: none;
                }
                @media (max-width: 540px) {
                    .prosa-dots-container {
                        display: flex;
                        justify-content: center;
                        gap: 8px;
                        margin-top: 16px;
                        margin-bottom: 8px;
                    }
                    .prosa-dot {
                        width: 6px;
                        height: 6px;
                        border-radius: 50%;
                        background-color: #d8d3cc;
                        transition: background-color 0.3s;
                    }
                    .prosa-dot.active {
                        background-color: #b70d0f;
                    }
                }

                /* Scope ke #ysk: kartu inspirasi (background-image) */
                #ysk .card {
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    min-height: 200px;
                }
                /* Hindari perubahan warna merah pada teks "Inspirasi" saat di-hover */
                #ysk a:hover .theme {
                    color: #ffffff !important;
                }

                /* YSK / Inspirasi mobile */
                @media (max-width: 768px) {
                    .ysk-arrow {
                        width: 32px;
                        height: 32px;
                    }
                    .ysk-arrow i {
                        font-size: 12px !important;
                    }
                }
                @media (max-width: 480px) {
                    #ysk .container .title {
                        padding: 12px 0;
                        margin-bottom: 16px;
                    }
                    #ysk .container .title h3 {
                        font-size: 16px !important;
                        letter-spacing: 2px;
                    }
                    .ysk-arrow {
                        width: 28px;
                        height: 28px;
                        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
                    }
                    #ysk .container .content .card .desc .card-title {
                        font-size: 0.75rem;
                        -webkit-line-clamp: 2;
                    }
                    #ysk .container .content .card .desc .theme {
                        font-size: 0.55rem;
                        padding: 1px 5px;
                    }
                }
            </style>

            {{-- ===== BLOK 1: HERO COFFEESHOPHIA (2 kolom) ===== --}}
            @foreach($coffeeshophia as $r1)
            <div class="bj-hero">

                {{-- Kolom Kiri: Teks Artikel & Drop Cap --}}
                <div class="bj-hero-left">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; width: 100%; margin: 0;">
                        @foreach($magz as $m)
                        <a href="{{ route('magz.preview', $m->slug) }}" style="text-decoration: none; display: flex; flex-direction: column; transition: transform 0.3s ease;">
                            <img src="{{ asset('img/'.$m->cover_gambar) }}" style="width: 100%; height: auto; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 15px;" alt="{{ $m->judul }}">
                            <p style="font-family: var(--font-sans); font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #b70d0f; margin: 0 0 5px 0;">Magz</p>
                            <h3 style="font-family: var(--font-serif); font-size: 16px; font-weight: 700; line-height: 1.35; margin: 0 0 8px 0; color: #111;">{{ $m->judul }}</h3>
                            <p style="font-family: var(--font-sans); font-size: 11px; color: #666; text-transform: uppercase; letter-spacing: 1px; margin: 0;">{{ $m->penulis ?? 'Editorial Team' }}</p>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Kolom Kanan: Gambar Landscape + Judul + Sub-artikel --}}
                <div class="bj-hero-right">
                    <a href="{{ url('/artikel/'.$r1->slug) }}" style="display: block; width: 100%;">
                        <img src="{{ asset('img/'.$r1->gambar_pertama) }}" class="bj-landscape" alt="{{ $r1->judul }}">
                    </a>

                    <a href="{{ url('/artikel/'.$r1->slug) }}" class="bj-hero-main-title">
                        &ldquo;{{ $r1->judul }}&rdquo;
                    </a>

                    {{-- Sub-artikel: meniru 'This Week in Fiction' & 'The Writer's Voice' --}}
                    <div class="bj-sub-grid">
                        @if($jakartaPlus->isNotEmpty())
                        @php $jp = $jakartaPlus->first(); @endphp
                        <a href="{{ url('/artikel/'.$jp->slug) }}" class="bj-sub-item">
                            <div class="bj-sub-text">
                                <p class="bj-sub-cat">Minggu Ini di Jakarta+</p>
                                <h4 class="bj-sub-h">{{ $jp->judul }}</h4>
                            </div>
                            <img src="{{ asset('img/'.$jp->gambar_pertama) }}" class="bj-sub-thumb" alt="">
                        </a>
                        @endif
                        
                        @if($editorsChoice->isNotEmpty())
                        @php $ec = $editorsChoice->first(); @endphp
                        <a href="{{ url('/artikel/'.$ec->slug) }}" class="bj-sub-item">
                            <div class="bj-sub-text">
                                <p class="bj-sub-cat">Letter from Editor's</p>
                                <h4 class="bj-sub-h">{{ $ec->judul }}</h4>
                            </div>
                            <img src="{{ asset('img/'.$ec->gambar_pertama) }}" class="bj-sub-thumb" alt="">
                        </a>
                        @endif
                    </div>
                </div>

            </div>
            @endforeach

            {{-- ===== BLOK 2: WRAPPER (border full-width) + DIVIDER + GRID Puisi ===== --}}
            <div class="bj-section2">

                <div class="bj-divider">
                    <a href="{{ url('/page/puisi') }}" class="bj-divider-title">Puisi</a>
                </div>

            <div class="bj-kk-grid">
                @foreach ($puisi as $r2)
                <div class="bj-kk-item">
                    <a href="{{ url('/artikel/'.$r2->slug) }}" class="bj-kk-link">
                        <div class="bj-kk-text">
                            <p class="bj-kk-cat">Puisi</p>
                            <h3 class="bj-kk-title">{{ $r2->judul }}</h3>
                            <p class="bj-kk-author">By {{ $r2->penulis->nama ?? '-' }}</p>
                        </div>
                        <img src="{{ asset('img/'.$r2->gambar_pertama) }}" class="bj-kk-thumb" alt="{{ $r2->judul }}">
                    </a>
                </div>
                @endforeach
            </div>

            </div>{{-- /bj-section2 --}}


        </section>


        <!-- review book -->
        <section id="review">
            <div class="container">
                <div class="row review-header-row" style="width: 100%; display: flex !important; flex-direction: row; justify-content: space-between; align-items: center; border-bottom: 1px solid #e0e0e0; padding: 15px 0; margin: 0 0 30px 0; height: auto;">
                    <h3 style="font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 700; margin: 0; padding: 0; line-height: 1;">
                        <a href="{{ url('/page/buku') }}" style="color: #111; text-decoration: none;">The Review Book</a>
                    </h3>
                    <div class="review-sponsors" style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap; justify-content: flex-end;">
                        <img src="{{ asset('img/sponsor/Sarinah png.png') }}" alt="Sarinah" style="height: 32px; object-fit: contain;">
                    </div>
                </div>
                <div class="row">
                    @if($bukuTerbaru->isNotEmpty())
                    <div class="col-lg-8 col-md-8 review-main-grid">
                        @foreach($bukuTerbaru as $buku)
                        <div class="buku-terbaru-item" style="flex: 1; min-width: 0; display: flex; flex-direction: column; text-align: left;">
                            <a href="{{ url('/artikel/'.$buku->slug) }}" style="text-decoration: none; display:block; margin-bottom: 16px;">
                                <img src="{{ asset('img/'.$buku->gambar_pertama) }}" style="width:100%; height:260px; object-fit:contain; object-position:center; box-shadow: 0 4px 10px rgba(0,0,0,0.08); display:block; background:#f5f4f0; padding: 16px 12px;" alt="">
                            </a>
                            <div class="desc">
                                <a href="{{ url('/artikel/'.$buku->slug) }}" style="text-decoration: none;color:#000000; display:block;">
                                    <h3 style="font-family: var(--font-serif); font-size: 0.85rem; line-height: 1.25; margin-bottom: 2px; font-weight: bold; max-width: 90%;">{{ $buku->judul }}</h3>
                                    <p style="font-family: var(--font-sans); color:#b70d0f; font-size: 10px; font-weight: 400; text-transform: uppercase; margin: 6px 0 0 0; letter-spacing: 0.5px;">By {{ $buku->penulis->nama ?? '-' }}</p>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="col-lg-4 col-md-4 review-side-grid">
                        @foreach ($bukuLama as $row)
                        <div class="content buku-lama-item" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; width: 100%;">
                            <div class="desc" style="flex: 1; padding-right: 8px; text-align: left;">
                                <a href="{{ url('/artikel/'.$row->slug) }}" style="text-decoration: none;color:#000000; display: block;">
                                    <p style="display:none; font-family: var(--font-sans); font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #b70d0f; margin: 0 0 5px 0;" class="mobile-magz-tag">Review</p>
                                    <h6 style="font-family: var(--font-serif); font-weight:bold; font-size: 0.8rem; line-height: 1.3; margin: 0; max-width: 90%;">{{ $row->judul }}</h6>
                                    <p style="font-family: var(--font-sans); font-size: 10px; font-weight: 400; color: #b70d0f; margin: 6px 0 0 0; text-transform: uppercase;">By {{ $row->penulis->nama ?? '-' }}</p>
                                </a>
                            </div>
                            <img src="{{ asset('img/'.$row->gambar_pertama) }}" style="width:65px; height:85px; object-fit:contain; object-position:top center; flex-shrink:0;" alt="">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </section>

                <style>
                @media (max-width: 540px) {
                    .prosa-dots-container {
                        display: flex;
                        justify-content: center;
                        gap: 8px;
                        margin-top: 16px;
                        margin-bottom: 8px;
                    }
                    .prosa-dot {
                        width: 6px;
                        height: 6px;
                        border-radius: 50%;
                        background-color: #d8d3cc;
                        transition: background-color 0.3s;
                    }
                    .prosa-dot.active {
                        background-color: #b70d0f;
                    }
                }

                /* Scope ke #ysk: kartu inspirasi (background-image) */
                #ysk .card {
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    min-height: 200px;
                }
                /* Hindari perubahan warna merah pada teks "Inspirasi" saat di-hover */
                #ysk a:hover .theme {
                    color: #ffffff !important;
                }

                /* YSK / Inspirasi mobile */
                @media (max-width: 768px) {
                    .ysk-arrow {
                        width: 32px;
                        height: 32px;
                    }
                    .ysk-arrow i {
                        font-size: 12px !important;
                    }
                }
                @media (max-width: 480px) {
                    #ysk .container .title {
                        padding: 12px 0;
                        margin-bottom: 16px;
                    }
                    #ysk .container .title h3 {
                        font-size: 16px !important;
                        letter-spacing: 2px;
                    }
                    .ysk-arrow {
                        width: 28px;
                        height: 28px;
                        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
                    }
                    #ysk .container .content .card .desc .card-title {
                        font-size: 0.75rem;
                        -webkit-line-clamp: 2;
                    }
                    #ysk .container .content .card .desc .theme {
                        font-size: 0.55rem;
                        padding: 1px 5px;
                    }
                }
                </style>
        </section>

        <style>
            #prosa-section-desktop { display: block; }
            #prosa-section-mobile { display: none; }
            @media (max-width: 768px) {
                #prosa-section-desktop { display: none !important; }
                #prosa-section-mobile { display: block !important; }
            }
        </style>
        
        <!-- Prosa Section (Desktop) -->
        <section id="prosa-section-desktop" style="padding: 20px 0 40px 0; background: #ffffff;">
            <div class="container">
                <div class="bj-divider" style="margin-bottom: 24px;">
                    <a href="{{ url('/page/prosa') }}" class="bj-divider-title">Prosa</a>
                </div>
                <div class="time-grid">
                    @foreach ($prosa as $r3)
                    <div class="time-item">
                        <a href="{{ url('/artikel/'.$r3->slug) }}" class="time-link">
                            <span class="time-badge">Prosa</span>
                            <h3 class="time-title">{{ $r3->judul }}</h3>
                            <p style="font-family: var(--font-serif); color:#b70d0f; font-size: 0.58rem; font-weight: 700; text-transform: uppercase; margin: 6px 0 0 0; letter-spacing: 0.5px;">by {{ $r3->penulis->nama ?? '-' }}</p>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Prosa Section (Mobile) -->
        <section id="prosa-section-mobile" style="padding: 20px 0 40px 0; background: #ffffff;">
            <div class="container">
                <div class="bj-divider" style="margin-bottom: 24px;">
                    <a href="{{ url('/page/prosa') }}" class="bj-divider-title">Prosa</a>
                </div>                <!-- PROSA SLIDER WRAPPER -->
                <div class="prosa-slider-viewport" style="overflow: hidden; width: 100%;">
                    <div class="prosa-slider-inner" id="prosa-slider-inner" style="display: flex; transition: transform 0.3s ease;">
                        @forelse ($prosa->take(6)->chunk(3) as $chunk)
                        <div class="prosa-slide" style="flex: 0 0 100%; max-width: 100%; box-sizing: border-box;">
                            <div class="time-grid" style="padding: 0; margin-bottom: 0; display: block; box-sizing: border-box;">
                                @foreach ($chunk as $r3)
                                <div class="time-item" style="box-sizing: border-box; border-left: none; padding: 0 16px 16px; margin-bottom: 12px; border-bottom: 0.5px solid #eee; width: auto;">
                                    <a href="{{ url('/artikel/'.$r3->slug) }}" class="time-link" style="display: block;">
                                        <span class="time-badge">Prosa</span>
                                        <h3 class="time-title" style="word-wrap: break-word; white-space: normal;">{{ $r3->judul }}</h3>
                                        <p style="font-family: var(--font-serif); color:#b70d0f; font-size: 0.58rem; font-weight: 700; text-transform: uppercase; margin: 6px 0 0 0; letter-spacing: 0.5px;">by {{ $r3->penulis->nama ?? '-' }}</p>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @empty
                        <p style="font-family:var(--font-sans);font-size:13px;color:#999;padding:20px 16px;">Belum ada artikel Prosa.</p>
                        @endforelse
                    </div>
                </div>

                @if($prosa->count() > 3)
                <div class="prosa-dots-container" id="prosa-dots">
                    @for($i = 0; $i < min(2, ceil($prosa->count() / 3)); $i++)
                    <span class="prosa-dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}"></span>
                    @endfor
                </div>
                @endif
            </div>
        </section>

        <!-- EVERYONE'S READING SECTION -->
        <style>
            .er-container { padding: 0 40px; }
            .er-slider-wrapper { margin: 0 -20px; width: calc(100% + 40px) !important; }
            .er-card { 
                flex: 0 0 25%; 
                max-width: 25%; 
                box-sizing: border-box; 
                padding: 0 20px;
                border-right: 1px solid #e0e0e0;
            }
            .er-title { font-size: 1.1rem; }
            .er-card-title { font-size: 1.05rem; }
            @media (max-width: 992px) { 
                .er-card { flex: 0 0 33.333%; max-width: 33.333%; } 
            }
            @media (max-width: 768px) { 
                .er-container { padding: 0 20px; }
                .er-slider-wrapper { overflow-x: auto !important; scroll-snap-type: x mandatory; padding-bottom: 15px; margin: 0 -10px; width: calc(100% + 20px) !important; }
                .er-slider-wrapper::-webkit-scrollbar { display: none; }
                .er-slider-track { transition: none !important; transform: none !important; gap: 0 !important; }
                .er-card { flex: 0 0 60%; max-width: 60%; scroll-snap-align: start; padding: 0 10px; } 
                .er-nav-buttons { display: none !important; }
            }
            @media (max-width: 480px) { 
                .er-container { padding: 0 16px; }
                .er-card { flex: 0 0 85%; max-width: 85%; } 
                .er-title { font-size: 1rem; }
            }
            .er-card a:hover h3 { color: #b70d0f !important; }
            .er-card a:hover img { transform: scale(1.05); }
        </style>
        <section id="everyone-reading-section" style="padding: 10px 0 60px 0; background: #ffffff;">
            <div class="container er-container">
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 3px solid #111; padding-top: 15px; margin-bottom: 30px;">
                    <h2 class="er-title" style="font-family: var(--font-sans), 'Arial', sans-serif; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; margin: 0; color: #111;">EVERYONE'S READING</h2>
                    <div class="er-nav-buttons" style="display: flex; gap: 8px;">
                        <button id="er-prev" style="width: 28px; height: 28px; border-radius: 50%; border: none; background: #f4f4f4; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #333; transition: background 0.3s;">
                            <i class="fas fa-chevron-left" style="font-size: 10px;"></i>
                        </button>
                        <button id="er-next" style="width: 28px; height: 28px; border-radius: 50%; border: none; background: #f4f4f4; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #333; transition: background 0.3s;">
                            <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                        </button>
                    </div>
                </div>

                <div class="er-slider-wrapper" style="overflow: hidden; position: relative;">
                    <div class="er-slider-track" id="er-slider-track" style="display: flex; gap: 0; transition: transform 0.4s ease-in-out;">
                        @foreach ($pemikiran as $pmk)
                        <div class="er-card">
                            <a href="{{ url('/artikel/'.$pmk->slug) }}" style="text-decoration: none; display: block;">
                                <div style="width: 100%; aspect-ratio: 1/1; overflow: hidden; margin-bottom: 12px;">
                                    <img src="{{ asset('img/'.$pmk->gambar_pertama) }}" alt="{{ $pmk->judul }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;">
                                </div>
                                <span style="display: block; font-family: var(--font-sans), 'Arial', sans-serif; font-size: 9px; font-weight: 700; color: #b70d0f; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">{{ $pmk->kategori->nama ?? 'PEMIKIRAN' }}</span>
                                <h3 class="er-card-title" style="font-family: var(--font-serif), 'Georgia', serif; color: #111; line-height: 1.25; margin: 0; font-weight: 600; transition: color 0.2s;">{{ $pmk->judul }}</h3>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Script for EVERYONE'S READING Slider -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const track = document.getElementById("er-slider-track");
                const prevBtn = document.getElementById("er-prev");
                const nextBtn = document.getElementById("er-next");
                let cards = track.querySelectorAll(".er-card");
                
                if(track && prevBtn && nextBtn && cards.length > 0) {
                    let currentIndex = 0;
                    
                    function updateSlider() {
                        if (window.innerWidth <= 768) return; // Disable JS slider on mobile
                        const cardWidth = cards[0].offsetWidth;
                        const gap = 0;
                        const moveX = currentIndex * (cardWidth + gap);
                        track.style.transform = `translateX(-${moveX}px)`;
                    }

                    nextBtn.addEventListener("click", () => {
                        if (window.innerWidth <= 768) return;
                        const visibleCards = window.innerWidth > 992 ? 4 : (window.innerWidth > 768 ? 3 : 2);
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
                            track.style.transform = 'none'; // Reset transform on mobile
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
            });
        </script>
        
        <style>
            .ysk-wrap {
                display: flex;
                align-items: center;
                gap: 10px;
                width: 100%;
            }
            .ysk-arrow {
                flex-shrink: 0;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                border: 1px solid #ccc;
                background: #fff;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                transition: background 0.2s, border 0.2s;
                user-select: none;
                z-index: 5;
            }
            .ysk-arrow:hover { background: #111; border-color: #111; }
            .ysk-arrow:hover i { color: #fff !important; }
            /* Wrapper yang memotong overflow */
            #ysk-viewport {
                flex: 1;
                overflow: hidden;
                min-width: 0; /* penting agar tidak melampaui flex container */
            }
            /* Track yang bergerak dengan transform — HARUS lebih lebar dari viewport */
            #ysk-inner {
                display: flex !important;
                flex-wrap: nowrap !important;
                width: max-content !important; /* override width:100% dari style.css agar bisa lebih lebar */
                overflow: visible !important;  /* jangan clip, biarkan viewport yang clip */
                gap: 12px;
                transition: transform 0.4s ease;
                will-change: transform;
            }
            /* Lebar kartu diatur oleh JS agar pas 5 per halaman */
            #ysk-inner > a {
                text-decoration: none;
                display: block;
            }
        </style>

        <section id="ysk">
            <div class="container">
                <div class="title">
                    <h3><a href="{{ url('/page/inspirasi') }}">INSPIRASI</a></h3>
                </div>
                <div class="ysk-wrap">
                    <!-- Tombol Prev -->
                    <div class="ysk-arrow" id="ysk-prev">
                        <i class="fa fa-chevron-left" style="color:#111;"></i>
                    </div>

                    <!-- Viewport: hanya memperlihatkan 5 kartu -->
                    <div id="ysk-viewport">
                        <div id="ysk-inner" class="content">
                            @foreach ($inspirasi as $r3)
                            <a href="{{ url('/artikel/'.$r3->slug) }}">
                                <div class="card" style="background-image: url('{{ asset('img/'.$r3->gambar_pertama) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                                    <div class="desc">
                                        <h3 style="font-family: var(--font-sans);" class="theme">Inspirasi</h3>
                                        <h3 style="font-family: var(--font-serif);" class="card-title">{{ $r3->judul }}</h3>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tombol Next -->
                    <div class="ysk-arrow" id="ysk-next">
                        <i class="fa fa-chevron-right" style="color:#111;"></i>
                    </div>
                </div>
            </div>
        </section>


    @endsection

    @push('scripts')

        <script>
            let next = document.querySelector(".button .next")
            let prev = document.querySelector(".button .prev")
            
            if (next && prev) {
                next.addEventListener('click', function() {
                    let items = document.querySelectorAll('.item')
                    document.querySelector('.slide').appendChild(items[0])
                })
                prev.addEventListener('click', function() {
                    let items = document.querySelectorAll('.item')
                    document.querySelector('.slide').prepend(items[items.length - 1])
                })
                let interval = setInterval(function(){
                    let items = document.querySelectorAll('.item')
                    if(items.length > 0) {
                        document.querySelector('.slide').appendChild(items[0])
                    }
                },6000)
            }
        </script>

        <script>
            window.addEventListener('load', function() {
                var viewport   = document.getElementById('ysk-viewport');
                var inner      = document.getElementById('ysk-inner');
                var btnPrev    = document.getElementById('ysk-prev');
                var btnNext    = document.getElementById('ysk-next');
                if (!viewport || !inner || !btnPrev || !btnNext) return;

                var PER_PAGE   = window.innerWidth <= 480 ? 2 : (window.innerWidth <= 768 ? 3 : 5);
                var GAP        = 12;
                var cards      = [].slice.call(inner.querySelectorAll(':scope > a'));
                var totalCards = cards.length;
                var totalPages = Math.ceil(totalCards / PER_PAGE);
                var page       = 0;

                function setup() {
                    PER_PAGE = window.innerWidth <= 480 ? 2 : (window.innerWidth <= 768 ? 3 : 5);
                    totalPages = Math.ceil(totalCards / PER_PAGE);
                    
                    var vw = viewport.offsetWidth;
                    if (vw <= 0) return; // jangan proses jika layout belum siap
                    var cw = Math.floor((vw - (PER_PAGE - 1) * GAP) / PER_PAGE);
                    cards.forEach(function(a) {
                        a.style.flex     = '0 0 ' + cw + 'px';
                        a.style.width    = cw + 'px';
                        a.style.minWidth = cw + 'px';
                    });
                }

                function goTo(p) {
                    if (p < 0) p = 0;
                    if (p >= totalPages) p = totalPages - 1;
                    page = p;
                    inner.style.transform = 'translateX(-' + (viewport.offsetWidth * page) + 'px)';
                }

                // Pastikan layout sudah stabil dulu
                requestAnimationFrame(function() {
                    setup();
                    goTo(0);
                });

                btnNext.addEventListener('click', function() { goTo(page + 1); });
                btnPrev.addEventListener('click', function() { goTo(page - 1); });
                window.addEventListener('resize', function() { setup(); goTo(page); });
            });

            // Prosa Slider Dots Logic
            window.addEventListener('load', function() {
                var inner = document.getElementById('prosa-slider-inner');
                var dots = document.querySelectorAll('#prosa-dots .prosa-dot');
                if(inner && dots.length > 0) {
                    // Fitur touch swipe simpel
                    var startX = 0;
                    var currentTranslate = 0;
                    var currentIndex = 0;
                    var isDragging = false;

                    function setPositionByIndex() {
                        currentTranslate = currentIndex * -100;
                        inner.style.transform = `translateX(${currentTranslate}%)`;
                        dots.forEach((d, i) => {
                            if(i === currentIndex) d.classList.add('active');
                            else d.classList.remove('active');
                        });
                    }

                    // Click on dots
                    dots.forEach((dot, index) => {
                        dot.addEventListener('click', () => {
                            if (window.innerWidth > 540) return;
                            currentIndex = index;
                            setPositionByIndex();
                        });
                    });

                    // Touch events for swiping
                    inner.addEventListener('touchstart', (e) => {
                        if (window.innerWidth > 540) return;
                        startX = e.touches[0].clientX;
                        isDragging = true;
                    }, {passive: true});

                    inner.addEventListener('touchmove', (e) => {
                        if (!isDragging || window.innerWidth > 540) return;
                    }, {passive: true});

                    inner.addEventListener('touchend', (e) => {
                        if (!isDragging || window.innerWidth > 540) return;
                        isDragging = false;
                        var endX = e.changedTouches[0].clientX;
                        var diffX = startX - endX;

                        if (diffX > 50 && currentIndex < dots.length - 1) {
                            currentIndex++; // Swipe left (next)
                        } else if (diffX < -50 && currentIndex > 0) {
                            currentIndex--; // Swipe right (prev)
                        }
                        setPositionByIndex();
                    });
                }
            });
        </script>
    @endpush
