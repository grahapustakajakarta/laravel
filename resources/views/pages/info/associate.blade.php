@extends('layouts.app')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
    /* === SCOPED STYLES === */
    #experts-wrapper {
        font-family: 'Inter', sans-serif;
        color: #111111;
        background-color: #ffffff;
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
        padding-bottom: 60px;
    }

    #experts-wrapper * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    #experts-wrapper .container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* --- BREADCRUMB --- */
    #experts-wrapper .breadcrumb {
        font-size: 0.65rem;
        text-transform: uppercase;
        color: #666;
        letter-spacing: 0.5px;
        margin-bottom: 15px;
    }

    /* --- TOP SECTION (HEADER & BOXES) --- */
    #experts-wrapper .top-section {
        display: flex;
        gap: 40px;
        margin-bottom: 50px;
    }

    #experts-wrapper .intro-text {
        flex: 1.2;
        padding-right: 20px;
    }

    #experts-wrapper h1 {
        font-size: 3.5rem;
        font-weight: 800;
        letter-spacing: -1.5px;
        margin-bottom: 25px;
        line-height: 1;
        color: #000;
    }

    #experts-wrapper .intro-text p {
        font-size: 1.25rem;
        color: #333;
        line-height: 1.6;
    }

    #experts-wrapper .callout-boxes {
        flex: 1;
        display: flex;
        gap: 20px;
    }

    #experts-wrapper .box {
        flex: 1;
        padding: 30px 25px;
        display: flex;
        flex-direction: column;
    }

    #experts-wrapper .box-media {
        background-color: #e5e4f5; /* Ungu sangat muda */
    }

    #experts-wrapper .box-speaker {
        background-color: #dcdbd8; /* Abu-abu hangat */
    }

    #experts-wrapper .box h3 {
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: #000;
        line-height: 1.3;
    }

    #experts-wrapper .box p {
        font-size: 0.85rem;
        color: #333;
        margin-bottom: 25px;
        line-height: 1.5;
    }

    #experts-wrapper .box a {
        color: #555;
        text-decoration: underline;
    }

    #experts-wrapper .btn-speaker {
        background-color: #712fd1; /* Ungu cerah */
        color: #ffffff;
        border: none;
        padding: 12px 15px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        margin-top: auto;
        align-self: flex-start;
        transition: background-color 0.2s;
    }

    #experts-wrapper .btn-speaker:hover {
        background-color: #591ba8;
    }

    /* --- DIVIDER --- */
    #experts-wrapper .section-divider {
        border: 0;
        border-top: 1px solid #dcdcdc;
        margin-bottom: 40px;
    }

    /* --- SEARCH & FILTER BAR --- */
    #experts-wrapper .search-filter-bar {
        display: flex;
        border: 1px solid #dcdcdc;
        margin-bottom: 30px;
        background-color: #fff;
    }

    #experts-wrapper .search-input-group {
        flex: 1;
        display: flex;
        align-items: center;
        padding: 0 15px;
    }

    #experts-wrapper .search-input-group input {
        width: 100%;
        border: none;
        padding: 15px 10px;
        font-size: 0.95rem;
        outline: none;
        font-family: inherit;
    }

    #experts-wrapper .search-input-group input::placeholder {
        color: #666;
    }

    #experts-wrapper .search-icon {
        color: #555;
        cursor: pointer;
    }

    #experts-wrapper .filter-dropdowns {
        display: flex;
    }

    #experts-wrapper .dropdown {
        border-left: 1px solid #dcdcdc;
        padding: 0 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        color: #333;
    }

    #experts-wrapper .dropdown:hover {
        background-color: #f9f9f9;
    }

    /* --- RESULTS INFO --- */
    #experts-wrapper .results-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }

    #experts-wrapper .results-count {
        font-weight: 700;
        font-size: 1rem;
        color: #000;
    }

    #experts-wrapper .results-per-page {
        font-size: 0.75rem;
        color: #555;
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
    }

    #experts-wrapper .results-per-page strong {
        font-size: 0.9rem;
        color: #000;
    }

    /* --- EXPERTS GRID --- */
    #experts-wrapper .experts-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 40px 20px; /* Gap baris 40px, gap kolom 20px */
    }

    #experts-wrapper .expert-card {
        display: flex;
        flex-direction: column;
    }

    #experts-wrapper .expert-image {
        width: 100%;
        aspect-ratio: 1 / 1; /* Pastikan gambar berbentuk kotak persis seperti aslinya */
        object-fit: cover;
        background-color: #eee;
        margin-bottom: 12px;
    }

    #experts-wrapper .expert-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: #000;
        margin-bottom: 4px;
        line-height: 1.2;
    }

    #experts-wrapper .expert-role {
        font-size: 0.75rem;
        color: #666;
        line-height: 1.4;
    }

    /* --- RESPONSIVE MOBILE & TABLET --- */
    @media (max-width: 900px) {
        #experts-wrapper .top-section {
            flex-direction: column;
        }
        #experts-wrapper .callout-boxes {
            flex-direction: column;
        }
        #experts-wrapper h1 {
            font-size: 2.8rem;
        }
        #experts-wrapper .experts-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        #experts-wrapper .search-filter-bar {
            flex-direction: column;
        }
        #experts-wrapper .filter-dropdowns {
            border-top: 1px solid #dcdcdc;
            width: 100%;
        }
        #experts-wrapper .dropdown {
            flex: 1;
            justify-content: center;
            border-left: none;
            border-right: 1px solid #dcdcdc;
            padding: 15px 0;
        }
        #experts-wrapper .dropdown:last-child {
            border-right: none;
        }
        #experts-wrapper .experts-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div id="experts-wrapper">
    <div class="container">
        
        <div class="top-section">
            <div class="intro-text">
                <!-- <div class="breadcrumb">RAN / About /</div> -->
                <h1>Editorial Independence</h1>
                <p>
                    Though Galeri Buku Jakarta is supported in part by advertising, our content is produced independently and held to rigorous standards of quality, accuracy, and integrity. In some cases, sponsors may be allowed input regarding broad concepts, but they hold no material influence over the end product. Content created in partnership with advertisers is clearly marked as such.
                </p>
            </div>
            
            <div class="callout-boxes">
                <div class="box box-media">
                    <h3>Advertising</h3>
                    <p>Learn about opportunities to advertise in our magazine or on our digital/mobile site. For complete information, see our <a href="#">Media kit.</a></p>
                </div>
                <div class="box box-speaker">
                    <h3>Donate to Galeri Buku Jakarta</h3>
                    <p>To learn more about us and our mission, or if you have any questions about donating to the Galeri Buku Jakarta, please contact galeribukujakarta@gmail.com</p>
                    
                    <a href="{{ route('donate') }}" class="btn-speaker" style="color: #ffffff; text-decoration:none; display:inline-block; text-align:center;">Donate</a>
                </div>
            </div>
        </div>

        <hr class="section-divider">

        <div class="experts-grid">
            <div class="expert-card">
                <img src="{{ asset('editorialteam/Sabiq Carebesth.png') }}" alt="Sabiq Carebesth" class="expert-image">
                <h4 class="expert-name">Sabiq Carebesth</h4>
                <p class="expert-role">Chief Editor / Directors</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/Afrizal Malna.png') }}" alt="Afrizal Malna" class="expert-image">
                <h4 class="expert-name">Afrizal Malna</h4>
                <p class="expert-role">Board of Directors</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/Damhuri Muhammad.png') }}" alt="Damhuri Muhammad" class="expert-image">
                <h4 class="expert-name">Damhuri Muhammad</h4>
                <p class="expert-role">Board of Directors</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/rini lucia.png') }}" alt="Rini Lucia" class="expert-image">
                <h4 class="expert-name">Rini Lucia</h4>
                <p class="expert-role">Editorial Board</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/5 Saras Dewi.png') }}" alt="Saras Dewi" class="expert-image">
                <h4 class="expert-name">Saras Dewi</h4>
                <p class="expert-role">Editorial Board</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/6 Hamdy Salad.png') }}" alt="Hamdy Salad" class="expert-image">
                <h4 class="expert-name">Hamdy Salad</h4>
                <p class="expert-role">Board of Directors</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/7 Aan Mansyur.png') }}" alt="Aan Mansyur" class="expert-image">
                <h4 class="expert-name">Aan Mansyur</h4>
                <p class="expert-role">Editorial Board</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/8 Badruddin MC.png') }}" alt="Badruddin MC" class="expert-image">
                <h4 class="expert-name">Badruddin MC</h4>
                <p class="expert-role">Editorial Board</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/9 Addi M Idham.png') }}" alt="Addi M Idham" class="expert-image">
                <h4 class="expert-name">Addi M Idham</h4>
                <p class="expert-role">Senior Managing Editor</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/10 Marlina Sopiana.png') }}" alt="Marlina Sopiana" class="expert-image">
                <h4 class="expert-name">Marlina Sopiana</h4>
                <p class="expert-role">Managing Editor</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/11 Virdika R Utama.png') }}" alt="Virdika R Utama" class="expert-image">
                <h4 class="expert-name">Virdika R Utama</h4>
                <p class="expert-role">Editorial Team</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/12 Regina.png') }}" alt="Regina N Helnaz" class="expert-image">
                <h4 class="expert-name">Regina N Helnaz</h4>
                <p class="expert-role">Managing Editor</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/13 Frea Petra Maheswari.png') }}" alt="Frea Petra Maheswari" class="expert-image">
                <h4 class="expert-name">Frea Petra Maheswari</h4>
                <p class="expert-role">Editorial Team</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/14 Lika Fuaddah.png') }}" alt="Lika Fuaddah" class="expert-image">
                <h4 class="expert-name">Lika Fuaddah</h4>
                <p class="expert-role">Editorial Board</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/15 Amalia Dian Utami.png') }}" alt="Amalia Dian Utami" class="expert-image">
                <h4 class="expert-name">Amalia Dian Utami</h4>
                <p class="expert-role">Editorial Board</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/16 Eka Prasetya Widhi Utami.png') }}" alt="Eka Prasetya Widhi Utami" class="expert-image">
                <h4 class="expert-name">Eka Prasetya Widhi Utami</h4>
                <p class="expert-role">Editorial Board</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/17 Affan Firmansyah.png') }}" alt="Affan Firmansyah" class="expert-image">
                <h4 class="expert-name">Affan Firmansyah</h4>
                <p class="expert-role">Editorial Board</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/18 Nandito Maulana.png') }}" alt="Nandito Maulana" class="expert-image">
                <h4 class="expert-name">Nandito Maulana</h4>
                <p class="expert-role">Web Development / Software Engineer</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/19 Imarafsah Mutia.png') }}" alt="Imarafsah Mutia" class="expert-image">
                <h4 class="expert-name">Imarafsah Mutia</h4>
                <p class="expert-role">Editorial Board</p>
            </div>
            <div class="expert-card">
                <img src="{{ asset('editorialteam/SugengBahagijo.jpeg') }}" alt="Sugeng Bahagijo" class="expert-image">
                <h4 class="expert-name">Sugeng Bahagijo</h4>
                <p class="expert-role">Editorial Board</p>
            </div>
        </div>


    </div>
</div>
@endsection
