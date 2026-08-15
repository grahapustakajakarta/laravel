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
</style>
@endpush

@section('content')
<div class="privacy-container">
    <h1 class="privacy-title">Disclaimer & Syarat Ketentuan</h1>
    <div class="privacy-date">Terakhir Diperbarui: 1 Januari 2026</div>
    <hr class="privacy-divider">
    
    <p class="privacy-text">
        Selamat datang di website galeribukujakarta.com. Penggunaan Website galeribukujakarta.com tunduk pada Syarat dan Ketentuan kami. Dengan mendaftarkan diri Anda sebagai pengguna di galeribukujakarta.com (selanjutnya disebut Pengguna) dan mengakses serta menggunakan fitur dan layanan di Website galeribukujakarta.com (termasuk melakukan Pesanan dan/atau Pembelian), berarti Anda setuju untuk terikat pada Syarat Ketentuan dan Kebijakan Privasi kami.
    </p>

    <p class="privacy-text">
        Selain itu seluruh layanan data dan informasi yang diberikan mengikuti ketentuan yang berlaku dan ditetapkan oleh Galeri Buku Jakarta (GBJ). Seluruh layanan yang diberikan di situs galeribukujakarta.com ditujukan untuk kebutuhan pribadi dan bukan untuk digunakan kembali secara komersial. Selengkapnya:
    </p>

    <h2 class="privacy-heading">Disclaimer</h2>
    
    <ul class="privacy-list">
        <li>Seluruh konten yang ada di dalam situs termasuk teks, video, foto, audio, ilustrasi, infografik dan lainnya dilindungi oleh undang-undang hak cipta yang dimiliki GBJ, dan atau pihak ketiga penyedia isi di situs ini.</li>
        <li>GBJ berhak memuat, atau tidak memuat, melakukan penyuntingan atau menghapus komentar, tanggapan, data atau informasi dari pembaca.</li>
        <li>GBJ tak bertanggungjawab atas kegagalan penyampaian data atau informasi dari pembaca melalui berbagai saluran komunikasi, baik email, SMS, atau jalur komunikasi online lainnya akibat kesalahan teknis yang tak diharapkan.</li>
        <li>Segala bentuk data atau informasi yang dipublikasi dan disiarkan oleh GBJ adalah sebagai referensi dan rujukan untuk pengayaan informasi bagi pembaca. GBJ tidak bertanggungjawab jika informasi yang disajikan digunakan untuk mengambil keputusan dan penilaian atau perspektif.</li>
        <li>Data dan informasi yang disajikan GBJ Indonesia atau pihak ketiga yang menjadi mitra dalam menyediakan isi, diupayakan memenuhi akurasi yang cermat. Namun demikian GBJ tidak bertanggungjawab jika terjadi kesalahan atau keterlambatan dalam memperbaharui data yang mengakibatkan kerugian bagi pengguna data maupun pihak yang membaca informasi yang disajikan di situs ini.</li>
        <li>Data dan informasi yang disajikan, ditampilkan dan disebarkan melalui semua akun resmi sosial media GBJ merupakan upaya untuk memperluas akses sebaran informasi. GBJ tidak bertanggungjawab jika ada pembaca atau pihak-pihak tertentu yang menyalahgunakan data dan informasi yang ditampilkan dan disebarkan melalui akun sosial media.</li>
        <li>GBJ berhak menyunting, atau menghilangkan segala isi unggahan pengguna yang melanggar aturan hukum, dan atau sebagaimana diatur oleh <a href="{{ asset('pdf/Pedoman Media Siber.pdf') }}" class="privacy-link" target="_blank" download>Pedoman Media Siber</a>.</li>
    </ul>
</div>
@endsection
