@extends('layouts.app')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

<style>
    /* === SCOPED STYLES === */
    #jakarta-wrapper {
        font-family: 'Open Sans', sans-serif;
        background-color: #ffffff;
        color: #000000;
        width: 100%;
        padding-bottom: 60px;
        overflow-x: hidden;
    }

    #jakarta-wrapper * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    /* --- BAGIAN 1: ILUSTRASI ATAS --- */
    #jakarta-wrapper .hero-image-container {
        width: 100%;
        height: 700px; /* Batasi tinggi gambar agar tidak terlalu besar di layar lebar */
        background-color: #fce4e4; /* Warna pastel cadangan */
        overflow: hidden;
    }

    #jakarta-wrapper .hero-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* --- BAGIAN 2: KUTIPAN TENGAH --- */
    #jakarta-wrapper .quote-section {
        max-width: 900px;
        margin: 60px auto;
        padding: 0 30px;
        text-align: center;
    }

    #jakarta-wrapper .quote-section::before {
        content: "";
        display: block;
        width: 60px;
        height: 3px;
        background-color: #b70d0f; /* Aksen merah */
        margin: 0 auto 30px auto;
    }

    #jakarta-wrapper .quote-section p {
        font-size: 1.35rem;
        line-height: 1.8;
        color: #333;
        font-style: italic;
        font-family: Georgia, 'Times New Roman', serif;
    }

    /* --- BAGIAN 3: PETA & DAFTAR KOTA --- */
    #jakarta-wrapper .map-section {
        position: relative;
        width: 100%;
        padding: 80px 10%; /* padding lebih luas agar terasa full page */
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Latar belakang peta dunia transparan (menggunakan SVG public) */
        background-image: url('https://upload.wikimedia.org/wikipedia/commons/e/ec/World_map_blank_without_borders.svg');
        background-size: cover; /* diubah dari contain menjadi cover agar memenuhi background */
        background-position: center;
        background-repeat: no-repeat;
    }

    /* Efek transparan/pudar untuk peta dunia di belakang */
    #jakarta-wrapper .map-section::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: rgba(255, 255, 255, 0.7); /* Peta lebih jelas terlihat */
        z-index: 1;
    }

    #jakarta-wrapper .cities-container {
        position: relative;
        z-index: 2; /* Memastikan teks berada di atas lapisan pudar */
        display: flex;
        justify-content: space-between;
        width: 100%;
        max-width: 1100px; /* Dikembalikan untuk 3 kolom */
        margin: 0 auto;
        gap: 30px;
    }

    #jakarta-wrapper .city-column {
        flex: 1;
    }

    #jakarta-wrapper .city-column h3 {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 15px;
        margin-left: 20px;
    }

    #jakarta-wrapper .city-list {
        padding-left: 30px; /* Ruang untuk nomer */
    }

    #jakarta-wrapper .city-list li {
        font-size: 1rem;
        margin-bottom: 15px;
        line-height: 1.5;
        padding-left: 10px;
    }

    #jakarta-wrapper .city-list li a {
        color: #222;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    #jakarta-wrapper .city-list li a:hover {
        color: #b70d0f;
        text-decoration: underline;
    }

    #jakarta-wrapper .city-list li::marker {
        font-size: 1.2rem;
        font-weight: 800;
        color: #b70d0f; /* warna estetis (merah aksen) */
    }

    /* --- PENYAIR TAMU --- */
    #jakarta-wrapper .guest-column h3 {
        margin-left: 0; /* Diluruskan rata kiri dengan paragraf */
        font-family: Georgia, 'Times New Roman', serif; /* Font serif */
    }

    #jakarta-wrapper .guest-paragraph {
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 0.8rem; /* Font serif kecil */
        line-height: 1.6;
        text-align: left;
        color: #b70d0f; /* Full merah */
    }

    #jakarta-wrapper .guest-paragraph a {
        color: #b70d0f; 
        text-decoration: none;
        transition: color 0.3s ease;
        text-transform: capitalize;
        font-weight: 600;
    }

    #jakarta-wrapper .guest-paragraph a:hover {
        text-decoration: underline;
        color: #8a0808; /* Merah gelap saat di-hover */
    }

    /* Menyembunyikan judul "Cities" di kolom kedua agar rapi */
    #jakarta-wrapper .hidden-title {
        visibility: hidden;
    }

    /* --- RESPONSIVITAS MOBILE --- */
    @media (max-width: 768px) {
        #jakarta-wrapper .main-heading {
            font-size: 1.8rem;
            margin: 30px 20px 40px 20px;
        }
        #jakarta-wrapper .map-section {
            padding: 30px 5%;
            background-size: cover;
        }
        #jakarta-wrapper .cities-container {
            flex-direction: column;
            gap: 0; /* Menghilangkan gap agar list menyambung ke bawah */
        }
        #jakarta-wrapper .city-column:not(:first-child) {
            margin-top: -8px; /* Merapatkan daftar antar kolom saat di mobile */
        }
        #jakarta-wrapper .hidden-title {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<div id="jakarta-wrapper">
    
    <div class="hero-image-container">
        <img src="{{ asset('pustaka/siapakajakarta.jpeg') }}" alt="Ilustrasi Kota">
    </div>

    <div class="quote-section">
        <p>"Puisi dan kota. Di hari ini. Panas dan wabah. Ada apa? Kota yang dibangun oleh banyak suku bangsa, menjadi performance utama dari representasi bagaimana Indonesia dibentuk. Jakarta belum punya pengalaman untuk membaca kegagalan-kegagalannya sendiri sebagai evaluasi kota atas pusat perubahan yang dijalaninya. Apakah puisi bisa digunakan sebagai cara melihat politik warga negara berdasarkan institusi kota?"</p>
    </div>

    <div class="map-section">
        <div class="cities-container">
            
            <div class="city-column">
                <h3>Penyair</h3>
                <ol class="city-list">
                    <li><a href="#">Septian Murival</a></li>
                    <li><a href="#">Lukman A. Salendra</a></li>
                    <li><a href="#">F Daus AR</a></li>
                    <li><a href="#">Ardhi Ridwansyah</a></li>
                    <li><a href="#">Warake</a></li>
                    <li><a href="#">Nanang RS</a></li>
                    <li><a href="#">Ahmad Kohawan</a></li>
                    <li><a href="#">Bambang Widiatmoko</a></li>
                    <li><a href="#">Sukaya Sukawati</a></li>
                    <li><a href="#">Rini Intama</a></li>
                    <li><a href="#">Reni Lestari</a></li>
                </ol>
            </div>

            <div class="city-column">
                <h3 class="hidden-title">Penyair</h3>
                <ol class="city-list" start="12">
                    <li><a href="#">Tri Astoto Kodarie</a></li>
                    <li><a href="#">Andriyana abdullah aziz</a></li>
                    <li><a href="#">Rizka Nur Laily Muallifa</a></li>
                    <li><a href="#">J Akid Lampacak</a></li>
                    <li><a href="#">Sam Mukhtar Chaniago</a></li>
                    <li><a href="#">Isbedy Stiawan Z.S.</a></li>
                    <li><a href="#">Faris Al Faisal</a></li>
                    <li><a href="#">Rizkya Dian Maharani</a></li>
                    <li><a href="#">Ikhsan Risfandi</a></li>
                    <li><a href="#">Zulfan Fauzi</a></li>
                </ol>
            </div>

            <div class="city-column">
                <h3 class="hidden-title">Penyair</h3>
                <ol class="city-list" start="22">
                    <li><a href="#">Fadhila Eka Ratnasari</a></li>
                    <li><a href="#">Ros Aruna</a></li>
                    <li><a href="#">Badruddin Emce</a></li>
                    <li><a href="#">Yoe Irawan</a></li>
                    <li><a href="#">Ganang Ajie Putra</a></li>
                    <li><a href="#">Ervirdi Rahmat</a></li>
                    <li><a href="#">Himas Nur</a></li>
                    <li><a href="#">Joshua Vincentius</a></li>
                    <li><a href="#">Ina herdiyana</a></li>
                    <li><a href="#">Roz Ekki</a></li>
                </ol>
            </div>
        </div> <!-- End of cities-container -->

        <!-- Dipindah kembali ke dalam map section -->
        <div class="guest-section-bottom" style="width: 100%; max-width: 1100px; margin: 40px auto 0 auto; position: relative; z-index: 2;">
            <h3 style="color: #b70d0f; font-size: 0.85rem; font-family: Georgia, 'Times New Roman', serif; margin-bottom: 5px;">Kurator & Penyair Tamu</h3>
            <p class="guest-paragraph">
                <a href="#">Afrizal Malna</a>, 
                <a href="#">Sabiq Carebesth</a>, 
                <a href="#">Saras Dewi</a>, 
                <a href="#">Aan Mansyur</a>, 
                <a href="#">Damhuri Muhammad</a>, 
                <a href="#">Sarah Monica</a>, 
                <a href="#">Lucia Priandarini</a>, 
                <a href="#">Mutia Sukma</a>, 
                <a href="#">Hamdy Salad</a>.
            </p>
        </div>

    </div> <!-- End of map-section -->

</div> <!-- End of jakarta-wrapper -->
@endsection
