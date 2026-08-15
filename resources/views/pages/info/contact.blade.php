@extends('layouts.app')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=PT+Serif:wght@400;700&display=swap" rel="stylesheet">

<style>
    /* === RESET & VARIABEL DASAR === */
    .kontak-page {
        font-family: 'PT Serif', serif; /* Font utama untuk teks paragraf */
        color: #000;
        background-color: #fff;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        padding-top: 60px; /* Offset for fixed header */
    }

    .kontak-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* === TIPOGRAFI & GARIS PEMBATAS === */
    .kontak-page h1.page-title {
        font-family: 'Oswald', sans-serif;
        font-size: 5.5rem;
        font-weight: 700;
        letter-spacing: -2px;
        text-transform: capitalize;
        line-height: 1;
        margin-bottom: 25px;
        color: #000;
    }

    .kontak-page h2.section-title {
        font-family: 'Oswald', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.1;
        letter-spacing: -0.5px;
        color: #000;
    }

    .kontak-page .thick-divider {
        border: none;
        border-top: 5px solid #000;
        margin: 0;
    }

    .kontak-page p.body-text {
        font-size: 0.95rem;
        margin-bottom: 15px;
        color: #111;
        font-family: 'PT Serif', serif;
    }

    /* === SISTEM TATA LETAK (GRID/FLEX) === */
    .kontak-page .row {
        display: flex;
        padding: 30px 0;
        gap: 50px;
        flex-direction: row;
        border: none;
    }

    .kontak-page .col-left {
        flex: 0 0 45%; /* Lebar kolom kiri */
    }

    .kontak-page .col-right {
        flex: 1; /* Sisa lebar untuk kolom kanan */
    }

    /* === BAGIAN 1: INTRO & ADDRESS === */
    .kontak-page .intro-row {
        padding: 20px 0;
        gap: 20px;
    }
    
    .kontak-page .intro-left {
        flex: 0 0 65%;
        padding-right: 40px;
    }

    .kontak-page .intro-right {
        flex: 1;
        border-left: 1px solid #000; /* Garis vertikal tipis */
        padding-left: 20px;
    }

    .kontak-page .address-title {
        font-family: sans-serif;
        font-size: 0.65rem;
        font-weight: bold;
        margin-bottom: 5px;
        color: #000;
    }

    /* === SISTEM LINK (TAG A) === */
    .kontak-page .inline-link {
        color: #000;
        text-decoration: underline;
        text-underline-offset: 3px;
        font-weight: bold;
        transition: color 0.2s;
    }

    .kontak-page .inline-link:hover {
        color: #b70d0f;
    }

    .kontak-page ul.link-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .kontak-page ul.link-list li {
        border-bottom: 1px solid #a0a0a0; /* Garis tipis bawah antar link */
        margin: 0;
        padding: 0;
    }

    .kontak-page ul.link-list li:first-child {
        padding-top: 0;
    }

    /* Style utama untuk tag <a> pada daftar menu */
    .kontak-page a.list-link {
        display: block;
        font-family: 'Oswald', sans-serif;
        font-size: 1.3rem;
        font-weight: 500;
        color: #000;
        text-decoration: none;
        padding: 12px 0;
        transition: all 0.2s ease-in-out;
    }

    .kontak-page a.list-link:hover {
        color: #b70d0f;
        padding-left: 5px; /* Efek sedikit bergeser saat dihover */
    }

    /* === BAGIAN BANNER DONASI === */
    .kontak-page .donate-banner {
        background-color: #b70d0f; /* Warna merah */
        color: #fff;
        padding: 40px;
        margin-top: 20px;
        text-align: left;
    }

    .kontak-page .donate-title-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .kontak-page .donate-word {
        font-family: 'Oswald', sans-serif;
        font-size: 6rem;
        font-weight: 700;
        line-height: 1;
        letter-spacing: -1px;
    }

    .kontak-page .donate-image {
        height: 100px;
        width: auto;
        object-fit: contain;
        background-color: #f7dfa6; /* Warna latar belakang gambar bunga asli */
        padding: 5px;
    }

    .kontak-page .donate-desc {
        font-family: 'PT Serif', serif;
        font-size: 1.5rem;
        line-height: 1.3;
        margin-bottom: 25px;
        max-width: 90%;
        color: #fff;
    }

    /* Tombol Donasi */
    .kontak-page a.btn-donate {
        display: inline-block;
        background-color: #fff;
        color: #000;
        font-family: 'Oswald', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        text-decoration: none;
        padding: 8px 30px;
        border-radius: 2px;
        transition: background-color 0.2s;
    }

    .kontak-page a.btn-donate:hover {
        background-color: #f0f0f0;
    }

    /* === RESPONSIVE MOBILE === */
    @media (max-width: 768px) {
        .kontak-page h1.page-title { font-size: 3.5rem; }
        .kontak-page .row, .kontak-page .intro-row { flex-direction: column; gap: 20px; padding: 20px 0; }
        .kontak-page .intro-right { border-left: none; padding-left: 0; border-top: 1px solid #000; padding-top: 15px;}
        .kontak-page .col-left, .kontak-page .intro-left { padding-right: 0; }
        .kontak-page .donate-word { font-size: 3rem; }
        .kontak-page .donate-image { height: 60px; }
        .kontak-page .donate-desc { font-size: 1.2rem; }
    }
</style>
@endpush

@section('content')
<div class="kontak-page">
    <div class="kontak-container">
        
        <h1 class="page-title">Contact Us</h1>

        <hr class="thick-divider">

        <div class="row intro-row">
            <div class="intro-left">
                <p class="body-text">GALERI BUKU JAKARTA is an organization with a mission to inspire, empower, and connect people to change their world.</p>
                <p class="body-text">We support the expression and discussion of ideas, literature, and opinions and encourage people to be informed citizens and engage in their communities.</p>
            </div>
            <div class="intro-right">
                <p class="address-title">Mailing Address</p>
                <p class="body-text">
                    Galeri Buku Jakarta<br>
                    Jl. Taman Patra III, Setiabudi,<br>
                    Kuningan, Jakarta Selatan, 12910
                </p>
            </div>
        </div>

        <hr class="thick-divider">

        <div class="row">
            <div class="col-left">
                <h2 class="section-title">Messages for<br>Our Team</h2>
            </div>
            <div class="col-right">
                <p class="body-text">
                    If you'd like to share a personal message or feedback with our team, please contact us at: 
                    <a href="mailto:info@galeribukujakarta.com" class="inline-link">galeribukujakarta@gmail.com ↗</a>
                </p>
            </div>
        </div>

        <hr class="thick-divider">

        <div class="row">
            <div class="col-left">
                <h2 class="section-title">Support &<br>Partnerships</h2>
            </div>
            <div class="col-right">
                <ul class="link-list">
                    <li><a href="{{ route('advertise') }}" class="list-link">Advertise with us</a></li>
                    <li><a href="{{ route('subscribe') }}" class="list-link">Become a Subscriber</a></li>
                    <li><a href="https://www.tokopedia.com/galeribukujakarta" target="_blank" class="list-link">Merchandise Store</a></li>
                </ul>
            </div>
        </div>

        <hr class="thick-divider">

        <div class="row">
            <div class="col-left">
                <h2 class="section-title">Getting Involved</h2>
            </div>
            <div class="col-right">
                <ul class="link-list">
                    <li><a href="{{ url('/page/redaksi') }}#tab-submisi" class="list-link">Submisi Karya</a></li>
                    <li><a href="{{ route('publikasi.index') }}" class="list-link">Publikasi</a></li>
                </ul>
            </div>
        </div>

        <div class="donate-banner">
            <div class="donate-title-wrapper">
                <span class="donate-word">DONATE</span>
                <img src="{{ asset('img/burung.png') }}" alt="Floral Art" class="donate-image">
                <span class="donate-word">TODAY</span>
            </div>
            <p class="donate-desc">We need your help to turn hope into action—to inspire, empower, and connect people to change their world.</p>
            <a href="{{ url('/donate') }}" class="btn-donate">Donate Now</a>
        </div>

    </div>
</div>
@endsection

