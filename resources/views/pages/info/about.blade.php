@extends('layouts.app')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
    /* === SCOPED RESET & GLOBAL === */
    #story-wrapper {
        font-family: 'Montserrat', sans-serif;
        background-color: #ffffff;
        color: #333333;
        width: 100%;
    }

    #story-wrapper * {
        box-sizing: border-box;
    }

    #story-wrapper img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* === HERO SECTION (VIDEO) === */
    #story-wrapper .hero-section {
        position: relative;
        width: 100%;
        height: 65vh;
        min-height: 400px;
        overflow: hidden;
        background-color: #000;
    }

    #story-wrapper .hero-video-wrapper {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100vw;
        height: 56.25vw; /* 16:9 aspect ratio */
        min-height: 100%;
        min-width: 177.77vh; /* 16:9 aspect ratio */
        opacity: 0.6; /* Slight dimming for better text readability */
        pointer-events: none; /* Disable interaction */
    }

    #story-wrapper .hero-video-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
        pointer-events: none;
    }

    #story-wrapper .hero-content {
        position: absolute;
        bottom: 50px;
        left: 5%;
        z-index: 2;
    }

    #story-wrapper .hero-content h1 {
        color: #ffffff;
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 20px;
        max-width: 500px;
        text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
    }

    #story-wrapper .btn-watch {
        background-color: #ffffff;
        color: #000000;
        padding: 10px 25px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-block;
        transition: all 0.3s;
    }
    #story-wrapper .btn-watch:hover { 
        background-color: #b70d0f; 
        color: #ffffff; 
    }

    /* === LOGO BANNER (HITAM) === */
    #story-wrapper .logo-banner {
        background-color: #1a1a1a;
        padding: 20px 5%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 40px;
    }

    #story-wrapper .logo-banner-h {
        background-color: #1a1a1a;
        padding: 20px 5%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 40px;
        margin-bottom: -50px; /* Mengatasi padding-top footer bawaan sebesar 50px */
        position: relative;
        z-index: 10;
        flex-wrap: wrap;
    }
    #story-wrapper .aesthetic-title {
        color: #a8a8a8;
        font-weight: 600;
        letter-spacing: 4px;
        font-size: 0.85rem;
        text-transform: uppercase;
        margin: 0;
        margin-right: 15px;
        display: flex;
        align-items: center;
    }
    #story-wrapper .aesthetic-title::after {
        content: '';
        display: inline-block;
        width: 1px;
        height: 20px;
        background-color: #444;
        margin-left: 25px;
    }
    #story-wrapper .store-link {
        color: #fff;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: color 0.3s;
    }
    #story-wrapper .store-link:hover {
        color: #b70d0f;
    }

    #story-wrapper .mock-logo {
        color: #ffffff;
        font-family: serif;
    }
    #story-wrapper .logo-bloomberg { font-size: 1.2rem; line-height: 1; }
    #story-wrapper .logo-lse { font-size: 1.8rem; font-weight: bold; font-family: sans-serif; display: flex; align-items: center; gap: 5px;}
    #story-wrapper .logo-lse span { font-weight: normal; font-size: 1.5rem; }
    #story-wrapper .logo-box { border: 1px solid #fff; padding: 2px 5px; font-size: 1.2rem; font-weight: bold;}

    /* === TIMELINE SECTION (DIVIDER) === */
    #story-wrapper .timeline-section {
        background-color: #f9f9f9;
        padding: 60px 5%;
        text-align: center;
        margin: 40px 0;
    }
    #story-wrapper .timeline-header .orange-line {
        width: 60px;
        height: 4px;
        background-color: #b70d0f;
        margin: 0 auto 15px auto;
    }
    #story-wrapper .timeline-header h2 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 10px;
        color: #000;
    }
    #story-wrapper .timeline-header p {
        font-size: 1.1rem;
        color: #333;
        margin-bottom: 25px;
    }
    #story-wrapper .btn-history {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 25px;
        border: 1px solid #000;
        border-radius: 25px;
        text-decoration: none;
        color: #000;
        font-weight: 700;
        font-size: 0.9rem;
        background: #fff;
        transition: all 0.3s;
    }
    #story-wrapper .btn-history:hover {
        background: #b70d0f;
        color: #fff;
        border-color: #b70d0f;
    }
    #story-wrapper .btn-history:hover svg { stroke: #fff; }

    #story-wrapper .timeline-slider {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        margin-top: 50px;
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: 20px;
    }
    #story-wrapper .timeline-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        min-width: 120px;
    }
    #story-wrapper .timeline-item .year {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 30px;
        background: #f9f9f9;
        z-index: 2;
        padding: 0 15px;
    }
    #story-wrapper .timeline-item::after {
        content: '';
        position: absolute;
        top: 12px;
        left: 50%;
        width: 100%;
        height: 1px;
        background-color: #dcdcdc;
        z-index: 1;
    }
    #story-wrapper .timeline-item:last-child::after {
        display: none;
    }
    #story-wrapper .timeline-item img {
        width: 85px;
        height: 125px;
        object-fit: cover;
        box-shadow: 2px 4px 10px rgba(0,0,0,0.15);
        transition: transform 0.3s ease;
    }
    #story-wrapper .timeline-item:hover img {
        transform: translateY(-8px);
    }
    
    /* === TEXT & 3-IMAGE GRID SECTION === */
    #story-wrapper .split-section {
        display: flex;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 5%;
        align-items: center;
        gap: 30px;
    }
    
    #story-wrapper .split-section.reverse-mobile {
        padding-top: 10px;
    }

    #story-wrapper .text-content {
        flex: 1;
    }

    #story-wrapper .text-content p {
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 20px;
        font-weight: 500;
    }

    #story-wrapper .btn-browse {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 20px;
        border: 1px solid #999;
        border-radius: 20px;
        text-decoration: none;
        color: #000;
        font-weight: 700;
        font-size: 0.85rem;
        transition: all 0.3s;
    }
    #story-wrapper .btn-browse:hover { 
        border-color: #b70d0f; 
        background-color: #b70d0f;
        color: #ffffff;
    }
    #story-wrapper .btn-browse svg { width: 14px; height: 14px; fill: #b70d0f; transition: fill 0.3s; }
    #story-wrapper .btn-browse:hover svg { fill: #ffffff; }

    #story-wrapper .faq-link {
        display: block;
        margin-top: 15px;
        color: #b70d0f;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: color 0.3s;
    }
    #story-wrapper .faq-link:hover {
        color: #8c0a0c;
        text-decoration: underline;
    }

    /* Grid 3 Gambar */
    #story-wrapper .image-grid-3 {
        flex: 1;
        display: flex; /* Changed from grid to flex for smooth transitions */
        gap: 5px;
        height: 350px;
    }

    #story-wrapper .image-grid-3 div {
        flex: 1;
        overflow: hidden;
        transition: flex 0.5s ease;
    }

    /* Default state is handled by JS adding .active class */
    #story-wrapper .image-grid-3 div.active {
        flex: 1.8;
    }

    #story-wrapper .image-grid-3 img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    #story-wrapper .image-grid-3 div:hover img {
        transform: scale(1.05);
    }
    


    /* === BLUE / GREEN BANNER SECTION === */
    #story-wrapper .color-banner-row {
        display: flex;
        width: 100%;
        height: 250px;
        margin-bottom: 5px;
    }

    #story-wrapper .banner-img-container {
        width: 75%;
        overflow: hidden;
    }
    #story-wrapper .banner-img-container img {
        transition: transform 0.6s ease;
    }
    #story-wrapper .banner-img-container:hover img {
        transform: scale(1.03);
    }

    #story-wrapper .banner-text-box {
        width: 25%;
        display: flex;
        align-items: center;
        padding: 30px;
    }

    #story-wrapper .banner-text-box h2 {
        color: #ffffff;
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1.2;
        margin: 0;
    }

    #story-wrapper .bg-blue { background-color: #006eb7; }
    #story-wrapper .bg-green { background-color: #7a9c46; }

    /* === FOOTER SOCIAL MEDIA (DIV) === */
    #story-wrapper .footer-social {
        text-align: center;
        padding: 30px 20px;
        font-size: 0.95rem;
        font-weight: 600;
        color: #000;
    }
    #story-wrapper .footer-social a {
        color: #333;
        text-decoration: none;
        margin: 0 12px;
        transition: color 0.3s ease;
        position: relative;
    }
    #story-wrapper .footer-social a::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -4px;
        left: 0;
        background-color: #b70d0f; /* red underline */
        transition: width 0.3s ease;
    }
    #story-wrapper .footer-social a:hover {
        color: #b70d0f;
    }
    #story-wrapper .footer-social a:hover::after {
        width: 100%;
    }
    #story-wrapper .footer-social span.separator {
        color: #ccc;
    }

    /* === RESPONSIVE (MOBILE) === */
    @media (max-width: 900px) {
        #story-wrapper .hero-content h1 { font-size: 2.5rem; }
        #story-wrapper .split-section { flex-direction: column; }
        #story-wrapper .image-grid-3 { width: 100%; height: 250px; }
        
        #story-wrapper .color-banner-row { flex-direction: column; height: auto; }
        #story-wrapper .banner-img-container, #story-wrapper .banner-text-box { width: 100%; }
        #story-wrapper .banner-img-container { height: 200px; }
        #story-wrapper .banner-text-box { text-align: center; justify-content: center; }
        
        #story-wrapper .reverse-mobile { flex-direction: column-reverse; }
    }
</style>
@endpush

@section('content')
<div id="story-wrapper">

    <div class="hero-section">
        <div class="hero-video-wrapper">
            <iframe 
                src="https://www.youtube.com/embed/sDuCushc_sU?autoplay=1&mute=1&loop=1&playlist=sDuCushc_sU&controls=0&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1&disablekb=1" 
                allow="autoplay; encrypted-media" 
                allowfullscreen>
            </iframe>
        </div>
        
        <div class="hero-content">
            <h1>Everyone Has a<br>Story to Tell</h1>
            <a href="#" class="btn-watch">Watch Our Story</a>
        </div>
    </div>

    <style>
        #story-wrapper .sponsor-link {
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            width: 140px;  /* Kotak pembatas seragam */
            height: 50px;  /* Kotak pembatas seragam */
        }

        #story-wrapper .banner-sponsor-logo {
            width: 100% !important;
            height: 100% !important;
            object-fit: contain;
            filter: brightness(0) invert(1) opacity(0.6); /* Putih transparan */
            transition: all 0.3s ease;
            transform: scale(var(--logo-scale, 1)); /* Fitur scale custom */
        }

        #story-wrapper .sponsor-link:hover .banner-sponsor-logo {
            filter: none; /* Kembali ke warna asli gambar */
            transform: scale(calc(var(--logo-scale, 1) * 1.15)); /* Membesar sedikit saat hover */
        }
    </style>
    <div class="logo-banner">
        <a href="https://www.pertaminapatraniaga.com/" target="_blank" class="sponsor-link">
            <img src="{{ asset('img/sponsor/PT_Pertamina_Patra_Niaga.svg-1024x576.png') }}" alt="Pertamina" class="banner-sponsor-logo" style="--logo-scale: 1.4    ;">
        </a>
        <a href="https://injourney.id/" target="_blank" class="sponsor-link">
            <img src="{{ asset('img/sponsor/ias-logo-7_eaFq_i.png') }}" alt="InJourney" class="banner-sponsor-logo" style="--logo-scale: 0.8;">
        </a>
        <a href="https://sarinah.co.id/" target="_blank" class="sponsor-link">
            <img src="{{ asset('img/sponsor/Sarinah png.png') }}" alt="Sarinah" class="banner-sponsor-logo" style="--logo-scale: 1.1;">
        </a>
        <a href="https://www.hyundai.com/id/id" target="_blank" class="sponsor-link">
            <img src="{{ asset('img/sponsor/hyundai.svg') }}" alt="Hyundai" class="banner-sponsor-logo" style="--logo-scale: 0.8;">
        </a>
        <a href="https://www.telkomsel.com/" target="_blank" class="sponsor-link">
            <img src="{{ asset('img/sponsor/telkomsel-baru-2021.png') }}" alt="Telkomsel" class="banner-sponsor-logo" style="--logo-scale: 1.5;">
        </a>
    </div>

    <div class="split-section">
        <div class="text-content">
            <p>
             Bersama para penulis dan kontributor Galeri Buku Jakarta yang dicintai pembacanya. Galeri Buku Jakarta selalu memiliki misi ganda: untuk mempromosikan penulis yang paling menarik dan untuk mendukung pembaca yang ambisius dan ingin tahu. Kisah-kisah itu penting dan membawa para pembaca pada kedalaman dan kebermaknaan. Galeri Buku Jakarta mengetengahkan tulisan penting dan mendalam; kolom dan pemikiran ahli tentang peristiwa sosial, seni dan politik, bisnis dan sains—bersama dengan dosis dari publikasi karya terjemahan, puisi dan cerita pendek juga kajian bukunya yang khas.
            </p>
            
            <a href="#" class="btn-browse">
                Selengkapnya
                <svg viewBox="0 0 24 24"><path d="M14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3m-2 16H5V5h7V3H5c-1.11 0-2 .89-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7z"/></svg>
            </a>
        </div>
        
        <div class="image-grid-3">
            <div><img src="{{ asset('pustaka/tentang1.png') }}" alt="Worker 1"></div>
            <div><img src="{{ asset('pustaka/tentang2.jpeg') }}" alt="Worker 2"></div>
            <div><img src="{{ asset('pustaka/tentang3.png') }}" alt="Worker 3"></div>
        </div>
    </div>

    <!-- TIMELINE DIVIDER -->
    <div class="timeline-section">
        <div class="timeline-header">
            <div class="orange-line"></div>
            <h2>Bersama Hasilkan Karya Bermakna</h2>
            <p>Ihtisar karya publikasi buku dan kolaborasi karya Galeri Buku Jakarta</p>
            <a href="#" class="btn-history">
                View History 
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
            </a>
        </div>
        
        <div class="timeline-slider">
            <div class="timeline-item">
                <span class="year">2012</span>
                <img src="{{ asset('tentang_assets/2012.jpg') }}" alt="Book 2012">
            </div>
            <div class="timeline-item">
                <span class="year">2018</span>
                <img src="{{ asset('tentang_assets/2018.jpg') }}" alt="Book 2018">
            </div>
            <div class="timeline-item">
                <span class="year">2019</span>
                <img src="https://picsum.photos/100/150?random=14" alt="Book 1935">
            </div>
            <div class="timeline-item">
                <span class="year">2021</span>
                <img src="https://picsum.photos/100/150?random=15" alt="Book 1960">
            </div>
            <div class="timeline-item">
                <span class="year">2022</span>
                <img src="https://picsum.photos/100/150?random=16" alt="Book 1969">
            </div>
            <div class="timeline-item">
                <span class="year">2024</span>
                <img src="https://picsum.photos/100/150?random=11" alt="Book 1897">
            </div>
            <div class="timeline-item">
                <span class="year">2026</span>
                <img src="https://picsum.photos/100/150?random=17" alt="Book 1988">
            </div>
        </div>
    </div>

    <div class="split-section reverse-mobile">
        <div class="image-grid-3">
            <div><img src="{{ asset('pustaka/tentangg1.jpeg') }}" alt="Office 1"></div>
            <div><img src="{{ asset('pustaka/tentangg2.jpeg') }}" alt="Office 2"></div>
            <div><img src="{{ asset('pustaka/tentangg3.jpeg') }}" alt="Office 3"></div>
        </div>

        <div class="text-content">
            <p>
              Setiap minggu selama lebih dari 10 tahun, Kami telah mencurahkan waktu, pikiran, cinta, dan sumber daya yang luar biasa untuk kerja cinta ini; menghasilan narasi dan kisah mendalam juga bermakna dan memberi dampak. Menghadirkan dunia melintasi batas-batas identitas lebih luas melalui kerja penerjemahan sebagai misi kosmopolitanisme kultural dalam identitas tak terbatas. Antara secangkir kopi dan makan siang yang enak. Dukungan Anda akan sangat berharga.  
            </p>
            
            <a href="{{ route('publikasi.index') }}" class="btn-browse">
                Our Publication
                <svg viewBox="0 0 24 24"><path d="M14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3m-2 16H5V5h7V3H5c-1.11 0-2 .89-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7z"/></svg>
            </a>
            <a href="{{ route('penerbitan') }}" class="faq-link">Getting Published</a>
        </div>
    </div>

    <div class="logo-banner-h">
        <h3 class="aesthetic-title">Kunjungi Toko Kami</h3>
        <a href="https://id.shp.ee/PLrzfWhi" target="_blank" class="store-link">
            <i class="fas fa-shopping-bag"></i> Shopee
        </a>
        <a href="https://play.google.com/books/publish/u/0/a/10617596503720814872#book/GGKEY:5USWAWPRK7G/review" target="_blank" class="store-link">
            <i class="fab fa-google-play"></i> Google Play
        </a>
        <a href="https://www.tiktok.com" target="_blank" class="store-link">
            <i class="fab fa-tiktok"></i> TikTok
        </a>
        <a href="https://www.instagram.com/galeribuku_jkt/" target="_blank" class="store-link">
            <i class="fab fa-instagram"></i> Instagram
        </a>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logika untuk menyimpan/mengingat foto terakhir yang di-hover (diperbesar)
        const grids = document.querySelectorAll('.image-grid-3');
        grids.forEach(grid => {
            const items = grid.querySelectorAll('div');
            
            // Set default foto tengah sebagai yang terbesar (index 1)
            if (items.length > 1) {
                items[1].classList.add('active');
            } else if (items.length > 0) {
                items[0].classList.add('active');
            }

            // Tambahkan event listener saat kursor masuk ke salah satu foto
            items.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    items.forEach(i => i.classList.remove('active'));
                    item.classList.add('active');
                });
            });
        });
    });
</script>
@endpush

@endsection
