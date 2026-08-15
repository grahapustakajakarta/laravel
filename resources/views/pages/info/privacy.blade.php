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
    <h1 class="privacy-title">Kebijakan Privasi</h1>
    <div class="privacy-date">Terakhir Diperbarui: 1 Januari 2026</div>
    <hr class="privacy-divider">
    
    <p class="privacy-text">
        Harap baca dokumen ini dengan seksama sebelum menggunakan website ini. Adalah kewajiban Anda untuk membaca Kebijakan Privasi ini terlebih dulu sebelum mengambil tindakan apa pun di website ini. Anda dapat memberitahu kami bila tidak ingin memberikan informasi tentang diri Anda kepada pihak ketiga sesuai dengan ketentuan di bawah. Anda dapat membaca selengkapnya terkait Syarat dan Ketentuan kami.
    </p>

    <h2 class="privacy-heading">Prinsip-prinsip Dasar</h2>
    <p class="privacy-text">
        Dengan mengakses dan menggunakan website ini Anda dianggap menyetujui batasan-batasan hukum yang diatur dalam Ketentuan Penggunaan dan Kebijakan Privasi ini. Oleh karena itu, Anda diharapkan juga membaca Ketentuan Penggunaan sebelum menggunakan website ini. 
    </p>
    <p class="privacy-text">
        PENGELOLA berkomitmen untuk melindungi privasi Anda. Penting bagi kami untuk memastikan Anda dapat menggunakan website ini dan menikmatinya tanpa harus mengalami pelanggaran atas privasi Anda. Namun demikian, memahami pengguna website kami, merupakan hal yang penting agar kami dapat meningkatkan layanan kami secara terus-menerus. Kami perlu membangun gambaran yang akurat tentang kebutuhan dan harapan para pengguna kami. Dan tentunya hal itu hanya dapat dilakukan dengan membangun komunikasi dengan Anda terlebih dahulu.
    </p>
    <p class="privacy-text">
        Pemahaman kami terhadap diri Anda akan membuat kami dapat menawarkan layanan yang relevan dan interaktif sebagaimana yang diharapkan oleh pengguna website kami. Itu juga membantu kami untuk memberikan akses atas informasi terbaik kepada pengguna bebas website ini. 
    </p>

    <h2 class="privacy-heading">"Informasi apa yang PENGELOLA minta dari Anda?"</h2>
    <p class="privacy-text">
        Secara otomatis kami mengumpulkan beberapa data tentang pola Anda menggunakan internet. Ini adalah data agregat dan tidak menunjuk pada diri Anda secara personal. Kami mungkin juga akan meminta Anda untuk memberikan informasi personal secara sukarela untuk tujuan mendapatkan gambaran yang tepat tentang pengguna website kami. Artinya, Anda dapat dengan bebas menentukan apakah Anda akan dengan sukarela bersedia memberikan informasi ini atau tidak. 
    </p>
    <p class="privacy-text">
        Bila Anda mengikuti sebuah kompetisi yang kami adakan, promosi dan tawaran-tawaran lain, Anda akan diminta untuk memberikan beberapa detail tambahan tentang diri Anda. Anda juga bisa memilih untuk memberikan informasi tersebut melalui email atau cara lain yang Anda pilih. Jika Anda melakukan transaksi atau pembelian barang dengan Perusahaan lain di bawah naungan PT Graha Pustaka Jakarta, mereka juga akan meminta beberapa informasi tertentu. Informasi ini mungkin akan dibagi dengan kami.
    </p>

    <h2 class="privacy-heading">Bagaimana kami mengumpulkan cookie pada website dan informasi apa yang kami kumpulkan?</h2>
    <h2 class="privacy-heading" style="margin-top: 15px;">Informasi dan Data Pribadi</h2>

    <p class="privacy-text"><strong>Pendaftaran di website kami</strong><br>
        Setiap orang dapat mengakses website kami. Tetapi akses dalam lingkup yang luas terhadap informasi dalam website kami hanya bisa didapat bila telah mendaftarkan diri secara gratis. Anda akan diminta untuk memberikan beberapa informasi pribadi Anda, termasuk alamat email dan informasi demografi seperti jenis kelamin, usia, kode pos, pendapatan (bersifat opsional), pekerjaan, dan sebagainya, pada saat mendaftar. Dengan mengakses www.galeribukujakarta.com, Anda dianggap menyetujui ketentuan untuk menjadi anggota di website kami.
    </p>

    <p class="privacy-text"><strong>Layanan dan Produk Tertentu</strong><br>
        Sebagian besar isi website kami dapat Anda akses dengan gratis. Namun demikian, beberapa produk dan layanan tertentu mungkin hanya dapat Anda akses dengan membayar. Bila Anda ingin membayar untuk akses terhadap produk dan layanan seperti itu, kami akan meminta dan menyimpan data kartu kredit atau debet Anda. Kami akan menjaga kerahasiaan informasi ini sepenuhnya dan hanya akan kami bagi dengan pihak bank penerbit kartu kredit atau debet Anda, yang perannya kami perlukan untuk menyelesaikan proses transaksi ini.
    </p>

    <p class="privacy-text"><strong>Kontes dan Penawaran Istimewa</strong><br>
        Di kesempatan tertentu, PENGELOLA akan mengumpulkan informasi pribadi dari pembaca dalam rangka penyelenggaraan kontes atau penawaran khusus. Informasi ini juga kemungkinan besar akan kami bagi dengan pihak ketiga yang bekerjasama dengan kami dalam penyelenggaraan kontes atau penawaran istimewa tersebut. Jika Anda tidak ingin informasi Anda dibagi dengan pihak ketiga, Anda bisa memilih untuk tidak berpartisipasi dalam kontes atau penawaran khusus tersebut.
    </p>

    <p class="privacy-text"><strong>Survei pembaca, panel pembaca, dan riset pasar</strong><br>
        Pengelola mungkin akan mengumpulkan data pribadi dari pembaca saat melakukan survei. Data mungkin dikumpulkan melalui website kami, telepon atau melalui email. Informasi yang Anda berikan untuk pertanyaan-pertanyaan survei yang membutuhkan jawaban opsional mungkin kami akan bagi dengan pihak ketiga (pengiklan atau rekanan kami lainnya) dalam bentuk data agregat.
    </p>
    <p class="privacy-text">
        Beberapa pembaca kami mungkin juga akan kami undang untuk menjadi anggota panel pembaca. Jika Anda mendapatkan undangan tersebut dan bersedia menjadi anggota panel pembaca, Anda akan diminta untuk memberi informasi tertentu, misalnya keuangan pribadi atau rumahtangga dan perilaku belanja Anda. Pembaca biasanya dihubungi melalui email, dengan tautan ke halaman online survei kami.
    </p>
    <p class="privacy-text">
        Seluruh data survey dilaporkan dan/atau digunakan hanya dalam bentuk data agregat, informasi pribadi sama sekali tidak akan dikeluarkan. Sebagai anggota panel, kami hanya akan meminta Anda untuk memberikan alamat email Anda. Nama, alamat rumah, dan nomor telepon bersifat opsional.
    </p>

    <h2 class="privacy-heading">Teknologi Analitis</h2>
    <p class="privacy-text">
        Kami menggunakan website pihak ketiga untuk melacak dan menganalisa data penggunaan atas website kami. Data tersebut bersifat non-personal. Kegunaannya adalah untuk mengidentifikasi penggunaan dan mengukur statistik informasi dari pengunjung dan pembaca website. Seluruh data dikumpulkan oleh pihak ketiga yang menjadi rekanan kami tersebut, namun kepemilikan data dan hak untuk menggunakannya ada pada kami.
    </p>
    <p class="privacy-text">
        Kami mungkin akan mempublikasikan data agregat yang bersifat non-personal dan kesimpulan informasi secara umum mengenai pengunjung website kami untuk keperluan promosi dan sebagai representasi pembaca kami kepada pengiklan. Harap dicatat bahwa data yang kami presentasikan adalah data yang bersifat non-personal, hanya kesimpulan umum dari aktivitas para pengunjung dan pembaca kami.
    </p>

    <p class="privacy-text"><strong>Alamat internet protocol (IP)</strong><br>
        Pengelola mencatat alamat internet protocol, atau lokasi komputer Anda di internet, untuk tujuan administrasi sistem. Kami menggunakan informasi ini sebagai cara agregat untuk melacak akses terhadap website kami.
    </p>

    <p class="privacy-text"><strong>Arsip log (log file)</strong><br>
        Kami menggunakan data arsip log secara agregat untuk menganalisa penggunaan terhadap website kami. Jika Anda mengunduh dan menginstal aplikasi tertentu yang disediakan oleh website kami, arsip log akan dikumpulkan oleh aplikasi tersebut dan dikirimkan ke server kami saat komputer Anda melakukan sinkronisasi berita terbaru.
    </p>

    <h2 class="privacy-heading">Penggunaan cookie pada website</h2>
    <p class="privacy-text">
        Cookie adalah bagian data yang disimpan dalam file cookie pada browser di komputer pengguna sehingga website dapat mengingat Anda. Cookie biasanya mengandung nama domain dari mana cookie berasal, panjang sesi Anda berinteraksi dengan website kami, dan nilai yang biasanya berbentuk angka yang ditentukan secara acak. Cookie dapat membantu website untuk mengatur konten yang sesuai dengan minat dan perhatian Anda dengan cepat. Semua website pada umumnya menggunakan cookie. Kami tidak menggunakan cookie untuk mengumpulkan informasi pribadi Anda yang tidak ingin Anda ungkapkan.
    </p>
    <p class="privacy-text" style="margin-bottom: 10px;">Ada dua jenis cookie digunakan pada website kami:</p>
    <ul class="privacy-list">
        <li><strong>Session Cookies</strong>, merupakan cookie temporer yang akan ada di file cookie selama Anda mengakses website kami. Cookie ini akan terhapus dengan otomotasi begitu Anda keluar dari website.</li>
        <li><strong>Persistent Cookies</strong>, merupakan jenis cookie yang akan tetap tersimpan dalam browser Anda meskipun Anda sudah keluar dari website kami (panjang waktu cookie ini tetap tersimpan tergantung pada usia spesifik masing-masing cookie).</li>
    </ul>
    <p class="privacy-text">
        <strong>Session Cookies:</strong> Anda bisa menggunakan cookie ini untuk mengingat password yang Anda gunakan untuk mengakses website ini sehingga Anda bisa masuk secara otomatis ke dalam website kami.<br>
        <strong>Persistent Cookies:</strong> Cookie ini berguna bagi kami untuk mengenali Anda sebagai pengguna unik (unique visitor) saat Anda kembali mengunjungi website kami dan juga membantu kami untuk menyusun konten, iklan dan presentasi yang sesuai dengan kebutuhan Anda di dalam website kami. Selain itu, persistent cookie juga membantu kami untuk mengumpulkan statistik agregat yang sifatnya anonim sehingga kami dapat memahami bagaimana cara pengguna kami memanfaatkan website ini. Dengan demikian dapat membantu kami memperbaiki struktur website ini. Kami tetap tidak dapat mengidentifikasikan Anda secara personal dengan cara ini.
    </p>

    <h2 class="privacy-heading">Cookie pihak ketiga</h2>
    <p class="privacy-text" style="margin-bottom: 10px;">Pihak ketiga juga menggunakan cookie dalam website kami. Cookie-cookie ini digunakan untuk tujuan berikut:</p>
    <ul class="privacy-list">
        <li>Untuk menggunakan iklan pada iklan di website dan melacak apakah iklan-iklan tersebut diklik oleh pengguna.</li>
        <li>Untuk mengatur seberapa sering iklan tertentu diperlihatkan kepada Anda.</li>
        <li>Untuk menghitung jumlah pengguna anonim yang mengunjungi website.</li>
        <li>Untuk memberikan keamanan pada Anda saat melakukan transaksi.</li>
    </ul>

    <h2 class="privacy-heading">Menghidupkan/mematikan cookie</h2>
    <p class="privacy-text">
        Anda dapat menerima atau menolak cookie dengan memodifikasi pengaturan pada browser Anda. Namun demikian, bila Anda melakukan itu, kemungkinan besar Anda tidak akan dapat menggunakan semua fitur interaktif dalam website ini.
    </p>

    <h2 class="privacy-heading">Transfer data pribadi ke dunia internasional</h2>
    <p class="privacy-text">
        Seperti Anda ketahui, internet tidak mengenal batas-batas Negara. Layanan di internet bisa diakses secara global. Demikian juga dengan pengumpulan dan transmisi data personal tidak dapat dibatasi hanya di satu negara. Anda harus menyadari hal ini ketika mengakses website kami maupun website rekanan kami atau website lain yang ada tautannya pada website kami. Data pribadi Anda mungkin diproses di dalam atau ditransfer ke negara lain, misalnya Amerika. Dengan mengakses website kami, Anda dianggap menyetujui data pribadi Anda ditransfer atau diproses dengan cara demikian.
    </p>

    <h2 class="privacy-heading">Untuk tujuan apa PENGELOLA mengumpulkan dan menggunakan informasi dari Anda?</h2>
    <p class="privacy-text" style="margin-bottom: 10px;">
        Kami menggunakan detil agregat pengunjung website kami (pengguna diidentifikasikan secara anonim) untuk membantu meningkatkan pemahaman kami tentang pengguna website dan preferensi mereka. Kami menggunakannya untuk membantu menempatkan iklan, peluang komersil, dan kompetisi yang relevan bagi pengguna website kami. Informasi itu juga dapat membantu kami memastikan peliputan editorial terbaik untuk Anda, selain membantu kami mengembangkan website ini dan mengaudit penggunaannya.
    </p>
    <p class="privacy-text" style="margin-bottom: 10px;">Informasi tentang Anda sebagai pribadi atau individu, termasuk detil kontak, mungkin akan digunakan untuk keperluan berikut ini:</p>
    <ul class="privacy-list">
        <li>Untuk melakukan riset pasar dan survei lainnya.</li>
        <li>Untuk melihat dan menggambarkan minat Anda terhadap materi editorial tertentu maupun peluang komersil yang Anda minati. dibagi dengan pengiklan, rekan dagang, dan entitas bisnis lainnya yang bekerjasama dengan kami.</li>
        <li>Kami juga mungkin dapat berbagi informasi dengan mereka tentang data pelanggan mereka, yang mungkin juga termasuk Anda di dalamnya.</li>
    </ul>

    <p class="privacy-text"><strong>Analisa Statistik</strong><br>
        Pengelola akan menerapkan analisa statistik mengenai pasar dan demografis pembaca, dan pola langganan maupun belanja mereka, untuk tujuan pengembangan produk dan secara umum untuk memberikan informasi kepada pengiklan tentang karakter pelanggan kami. Kami juga menggunakan informasi tersebut agar iklan bisa lebih tepat target, secara agregat, dan lebih sesuai dengan dengan pembaca. Pengelola juga akan membagi informasi pribadi Anda dengan media-media lain di bawah naungan PT Graha Pustaka Jakarta untuk keperluan analisa, termasuk analisa untuk pengembangan hubungan dengan pelanggan.
    </p>

    <p class="privacy-text"><strong>Produk dan layanan dari Pengelola</strong><br>
        Dari waktu ke waktu, kami akan memberikan informasi secara teratur kepada para pembaca kami mengenai tawaran dan produk, termasuk layanan berlangganan spesial dan produk serta layanan premium lainnya.
    </p>

    <p class="privacy-text"><strong>Iklan banner</strong><br>
        Kami menggunakan informasi demografi dan preferensi agar iklan-iklan di website kami sesuai target, secara agregat, sampai pada pengguna yang memang membutuhkannya. Ini artinya, Anda bisa melihat iklan-iklan yang pada saat tertentu mungkin menjadi kebutuhan Anda di website kami. Kami hanya akan memberikan informasi pribadi Anda kepada pihak ketiga dalam bentuk data agregat atau non-personal.
    </p>

    <h2 class="privacy-heading">User Generated Content (termasuk komentar, review, artikel blog, dan sebagainya)</h2>
    <p class="privacy-text">
        Kami menawarkan kepada Anda kesempatan untuk terlibat dalam aktivitas publik di galeribukujakarta.com, termasuk menulis/ mengirimkan artikel, memberikan komentar, rekomendasi, review pembaca, dan memberikan peringkat. Setiap informasi yang Anda masukkan dalam kontribusi Anda, bersama dengan nama pengguna dan foto, akan tampil di publik dan mungkin akan digunakan oleh galeribukujakarta.com untuk keperluan website kami maupun untuk keperluan promosi atau komersial. 
    </p>
    <p class="privacy-text">
        Jika Anda memilih untuk terlibat dalam aktivitas publik di situs kami, Anda harus sadar bahwa informasi pribadi yang Anda masukkan akan dapat dibaca, dikumpulkan, atau digunakan oleh pengguna lain di area tersebut, dan ada kemungkinan Anda akan dikirimi informasi yang tidak Anda minta atau inginkan. Kami tidak bertanggungjawab atas informasi pribadi yang Anda masukkan ke dalam forum-forum tersebut. Untuk keterangan lebih lanjut, baca Tata Cara Posting dan Penggunaan Forum yang telah kami sediakan.
    </p>
    <p class="privacy-text">
        Demi kepentingan Anda, kami menyarankan untuk membaca dan mempelajari Tata Cara Posting dan Penggunaan Forum untuk mengetahui perubahan-perubahan yang akan kami buat secara berkala.
    </p>

    <h2 class="privacy-heading">E-Mail Newsletters</h2>
    <p class="privacy-text">
        www.galeribukujakarta.com menawarkan sejumlah email newsletter. Jika Anda mendaftarkan diri untuk berlangganan newsletter di dalam website kami, secara periodik Anda akan mendapatkan email berisi tautan newsletter tersebut di mailbox Anda. Jika Anda secara spesifik tidak ingin lagi menerima salah satu newsletter dari kami, ikuti instruksi "unsubscribe" yang terletak di bagian bawah setiap newsletter.
    </p>
    
    <p class="privacy-text"><strong>Akun dan layanan yang terkait dengan email:</strong><br>
        Pengelola memiliki hak untuk mengirimi Anda email terkait dengan status akun Anda. Ini termasuk instruksi untuk melakukan konfirmasi, pemberitahuan masa kadaluarsa dan pembaruan, pemberitahuan terkait dengan kartu kredit Anda (bila Anda melakukan transaksi di website kami), maupun bentuk transaksi email dan pemberitahuan lain yang terkait dengan perubahan besar yang terjadi pada website kami dan/atau Kebijakan Privasi kami. Jika Anda terdaftar dalam diskusi online atau fitur lain, mungkin Anda akan menerima email spesifik terkait dengan partisipasi Anda dalam aktivitas tersebut.
    </p>
    <p class="privacy-text"><strong>Email Promosi:</strong><br>
        Jika Anda memilih untuk menerima email promosi dari galeribukujakarta.com secara periodik kami akan mengirim Anda email berisi informasi tentang produk dan layanan menarik. Anda dapat memutuskan untuk tidak menerima pesan-pesan seperti itu di masa datang dengan cara mengikuti instruksi "unsubscribe" yang terletak di bagian bawah email.
    </p>
    <p class="privacy-text"><strong>Email dari Anda:</strong><br>
        Jika Anda mengirimi kami email, Anda harus tahu bahwa informasi yang diungkapkan dalam email mungkin tidak terlindungi atau terenkripsi dan dengan demikian mungkin dapat dilihat oleh pihak lain. Kami sarankan agar Anda lebih berhati-hati ketika memutuskan untuk mengungkapkan informasi pribadi atau confidential dalam email. Kami akan menggunakan alamat email Anda untuk menjawab secara langsung pertanyaan atau komentar Anda.
    </p>
    <p class="privacy-text"><strong>Fitur Kirimkan Artikel Ini Lewat Email:</strong><br>
        Pembaca galeribukujakarta.com dapat menggunakan fitur ini untuk merekomendasikan artikel (atau konten menarik lainnya, seperti foto) yang menarik kepada kenalannya. Artikel tersebut akan dimasukkan ke dalam email dalam bentuk tautan (link) yang akan mengarahkan penerima email Anda untuk mengakses artikel tersebut langsung di website kami. Alamat email yang Anda masukkan ke dalam layanan ini akan disimpan untuk kemudahan Anda saat ingin merekomendasikan artikel-artikel menarik lainnya di masa datang. Alamat-alamat email tersebut tidak akan digunakan untuk tujuan lain, dan tidak akan dibagikan dengan pihak ketiga.
    </p>

    <h2 class="privacy-heading">Seberapa besar privasi saya terhadap data pribadi Anda?</h2>
    <p class="privacy-text">
        Selain dengan perusahaan-perusahaan lain di dalam PENGELOLA, kami hanya membagi informasi personal Anda dengan pihak ketiga yang kami pilih secara selektif dan dengan siapa kami memiliki, atau mungkin memiliki, hubungan bisnis. PENGELOLA menggunakan perangkat hukum yang relevan dan diperlukan serta mengambil semua tindakan antisipasi yang memungkinkan untuk memastikan informasi pribadi Anda tetap terjaga aman dan hanya dapat dilihat oleh pihak ketiga yang bertanggungjawab.
    </p>
    <p class="privacy-text">
        Namun demikian, kami tidak bertanggungjawab untuk semua tindakan yang diambil oleh pihak ketiga yang menerima atau mendapatkan akses terhadap informasi tersebut, atau untuk semua pelanggaran hukum yang terjadi. Jika Anda meminta kami untuk tidak menggunakan detail pribadi Anda, maka data penggunaan Anda di website kami hanya akan berupa bagian dari statistik agregat dan tidak akan dikaitkan langsung kepada diri Anda sebagai individu.
    </p>
    <p class="privacy-text">
        Kami juga menjalin kontrak dengan perusahaan lain yang memberikan layanan yang kami butuhkan, misalnya pemrosesan transaksi dan tagihan kartu kredit yang Anda gunakan ketika bertransaksi di website kami. Kami akan memberikan informasi yang dibutuhkan oleh perusahaan-perusahaan tersebut agar mereka bisa melaksanakan tugas dan layanan mereka kepada kami. Perusahaan-perusahaan penyedia jasa dengan siapa kami bekerjasama ini hanya dapat menggunakan data Anda yang ada pada kami dalam lingkup yang sangat terbatas, dan mereka tidak boleh membagi atau menjual data tersebut. Kami kemungkinan, dan ini jarang sekali terjadi, mengeluarkan informasi pribadi karena permintaan dari, misalnya, pengadilan.
    </p>
    <p class="privacy-text">
        <strong>Butuh informasi lebih lanjut?</strong> Jika Anda membutuhkan informasi lebih lanjut, atau ingin menghubungi kami terkait dengan Kebijakan Privasi ini dan menyampaikan pendapat Anda tentang informasi personal Anda, silakan isi form kontak yang telah tersedia.
    </p>

    <h2 class="privacy-heading">Informasi perusahaan dan perlindungan data</h2>
    <p class="privacy-text">
        Pengontrol atas data-data yang ada dalam website ini adalah Galeri Buku Jakarta, yang bernaung di bawah PT. Graha Pustaka Jakarta, dengan alamat kantor: Jl. Taman Patra III. Setiabudi, Kuningan, Jakarta Selatan. 
    </p>
    
    <p class="privacy-text" style="font-weight: bold; margin-top: 30px;">
        © Copyright Galeri Buku Jakarta, 2026
    </p>
</div>
@endsection
