<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe — Galeri Buku Jakarta</title>
    <link rel="shortcut icon" href="{{ asset('img/LOGO.jpeg') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,700&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }
        body {
            font-family: 'Source Sans 3', Arial, sans-serif;
            background: #fff;
            min-height: 100vh;
        }

        /* ============================================================
           BANNER ATAS — foto full-width, tinggi 25vh
        ============================================================ */
        .sub-banner {
            position: relative;
            width: 100%;
            height: 47vh;
            min-height: 160px;
            overflow: hidden;
        }
        .sub-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 30%;
            display: block;
        }
        .sub-banner-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.2) 60%, rgba(0,0,0,0.05) 100%);
        }
        .sub-banner-content {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            padding: 0 60px;
        }
        .sub-banner-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 3.5px;
            color: rgba(255,255,255,0.65);
            font-weight: 700;
            margin-bottom: 8px;
        }
        .sub-banner-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(1.4rem, 3vw, 2rem);
            font-weight: 700;
            color: #fff;
            line-height: 1.18;
            letter-spacing: -0.3px;
        }
        .sub-back {
            position: absolute;
            top: 14px; right: 22px;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            transition: color 0.2s;
            z-index: 2;
        }
        .sub-back:hover { color: #fff; }

        /* ============================================================
           BODY — konten bawah
        ============================================================ */
        .sub-body {
            display: flex;
            justify-content: center;
            padding: 44px 24px 64px;
            background: #fff;
        }
        .sub-body-inner {
            width: 100%;
            max-width: 420px;
        }

        /* Brand */
        .sub-brand {
            text-align: center;
            margin-bottom: 20px;
        }
        .sub-brand-name {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.05rem;
            font-weight: 900;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            color: #111;
        }

        /* Judul */
        .sub-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 2rem;
            font-weight: 700;
            color: #111;
            line-height: 1.15;
            margin-bottom: 8px;
            letter-spacing: -0.3px;
            text-align: center;
        }
        .sub-subtitle {
            font-size: 0.815rem;
            color: #666;
            line-height: 1.55;
            margin-bottom: 24px;
            text-align: center;
        }

        /* ===== PAKET ===== */
        .sub-paket-wrap {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }
        .sub-paket-option { cursor: pointer; }
        .sub-paket-option input[type="radio"] { display: none; }
        .sub-paket-box {
            display: flex;
            flex-direction: column;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 12px;
            text-align: left;
            cursor: pointer;
            transition: all 0.2s ease;
            height: 100%;
            background: #fff;
        }
        .sub-paket-option input:checked + .sub-paket-box { 
            border-color: #d11f1f; 
        }
        .sub-paket-box:hover { border-color: #999; }
        .sub-paket-option input:checked + .sub-paket-box:hover { border-color: #d11f1f; }
        
        /* Custom Radio Button inside box */
        .pk-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }
        .pk-radio-circle {
            width: 20px;
            height: 20px;
            border: 2px solid #666;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }
        .pk-radio-circle::after {
            content: '';
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #d11f1f;
            transform: scale(0);
            transition: transform 0.2s ease;
        }
        .sub-paket-option input:checked + .sub-paket-box .pk-radio-circle {
            border-color: #d11f1f;
        }
        .sub-paket-option input:checked + .sub-paket-box .pk-radio-circle::after {
            transform: scale(1);
        }

        .pk-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: #111;
            margin: 0;
        }
        
        .pk-subtitle {
            font-family: 'Source Sans 3', Arial, sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 15px;
        }

        .pk-desc {
            font-size: 0.8rem;
            color: #555;
            line-height: 1.5;
            font-style: italic;
            margin-top: auto;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sub-paket-wrap {
                grid-template-columns: 1fr;
            }
        }
        /* ===== LABEL & INPUT — identik signin ===== */
        .sub-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.8px;
            color: #111;
            margin-bottom: 8px;
        }
        .sub-input {
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
            margin-bottom: 14px;
        }
        .sub-input:focus { border-color: #111; }
        .sub-input.is-invalid { border-color: #c00; }
        .sub-err {
            font-size: 0.78rem;
            color: #c00;
            margin-top: -10px;
            margin-bottom: 10px;
            display: none;
        }

        /* Password wrapper dengan show/hide toggle */
        .pass-wrap { position: relative; margin-bottom: 14px; }
        .pass-wrap .sub-input { margin-bottom: 0; padding-right: 44px; }
        .pass-toggle {
            position: absolute;
            right: 14px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #bbb; font-size: 0.85rem;
            transition: color 0.18s;
        }
        .pass-toggle:hover { color: #555; }

        /* Strength meter */
        .strength-meter {
            display: flex; gap: 4px; margin-bottom: 12px;
        }
        .strength-bar {
            flex: 1; height: 3px;
            background: #eee;
            transition: background 0.2s;
        }
        .strength-bar.weak   { background: #e03a3c; }
        .strength-bar.medium { background: #f59e0b; }
        .strength-bar.strong { background: #2a7a2a; }

        /* Tombol identik signin */
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
            margin-bottom: 12px;
        }
        .btn-main:hover { background: #333; }
        .btn-main:disabled { background: #bbb; cursor: not-allowed; }

        /* Secure note */
        .sub-secure {
            display: flex; align-items: center; justify-content: center;
            gap: 6px; font-size: 0.72rem; color: #bbb; margin-bottom: 20px;
        }

        /* Divider */
        .sub-divider {
            display: flex; align-items: center; gap: 14px; margin-bottom: 14px;
        }
        .sub-divider::before, .sub-divider::after {
            content: ''; flex: 1; height: 1px; background: #ebebeb;
        }
        .sub-divider span { font-size: 0.75rem; color: #bbb; }

        /* Perks */
        .sub-perks { display: flex; flex-direction: column; gap: 5px; margin-bottom: 22px; }
        .sub-perk {
            font-size: 0.78rem; color: #888;
            display: flex; align-items: center; gap: 9px;
        }
        .sub-perk::before {
            content: ''; width: 14px; height: 1px; background: #ccc; flex-shrink: 0;
        }

        /* Footer */
        .sub-footer-link { text-align: center; }
        .sub-footer-link a {
            font-size: 0.8rem; color: #777;
            text-decoration: underline; text-underline-offset: 2px;
        }
        .sub-footer-link a:hover { color: #111; }

        /* Alert */
        .sub-alert {
            padding: 10px 14px; margin-bottom: 16px;
            font-size: 0.83rem; border: 1px solid;
        }
        .sub-alert-success { border-color: #b5dfb5; background: #f0f9f0; color: #2a7a2a; }

        @media (max-width: 768px) {
            .sub-banner-content { padding: 0 24px; }
            .sub-body { padding: 36px 20px 48px; }
            .sub-body-inner { max-width: 100%; } /* Lebar penuh di mobile */
        }
        @media (min-width: 769px) {
            .sub-body-inner { max-width: 900px; } /* Lebarkan penampung untuk 3 kolom */
        }
    </style>
</head>
<body>

    {{-- ===== BANNER ATAS ===== --}}
    <div class="sub-banner">
        <img src="{{ asset('img/signin_editorial.png') }}" alt="Galeri Buku Jakarta">
        <div class="sub-banner-overlay"></div>
        <div class="sub-banner-content">
            <div>
                <p class="sub-banner-label">Galeri Buku Jakarta Premium</p>
                <h2 class="sub-banner-title">Baca tanpa batas,<br>tanpa kompromi.</h2>
            </div>
        </div>
        <a href="{{ route('home') }}" class="sub-back">← Beranda</a>
    </div>

    {{-- ===== KONTEN BAWAH ===== --}}
    <div class="sub-body">
        <div class="sub-body-inner">

            <div class="sub-brand">
                <span class="sub-brand-name">Galeri Buku Jakarta</span>
            </div>

            <h1 class="sub-title">Pilih Paket Anda</h1>
            <p class="sub-subtitle">
                Buat akun & bayar sekarang. Verifikasi email dikirim otomatis.
            </p>

            @if(session('success'))
                <div class="sub-alert sub-alert-success">{{ session('success') }}</div>
            @endif

            {{-- Pilih Paket --}}
            <div class="sub-paket-wrap">
                <label class="sub-paket-option">
                    <input type="radio" name="paket" value="bulanan" {{ request('plan') == 'bulanan' || !request()->has('plan') ? 'checked' : '' }}>
                    <span class="sub-paket-box">
                        <div class="pk-header">
                            <span class="pk-radio-circle"></span>
                            <h3 class="pk-title">Digital Bulanan</h3>
                        </div>
                        <div class="pk-subtitle">Rp 37.500 / bulan</div>
                        <div class="pk-desc">
                            Diperpanjang otomatis seharga Rp 37.500/bulan. Batalkan kapan saja.
                        </div>
                    </span>
                </label>
                
                <label class="sub-paket-option">
                    <input type="radio" name="paket" value="paket4bulan" {{ request('plan') == 'paket4bulan' ? 'checked' : '' }}>
                    <span class="sub-paket-box">
                        <div class="pk-header">
                            <span class="pk-radio-circle"></span>
                            <h3 class="pk-title">Digital 4 Bulan</h3>
                        </div>
                        <div class="pk-subtitle">Rp 37.500 / bulan - Bulan pertama GRATIS</div>
                        <div class="pk-desc">
                            Setelah masa percobaan gratis 30 hari, penawaran awal ini ditagih sebesar Rp 112.500 untuk 4 bulan pertama. Diperpanjang otomatis seharga Rp 150.000 (untuk 4 bulan berikutnya).
                        </div>
                    </span>
                </label>
                
                <label class="sub-paket-option">
                    <input type="radio" name="paket" value="paket6bulan" {{ request('plan') == 'paket6bulan' ? 'checked' : '' }}>
                    <span class="sub-paket-box">
                        <div class="pk-header">
                            <span class="pk-radio-circle"></span>
                            <h3 class="pk-title">Digital 6 Bulan</h3>
                        </div>
                        <div class="pk-subtitle">Rp 25.000 / bulan - Bulan pertama GRATIS</div>
                        <div class="pk-desc">
                            Setelah masa percobaan gratis 30 hari, penawaran awal ini ditagih sebesar Rp 125.000 untuk 6 bulan pertama. Diperpanjang otomatis seharga Rp 150.000 (untuk 6 bulan berikutnya).
                        </div>
                    </span>
                </label>
            </div>

            @guest('pengguna')
                {{-- Nama --}}
                <label class="sub-label" for="sub-nama">Nama Lengkap</label>
                <input type="text" id="sub-nama" class="sub-input" autocomplete="name" placeholder="">
                <div class="sub-err" id="err-nama">Nama harus diisi.</div>

                {{-- Email --}}
                <label class="sub-label" for="sub-email">Alamat Email</label>
                <input type="email" id="sub-email" class="sub-input" autocomplete="email" placeholder="">
                <div class="sub-err" id="err-email">Masukkan email yang valid.</div>

                {{-- Password --}}
                <label class="sub-label" for="sub-pass">Password</label>
                <div class="pass-wrap">
                    <input type="password" id="sub-pass" class="sub-input" autocomplete="new-password" placeholder="Minimal 6 karakter" oninput="checkStrength(this.value)">
                    <button type="button" class="pass-toggle" onclick="togglePass('sub-pass', this)" tabindex="-1">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="strength-meter" id="strength-meter">
                    <div class="strength-bar" id="sb1"></div>
                    <div class="strength-bar" id="sb2"></div>
                    <div class="strength-bar" id="sb3"></div>
                </div>
                <div class="sub-err" id="err-pass">Password minimal 6 karakter.</div>

                {{-- Konfirmasi Password --}}
                <label class="sub-label" for="sub-pass-confirm">Konfirmasi Password</label>
                <div class="pass-wrap">
                    <input type="password" id="sub-pass-confirm" class="sub-input" autocomplete="new-password" placeholder="">
                    <button type="button" class="pass-toggle" onclick="togglePass('sub-pass-confirm', this)" tabindex="-1">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="sub-err" id="err-confirm">Password tidak cocok.</div>
            @else
                <div style="background: #f9f9f9; padding: 16px; border: 1px solid #eee; margin-bottom: 24px;">
                    <p style="font-family: var(--font-sans); font-size: 0.85rem; color: #555; margin-bottom: 6px;">Melanjutkan sebagai:</p>
                    <h3 style="font-family: var(--font-serif); font-size: 1.1rem; color: #111; margin-bottom: 2px;">{{ Auth::guard('pengguna')->user()->nama }}</h3>
                    <p style="font-family: var(--font-sans); font-size: 0.8rem; color: #888;">{{ Auth::guard('pengguna')->user()->email }}</p>
                </div>
            @endguest

            {{-- Tombol Bayar --}}
            <button type="button" id="btn-pay" class="btn-main" onclick="startPayment()">
                Lanjut ke Pembayaran
            </button>

            <p class="sub-secure">
                <i class="fas fa-lock" style="font-size:0.63rem;"></i>
                Transaksi dienkripsi dengan SSL 256-bit
            </p>

            {{-- Divider --}}
            <div class="sub-divider"><span>included</span></div>

            <div class="sub-footer-link">
                <a href="{{ route('user.signin') }}">Sudah punya akun? Sign in</a>
            </div>

        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        // Show/hide password
        function togglePass(id, btn) {
            var inp = document.getElementById(id);
            if (inp.type === 'password') {
                inp.type = 'text';
                btn.querySelector('i').className = 'fas fa-eye-slash';
            } else {
                inp.type = 'password';
                btn.querySelector('i').className = 'fas fa-eye';
            }
        }

        // Password strength meter
        function checkStrength(val) {
            var bars = [document.getElementById('sb1'), document.getElementById('sb2'), document.getElementById('sb3')];
            bars.forEach(b => { b.className = 'strength-bar'; });
            if (val.length < 1) return;
            var score = 0;
            if (val.length >= 6) score++;
            if (val.length >= 10) score++;
            if (/[A-Z]/.test(val) && /[0-9]/.test(val)) score++;
            var cls = score === 1 ? 'weak' : score === 2 ? 'medium' : 'strong';
            for (var i = 0; i < score; i++) bars[i].classList.add(cls);
        }

        async function startPayment() {
            var isAuth = {{ Auth::guard('pengguna')->check() ? 'true' : 'false' }};
            var nama = '', email = '', pass = '', confirm = '';

            if (!isAuth) {
                nama    = document.getElementById('sub-nama').value.trim();
                email   = document.getElementById('sub-email').value.trim();
                pass    = document.getElementById('sub-pass').value;
                confirm = document.getElementById('sub-pass-confirm').value;
            }

            var paket   = document.querySelector('input[name="paket"]:checked').value;
            var valid   = true;

            function setErr(inputId, errId, msg, show) {
                document.getElementById(inputId).classList.toggle('is-invalid', show);
                var errEl = document.getElementById(errId);
                errEl.textContent = msg;
                errEl.style.display = show ? 'block' : 'none';
                if (show) valid = false;
            }

            if (!isAuth) {
                setErr('sub-nama',         'err-nama',    'Nama harus diisi.',            !nama);
                setErr('sub-email',        'err-email',   'Masukkan email yang valid.',   !email || !email.includes('@'));
                setErr('sub-pass',         'err-pass',    'Password minimal 6 karakter.', pass.length < 6);
                setErr('sub-pass-confirm', 'err-confirm', 'Password tidak cocok.',        pass !== confirm);
            }

            if (!valid) return;

            var btn = document.getElementById('btn-pay');
            btn.disabled    = true;
            btn.textContent = 'Memproses...';

            try {
                var res = await fetch('{{ route("subscribe.snap_token") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type':  'application/json',
                        'X-CSRF-TOKEN':  '{{ csrf_token() }}',
                        'Accept':        'application/json',
                    },
                    body: JSON.stringify({
                        nama:                  isAuth ? null : nama,
                        email:                 isAuth ? null : email,
                        password:              isAuth ? null : pass,
                        password_confirmation: isAuth ? null : confirm,
                        paket:                 paket,
                    }),
                });

                var data = await res.json();

                if (data.error) {
                    alert('Terjadi kesalahan: ' + data.error);
                    btn.disabled = false; btn.textContent = 'Lanjut ke Pembayaran';
                    return;
                }
                if (data.errors) {
                    // Laravel validation errors
                    var msgs = Object.values(data.errors).flat().join('\n');
                    alert(msgs);
                    btn.disabled = false; btn.textContent = 'Lanjut ke Pembayaran';
                    return;
                }

                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = '{{ route("subscribe.success") }}?order_id=' + result.order_id;
                    },
                    onPending: function(result) {
                        window.location.href = '{{ route("subscribe.success") }}?order_id=' + result.order_id + '&status=pending';
                    },
                    onError: function() {
                        alert('Pembayaran gagal. Silakan coba lagi.');
                        btn.disabled = false; btn.textContent = 'Lanjut ke Pembayaran';
                    },
                    onClose: function() {
                        btn.disabled = false; btn.textContent = 'Lanjut ke Pembayaran';
                    }
                });
            } catch(err) {
                console.error(err);
                alert('Koneksi bermasalah. Coba lagi.');
                btn.disabled = false; btn.textContent = 'Lanjut ke Pembayaran';
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); document.getElementById('btn-pay').click(); }
        });
    </script>
</body>
</html>
