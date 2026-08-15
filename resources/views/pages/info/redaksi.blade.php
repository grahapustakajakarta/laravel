@extends('layouts.app')

@push('styles')
<style>
    /* ===== GAYA HALAMAN REDAKSI: FULL-PAGE HERO SLIDER ===== */
    #redaksi-page {
        position: relative;
        width: 100%;
        /* Mengurangi margin atas jika terganggu header global */
        margin-top: -55px; 
    }

    #redaksi-page .hero-section {
        position: relative;
        width: 100%;
        height: 90vh; /* Dikurangi sedikit agar pas, tidak selayar penuh tapi tetap tinggi */
        min-height: 700px;
        display: flex;
        justify-content: center;
    }

    /* Area Gambar Full-Page */
    #redaksi-page .hero-slider {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    #redaksi-page .hero-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        opacity: 0;
        transition: opacity 0.6s ease-in-out;
    }

    #redaksi-page .hero-img.active {
        opacity: 1;
    }

    /* Area Menu/Tabs di Bawah Gambar */
    #redaksi-page .hero-nav-wrapper {
        position: absolute;
        bottom: 0; /* Menempel di bawah hero image */
        width: 100%;
        height: 18vh; /* Proporsi disesuaikan dengan tinggi hero */
        min-height: 120px;
        background-color: #ffffff;
        z-index: 5;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.05);
    }

    #redaksi-page .hero-nav-wrapper ul {
        width: 85%;
        max-width: 1200px;
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: space-between;
        align-items: stretch; /* Mengisi tinggi kontainer */
        height: 100%;
    }

    #redaksi-page .hero-nav-wrapper ul li {
        flex: 1;
        padding: 35px 2% 0 2%; /* Menambahkan padding atas agar posisi teks lebih naik */
        cursor: pointer;
        display: flex;
        align-items: flex-start; /* Mendorong teks ke atas alih-alih di tengah */
        justify-content: center;
        text-align: center;
        color: #cccccc;
        border-top: 9px solid transparent;
        transition: border-color 0.2s ease, color 0.2s ease;
    }

    /* Efek Hover Sederhana ala Fiksi */
    #redaksi-page .hero-nav-wrapper ul li:hover {
        border-top: 9px solid #525252;
        color: #1a1a1a;
    }

    /* Efek Saat Diklik/Aktif */
    #redaksi-page .hero-nav-wrapper ul li.active {
        border-top: 9px solid #e03a3c; /* Garis atas merah khas Fiksi */
        color: #1a1a1a;
    }

    #redaksi-page .hero-nav-wrapper ul li h3 {
        font-family: var(--font-serif, serif);
        font-size: 1.35rem;
        font-weight: 700;
        text-transform: uppercase;
        margin: 0;
        transition: color 0.2s ease;
    }

    /* Warna Teks Mengikuti Status */
    #redaksi-page .hero-nav-wrapper ul li:hover h3 {
        color: #1a1a1a;
    }

    #redaksi-page .hero-nav-wrapper ul li.active h3 {
        color: #e03a3c; /* Teks merah seperti Fiksi */
    }


    /* --- AREA KONTEN BAWAH --- */
    .redaksi-body {
        padding: 40px 20px 80px 20px; /* Padding atas dikurangi agar teks lebih dekat dengan menu */
        background-color: #ffffff;
    }

    .redaksi-tab-content {
        display: none; 
        animation: fadeIn 0.4s ease;
        max-width: 1100px;
        margin: 0 auto;
        color: #333;
        line-height: 1.8;
    }

    .redaksi-tab-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .redaksi-tab-content h2 {
        font-family: 'Garamond', serif;
        font-size: 2.5rem;
        color: #111;
        margin-bottom: 25px;
        border-bottom: 2px solid #111;
        padding-bottom: 15px;
        display: inline-block;
    }

    .redaksi-tab-content p {
        font-family: Arial, sans-serif;
        font-size: 1.05rem; /* Disesuaikan karena Arial lebih lebar dari Garamond */
        margin-bottom: 20px;
        text-align: justify;
        line-height: 1.6;
    }

    /* Membatasi lebar teks Letter from the Editor */
    .letter-container {
        max-width: 650px; /* Kurang lebih setengah layar pada desktop */
        margin-left: 0;
    }

    .letter-container p,
    .letter-container ul {
        font-family: Arial, sans-serif; /* Menggunakan Arial sesuai permintaan */
        font-size: 1.05rem; 
        text-align: left;
        line-height: 1.6; 
    }

    /* Warna khusus untuk tautan (link) di teks redaksi */
    .red-link {
        color: #e03a3c;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .red-link:hover {
        text-decoration: underline;
        color: #b70d0f;
    }

    /* --- EDITORIAL TEAM (BERDASARKAN REFERENSI KODE) --- */
    #tab-team h2 {
        font-family: 'Garamond', serif;
        font-size: 3.5rem;
        font-weight: 600;
        letter-spacing: -1px;
        color: #111;
        margin-bottom: 40px; /* Diperkecil agar lebih rapat */
        border-bottom: none;
        padding-bottom: 0;
    }

    /* Grid 2 Kolom untuk Profil Direktur/Editor */
    .directors-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px 50px; /* Jarak vertikal dan horizontal */
        font-family: 'Garamond', serif;
        max-width: 750px; /* Membatasi lebar agar kolom kiri dan kanan saling mendekat */
    }

    .director-card {
        display: flex;
        flex-direction: column;
        text-align: left;
    }

    .director-name {
        font-size: 1.6rem; /* Disesuaikan sedikit untuk Garamond */
        font-weight: 600;
        color: #000;
        margin: 0 0 2px 0; /* Jarak antara jabatan dan nama sangat dirapatkan */
        letter-spacing: -0.5px;
    }

    .director-title {
        font-size: 1.15rem; /* Disesuaikan untuk Garamond */
        color: #333; /* Abu-abu sedikit lebih terang dari judul */
        line-height: 1.3; /* Line height daftar nama diperkecil agar rapat */
        font-weight: 400;
        margin: 0;
    }

    @media (max-width: 1024px) {
        .directors-grid {
            gap: 50px 30px;
        }
    }
    @media (max-width: 768px) {
        .directors-grid { 
            grid-template-columns: 1fr; 
            gap: 40px; 
        }
    }

</style>
@endpush

@section('content')
<section id="redaksi-page">

    <!-- BAGIAN ATAS: FULL PAGE HERO SLIDER & MENU -->
    <div class="hero-section">
        <!-- Background Slider -->
        <div class="hero-slider">
            <div class="hero-img active" id="img-tab-letter" style="background-image: url('https://picsum.photos/seed/redaksi1/1920/1080');"></div>
            <div class="hero-img" id="img-tab-team" style="background-image: url('https://picsum.photos/seed/redaksi2/1920/1080');"></div>
            <div class="hero-img" id="img-tab-submisi" style="background-image: url('https://picsum.photos/seed/redaksi3/1920/1080');"></div>
            <div class="hero-img" id="img-tab-sponsored" style="background-image: url('https://picsum.photos/seed/redaksi4/1920/1080');"></div>
        </div>

        <!-- Tab Navigation di Atas Background -->
        <div class="hero-nav-wrapper">
            <ul>
                <li class="redaksi-tab-btn active" data-target="tab-letter" data-img="img-tab-letter">
                    <h3>Letter From the Editor</h3>
                </li>
                <li class="redaksi-tab-btn" data-target="tab-team" data-img="img-tab-team">
                    <h3>Editorial Team</h3>
                </li>
                <li class="redaksi-tab-btn" data-target="tab-submisi" data-img="img-tab-submisi">
                    <h3>Submisi Tulisan</h3>
                </li>
                <li class="redaksi-tab-btn" data-target="tab-sponsored" data-img="img-tab-sponsored">
                    <h3>Sponsored Artikel</h3>
                </li>
            </ul>
        </div>
    </div>

    <!-- BAGIAN BAWAH: KONTEN TEKS -->
    <div class="redaksi-body">
        
        <!-- TAB CONTENT: LETTER FROM THE EDITOR -->
        <div id="tab-letter" class="redaksi-tab-content active">
            
            <div class="letter-container">
                <p>Para penulis dan kontributor Galeri Buku Jakarta yang dicintai pembacanya. Kisah-kisah dalam <a href="http://www.galeribukujakarta.com" target="_blank" class="red-link">www.galeribukujakarta.com</a> itu penting dan membawa para pembaca pada keluasan wawasan dan kedalaman pemaknaan. Galeri Buku Jakarta mengetengahkan tulisan penting dan mendalam dalam bentuk kolom dan komentar ahli tentang peristiwa sosial dan politik, bisnis dan sains, juga budaya pop dan seni, bersama dengan dosis dari publikasi puisi dan cerita pendek—juga kajian bukunya yang khas.</p>
                
                <p>Sejak kehadirannya pada 2015 Galeri Buku Jakarta selalu memiliki misi ganda: untuk mempromosikan penulis paling menarik dan untuk mendukung pembaca paling ambisius dan ingin tahu. Secara khusus Galeri Buku Jakarta ditujukan kepada mereka yang muda dan pemula. Kami ingin menjadi sumber panduan dan inspirasi untuk semua dalam bidang sastra dan penulisan secara umum.</p>
                
                <p>Setiap minggu selama lebih dari 10 tahun, Kami telah mencurahkan waktu, pikiran, cinta, dan sumber daya yang luar biasa untuk kerja cinta ini sehingga pembaca kami mengenal narasi dan kisah sastra juga kebudayaan dunia lebih luas melalui kerja penerjemahan yang menjadi salah satu misi kami; yaitu kosmopolitanisme kultural dalam identitas tak terbatas. Dan kami tetap bebas (dan bebas iklan), yang tetap dimungkinkan oleh patronase pembaca dan voluntarisme. Kami membutuhkan ratusan jam sebulan untuk meneliti dan menulis, juga menerjemah, dan ratusan juta untuk bertahan—antara secangkir kopi dan makan siang yang enak, dukungan Anda akan sangat berharga bagi keberlangsungan kerja cinta ini.</p>
                
                <p>Dalam pasang surut keberadaan organisasi komunitas kami, Galeri Buku Jakarta ingin memulai kembali dan mencanangkan fokus kerja baru. Secara singkat dalam rencana kerja 3 tahun ke depan (2024-2027)kami akan:</p>
                
                <p>1. Berfokus pada kerja kolaborasi berbasis voluntarisme dan dukungan publik independent dalam kerja kolektif bersama para penulis/ sastrawan dan komunitas kreatif dari para pembaca dan pecinta sastra.</p>
                
                <p>2. Kami ingin terus tumbuh dan inovatif: kami mendukung inovasi dalam sastra baik prosa mau pun puisi: dalam bentuk digital, cetak mau pun event dan performance untuk meluaskan pengalaman sastrawi publik dalam keberagaman bentuk dan identitasnya.</p>
                
                <p>Itu tentang bagaimana warga kota mengalami sastra dan menjadikannnya ruang untuk menemukan gambar-gambar kemajuan di atas imajinasi yang ditarik oleh begitu banyak kepentingan—tetapi sebagaimana imajinasi, dia memiliki dorongan kebebasan dan kebebasan hanya berguna jika dia dihadirkan ke dalam bentuk-bentuk konkrit peradaban tak terkecuali peradaban warga kota</p>
            </div>
        </div>

        <!-- TAB CONTENT: EDITORIAL TEAM (MENGGUNAKAN DESIGN KODE REFERENSI) -->
        <div id="tab-team" class="redaksi-tab-content">            
            <div class="directors-grid">
                
                <div class="director-card">
                    <h3 class="director-name">Board of Directors</h3>
                    <p class="director-title">Afrizal Malna<br>Ladinata<br>Hamdy Salad<br>Damhuri Muhammad</p>
                </div>
                
                <div class="director-card">
                    <h3 class="director-name">Chief Editor / Directors</h3>
                    <p class="director-title">Sabiq Carebesth</p>
                </div>

                <div class="director-card">
                    <h3 class="director-name">Senior Managing Editor</h3>
                    <p class="director-title">Adi M Idham</p>
                </div>

                <div class="director-card">
                    <h3 class="director-name">Managing Editor</h3>
                    <p class="director-title">Marlina Sopiana<br>Regina N. Helnaz</p>
                </div>

                <div class="director-card">
                    <h3 class="director-name">Editorial Team</h3>
                    <p class="director-title">Marlina Sopiana<br>Virdika Rizky Utama<br>Ladinata<br>Agus Teguh<br>Adi M Idham<br>Frea Petra Maheswari<br>Jamaluddin</p>
                </div>

                <div class="director-card">
                    <h3 class="director-name">Communications Director</h3>
                    <p class="director-title">Nissita Tiyas</p>
                </div>

                <div class="director-card">
                    <h3 class="director-name">Web Development Manager</h3>
                    <p class="director-title">Nandito Maulana Yedikar<br>Siwika<br>Rahmat Darajat</p>
                </div>

                <div class="director-card">
                    <h3 class="director-name">Social Media</h3>
                    <p class="director-title">Lum Ilahil Afif</p>
                </div>

                <div class="director-card">
                    <h3 class="director-name">Design Contributors</h3>
                    <p class="director-title">Sabrina Puisi AZ<br>Aldia Putra<br>Amir Fuaddi</p>
                </div>

            </div>
        </div>

        <!-- TAB CONTENT: SUBMISI TULISAN -->
        <div id="tab-submisi" class="redaksi-tab-content">
            <div class="letter-container">
                <p>Terimakasih untuk minat dan ketertarikan rekan pembaca (dan juga penulis) sekalian untuk mengirim karya penulisan kepada Galeri Buku Jakarta. Kami akan menangani dengan penuh kecermatan dan pertimbangan atas semua karya yang dikirimkan dalam beragam bentuknya, baik puisi dan prosa mau pun artikel pemikiran yang ditujukan untuk mengiri rubrik/ menu di laman yang kami kelola. Tim redaksi kami terbatas dan terkadang ada saat-saat kami menerima banyak karya sehingga akan membutuhkan waktu dalam publikasi mau pun respon kami atas karya yang dikirimkan. Pada umumnya kami hanya membalas dan memberikan feedback kepada tulisan yang akan kami tayangkan. Terkadang itu memakan waktu hingga 2 bulan sebelum kami memberitahu anda publikasinya. Terimakasih atas kesabaran pembaca dan penulis sekalian.</p>

                <p>Silakan unduh Panduan Penulisan kami <a href="#" class="red-link">selengkapnya.</a></p>

                <p style="margin-bottom: 8px;"><strong>Catatan Keredaksian:</strong></p>
                <ul style="padding-left: 20px; margin-bottom: 20px;">
                    <li style="margin-bottom: 8px;"><strong>Pengiriman karya Puisi:</strong> kirimkan 3-5 puisi disertai biodata singkat. Bisa merupakan karya penerjemahan penulis dunia.</li>
                    <li style="margin-bottom: 8px;"><strong>Pengiriman Cerita:</strong> yang kami maksudkan adalah cerita pendek. Panjang cerpen 7.000-15.000 karakter, termasuk spasi.</li>
                    <li style="margin-bottom: 8px;"><strong>Pengiriman Kajian Buku:</strong> Buku diulas bebas tanpa batas ragam. Naskah 3000-5000 karakter termasuk spasi.</li>
                    <li style="margin-bottom: 8px;"><strong>Pengiriman Karya Esai dan Pemikiran:</strong> Esai dimaksud terutama kritik budaya; utamanya sastra, seni rupa, atau film. Pemikiran diutamakan esai sosial budaya perkotaan dan kritik tata kelola pembangunan. Tulisan tidak lebih dari 6000 karakter.</li>
                </ul>

                <p style="margin-bottom: 8px;"><strong>Catatan Penting:</strong></p>
                <ul style="padding-left: 20px; margin-bottom: 20px;">
                    <li style="margin-bottom: 8px;">Semua naskah/ karya yang dikirim asli (bukan saduran), belum pernah dipublikasi secara digital di laman lain sebelumnya. Dan bukan jiplakan karya penulis lain.</li>
                    <li style="margin-bottom: 8px;">Semua karya dikirim dengan disertai biodata singkat.</li>
                    <li style="margin-bottom: 8px;">Baik karya untuk rubrik cerita pendek, puisi, esai dan kajian buku, redaksi menerima hasil karya penerjemahan dengan wajib menyebut sumber dan pemilik karya asli.</li>
                    <li style="margin-bottom: 8px;">Kami tidak selalu memberikan respon atau pemberitahuan atas semua karya yang kami terima. Kecuali karya yang memiliki kemungkinan untuk kami publikasikan. Terkadang itu memakan waktu 2-3 bulan—kami hanya memiliki beberapa orang untuk melakukan kajian keredaksian dan harus membaca banyak karya tiap pekannya.</li>
                    <li style="margin-bottom: 8px;">Semua karya yang dikirimkan hak cipta sepenuhnya menjadi milik penulis. Tetapi kami juga memilki hak pakai dan hak memanfaatkan publikasinya (baik digital mau pun cetak) untuk mendukung keberadaan Galeri Buku Jakarta. Itu termasuk publikasi dalam bentuk digital sebagai materi content desain, sosial media, dan lainnya atas nama redaksi GBJ dan kami tidak selalu memberitahu pengirim karya akan hal tersebut. Terimakasih untuk pemahaman dan kontribusinya.</li>
                    <li style="margin-bottom: 8px;">Kami memberi batas 3 pekan jika karya yang anda kirimkan tidak kami publikasikan, Anda berhak mengirim karya anda kepada media lain atau untuk keperluan publikasi pribadi anda.</li>
                    <li style="margin-bottom: 8px;">Kami berharap para pembaca dan penulis mengirim karya original, baru dan hanya dikirim/ dipublikasikan untuk Galeri Buku Jakarta. Jika kami mendapati sebaliknya, kami berhak membatalkan publikasi tanpa terlebih dahulu memberitahu.</li>
                    <li style="margin-bottom: 8px;"><strong>Honorarium:</strong> Kami tidak memiliki dana untuk memberi honorarium kepada semua tulisan yang kami terima dan publikasikan.</li>
                </ul>

                <p>Kami hanya menerima karya dan menanggapi di email: <a href="mailto:galeribukujakarta@gmail.com" class="red-link">galeribukujakarta@gmail.com</a> selain email tersebut karya yang anda kirimkan tidak akan mendapat respon atau publikasi.</p>
            </div>
        </div>

        <!-- TAB CONTENT: SPONSORED ARTIKEL -->
        <div id="tab-sponsored" class="redaksi-tab-content">
            <div class="letter-container">
                <p>Galeri Buku Jakarta menawarkan ruang bagi mitra dan sponsor untuk menjangkau audiens kami yang terdiri dari para pembaca aktif, penulis, dan pemerhati literatur melalui artikel bersponsor (Sponsored Content).</p>
                <p>Kami bekerja sama dengan berbagai penerbit, jenama gaya hidup, dan institusi budaya untuk menciptakan narasi advertorial yang tidak mengganggu, melainkan memberikan nilai tambah (value) bagi pembaca kami. Seluruh artikel bersponsor akan ditulis atau disunting oleh tim kami untuk memastikan gaya bahasa dan kualitasnya selaras dengan standar editorial kami.</p>
                <p>Untuk informasi lebih lanjut mengenai rate card dan penawaran kerja sama, silakan hubungi <a href="mailto:partnership@bukujakarta.com" class="red-link">partnership@bukujakarta.com</a>.</p>
            </div>
        </div>

    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tabBtns = document.querySelectorAll('.redaksi-tab-btn');
        const tabContents = document.querySelectorAll('.redaksi-tab-content');
        const tabImages = document.querySelectorAll('.hero-img');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Reset semua tab, konten, dan gambar
                tabBtns.forEach(b => b.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                tabImages.forEach(img => img.classList.remove('active'));

                // Aktifkan tab dan konten yang diklik
                this.classList.add('active');
                
                const targetId = this.getAttribute('data-target');
                const targetContent = document.getElementById(targetId);
                if(targetContent) {
                    targetContent.classList.add('active');
                }

                // Tampilkan gambar hero yang sesuai
                const imgId = this.getAttribute('data-img');
                const targetImg = document.getElementById(imgId);
                if(targetImg) {
                    targetImg.classList.add('active');
                }
            });
        });

        // Cek URL hash untuk membuka tab secara otomatis saat direct link
        const hash = window.location.hash;
        if (hash) {
            // hash format: #tab-submisi
            // Kita cari button yang punya data-target "tab-submisi"
            const targetId = hash.substring(1); 
            const targetBtn = document.querySelector(`.redaksi-tab-btn[data-target="${targetId}"]`);
            if (targetBtn) {
                targetBtn.click(); // Simulasikan klik pada tab
                // Scroll sedikit ke bawah agar konten langsung terbaca
                setTimeout(() => {
                    document.querySelector('.redaksi-body').scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 300);
            }
        }
    });
</script>
@endpush
