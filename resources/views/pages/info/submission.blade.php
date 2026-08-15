@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
<style>
    .privacy-container {
        max-width: 840px;
        margin: 60px auto;
        padding: 0 30px;
        background: #fff;
        color: #333;
        font-family: Arial, Helvetica, sans-serif;
        line-height: 1.6;
    }
    .privacy-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.2rem;
        font-weight: 400;
        color: #111;
        margin-bottom: 10px;
        letter-spacing: 0.3px;
    }
    .privacy-date {
        font-size: 0.85rem;
        color: #666;
        font-weight: 700;
        margin-bottom: 25px;
    }
    .privacy-divider {
        border: 0;
        border-top: 1px solid #e5e5e5;
        margin-bottom: 30px;
    }
    .privacy-text {
        font-size: 0.95rem;
        margin-bottom: 20px;
        color: #4a4a4a;
    }
    .privacy-heading {
        font-size: 1.05rem;
        font-weight: 700;
        color: #4a4a4a;
        margin: 35px 0 15px 0;
    }
    .privacy-list {
        margin-bottom: 25px;
        padding-left: 20px;
        font-size: 0.95rem;
        color: #4a4a4a;
    }
    .privacy-list li {
        margin-bottom: 15px;
        list-style-type: disc;
    }
    .privacy-link {
        text-decoration: underline;
        color: #4a4a4a;
    }
    
    /* =========================================
       BAGIAN BANNER SUBMISSION
       ========================================= */
    .newsletter-section {
        background-color: #EFEFEA; 
        padding: 90px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .pattern-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: repeating-linear-gradient(90deg, transparent, transparent 15px, #7e3dd4 15px, #7e3dd4 17px);
        -webkit-mask-image: repeating-linear-gradient(-35deg, black, black 40px, transparent 40px, transparent 80px);
        mask-image: repeating-linear-gradient(-35deg, black, black 40px, transparent 40px, transparent 80px);
        z-index: 1;
    }

    .newsletter-box {
        background-color: #ffffff;
        width: 100%;
        max-width: 880px;
        display: flex;
        padding: 55px 45px;
        position: relative;
        z-index: 2;
    }

    .newsletter-left {
        flex: 1;
        padding-right: 30px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .newsletter-left h2 {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        font-size: 32px;
        font-weight: 800;
        line-height: 1.15;
        margin-top: 0;
        margin-bottom: 25px;
        letter-spacing: -0.5px;
        color: #000;
    }

    .newsletter-left a {
        color: #7e3dd4;
        text-decoration: underline;
        text-decoration-thickness: 1px;
        text-underline-offset: 4px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .newsletter-right {
        flex: 1.1;
        padding-left: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .newsletter-right p {
        font-family: Georgia, serif;
        font-size: 16px;
        color: #444;
        line-height: 1.5;
        margin-top: 0;
        margin-bottom: 30px;
    }
    
    a.btn-selengkapnya {
        background-color: #7e3dd4;
        color: #fff;
        border: none;
        padding: 13px 22px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.2s;
    }
    a.btn-selengkapnya:hover {
        background-color: #6a2cc0;
    }

    @media (max-width: 768px) {
        .newsletter-box { flex-direction: column; padding: 35px; }
        .newsletter-left { padding-right: 0; margin-bottom: 30px; }
        .newsletter-right { padding-left: 0; }
    }
</style>
@endpush

@section('content')
    <section class="newsletter-section">
        <div class="pattern-overlay"></div> 
        <div class="newsletter-box">
            <div class="newsletter-left">
                <h2>Reclaiming Our <br>Cities with Art <br>and Culture</h2>
                <a href="{{ url('/page/jktplus') }}">See All Inspiration</a>
            </div>
            <div class="newsletter-right">
                <p>Kolaborasi bersama menyulam kota; menghasilkan karya bermakna dan berdampak. Inovatif dan berkelanjutan..</p>
                <div class="form-group">
                    <a href="{{ (\Illuminate\Support\Facades\Auth::guard('pengguna')->check() && \Illuminate\Support\Facades\Auth::guard('pengguna')->user()->isPremium()) ? route('user.profile', ['tab' => 'kirim-tulisan']) : route('getting_published') }}" class="btn-selengkapnya">Kirim Tulisan</a>
                </div>
            </div>
        </div>
    </section>

<!-- Bagian Konten Utama -->
<div class="privacy-container" style="margin-top: 20px;">
    <hr class="privacy-divider">
    
    <div class="privacy-text">
        <h2 class="privacy-heading" style="font-size: 1.5rem; margin-top: 0;">Panduan Pengiriman Karya</h2>
        <p style="margin-bottom: 15px; text-align: justify;">
            Tim redaksi kami terbatas dan terkadang ada saat-saat kami menerima banyak karya sehingga akan membutuhkan waktu dalam publikasi mau pun respon kami atas karya yang dikirimkan. Pada umumnya kami hanya membalas dan memberikan feedback kepada tulisan yang akan kami tayangkan. Terkadang itu memakan waktu hingga 2 bulan sebelum kami memberitahu waktu publikasinya. Terimakasih atas kesabaran pembaca dan penulis sekalian.
        </p>
        <p style="margin-bottom: 25px; text-align: justify;">
            Silakan unduh Panduan Penulisan kami selengkapnya. Kami menerima tulisan dengan dua cara: melalui panel KIRIM TULISAN dan anda harus menjadi subscriber untuk dapat menikmati fitur yang tersedia. Rekan sekalian bisa menulis untuk semua rubrik. Cara lain adalah melalui email redaksi khususnya untuk para pembaca dan penulis yang tidak berlangganan—dan hanya ditujukan untuk rubrik cerpen dan puisi.
        </p>

        <h2 class="privacy-heading">Catatan Keredaksian:</h2>
        <ul class="privacy-list">
            <li>Pengiriman karya Puisi: kirimkan 3-5 puisi disertai biodata singkat. Bisa merupakan karya penerjemahan penulis dunia.</li>
            <li>Pengiriman Cerita: yang kami maksudkan adalah cerita pendek. Panjang cerpen 7.000-15.000 karakter, termasuk spasi.</li>
            <li>Pengiriman Kajian Buku: Buku diulas bebas tanpa batas ragam. Naskah 3000-5000 karakter termasuk spasi.</li>
            <li>Pengiriman Karya Esai dan Pemikiran: Esai dimaksud terutama kritik budaya; utamanya sastra, seni rupa, atau film. Pemikiran diutamakan esai sosial budaya perkotaan dan kritik tata kelola pembangunan. Tulisan tidak lebih dari 6000 karakter.</li>
        </ul>

        <h2 class="privacy-heading">Catatan penting:</h2>
        <ul class="privacy-list">
            <li>Semua naskah/ karya yang dikirim asli (bukan saduran), belum pernah dipublikasi secara digital di laman lain sebelumnya. Dan bukan jiplakan karya penulis lain.</li>
            <li>Semua karya dikirim dengan disertai biodata singkat.</li>
            <li>Baik karya untuk rubrik cerita pendek, puisi, esai dan kajian buku, redaksi menerima hasil karya penerjemahan dengan wajib menyebut sumber dan pemilik karya asli.</li>
            <li>Kami tidak selalu memberikan respon atau pemberitahuan atas semua karya yang kami terima. Kecuali karya yang memiliki kemungkinan untuk kami publikasikan. Terkadang itu memakan waktu 2-3 bulan—kami hanya memiliki beberapa orang untuk melakukan kajian keredaksian dan harus membaca banyak karya tiap pekannya.</li>
            <li>Semua karya yang dikirimkan hak cipta sepenuhnya menjadi milik penulis. Tetapi kami juga memilki hak pakai dan hak memanfaatkan publikasinya (baik digital mau pun cetak) untuk mendukung keberadaan Galeri Buku Jakarta. Itu termasuk publikasi dalam bentuk digital sebagai materi content desain, sosial media, mau pun penerbitan yang kami kelola atas nama Galeri Buku Jakarta dan kami tidak selalu memberitahu pengirim karya akan hal tersebut. Terimakasih untuk pemahaman dan kontribusinya.</li>
            <li>Kami memberi batas 4 pekan jika karya yang anda kirimkan tidak kami publikasikan atau tidak mendapat feedback, Anda berhak mengirim karya anda kepada media lain atau untuk keperluan publikasi pribadi anda.</li>
            <li>Kami berharap para pembaca dan penulis mengirim karya original, baru dan hanya dikirim/ dipublikasikan untuk Galeri Buku Jakarta. Jika kami mendapati sebaliknya, kami berhak membatalkan publikasi tanpa terlebih dahulu memberitahu.</li>
            <li>Honorarium: Kami tidak memiliki dana untuk memberi honorarium kepada semua tulisan yang kami terima dan publikasikan. Tetapi kami memberi ruang ekshibisi publikasi memadai dan penuh rasa hormat.</li>
            <li>Kami hanya menerima kiriman tulisan melalui email: <strong>galeribukujakarta@gmail.com</strong> selain email tersebut karya yang anda kirimkan tidak akan mendapat respon atau kesempatan publikasi.</li>
        </ul>
    </div>
</div>
@endsection
