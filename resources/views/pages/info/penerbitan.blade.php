@extends('layouts.app')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* === SCOPED STYLES (Mencegah Konflik Layout Global) === */
    #penguin-corporate-wrapper {
        font-family: 'Inter', sans-serif;
        color: #333333;
        background-color: #ffffff;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        padding: 40px 0;
        width: 100%;
    }

    #penguin-corporate-wrapper * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    #penguin-corporate-wrapper .container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* === 1. BAGIAN ATAS: PENGUIN CLASSICS === */
    #penguin-corporate-wrapper .section-header {
        margin-bottom: 15px;
    }

    #penguin-corporate-wrapper .section-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 10px;
    }

    #penguin-corporate-wrapper .header-divider {
        border: none;
        border-top: 2px solid #555; /* Garis abu-abu tebal */
        margin-bottom: 15px;
    }

    #penguin-corporate-wrapper .classics-row {
        display: flex;
        gap: 30px;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    #penguin-corporate-wrapper .classics-image-col {
        flex: 0 0 45%;
    }

    #penguin-corporate-wrapper .classics-image-col img {
        width: 100%;
        height: auto;
        display: block;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    #penguin-corporate-wrapper .classics-text-col {
        flex: 1;
        font-size: 0.9rem;
        color: #444;
        text-align: justify;
    }

    #penguin-corporate-wrapper .classics-text-col p {
        margin-bottom: 15px;
    }

    /* === 2. BAGIAN BANNER LOGO (BIRU TUA) === */
    #penguin-corporate-wrapper .partner-banner {
        background-color: #002b5c; /* Biru tua korporat */
        padding: 30px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }

    /* Styling Mockup Logo Putih */
    #penguin-corporate-wrapper .mock-logo {
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    #penguin-corporate-wrapper .logo-prh { font-family: serif; font-size: 0.75rem; line-height: 1.1; }
    #penguin-corporate-wrapper .logo-prh-icon { border: 1px solid #fff; border-radius: 50%; width: 24px; height: 24px; display: inline-block; }
    
    #penguin-corporate-wrapper .logo-bmg { font-weight: 700; font-size: 1.2rem; letter-spacing: 1px; }
    #penguin-corporate-wrapper .logo-bmg-icon { font-size: 1.5rem; }
    
    #penguin-corporate-wrapper .logo-arvato { font-weight: 600; font-size: 1rem; }
    
    #penguin-corporate-wrapper .logo-bertelsmann { font-size: 0.65rem; line-height: 1.1; display: flex; align-items: center; gap: 8px;}
    #penguin-corporate-wrapper .logo-bertelsmann-line { width: 2px; height: 25px; background-color: #00a0d2; } /* Garis biru muda kecil */

    /* === 3. BAGIAN GRID KARTU (BERMUDA & COSENTINO) === */
    #penguin-corporate-wrapper .cards-row {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
    }

    #penguin-corporate-wrapper .card-large {
        flex: 1.5; /* Proporsi lebih lebar */
    }

    #penguin-corporate-wrapper .card-small {
        flex: 1; /* Proporsi lebih sempit */
    }

    #penguin-corporate-wrapper .content-card {
        position: relative;
        width: 100%;
        height: 350px;
        overflow: hidden;
        border-radius: 4px;
    }

    #penguin-corporate-wrapper .content-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }

    #penguin-corporate-wrapper .content-card:hover img {
        transform: scale(1.05);
    }

    /* Kotak Gelap Overlay */
    #penguin-corporate-wrapper .card-overlay {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background-color: rgba(40, 60, 70, 0.85); /* Warna kotak gelap transparan */
        padding: 25px;
        border-radius: 4px;
        max-width: 80%;
        backdrop-filter: blur(4px);
    }

    /* Variasi warna kotak untuk Cosentino agar agak kecoklatan */
    #penguin-corporate-wrapper .card-overlay.brown-tint {
        background-color: rgba(90, 80, 70, 0.85);
    }

    #penguin-corporate-wrapper .overlay-title {
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    #penguin-corporate-wrapper .overlay-desc {
        color: #f0f0f0;
        font-size: 0.85rem;
        line-height: 1.4;
        margin-bottom: 20px;
    }

    #penguin-corporate-wrapper .btn-discover {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        border: 1px solid #ffffff;
        border-radius: 20px;
        background-color: transparent;
        color: #ffffff;
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    #penguin-corporate-wrapper .btn-discover:hover {
        background-color: #ffffff;
        color: #000000;
    }

    /* === 4. BAGIAN BAWAH: PROGRAMMATIC SERVICES === */
    #penguin-corporate-wrapper .programmatic-row {
        display: flex;
        align-items: center;
        gap: 40px;
        margin-top: 20px;
    }

    #penguin-corporate-wrapper .prog-image-col {
        flex: 1;
    }

    #penguin-corporate-wrapper .prog-image-col img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    #penguin-corporate-wrapper .prog-text-col {
        flex: 1;
        padding-right: 40px;
    }

    #penguin-corporate-wrapper .prog-title {
        font-size: 2.2rem;
        font-weight: 500;
        color: #111111;
        line-height: 1.1;
        margin-bottom: 20px;
        letter-spacing: -0.5px;
    }

    #penguin-corporate-wrapper .prog-desc {
        font-size: 0.85rem;
        color: #555555;
        margin-bottom: 25px;
        line-height: 1.5;
    }

    #penguin-corporate-wrapper .btn-learn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 20px;
        border: 1px solid #333;
        border-radius: 20px;
        background-color: transparent;
        color: #111;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    #penguin-corporate-wrapper .btn-learn:hover {
        background-color: #111;
        color: #fff;
    }

    /* === RESPONSIVITAS MOBILE === */
    @media (max-width: 850px) {
        #penguin-corporate-wrapper .classics-row,
        #penguin-corporate-wrapper .cards-row,
        #penguin-corporate-wrapper .programmatic-row {
            flex-direction: column;
            gap: 30px;
        }
        #penguin-corporate-wrapper .classics-image-col,
        #penguin-corporate-wrapper .card-large,
        #penguin-corporate-wrapper .card-small,
        #penguin-corporate-wrapper .prog-image-col {
            width: 100%;
        }
        #penguin-corporate-wrapper .partner-banner {
            justify-content: center;
        }
        #penguin-corporate-wrapper .prog-text-col {
            padding-right: 0;
            order: -1; /* Teks di atas gambar pada mobile */
        }
    }
</style>
@endpush

@section('content')
<div id="penguin-corporate-wrapper">
    <div class="container">
        
        <div class="section-header">
            <h2 class="section-title">Galeri Buku Jakarta</h2>
            <hr class="header-divider">
        </div>

        <div class="classics-row">
            <div class="classics-image-col">
                <img src="{{ asset('pustaka/penerbitan.png') }}" alt="Galeri Buku Jakarta Pustaka">
            </div>
            
            <div class="classics-text-col">
                <p>Galeri Buku Jakarta berkomitmen untuk menghadirkan produk dan hasil kerja berkualitas, memberikan inspirasi, kekayaan dan kedalaman—sebagaimana sebuah karya seni. Ia menembus hati pecintanya, dan berharga.</p>
                <p>Kami selalu memiliki misi ganda: untuk mempromosikan penulis yang paling menarik dan untuk mendukung pembaca yang ambisius dan ingin tahu. Penerbitan Galeri Buku Jakarta berkomitmen membantu para penulis dan mitra kerja kami mencapai dampak yang memungkinkan publik menikmati hasil inovasi dan profesionalitas; menghasilkan karya kolaborasi penuh harapan dan keindahan; menjulangkan perasaan optimis dan kemajuan.</p>

                <a href="#" class="btn-learn">Contact Us</a>
            </div>
        </div>

        <!-- 3. CARDS ROW (BERMUDA & COSENTINO) -->
        <div class="cards-row">
            <div class="card-large content-card">
                <img src="{{ asset('pustaka/percetakan.png') }}" alt="Bermuda">
                <div class="card-overlay">
                    <div class="overlay-title">Percetakan</div>
                    <div class="overlay-desc">Kami berkomitmen untuk menghadirkan produk dan hasil kerja berkualitas, memberikan inspirasi, kekayaan dan kedalaman</div>
                    <a href="#" class="btn-discover">Discover More</a>
                </div>
            </div>
            
            <div class="card-small content-card">
                <img src="{{ asset('pustaka/design.png') }}" alt="Cosentino">
                <div class="card-overlay brown-tint">
                    <div class="overlay-title">Design & Penerbitan</div>
                    <div class="overlay-desc">Kami menciptakan ruang multiperspektif, berusia panjang untuk dikenang—menghasilkan karya, keindahan dan dampak kemajuan.</div>
                    <a href="#" class="btn-discover">Discover More</a>
                </div>
            </div>
        </div>

        <!-- 4. PROGRAMMATIC SERVICES -->
        <div class="programmatic-row">
            <div class="prog-image-col">
                <img src="{{ asset('pustaka/ourservice.png') }}" alt="Programmatic Services">
            </div>
            <div class="prog-text-col">
                <h3 class="prog-title">Our Services</h3>
                <p class="prog-desc">percetakan, desain, penerbitan, buku, video, website design, visual identity, brand strategy, penulisan biografi & pemikiran, pemasaran, majalah, copy writing, podcast, konferensi, event management, bazaar, festival.</p>
                <a href="#" class="btn-learn">Learn More</a>
            </div>
        </div>

    </div>
</div>
@endsection
