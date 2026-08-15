@extends('layouts.app')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* === SCOPED STYLES TO PREVENT CONFLICT === */
    #penguin-overview-wrapper {
        font-family: 'Inter', sans-serif;
        color: #333333;
        background-color: #ffffff;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        padding: 0 0 40px 0; /* Padding atas dibuat 0 agar menempel ke navbar */
    }

    #penguin-overview-wrapper * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    #penguin-overview-wrapper .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px 0 20px; /* Padding atas ditambahkan untuk jarak dari logo banner */
    }

    /* === LOGO BANNER === */
    #penguin-overview-wrapper .logo-banner {
        background-color: #1a1a1a;
        padding: 20px 5%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 40px;
        flex-wrap: wrap;
    }

    #penguin-overview-wrapper .sponsor-link {
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        width: 140px;
        height: 50px;
    }

    #penguin-overview-wrapper .banner-sponsor-logo {
        width: 100% !important;
        height: 100% !important;
        object-fit: contain;
        filter: brightness(0) invert(1) opacity(0.6);
        transition: all 0.3s ease;
        transform: scale(var(--logo-scale, 1));
    }

    #penguin-overview-wrapper .sponsor-link:hover .banner-sponsor-logo {
        filter: none;
        transform: scale(calc(var(--logo-scale, 1) * 1.15));
    }

    /* === INFO BOXES GRID === */
    #penguin-overview-wrapper .info-boxes-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 20px;
        margin-bottom: 60px;
    }

    #penguin-overview-wrapper .info-box {
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        border-radius: 4px;
        min-height: 380px;
        background-color: transparent;
        border: 1px solid #ddd;
        transition: all 0.4s ease;
    }

    #penguin-overview-wrapper .info-box h3 {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: #111;
        line-height: 1.2;
    }

    #penguin-overview-wrapper .info-box p {
        font-size: 0.95rem;
        color: #444;
        margin-bottom: 25px;
        line-height: 1.5;
    }

    #penguin-overview-wrapper .btn-box {
        display: inline-block;
        padding: 10px 25px;
        font-weight: 700;
        text-transform: uppercase;
        text-decoration: none;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border-radius: 4px;
        margin-top: auto;
    }

    /* Spesifik Box & Hover Effect */
    #penguin-overview-wrapper .box-media-combined h3 { font-size: 2.2rem; margin-bottom: 20px; }
    
    #penguin-overview-wrapper .box-media-combined:hover {
        background-color: #e8e8f3;
        border-color: #e8e8f3;
    }
    
    #penguin-overview-wrapper .box-rate:hover {
        background-color: #e0ece4;
        border-color: #e0ece4;
    }
    
    #penguin-overview-wrapper .box-donate:hover {
        background-color: #e0dfda;
        border-color: #e0dfda;
    }

    /* Custom Button Colors */
    #penguin-overview-wrapper .box-media-combined .btn-box,
    #penguin-overview-wrapper .box-rate .btn-box {
        border: 2px solid #111;
        color: #111;
    }
    #penguin-overview-wrapper .box-media-combined .btn-box:hover,
    #penguin-overview-wrapper .box-rate .btn-box:hover {
        background-color: #111;
        color: #fff;
    }

    #penguin-overview-wrapper .box-donate .btn-box {
        background-color: #673ab7;
        color: #ffffff;
        border: 2px solid #673ab7;
    }
    #penguin-overview-wrapper .box-donate .btn-box:hover {
        background-color: #512da8;
        border-color: #512da8;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        #penguin-overview-wrapper .info-boxes-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        #penguin-overview-wrapper .info-boxes-grid {
            grid-template-columns: 1fr;
        }
    }

    /* === HERO SECTION (VIDEO) === */
    #penguin-overview-wrapper .hero-section {
        position: relative;
        width: 100%;
        height: 65vh;
        min-height: 400px;
        overflow: hidden;
        background-color: #000;
    }

    #penguin-overview-wrapper .hero-video-wrapper {
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

    #penguin-overview-wrapper .hero-video-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
        pointer-events: none;
    }

    #penguin-overview-wrapper .hero-content {
        position: absolute;
        bottom: 50px;
        left: 5%;
        z-index: 2;
    }

    #penguin-overview-wrapper .hero-content h1 {
        color: #ffffff;
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 20px;
        max-width: 500px;
        text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
    }

    #penguin-overview-wrapper .btn-watch {
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
    #penguin-overview-wrapper .btn-watch:hover { 
        background-color: #b70d0f; 
        color: #ffffff; 
    }

    /* === 1. BAGIAN ATAS: OVERVIEW === */
    #penguin-overview-wrapper .overview-section {
        margin-bottom: 50px;
    }

    #penguin-overview-wrapper .overview-tag {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #777777;
        letter-spacing: 1px;
        margin-bottom: 25px;
    }

    #penguin-overview-wrapper .overview-text {
        font-size: 1.05rem;
        color: #444444;
        text-align: justify;
        margin-bottom: 20px;
        font-weight: 400;
    }

    #penguin-overview-wrapper .section-divider {
        border: none;
        border-top: 1px solid #e0e0e0;
        margin-top: 40px;
    }

    /* === 2. BAGIAN TENGAH: AURA SECTION (BOX ABU-ABU) === */
    #penguin-overview-wrapper .aura-container {
        background-color: #f4f4f4;
        padding: 60px;
        display: flex;
        align-items: center;
        gap: 50px;
        margin-bottom: 60px;
    }

    #penguin-overview-wrapper .aura-text-col {
        flex: 1;
    }

    #indicators-row {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 40px;
        font-size: 0.8rem;
        color: #666;
    }

    #indicators-row .arrow-nav {
        cursor: pointer;
        user-select: none;
    }

    #penguin-overview-wrapper .aura-title {
        font-size: 2.5rem;
        font-weight: 400;
        color: #111111;
        margin-bottom: 10px;
        letter-spacing: -0.5px;
    }

    #penguin-overview-wrapper .aura-subtitle {
        font-size: 1.25rem;
        font-weight: 600;
        color: #222222;
        margin-bottom: 25px;
        line-height: 1.3;
    }

    #penguin-overview-wrapper .aura-desc {
        font-size: 0.9rem;
        color: #555555;
        margin-bottom: 30px;
        line-height: 1.5;
    }

    #penguin-overview-wrapper .btn-learn-more {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        border: 1px solid #333333;
        border-radius: 25px;
        background-color: transparent;
        color: #111111;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    #penguin-overview-wrapper .btn-learn-more:hover {
        background-color: #111111;
        color: #ffffff;
    }

    #penguin-overview-wrapper .aura-visual-col {
        flex: 1.2;
        background-color: #1a1a1a;
        border-radius: 8px;
        padding: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    /* Transisi fade out untuk text */
    #penguin-overview-wrapper .fade-text {
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }

    /* === EDITORIAL SLIDE LAYOUTS === */
    .ed-polaroid {
        background: #fff; padding: 12px 12px 30px 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transform: rotate(-2deg); transition: all 0.3s ease;
        max-width: 300px; width: 100%;
    }
    .ed-polaroid:hover { transform: rotate(0) scale(1.02); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
    .ed-polaroid img { width: 100%; aspect-ratio: 1; object-fit: cover; filter: grayscale(100%); transition: filter 0.3s ease; }
    .ed-polaroid:hover img { filter: grayscale(0%); }
    .ed-caption { text-align: center; margin-top: 15px; font-weight: 500; font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase; color: #111; }

    .ed-circle-wrap {
        position: relative; width: 280px; height: 280px;
        display: flex; align-items: center; justify-content: center;
    }
    .ed-circle-ring {
        position: absolute; width: 100%; height: 100%;
        border: 1px dashed rgba(255,255,255,0.3); border-radius: 50%;
        animation: spin 20s linear infinite;
    }
    .ed-circle-img {
        width: 85%; height: 85%; border-radius: 50%; object-fit: cover;
        filter: grayscale(100%); transition: all 0.4s ease;
    }
    .ed-circle-wrap:hover .ed-circle-img { filter: grayscale(0%); transform: scale(1.05); }
    @keyframes spin { 100% { transform: rotate(360deg); } }

    .ed-duo { position: relative; width: 300px; height: 340px; }
    .ed-duo-bg {
        position: absolute; top: 0; left: 0; width: 220px; height: 280px;
        object-fit: cover; filter: grayscale(100%); opacity: 0.6;
        transition: all 0.4s ease;
    }
    .ed-duo-fg {
        position: absolute; bottom: 0; right: 0; width: 200px; height: 200px;
        object-fit: cover; border: 4px solid #1a1a1a;
        box-shadow: -10px -10px 0 rgba(255,255,255,0.05);
        transition: all 0.4s ease; filter: grayscale(100%);
    }
    .ed-duo:hover .ed-duo-bg { opacity: 1; filter: grayscale(50%); transform: translate(-10px, -10px); }
    .ed-duo:hover .ed-duo-fg { filter: grayscale(0%); transform: translate(10px, 10px); }

    .ed-simple {
        width: 100%; max-width: 320px; border-radius: 6px; overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.15); transition: transform 0.3s ease;
    }
    .ed-simple:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.25); }
    .ed-simple-img {
        width: 100%; aspect-ratio: 4/3; object-fit: cover; display: block;
        filter: grayscale(80%); transition: filter 0.3s ease;
    }
    .ed-simple:hover .ed-simple-img { filter: grayscale(0%); }

    .ed-magazine { position: relative; width: 260px; height: 340px; }
    .ed-mag-block {
        position: absolute; top: 20px; left: 20px; width: 100%; height: 100%;
        background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.2);
        transition: all 0.4s ease;
    }
    .ed-mag-img {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        object-fit: cover; filter: grayscale(100%); transition: all 0.4s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.3);
    }
    .ed-magazine:hover .ed-mag-block { transform: translate(15px, 15px); background: rgba(255,255,255,0.08); }
    .ed-magazine:hover .ed-mag-img { filter: grayscale(0%); transform: translate(-5px, -5px); }

    /* === 3. BAGIAN BAWAH: BRAND GRID (DIKEMBALIKAN KE SVG) === */
    #penguin-overview-wrapper .brand-section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        padding-bottom: 15px;
        border-bottom: 2px solid #111111;
        margin-bottom: 40px;
    }

    #penguin-overview-wrapper .brand-main-title {
        font-size: 2rem;
        font-weight: 700;
        color: #111111;
    }

    #penguin-overview-wrapper .brand-mini-logo {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #444;
        line-height: 1.2;
    }

    /* Grid Logo Penerbit dengan gaya SVG sebelumnya */
    #penguin-overview-wrapper .logos-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        row-gap: 50px;
        column-gap: 20px;
    }

    #penguin-overview-wrapper .logo-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        text-align: center;
        height: 80px; 
        transition: transform 0.2s ease;
    }

    #penguin-overview-wrapper .logo-container:hover {
        transform: scale(1.05);
    }

    #penguin-overview-wrapper .logo-art {
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }

    #penguin-overview-wrapper .logo-text {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #000;
        line-height: 1.2;
    }

    /* === RESPONSIVITAS MOBILE === */
    @media (max-width: 950px) {
        #penguin-overview-wrapper .aura-container {
            flex-direction: column;
            padding: 40px 30px;
        }
        #penguin-overview-wrapper .aura-text-col, 
        #penguin-overview-wrapper .aura-visual-col {
            width: 100%;
        }
        #penguin-overview-wrapper .logos-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 600px) {
        #penguin-overview-wrapper .brand-section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        #penguin-overview-wrapper .logos-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        #penguin-overview-wrapper h1 { font-size: 2.5rem; }
    }
</style>
@endpush

@section('content')
<div id="penguin-overview-wrapper">
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
            <a href="#" class="btn-watch">About Us</a>
        </div>
    </div>
    <div class="logo-banner">
        <a href="https://www.pertaminapatraniaga.com/" target="_blank" class="sponsor-link">
            <img src="{{ asset('img/sponsor/PT_Pertamina_Patra_Niaga.svg-1024x576.png') }}" alt="Pertamina" class="banner-sponsor-logo" style="--logo-scale: 1.4;">
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
    <div class="container">
        
        <!-- Info Boxes -->
        <div class="info-boxes-grid">
            <div class="info-box box-media-combined">
                <div class="info-box-content">
                    <h3>Media Kit</h3>
                    <p>Kami telah bekerja dalam rentang panjang memfasilitasi keberagaman dan kolaborasi keahalian para “seniman” dan “pemikir” terbaik. Kami bekerja dengan integritas, hati dan profesionalitas yang membantu publik dan bisnis bertumbuh melampaui semata-mata hasil—melainkan sebagaimana seni, ia menciptakan ruang multiperspektif, berusia panjang untuk dikenang—menghasilkan karya, keindahan dan dampak kemajuan. Dengan cara itu kami berkontribusi bagi kemajuan bisnis, kota-kota dan Indonesia.</p>
                </div>
                <a href="#" class="btn-box">Selengkapnya</a>
            </div>

            <div class="info-box box-rate">
                <div class="info-box-content">
                    <h3>Rate Card</h3>
                    <p>Learn about opportunities to advertise in our magazine or on our digital/mobile site. For complete information, see our Rate Card</p>
                </div>
                <a href="#" class="btn-box">Selengkapnya</a>
            </div>

            <div class="info-box box-donate">
                <div class="info-box-content">
                    <h3>Donate to Galeri Buku Jakarta</h3>
                    <p>To learn more about us and our mission, or if you have any questions about donating to the Galeri Buku Jakarta, please contact galeribukujakarta@gmail.com</p>
                </div>
                <a href="{{ route('donate') }}" class="btn-box">DONATE</a>
            </div>
        </div>

        <div class="brand-section-header">
            <div class="brand-main-title">Galeri Sponsorship Group</div>
        </div>

        <div class="logos-grid">
            <div class="logo-container">
                <div class="logo-art"><img src="{{ asset('pustaka/logo model.jpeg') }}" style="max-width: 70px; max-height: 60px; object-fit: contain;" alt="Avery Logo"></div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="50" height="50" viewBox="0 0 60 60"><rect x="10" y="5" width="40" height="50" fill="none" stroke="black" stroke-width="2"/><text x="30" y="45" font-family="serif" font-size="40" text-anchor="middle">B</text></svg></div>
                <div class="logo-text">BERKLEY</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="35" height="45" viewBox="0 0 40 50"><rect x="5" y="5" width="30" height="40" fill="none" stroke="black" stroke-width="3"/></svg></div>
                <div class="logo-text">DUTTON</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="45" height="50" viewBox="0 0 50 60"><rect x="0" y="0" width="50" height="60" fill="black"/><text x="25" y="45" font-family="serif" font-size="45" font-style="italic" fill="white" text-anchor="middle">ft</text></svg></div>
                <div class="logo-text">FAMILY<br>TREE<br>BOOKS</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="85" height="25" viewBox="0 0 100 30"><rect x="0" y="0" width="100" height="30" rx="15" fill="#222"/><text x="50" y="16" font-family="sans-serif" font-size="10" font-weight="bold" fill="white" text-anchor="middle" letter-spacing="1">PUTNAM</text><text x="50" y="24" font-family="sans-serif" font-size="5" fill="white" text-anchor="middle" letter-spacing="2">EST. 1838</text></svg></div>
                <div class="logo-text"></div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="40" height="50" viewBox="0 0 40 60"><text x="20" y="55" font-family="serif" font-size="60" font-weight="bold" text-anchor="middle">I</text><line x1="0" y1="20" x2="40" y2="30" stroke="white" stroke-width="3"/><line x1="0" y1="40" x2="40" y2="35" stroke="white" stroke-width="2"/></svg></div>
                <div class="logo-text">IMPACT</div>
            </div>

            <div class="logo-container">
                <div class="logo-art"><svg width="45" height="55" viewBox="0 0 50 60"><rect x="0" y="0" width="50" height="60" fill="black"/><circle cx="25" cy="30" r="18" fill="white"/><text x="25" y="38" font-family="serif" font-size="28" font-weight="bold" fill="black" text-anchor="middle">kp</text></svg></div>
                <div class="logo-text"></div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="40" height="50" viewBox="0 0 50 60"><path d="M10,60 L20,0 L40,60" fill="none" stroke="black" stroke-width="8"/><path d="M10,0 L10,60" stroke="black" stroke-width="8"/><path d="M40,0 L40,60" stroke="black" stroke-width="8"/><line x1="0" y1="10" x2="50" y2="20" stroke="white" stroke-width="2"/><line x1="0" y1="30" x2="50" y2="40" stroke="white" stroke-width="3"/></svg></div>
                <div class="logo-text">NORTH<br>LIGHT<br>BOOKS</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="45" height="45" viewBox="0 0 50 50"><circle cx="25" cy="25" r="20" fill="none" stroke="black" stroke-width="1.5"/><text x="25" y="30" font-family="serif" font-size="16" fill="black" text-anchor="middle">pgd</text></svg></div>
                <div class="logo-text" style="font-size:7px;">PAMELA<br>DORMAN<br>BOOKS<br>VIKING</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="35" height="45" viewBox="0 0 40 50"><ellipse cx="20" cy="25" rx="15" ry="22" fill="none" stroke="black" stroke-width="2"/><path d="M20,10 C15,15 15,35 20,40 C25,35 25,15 20,10 Z" fill="black"/></svg></div>
                <div class="logo-text">PENGUIN<br>CLASSICS</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="45" height="45" viewBox="0 0 50 50"><rect x="0" y="0" width="50" height="50" fill="black"/><text x="20" y="35" font-family="serif" font-size="30" fill="white" text-anchor="middle">P</text><text x="30" y="35" font-family="serif" font-size="30" fill="white" text-anchor="middle">P</text></svg></div>
                <div class="logo-text" style="text-transform: capitalize;">Penguin<br>Press</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="40" height="40" viewBox="0 0 50 50"><path d="M25,45 C10,45 10,25 25,25 C40,25 40,5 25,5 C10,5 10,25 25,25" fill="none" stroke="black" stroke-width="5"/><circle cx="25" cy="25" r="5" fill="black"/></svg></div>
                <div class="logo-text">PLUME</div>
            </div>

            <div class="logo-container">
                <div class="logo-art"><svg width="40" height="45" viewBox="0 0 40 50"><rect x="0" y="15" width="40" height="15" fill="black"/><text x="20" y="45" font-family="serif" font-size="50" font-weight="bold" fill="black" text-anchor="middle">P</text><rect x="0" y="15" width="40" height="15" fill="none" stroke="white" stroke-width="2"/></svg></div>
                <div class="logo-text" style="font-size:7px;">POPULAR WOODWORKING BOOKS</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="45" height="50" viewBox="0 0 50 60"><circle cx="25" cy="45" r="15" fill="#e86b24"/><path d="M15,60 L25,30 L35,60 Z" fill="black"/><circle cx="25" cy="25" r="5" fill="black"/><line x1="10" y1="10" x2="40" y2="40" stroke="black" stroke-width="2"/></svg></div>
                <div class="logo-text">PORTFOLIO<br>PENGUIN</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="45" height="45" viewBox="0 0 50 50"><rect x="0" y="0" width="50" height="50" fill="#222"/><text x="25" y="38" font-family="serif" font-size="40" fill="white" text-anchor="middle">R</text></svg></div>
                <div class="logo-text"></div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="40" height="50" viewBox="0 0 40 60"><rect x="30" y="20" width="8" height="12" fill="black"/><path d="M20,10 L15,60 L25,60 Z" fill="black"/><circle cx="20" cy="15" r="6" fill="black"/><line x1="20" y1="20" x2="35" y2="20" stroke="black" stroke-width="2"/></svg></div>
                <div class="logo-text">SENTINEL</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="35" height="45" viewBox="0 0 40 50"><text x="20" y="45" font-family="serif" font-size="45" font-style="italic" fill="#0b7a39" text-anchor="middle">t</text><path d="M20,10 C25,5 35,5 40,10" fill="none" stroke="#0b7a39" stroke-width="3"/></svg></div>
                <div class="logo-text" style="text-transform: capitalize;">Tarcher</div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="65" height="45" viewBox="0 0 80 50"><text x="35" y="45" font-family="serif" font-size="45" font-weight="bold" fill="#222" text-anchor="middle">A</text><path d="M15,45 L20,30 L25,45 Z" fill="black"/><circle cx="20" cy="25" r="4" fill="black"/><line x1="20" y1="35" x2="30" y2="35" stroke="black" stroke-width="3"/><text x="50" y="20" font-family="sans-serif" font-size="14" font-weight="bold">Tiny</text><text x="50" y="35" font-family="sans-serif" font-size="14" font-weight="bold">Rep</text><text x="50" y="50" font-family="sans-serif" font-size="14" font-weight="bold">Books</text></svg></div>
                <div class="logo-text"></div>
            </div>

            <div class="logo-container">
                <div class="logo-art"><svg width="55" height="35" viewBox="0 0 60 40"><ellipse cx="30" cy="20" rx="25" ry="18" fill="none" stroke="black" stroke-width="1.5"/><path d="M10,25 Q30,40 50,25 Q30,30 10,25 Z" fill="black"/><path d="M25,5 L25,25 L35,25 L35,5 Z" fill="none" stroke="black" stroke-width="1.5"/><path d="M30,5 L40,15 L30,25" fill="none" stroke="black" stroke-width="1.5"/></svg></div>
                <div class="logo-text"></div>
            </div>
            <div class="logo-container">
                <div class="logo-art"><svg width="45" height="45" viewBox="0 0 50 50"><circle cx="25" cy="25" r="23" fill="#222"/><circle cx="25" cy="25" r="20" fill="none" stroke="white" stroke-width="1"/><text x="25" y="32" font-family="sans-serif" font-size="18" font-weight="bold" fill="white" text-anchor="middle">WD</text></svg></div>
                <div class="logo-text">WRITER'S DIGEST<br>BOOKS</div>
            </div>
            
            <div></div><div></div><div></div><div></div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const slides = [
        {
            title: "AURA",
            subtitle: "Next-Generation First-Party Targeting",
            desc: "Our revolutionary targeting tool utilizes our own audience data, multi-layered content and commerce signals and proprietary AI-enabled segmentation for future-proofed addressability and reach accuracy.",
            html: `
                <div class="ed-polaroid">
                    <img src="https://picsum.photos/seed/slide1/400/400" alt="Slide 1">
                    <div class="ed-caption">Precision Targeting</div>
                </div>
            `
        },
        {
            title: "REACH",
            subtitle: "Expand Your Horizon",
            desc: "Connect with millions of active readers through our curated network. We bridge the gap between creative storytelling and engaged communities to amplify your brand's voice.",
            html: `
                <div class="ed-circle-wrap">
                    <div class="ed-circle-ring"></div>
                    <img src="https://picsum.photos/seed/slide2/400/400" class="ed-circle-img" alt="Slide 2">
                </div>
            `
        },
        {
            title: "ENGAGE",
            subtitle: "Deep Audience Connection",
            desc: "Build meaningful relationships with readers who are passionate about literature and culture. Our platform ensures your message resonates with the right demographic.",
            html: `
                <div class="ed-duo">
                    <img src="https://picsum.photos/seed/slide3a/300/400" class="ed-duo-bg" alt="Back Image">
                    <img src="https://picsum.photos/seed/slide3b/300/300" class="ed-duo-fg" alt="Front Image">
                </div>
            `
        },
        {
            title: "ANALYZE",
            subtitle: "Data-Driven Decisions",
            desc: "Gain actionable insights into reader behavior and campaign performance. We provide comprehensive analytics to help you optimize your marketing strategies effectively.",
            html: `
                <div class="ed-simple">
                    <img src="https://picsum.photos/seed/slide4/400/300" class="ed-simple-img" alt="Simple">
                </div>
            `
        },
        {
            title: "GROW",
            subtitle: "Sustainable Audience Growth",
            desc: "Scale your brand presence efficiently with our proven marketing frameworks. We partner with you to achieve long-term growth and sustainable market dominance.",
            html: `
                <div class="ed-magazine">
                    <div class="ed-mag-block"></div>
                    <img src="https://picsum.photos/seed/slide5/400/500" class="ed-mag-img" alt="Magazine">
                </div>
            `
        }
    ];

    let currentIdx = 0;
    
    const titleEl = document.getElementById("slide-title");
    const subtitleEl = document.getElementById("slide-subtitle");
    const descEl = document.getElementById("slide-desc");
    const visualEl = document.getElementById("slide-visual");
    const currentSlideEl = document.getElementById("current-slide");
    
    const prevBtn = document.getElementById("prev-slide");
    const nextBtn = document.getElementById("next-slide");

    function updateSlide(newIdx) {
        titleEl.classList.add("fade-text");
        subtitleEl.classList.add("fade-text");
        descEl.classList.add("fade-text");
        visualEl.style.opacity = '0';
        visualEl.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            currentIdx = newIdx;
            const slide = slides[currentIdx];
            
            titleEl.textContent = slide.title;
            subtitleEl.textContent = slide.subtitle;
            descEl.textContent = slide.desc;
            visualEl.innerHTML = slide.html;
            currentSlideEl.textContent = currentIdx + 1;
            
            titleEl.classList.remove("fade-text");
            subtitleEl.classList.remove("fade-text");
            descEl.classList.remove("fade-text");
            visualEl.style.opacity = '1';
            visualEl.style.transform = 'scale(1)';
        }, 300);
    }

    prevBtn.addEventListener("click", () => {
        let nextIdx = currentIdx - 1;
        if (nextIdx < 0) nextIdx = slides.length - 1;
        updateSlide(nextIdx);
    });

    nextBtn.addEventListener("click", () => {
        let nextIdx = currentIdx + 1;
        if (nextIdx >= slides.length) nextIdx = 0;
        updateSlide(nextIdx);
    });
});
</script>
@endpush
