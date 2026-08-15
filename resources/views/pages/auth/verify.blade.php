<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email — Galeri Buku Jakarta</title>
    <link rel="shortcut icon" href="{{ asset('img/LOGO.jpeg') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Source Sans 3', Arial, sans-serif;
            background: #fff;
            height: 100vh;
            overflow: hidden;
        }

        /* Split layout — identik signin */
        .verify-page {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        .verify-photo {
            flex: 0 0 44%;
            position: relative;
            overflow: hidden;
        }
        .verify-photo img {
            width: 100%; height: 100%;
            object-fit: cover; object-position: center top;
            display: block;
        }
        .verify-photo::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.18) 100%);
            pointer-events: none;
        }

        .verify-panel {
            flex: 1;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 40px 60px;
            background: #fff;
            position: relative;
            overflow-y: auto;
        }
        .verify-inner {
            width: 100%;
            max-width: 370px;
            text-align: center;
        }

        /* Brand */
        .verify-brand {
            margin-bottom: 32px;
        }
        .verify-brand-name {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.05rem; font-weight: 900;
            letter-spacing: 3.5px; text-transform: uppercase;
            color: #111;
        }

        /* Icon envelope */
        .verify-icon {
            width: 56px; height: 56px;
            border: 1.5px solid #111; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 22px;
            font-size: 1.3rem; color: #111;
        }

        /* Judul */
        .verify-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 2rem; font-weight: 700;
            color: #111; line-height: 1.15;
            margin-bottom: 12px; letter-spacing: -0.3px;
        }
        .verify-desc {
            font-size: 0.815rem; color: #555;
            line-height: 1.6; margin-bottom: 28px;
        }
        .verify-desc strong { color: #111; }

        /* Alert messages */
        .verify-alert {
            padding: 10px 14px; margin-bottom: 18px;
            font-size: 0.83rem; border: 1px solid; text-align: left;
        }
        .verify-alert-success { border-color: #b5dfb5; background: #f0f9f0; color: #2a7a2a; }
        .verify-alert-error   { border-color: #f5c6cb; background: #fff5f5; color: #c00; }

        /* Tombol identik signin */
        .btn-main {
            display: block; width: 100%; padding: 14px;
            background: #111; color: #fff;
            font-family: 'Source Sans 3', Arial, sans-serif;
            font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 2.5px;
            border: none; cursor: pointer;
            transition: background 0.18s; text-align: center;
            margin-bottom: 14px; text-decoration: none;
        }
        .btn-main:hover { background: #333; }
        .btn-main:disabled { background: #bbb; cursor: not-allowed; }

        /* Tombol outline */
        .btn-outline {
            display: block; width: 100%; padding: 13px;
            background: #fff; color: #111;
            font-family: 'Source Sans 3', Arial, sans-serif;
            font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 2.5px;
            border: 1.5px solid #bbb; cursor: pointer;
            transition: border-color 0.18s; text-align: center;
            margin-bottom: 14px;
        }
        .btn-outline:hover { border-color: #111; }

        /* Divider */
        .verify-divider {
            height: 1px; background: #ebebeb; margin: 20px 0;
        }

        /* Footer links */
        .verify-footer {
            font-size: 0.8rem; color: #aaa;
        }
        .verify-footer a {
            color: #555; text-decoration: underline; text-underline-offset: 2px;
        }
        .verify-footer a:hover { color: #111; }

        /* Countdown */
        .resend-countdown {
            font-size: 0.78rem; color: #bbb; margin-top: 6px;
        }

        @media (max-width: 768px) {
            .verify-photo { display: none; }
            .verify-panel { padding: 40px 28px; }
        }
    </style>
</head>
<body>
<div class="verify-page">

    {{-- Panel Kiri --}}
    <div class="verify-photo">
        <img src="{{ asset('img/signin_editorial.png') }}" alt="Galeri Buku Jakarta">
    </div>

    {{-- Panel Kanan --}}
    <div class="verify-panel">
        <div class="verify-inner">

            <div class="verify-brand">
                <span class="verify-brand-name">Galeri Buku Jakarta</span>
            </div>

            <div class="verify-icon">
                <i class="fas fa-envelope"></i>
            </div>

            <h1 class="verify-title">Cek email Anda</h1>

            @php $user = Auth::guard('pengguna')->user(); @endphp

            <p class="verify-desc">
                Kami telah mengirim link verifikasi ke<br>
                <strong>{{ $user ? $user->email : 'email Anda' }}</strong>.<br>
                Klik link di email untuk mengaktifkan akun.
            </p>

            {{-- Alerts --}}
            @if(session('success'))
                <div class="verify-alert verify-alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if($errors->has('verify'))
                <div class="verify-alert verify-alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first('verify') }}
                </div>
            @endif

            {{-- Tombol Kirim Ulang --}}
            <form action="{{ route('user.verification.resend') }}" method="POST" id="resend-form">
                @csrf
                <button type="submit" class="btn-main" id="btn-resend">
                    Kirim Ulang Email Verifikasi
                </button>
                <div class="resend-countdown" id="countdown" style="display:none;"></div>
            </form>

            <div class="verify-divider"></div>

            {{-- Tips --}}
            <p style="font-size:0.78rem;color:#888;margin-bottom:18px;line-height:1.6;">
                Tidak menerima email? Cek folder <strong>Spam</strong> atau <strong>Promotions</strong>. Link berlaku selama 60 menit.
            </p>

            <p class="verify-footer">
                <a href="{{ route('home') }}">← Kembali ke Beranda</a>
                &nbsp;·&nbsp;
                <form action="{{ route('user.signout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none;border:none;cursor:pointer;font-size:0.8rem;color:#aaa;text-decoration:underline;text-underline-offset:2px;font-family:inherit;">Keluar</button>
                </form>
            </p>

        </div>
    </div>
</div>

<script>
    // Countdown setelah klik kirim ulang
    var btn = document.getElementById('btn-resend');
    var cdEl = document.getElementById('countdown');
    var cdInterval;

    document.getElementById('resend-form').addEventListener('submit', function() {
        btn.disabled = true;
        var secs = 60;
        cdEl.style.display = 'block';
        cdEl.textContent   = 'Dapat dikirim ulang dalam ' + secs + ' detik';
        cdInterval = setInterval(function() {
            secs--;
            if (secs <= 0) {
                clearInterval(cdInterval);
                btn.disabled     = false;
                cdEl.style.display = 'none';
            } else {
                cdEl.textContent = 'Dapat dikirim ulang dalam ' + secs + ' detik';
            }
        }, 1000);
    });
</script>
</body>
</html>
