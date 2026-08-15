<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Galeri Buku Jakarta</title>
    <link rel="shortcut icon" href="{{ asset('img/LOGO.jpeg') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,700&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Source Sans 3', Arial, sans-serif;
            background: #fff;
            overflow: hidden;
            height: 100vh;
        }

        /* ===== LAYOUT SPLIT ===== */
        .signin-page {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* ——— Panel Kiri: Foto Editorial ——— */
        .signin-photo {
            flex: 0 0 44%;
            position: relative;
            overflow: hidden;
        }
        .signin-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            display: block;
        }
        /* Gradient overlay bawah yang subtle */
        .signin-photo::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.18) 100%);
            pointer-events: none;
        }

        /* ——— Panel Kanan: Form ——— */
        .signin-form-panel {
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

        /* Konten form: max-width seperti Vanity Fair */
        .signin-form-inner {
            width: 100%;
            max-width: 370px;
        }

        /* Logo / Brand */
        .signin-brand {
            text-align: center;
            margin-bottom: 28px;
        }
        .signin-brand-name {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.05rem;
            font-weight: 900;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            color: #111;
            display: inline-block;
        }

        /* Judul utama */
        .signin-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 2.05rem;
            font-weight: 700;
            color: #111;
            line-height: 1.15;
            margin-bottom: 14px;
            letter-spacing: -0.3px;
        }

        /* Teks disclaimer / syarat */
        .signin-disclaimer {
            font-size: 0.815rem;
            color: #555;
            line-height: 1.55;
            margin-bottom: 26px;
        }
        .signin-disclaimer a {
            color: #111;
            text-underline-offset: 2px;
        }

        /* Label field */
        .signin-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.8px;
            color: #111;
            margin-bottom: 8px;
        }

        /* Input email */
        .signin-input {
            width: 100%;
            padding: 13px 14px;
            font-size: 1rem;
            font-family: 'Source Sans 3', Arial, sans-serif;
            color: #111;
            background: #fff;
            border: 1.5px solid #bbb;
            border-radius: 0;
            outline: none;
            transition: border-color 0.2s;
            margin-bottom: 12px;
        }
        .signin-input:focus { border-color: #111; }
        .signin-input.is-invalid { border-color: #c00; }

        /* Error */
        .signin-error {
            font-size: 0.8rem;
            color: #c00;
            margin-bottom: 10px;
        }

        /* Password field (hidden awal) */
        .signin-pass-group {
            display: none;
        }
        .signin-pass-group.visible { display: block; }

        /* Tombol utama hitam */
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
            margin-bottom: 18px;
        }
        .btn-main:hover { background: #333; }

        /* Divider "or" */
        .signin-or {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }
        .signin-or::before, .signin-or::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #ddd;
        }
        .signin-or span {
            font-size: 0.8rem;
            color: #888;
        }

        /* Social buttons */
        .signin-socials {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 28px;
        }
        .btn-social {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 13px 6px 11px;
            background: #fff;
            border: 1.5px solid #ddd;
            cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s;
            text-decoration: none;
            color: #111;
        }
        .btn-social:hover {
            border-color: #aaa;
            box-shadow: 0 1px 6px rgba(0,0,0,0.08);
        }
        .btn-social-label {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #111;
        }
        .btn-social svg { width: 22px; height: 22px; }

        /* Footer link */
        .signin-footer-link {
            text-align: center;
        }
        .signin-footer-link a {
            font-size: 0.8rem;
            color: #555;
            text-decoration: underline;
            text-underline-offset: 2px;
        }
        .signin-footer-link a:hover { color: #111; }

        /* Alert sukses & error */
        .signin-alert-success {
            background: #f0f9f0;
            border: 1px solid #b5dfb5;
            border-radius: 2px;
            padding: 10px 14px;
            margin-bottom: 16px;
            font-size: 0.85rem;
            color: #2a7a2a;
        }
        .signin-alert-error {
            background: #fdf2f2;
            border: 1px solid #fbc4c4;
            border-radius: 2px;
            padding: 10px 14px;
            margin-bottom: 16px;
            font-size: 0.85rem;
            color: #c00;
        }

        /* Back to home link top-left */
        .signin-back {
            position: absolute;
            top: 20px;
            left: 24px;
            font-size: 0.78rem;
            color: #888;
            text-decoration: none;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: color 0.2s;
        }
        .signin-back:hover { color: #111; }

        /* Responsive: pada layar kecil sembunyikan foto */
        @media (max-width: 768px) {
            .signin-photo { display: none; }
            .signin-form-panel { padding: 40px 28px; }
        }
    </style>
</head>
<body>
<div class="signin-page">

    {{-- ===== PANEL KIRI: FOTO EDITORIAL ===== --}}
    <div class="signin-photo">
        <img src="{{ asset('img/signin_editorial.png') }}" alt="Galeri Buku Jakarta">
    </div>

    {{-- ===== PANEL KANAN: FORM ===== --}}
    <div class="signin-form-panel">
        {{-- Link kembali --}}
        <a href="{{ route('home') }}" class="signin-back">← Beranda</a>

        <div class="signin-form-inner">

            {{-- Brand Logo --}}
            <div class="signin-brand">
                <span class="signin-brand-name">Galeri Buku Jakarta</span>
            </div>

            {{-- Judul --}}
            <h1 class="signin-title">Sign in or create an account</h1>

            {{-- Disclaimer --}}
            <p class="signin-disclaimer">
                Dengan melanjutkan, Anda menyetujui <a href="#">Perjanjian Pengguna</a> (termasuk <a href="#">ketentuan arbitrase</a>) dan mengakui <a href="{{ url('/page/disclaimer') }}">Kebijakan Privasi</a> kami.
            </p>

            @if (session('success'))
                <div class="signin-alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="signin-alert-error">{{ session('error') }}</div>
            @endif

            {{-- FORM --}}
            <form id="signin-form" action="{{ route('user.signin.post') }}" method="POST">
                @csrf

                {{-- Langkah 1: Email --}}
                <div id="step-email">
                    <label class="signin-label" for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="signin-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        value="{{ old('email') }}"
                        placeholder=""
                        autocomplete="email"
                    >
                    @if($errors->has('email'))
                        <div class="signin-error">{{ $errors->first('email') }}</div>
                    @endif

                    {{-- Langkah 2: Password (muncul setelah klik Continue) --}}
                    <div class="signin-pass-group {{ $errors->has('password') || old('email') ? 'visible' : '' }}" id="pass-group">
                        <label class="signin-label" for="password" style="margin-top:12px;">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="signin-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder=""
                            autocomplete="current-password"
                        >
                        @if($errors->has('password'))
                            <div class="signin-error">{{ $errors->first('password') }}</div>
                        @endif
                    </div>

                    <button type="button" id="btn-continue" class="btn-main">Continue with Email</button>
                </div>

                {{-- Tombol submit (tersembunyi, dipanggil via JS) --}}
                <button type="submit" id="btn-submit" style="display:none;"></button>
            </form>

            {{-- Divider --}}
            <div class="signin-or"><span>or</span></div>

            {{-- Social Buttons (UI only) --}}
            <div class="signin-socials">
                {{-- Google --}}
                <a href="{{ route('socialite.redirect', 'google') }}" class="btn-social" title="Login dengan Google">
                    <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                    </svg>
                    <span class="btn-social-label">Google</span>
                </a>

                {{-- X (Twitter) --}}
                <a href="{{ route('socialite.redirect', 'twitter') }}" class="btn-social" title="Login dengan X">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#111">
                        <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/>
                    </svg>
                    <span class="btn-social-label">X</span>
                </a>

            </div>

            {{-- Footer --}}
            <div class="signin-footer-link">
                Belum punya akun? <a href="{{ route('user.signup') }}">Daftar Gratis di sini</a>
                <br><br>
                <a href="{{ route('subscribe') }}">Subscribe untuk akses premium</a>
            </div>

        </div>
    </div>
</div>

<script>
    const btnContinue = document.getElementById('btn-continue');
    const passGroup   = document.getElementById('pass-group');
    const emailInput  = document.getElementById('email');
    const btnSubmit   = document.getElementById('btn-submit');
    let   emailStep   = true;

    // Jika sudah ada error password dari server, langsung tampilkan step password
    @if(old('email') || $errors->has('password'))
        emailStep = false;
        passGroup.classList.add('visible');
        btnContinue.textContent = 'Sign In';
    @endif

    btnContinue.addEventListener('click', function () {
        if (emailStep) {
            // Validasi email
            const email = emailInput.value.trim();
            if (!email || !email.includes('@')) {
                emailInput.classList.add('is-invalid');
                return;
            }
            emailInput.classList.remove('is-invalid');
            // Tampilkan field password
            passGroup.classList.add('visible');
            document.getElementById('password').focus();
            btnContinue.textContent = 'Sign In';
            emailStep = false;
        } else {
            // Submit form
            btnSubmit.click();
        }
    });

    // Enter key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            btnContinue.click();
        }
    });
</script>
</body>
</html>
