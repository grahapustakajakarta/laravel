<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Langganan Berhasil — Galeri Buku Jakarta</title>
    <link rel="shortcut icon" href="{{ asset('img/LOGO.jpeg') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,700&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Source Sans 3', Arial, sans-serif;
            background: #fff;
            height: 100vh;
            overflow: hidden;
        }

        /* Layout identik dengan signin/subscribe */
        .success-page {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* Panel kiri — foto sama */
        .success-photo {
            flex: 0 0 44%;
            position: relative;
            overflow: hidden;
        }
        .success-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            display: block;
        }
        .success-photo::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.18) 100%);
            pointer-events: none;
        }

        /* Panel kanan */
        .success-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 60px;
            background: #fff;
            position: relative;
            overflow-y: auto;
        }
        .success-inner {
            width: 100%;
            max-width: 370px;
            text-align: center;
        }

        /* Brand */
        .success-brand {
            margin-bottom: 36px;
        }
        .success-brand-name {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.05rem;
            font-weight: 900;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            color: #111;
        }

        /* Icon cek */
        .success-icon {
            width: 52px;
            height: 52px;
            border: 1.5px solid #111;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 1.2rem;
            color: #111;
        }
        .success-icon.pending {
            border-color: #888;
            color: #888;
        }

        /* Judul */
        .success-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 2.05rem;
            font-weight: 700;
            color: #111;
            line-height: 1.15;
            margin-bottom: 14px;
            letter-spacing: -0.3px;
        }
        .success-desc {
            font-size: 0.815rem;
            color: #555;
            line-height: 1.6;
            margin-bottom: 8px;
        }
        .success-order {
            font-size: 0.75rem;
            color: #aaa;
            margin-bottom: 28px;
            font-style: italic;
        }

        /* Divider */
        .success-divider {
            height: 1px;
            background: #eee;
            margin: 24px 0;
        }

        /* Tombol utama */
        .btn-main {
            display: block;
            width: 100%;
            padding: 14px;
            background: #111;
            color: #fff;
            font-family: 'Source Sans 3', Arial, sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2.5px;
            border: none;
            cursor: pointer;
            transition: background 0.18s;
            text-align: center;
            text-decoration: none;
            margin-bottom: 14px;
        }
        .btn-main:hover { background: #333; }

        .success-footer {
            font-size: 0.78rem;
            color: #aaa;
            line-height: 1.6;
        }
        .success-footer a {
            color: #555;
            text-decoration: underline;
            text-underline-offset: 2px;
        }
        .success-footer a:hover { color: #111; }

        @media (max-width: 768px) {
            .success-photo { display: none; }
            .success-panel { padding: 40px 28px; }
        }
    </style>
</head>
<body>
<div class="success-page">

    {{-- Panel Kiri: Foto Editorial --}}
    <div class="success-photo">
        <img src="{{ asset('img/signin_editorial.png') }}" alt="Galeri Buku Jakarta">
    </div>

    {{-- Panel Kanan: Pesan Sukses --}}
    <div class="success-panel">
        <div class="success-inner">

            {{-- Brand --}}
            <div class="success-brand">
                <span class="success-brand-name">Galeri Buku Jakarta</span>
            </div>

            {{-- Icon --}}
            @if(request()->query('status') === 'pending')
                <div class="success-icon pending">
                    <i class="fas fa-clock"></i>
                </div>
                <h1 class="success-title">Pembayaran diproses</h1>
                <p class="success-desc">
                    Kami sedang memverifikasi pembayaran Anda. Akses premium akan aktif segera setelah konfirmasi diterima.
                </p>
            @else
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h1 class="success-title">Anda kini Premium.</h1>
                <p class="success-desc">
                    Langganan berhasil diaktifkan. Nikmati akses penuh ke seluruh konten eksklusif Galeri Buku Jakarta.
                </p>
            @endif

            @if($orderId)
                <p class="success-order">Order ID: {{ $orderId }}</p>
            @endif

            <div class="success-divider"></div>

            <a href="{{ route('home') }}" class="btn-main">Mulai Membaca →</a>

            <p class="success-footer">
                Butuh bantuan?
                <a href="mailto:hello@galeribukujakarta.com">Hubungi kami</a>
            </p>

        </div>
    </div>

</div>
</body>
</html>
