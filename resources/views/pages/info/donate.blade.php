@extends('layouts.app')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=PT+Serif:wght@400;700&display=swap" rel="stylesheet">
<style>
    /* ===== HALAMAN DONATE ===== */
    #donate-page {
        background-color: #fff;
    }

    .donate-wrapper {
        max-width: 1200px;
        margin: 10px auto;
        padding: 0 40px;
    }

    /* --- HERO SECTION (atas banner) --- */
    .donate-hero {
        padding: 60px 0 50px;
        background-color: #fff;
    }

    .donate-hero-header {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: start;
        margin-bottom: 48px;
    }

    .donate-hero-title {
        font-family: 'PT Serif', serif;
        font-size: 2.6rem;
        font-weight: 700;
        line-height: 1.2;
        color: #111;
        margin: 0;
    }

    .donate-hero-desc {
        font-family: 'PT Serif', serif;
        font-size: 1.15rem;
        line-height: 1.5;
        color: #333;
        padding-top: 6px;
    }

    .donate-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .donate-card {
        display: flex;
        flex-direction: column;
    }

    .donate-card-img {
        width: 100%;
        aspect-ratio: 4/3;
        object-fit: cover;
        border-radius: 12px;
        display: block;
        margin-bottom: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .donate-card:hover .donate-card-img {
        transform: scale(1.02);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }

    .donate-card-title {
        font-family: 'PT Serif', serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 8px;
    }

    .donate-card-text {
        font-family: Arial, sans-serif;
        font-size: 0.9rem;
        line-height: 1.5;
        color: #444;
    }

    /* Responsive hero */
    @media (max-width: 768px) {
        .donate-hero-header {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .donate-hero-title { font-size: 2rem; }
        .donate-cards {
            grid-template-columns: 1fr;
            gap: 32px;
        }
    }
    @media (max-width: 480px) {
        .donate-hero-title { font-size: 1.6rem; }
        .donate-hero { padding: 40px 0 30px; }
    }

    /* --- BANNER --- */
    .donate-banner {
        background-color: #c0392b;
        padding: 60px 40px;
        text-align: center;
    }

    .donate-title-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .donate-word {
        font-family: 'PT Serif', serif;
        font-size: 3.5rem;
        font-weight: 700;
        letter-spacing: 3px;
        color: #fff;
    }

    .donate-image {
        height: 65px;
        object-fit: contain;
    }

    .donate-desc {
        font-family: 'Garamond', serif;
        font-size: 1.35rem;
        line-height: 1.4;
        color: rgba(255,255,255,0.88);
        max-width: 650px;
        margin: 0 auto 30px auto;
    }

    .btn-donate {
        display: inline-block;
        background-color: #fff;
        color: #c0392b;
        padding: 12px 40px;
        font-family: 'PT Serif', serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        text-decoration: none;
        border: 2px solid #fff;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-donate:hover {
        background-color: transparent;
        color: #fff;
    }

    .btn-nominal {
        padding: 10px 22px;
        border: 1.5px solid rgba(255,255,255,0.6);
        background: transparent;
        color: #fff;
        cursor: pointer;
        font-family: 'PT Serif', serif;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        transition: all 0.25s ease;
    }

    .btn-nominal:hover {
        background: #fff;
        color: #c0392b;
        border-color: #fff;
    }

    .donate-nominals {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
        margin-bottom: 20px;
    }

    .donate-input-group {
        display: flex;
        justify-content: center;
        gap: 10px;
        align-items: stretch;
        max-width: 520px;
        margin: 0 auto;
        flex-wrap: wrap;
    }

    .input-wrapper {
        position: relative;
        flex: 1;
        display: flex;
        min-width: 200px;
    }

    .donate-input-group input {
        width: 100%;
        padding: 14px 45px 14px 18px;
        border: 1.5px solid rgba(255,255,255,0.7);
        background: rgba(255,255,255,0.15);
        color: #fff;
        font-family: 'PT Serif', serif;
        font-size: 1rem;
        outline: none;
        transition: border-color 0.2s;
    }

    .static-decimals {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255,255,255,0.65);
        font-family: 'PT Serif', serif;
        font-size: 1rem;
        pointer-events: none;
    }

    .donate-input-group input::placeholder {
        color: rgba(255,255,255,0.65);
    }

    .donate-input-group input:focus {
        border-color: #fff;
    }

    /* --- SECTION BAWAH BANNER: jarak 15px --- */
    .donate-content-section {
        margin-top: 15px;
    }

    /* --- BAGIAN 1: KUTIPAN + FOTO (mirip referensi) --- */
    .quote-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: stretch;
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }

    .quote-left {
        padding: 50px 50px 50px 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .quote-text {
        font-family: 'PT Serif', serif;
        font-size: 1.7rem;
        font-weight: 400;
        line-height: 1.35;
        color: #111;
        margin: 0 0 20px 0;
    }

    .quote-author {
        font-family: Arial, sans-serif;
        font-size: 1.05rem;
        color: #c0392b;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .quote-right {
        position: relative;
        overflow: hidden;
        height: 420px;
        padding: 50px 0;
        background-color: #fff;
    }

    .quote-right img {
        position: absolute;
        top: 50px;
        left: 0;
        width: 100%;
        height: calc(100% - 100px);
        object-fit: cover;
        object-position: center top;
        display: block;
        filter: grayscale(20%);
        transition: filter 0.4s ease;
    }

    .quote-right:hover img {
        filter: grayscale(0%);
    }

    /* --- BAGIAN 2: HEADING + BODY TEXT --- */
    .body-row {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 0;
        padding: 60px 0;
        border-top: 4px solid #111;
    }

    .body-heading {
        font-family: 'PT Serif', serif;
        font-size: 1.35rem;
        font-weight: 400;
        color: #111;
        line-height: 1.4;
        padding-right: 50px;
        border-right: 1px solid #ddd;
    }

    .body-text-col {
        padding-left: 60px;
    }

    .body-text-col p {
        font-family: 'PT Serif', serif;
        font-size: 1rem;
        line-height: 1.5;
        color: #333;
        margin-bottom: 18px;
    }

    .body-text-col p:last-child {
        margin-bottom: 0;
    }

    /* --- RESPONSIVE: Tablet (max 1024px) --- */
    @media (max-width: 1024px) {
        .quote-left {
            padding: 50px 40px;
        }
        .quote-text {
            font-size: 1.5rem;
        }
        .body-row {
            padding: 50px 40px;
        }
        .body-text-col {
            padding-left: 40px;
        }
    }

    /* --- RESPONSIVE: Mobile landscape / small tablet (max 768px) --- */
    @media (max-width: 768px) {
        .quote-row {
            grid-template-columns: 1fr;
        }
        .quote-left {
            padding: 40px 25px;
            order: 2;
        }
        .quote-right {
            height: 280px;
            order: 1;
        }
        .quote-mark { font-size: 3rem; }
        .quote-text { font-size: 1.2rem; }

        .body-row {
            grid-template-columns: 1fr;
            padding: 40px 25px;
        }
        .body-heading {
            border-right: none;
            border-bottom: 1px solid #ddd;
            padding-right: 0;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .body-text-col {
            padding-left: 0;
        }

        .donate-word { font-size: 2rem; }
        .donate-image { height: 45px; }
        .donate-banner { padding: 35px 20px; }
        .donate-nominals { gap: 10px; }
        .btn-nominal { padding: 8px 14px; font-size: 0.85rem; }
    }

    /* --- RESPONSIVE: Mobile portrait (max 480px) --- */
    @media (max-width: 480px) {
        .donate-word { font-size: 1.6rem; }
        .donate-image { height: 35px; }
        .donate-title-wrapper { gap: 12px; }
        .donate-desc { font-size: 0.95rem; }
        .quote-right { height: 220px; }
        .quote-text { font-size: 1rem; }
        .body-heading { font-size: 1.15rem; }
        .body-text-col p { font-size: 0.9rem; }
        .donate-input-group { flex-direction: column; align-items: stretch; }
        .input-wrapper { min-width: unset; width: 100%; }
        #btn-pay-donation { width: 100%; }
    }
</style>
@endpush

@section('content')
<div id="donate-page">
<div class="donate-wrapper">

    {{-- ===== HERO SECTION ===== --}}
    <section class="donate-hero">
        <div class="donate-hero-header">
            <h1 class="donate-hero-title">Bersama wujudkan perubahan bermakna.</h1>
            <p class="donate-hero-desc">Galeri Buku Jakarta hadir untuk menginspirasi, memberdayakan, dan menghubungkan masyarakat agar dapat mengubah dunia di sekitar mereka. Setiap donasi—sekecil apapun—membantu kami terus menjalankan program literasi, beasiswa penulis muda, dan ruang ekspresi yang terbuka bagi semua.</p>
        </div>
        <div class="donate-cards">
            <div class="donate-card">
                <img class="donate-card-img" src="{{ asset('pustaka/programliterasi.jpeg') }}" alt="Program Literasi">
                <div class="donate-card-title">Program Literasi</div>
                <p class="donate-card-text">Mendukung program bacaan dan diskusi buku yang menjangkau komunitas di seluruh Jakarta dan sekitarnya.</p>
            </div>
            <div class="donate-card">
                <img class="donate-card-img" src="{{ asset('pustaka/penulismuda.jpeg') }}" alt="Beasiswa Penulis">
                <div class="donate-card-title">Dukungan Penulis Muda</div>
                <p class="donate-card-text">Memberikan kesempatan bagi penulis berbakat yang kurang memiliki akses untuk mengembangkan karya dan suara mereka.</p>
            </div>
            <div class="donate-card">
                <img class="donate-card-img" src="{{ asset('pustaka/ruangekspresi.jpeg') }}" alt="Ruang Ekspresi">
                <div class="donate-card-title">Ruang Ekspresi Terbuka</div>
                <p class="donate-card-text">Menyediakan ruang fisik dan digital bagi siapa pun untuk berbagi karya, ide, dan cerita demi memperkaya khazanah sastra Indonesia.</p>
            </div>
        </div>
    </section>

    </div>{{-- close wrapper before banner --}}

    {{-- ===== BANNER FULL WIDTH (outside wrapper) ===== --}}
    <div class="donate-banner">
        <div class="donate-title-wrapper">
            <span class="donate-word">DONATE</span>
            <img src="{{ asset('img/burung.png') }}" alt="Floral Art" class="donate-image">
            <span class="donate-word">TODAY</span>
        </div>
        <p class="donate-desc">We need your help to turn hope into action—to inspire, empower, and connect people to change their world.</p>

        <div style="margin-top: 30px;">
            <div class="donate-nominals">
                <button type="button" class="btn-nominal" data-amount="100000">100rb</button>
                <button type="button" class="btn-nominal" data-amount="500000">500rb</button>
                <button type="button" class="btn-nominal" data-amount="1000000">1 Jt</button>
                <button type="button" class="btn-nominal" data-amount="5000000">5 Jt</button>
                <button type="button" class="btn-nominal" data-amount="10000000">10 Jt</button>
                <button type="button" class="btn-nominal" data-amount="25000000">25 Jt</button>
            </div>
            <div class="donate-input-group">
                <div class="input-wrapper">
                    <input type="text" id="donation_amount" placeholder="Nominal Lain (Min: Rp 10.000)">
                    <span class="static-decimals">,00</span>
                </div>
                <button type="button" id="btn-pay-donation" class="btn-donate">Donate Now</button>
            </div>
        </div>
    </div>

    </div>{{-- /.donate-banner --}}

    <div class="donate-wrapper">{{-- reopen wrapper for content below --}}
    {{-- ===== KONTEN BAWAH (jarak 15px dari banner) ===== --}}
    <div class="donate-content-section">

        {{-- Baris 1: Kutipan (kiri) + Foto (kanan) --}}
        <div class="quote-row">
            <div class="quote-left">
                <p class="quote-text">"Ketika kita menutup hidup kita dari segala sesuatu, terkecuali makanan dan tempat bernaung, ada sebagian dari diri kita yang kelaparan sampai mati. Makanan untuk rasa kelaparan yang demikian itu adalah musik, lukisan, film, drama, sajak, cerita, dan novel."</p>
                <span class="quote-author">— Donald Hall</span>
            </div>
            <div class="quote-right">
                <img src="{{ asset('pustaka/donate.jpeg') }}" alt="Galeri Buku Jakarta">
            </div>
        </div>

        {{-- Baris 2: Heading bold (kiri) + Paragraf panjang (kanan) --}}
        <div class="body-row">
            <div class="body-heading">
                Membudayakan literasi untuk masa depan kota yang bermutu dan bermakna—memberi dampak dan harapan bagi generasi indonesia.
            </div>
            <div class="body-text-col">
                <p>Banyak orang secara teknis dapat membaca (dan barangkali juga menulis), tetapi secara fungsional dan secara budaya sebetulnya buta-huruf. Membaca dan menulis adalah sebuah fungsi yang harus dijalankan dalam pekerjaan. Kalua hal ini saja yang dilakukan, maka kelompok ini menderita satu kekurangan, yaitu membaca dan menulis sebagai kebiasaan untuk berkomunikasi dan berekspresi melalui tulisan. –Ignas Kleden</p>
                <p>Bersama para penulis dan kontributor Galeri Buku Jakarta yang dicintai pembacanya. Galeri Buku Jakarta selalu memiliki misi ganda: untuk mempromosikan penulis yang paling menarik dan untuk mendukung pembaca yang ambisius dan ingin tahu. Setiap minggu selama lebih dari 10 tahun, Kami telah mencurahkan waktu, pikiran, cinta, dan sumber daya yang luar biasa untuk kerja cinta ini; menghasilan narasi dan kisah mendalam juga bermakna dan memberi dampak. Di antara secangkir kopi dan makan siang yang enak. Dukungan Anda akan sangat berharga.</p>
            </div>
        </div>

    </div>

</div>{{-- /.donate-wrapper --}}
</div>{{-- /#donate-page --}}
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nominalButtons = document.querySelectorAll('.btn-nominal');
        const amountInput = document.getElementById('donation_amount');
        const payButton = document.getElementById('btn-pay-donation');

        function formatRupiah(angka) {
            var number_string = angka.replace(/[^0-9]/g, '').toString();
            if (!number_string) return '';
            
            var sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return 'Rp ' + rupiah;
        }

        amountInput.addEventListener('input', function(e) {
            this.value = formatRupiah(this.value);
        });

        nominalButtons.forEach(button => {
            button.addEventListener('click', function() {
                nominalButtons.forEach(btn => {
                    btn.style.background = 'transparent';
                    btn.style.color = '#fff';
                    btn.style.borderColor = 'rgba(255,255,255,0.6)';
                });
                this.style.background = '#fff';
                this.style.color = '#c0392b';
                this.style.borderColor = '#fff';
                amountInput.value = formatRupiah(this.getAttribute('data-amount'));
            });
        });

        let isProcessing = false;

        payButton.addEventListener('click', async function () {
            if (isProcessing) return;
            
            const rawAmount = amountInput.value.replace(/[^0-9]/g, '');
            if (!rawAmount || parseInt(rawAmount) < 10000) {
                alert('Silakan masukkan atau pilih nominal donasi yang valid (minimal Rp 10.000).');
                return;
            }

            isProcessing = true;
            payButton.innerText = 'Processing...';
            payButton.disabled = true;

            try {
                const response = await fetch('{{ route("donate.snap_token") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ amount: parseInt(rawAmount) })
                });

                const data = await response.json();

                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function () {
                            alert('Terima kasih! Donasi Anda telah berhasil. Kami sangat menghargai kepedulian Anda.');
                            window.location.reload();
                        },
                        onPending: function () {
                            alert('Menunggu konfirmasi pembayaran Anda...');
                        },
                        onError: function () {
                            alert('Pembayaran gagal. Silakan coba lagi.');
                        },
                        onClose: function () {
                            payButton.innerText = 'Donate Now';
                            payButton.disabled = false;
                            isProcessing = false;
                        }
                    });
                } else {
                    alert('Gagal memproses pembayaran: ' + (data.error || 'Unknown error'));
                    payButton.innerText = 'Donate Now';
                    payButton.disabled = false;
                    isProcessing = false;
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan sistem: ' + error.message);
                payButton.innerText = 'Donate Now';
                payButton.disabled = false;
                isProcessing = false;
            }
        });
    });
</script>
@endpush
