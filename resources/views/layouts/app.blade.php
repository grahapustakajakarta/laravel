<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title') @yield('title') — @endif Galeri Buku Jakarta</title>
    @stack('meta')
    <link rel="shortcut icon" href="{{ asset('img/LOGO.jpeg') }}" type="image/x-icon">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Google Fonts untuk Tipografi Utama Website -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=Source+Sans+3:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}?v={{ time() }}">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('styles')
    <style>
        /* --- MINIMALIST PRELOADER CSS --- */
        #global-preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: #ffffff;
            z-index: 99999999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }
        #global-preloader.loaded {
            opacity: 0;
            visibility: hidden;
        }
        
        .preloader-logo {
            width: 90px;
            height: auto;
            opacity: 0.9;
            animation: breathe 2s ease-in-out infinite alternate;
        }

        .preloader-loader {
            margin-top: 20px;
            width: 40px;
            height: 2px;
            background: rgba(183, 13, 15, 0.2);
            position: relative;
            overflow: hidden;
            border-radius: 2px;
        }

        .preloader-loader::after {
            content: '';
            position: absolute;
            left: -20px;
            top: 0;
            height: 100%;
            width: 20px;
            background: #b70d0f;
            animation: loading-line 1.5s infinite cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes breathe {
            0% { transform: scale(0.98); opacity: 0.8; }
            100% { transform: scale(1.02); opacity: 1; }
        }

        @keyframes loading-line {
            0% { left: -20px; width: 20px; }
            50% { width: 40px; }
            100% { left: 40px; width: 20px; }
        }

        html, body {
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
        }

        /* ===== SEARCH OVERLAY ===== */
        #searchOverlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999999;
            background: rgba(0,0,0,0.35);
        }
        #searchOverlay.active { display: block; }

        #searchOverlayPanel {
            background: #fff;
            width: 100%;
            transform: translateY(-100%);
            transition: transform 0.38s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }
        #searchOverlay.active #searchOverlayPanel {
            transform: translateY(0);
        }

        #searchOverlayHeader {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 5%;
            gap: 16px;
            border-bottom: 1px solid #e5e5e5;
        }

        #searchInputWrapper {
            width: 55%;
            max-width: 680px;
            display: flex;
            align-items: center;
            border: 2px solid #222;
            padding: 10px 14px;
            gap: 10px;
            background: #fff;
        }
        #searchIconLeft {
            color: #888;
            font-size: 16px;
            flex-shrink: 0;
        }
        #searchOverlayInput {
            flex: 1;
            border: none;
            outline: none;
            font-family: 'Source Sans 3', 'Arial', sans-serif;
            font-size: 18px;
            color: #111;
            background: transparent;
        }
        #searchOverlayInput::placeholder { color: #bbb; }

        #searchClearBtn, #searchSubmitBtn {
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 4px 6px;
            color: #888;
            font-size: 16px;
            flex-shrink: 0;
            transition: color 0.2s;
        }
        #searchSubmitBtn {
            color: #111;
            font-size: 18px;
            border-left: 1px solid #e0e0e0;
            padding-left: 12px;
        }
        #searchClearBtn:hover { color: #b70d0f; }
        #searchSubmitBtn:hover { color: #b70d0f; }

        #searchCloseBtn {
            background: transparent;
            border: none;
            color: #111;
            font-size: 22px;
            cursor: pointer;
            padding: 8px;
            flex-shrink: 0;
            transition: color 0.2s;
        }
        #searchCloseBtn:hover { color: #b70d0f; }

        /* Live Results — Two Column Layout */
        #searchLiveResults {
            max-height: 460px;
            overflow-y: auto;
            padding: 0 5%;
            display: none; /* hidden until results appear */
        }
        #searchLiveResults.has-results { display: block; }

        .slr-columns {
            display: flex;
            gap: 0;
            border-bottom: 1px solid #e5e5e5;
            padding: 16px 0 8px;
        }
        .slr-col {
            flex: 1;
            min-width: 0;
        }
        .slr-col:first-child {
            border-right: 1px solid #e5e5e5;
            padding-right: 30px;
        }
        .slr-col:last-child {
            padding-left: 30px;
        }
        .slr-col-heading {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f0f0f0;
        }

        .slr-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid #f0f0f0;
            text-decoration: none;
            color: #111;
            transition: background 0.2s;
        }
        .slr-item:last-child { border-bottom: none; }
        .slr-item:hover { background: #fafafa; padding-left: 6px; }
        .slr-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            flex-shrink: 0;
            background: #eee;
        }
        .slr-img-placeholder {
            width: 60px;
            height: 60px;
            flex-shrink: 0;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ccc;
            font-size: 20px;
        }
        .slr-text { flex: 1; min-width: 0; }
        .slr-kategori {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #b70d0f;
            margin-bottom: 4px;
        }
        .slr-judul {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 15px;
            font-weight: 600;
            line-height: 1.3;
            color: #111;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
            max-width: 400px; /* Batasi lebar khusus judul agar cepat wrap ke bawah */
        }
        .slr-penulis {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 12px;
            color: #888;
            margin-top: 2px;
        }
        .slr-arrow {
            color: #ccc;
            font-size: 14px;
            flex-shrink: 0;
        }
        #slr-footer {
            padding: 14px 0;
            border-top: 1px solid #e5e5e5;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            color: #333;
        }
        #slr-footer:hover { color: #b70d0f; }
        .slr-empty {
            padding: 30px 0;
            text-align: center;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 15px;
            color: #888;
        }
        /* Pustaka item — no author line, has tipe label */
        .slr-item-pustaka .slr-kategori { color: #555; }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div id="global-preloader">
        <img src="{{ asset('img/LOGO.jpeg') }}" alt="Loading..." class="preloader-logo">
        <div class="preloader-loader"></div>
    </div>

    <!-- nav -->
    <header id="header">
        <div class="container">
            <div class="ms" id="megaMenu">
                {{-- ===== TOP HALF: SECTION + ARTICLES + BUKU KAMI ===== --}}
                <div class="ms-top">
                    {{-- LEFT: SECTION nav links --}}
                    <div class="ms-section">
                        <h3 class="ms-heading">SECTION</h3>
                        <div class="ms-links">
                            <ul>
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ url('/page/puisi') }}">Puisi</a></li>
                                <li><a href="{{ url('/page/prosa') }}">Prosa</a></li>
                                <li><a href="{{ route('donate') }}" style="color: red; font-weight: bold;">Support us</a></li>
                                <li><a href="{{ url('/page/fiksi') }}">Fiksi</a></li>
                                <li><a href="{{ url('/page/buku') }}">Buku</a></li>
                            </ul>
                            <ul>
                                <li><a href="{{ url('/page/pemikiran') }}">Pemikiran</a></li>
                                <li><a href="{{ url('/page/coffeeshophia') }}">Coffeesophia</a></li>
                                <li><a href="{{ url('/page/writingTips') }}">Writing Tips</a></li>
                                <li><a href="{{ url('/page/inspirasi') }}">Inspirasi</a></li>
                                <li><a href="{{ url('/page/jktplus') }}">Jakarta+</a></li>
                            </ul>
                            <ul>
                                <li><a href="{{ url('/page/submission') }}">Submission</a></li>
                                <li><a href="{{ url('/page/redaksi') }}">Redaksi</a></li>
                                <li><a href="{{ url('/tentang') }}">Tentang</a></li>
                                <li><a href="{{ route('kontak') }}">Kontak</a></li>
                                <li><a href="{{ route('advertise') }}">Advertise</a></li>
                            </ul>
                        </div>
                    </div>

                    {{-- MIDDLE: Support Us & Articles --}}
                    <style>
                        .desk .mega .ms-section { width: 32% !important; }
                        .desk .mega .ms-buku { width: 23% !important; }
                        .desk .mega .ms-middle { flex: 0 0 auto; width: 45%; display: flex; gap: 20px; }
                        .support-box:hover { opacity: 0.9; }
                    </style>
                    <div class="ms-middle">
                        {{-- Support Us Box --}}
                        <a href="{{ route('donate') }}" class="support-box" style="flex: 1; background-color: #ffe500; padding: 20px; text-decoration: none; display: flex; flex-direction: column; justify-content: space-between; color: #111; min-height: 200px;">
                            <div>
                                <h3 style="font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; line-height: 1.1; margin-bottom: 15px; margin-top: 0; color: #111;">Support<br>Galeri Buku Jakarta</h3>
                                <p style="font-family: 'Source Sans 3', sans-serif; font-size: 14px; line-height: 1.4; margin: 0; color: #111;">Available for everyone, funded by readers.</p>
                            </div>
                            <div style="margin-top: 20px; font-family: 'Source Sans 3', sans-serif; font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 5px;">
                                <span style="background: #111; color: #ffe500; padding: 6px 16px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">Support us <i class="fas fa-arrow-right" style="font-size: 12px;"></i></span>
                            </div>
                        </a>

                        {{-- Articles (Coffeeshophia) --}}
                        <div class="ms-articles-inner" style="flex: 1; display: flex; flex-direction: column; gap: 15px;">
                            @if(isset($coffeeshophia_menu))
                                @foreach($coffeeshophia_menu as $r)
                                <a href="{{ url('/artikel/'.$r->slug) }}" class="ms-article-item" style="display: flex; gap: 12px; text-decoration: none;">
                                    <div class="ms-article-img" style="width: 80px; height: 80px; background: url('{{ asset('img/'.$r->gambar_pertama) }}') center/cover no-repeat; flex-shrink: 0;"></div>
                                    <p class="ms-article-title" style="color: #fff; font-family: 'Source Sans 3', sans-serif; font-size: 13px; margin: 0; line-height: 1.4;">{{ $r->judul }}</p>
                                </a>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    {{-- RIGHT: BUKU KAMI — pakai cover Memikirkan Kata dari folder sponsor --}}
                    <div class="ms-buku">
                        <h3 class="ms-heading">Memikirkan Kata</h3>
                        <style>
                            .ms-buku-link {
                                display: block;
                                perspective: 1000px; /* Efek ruang 3D */
                                text-decoration: none;
                            }
                            .ms-buku-img {
                                width: 100%;
                                display: block;
                                transform-origin: center center;
                                transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1), filter 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
                                will-change: transform, filter;
                                filter: drop-shadow(0 10px 15px rgba(0,0,0,0.25));
                            }
                            /* Hover yang natural untuk gambar isometrik */
                            .ms-buku-link:hover .ms-buku-img {
                                transform: scale(1.05) translateY(-6px) rotateY(-8deg) rotateX(4deg);
                                filter: drop-shadow(15px 20px 20px rgba(0,0,0,0.35));
                            }
                        </style>
                        <a href="https://id.shp.ee/PLrzfWhi" target="_blank" class="ms-buku-link" title="Beli di Shopee">
                            <img src="{{ asset('img/sponsor/1 Memikirkan Kata.png') }}" alt="Memikirkan Kata" class="ms-buku-img">
                        </a>
                    </div>
                </div>

                {{-- ===== BOTTOM: OUR SPONSOR row ===== --}}
                <div class="ms-sponsor">
                    <div class="ms-sponsor-inner">
                        <h4 class="ms-sponsor-heading">OUR PARTNERS</h4>
                        <div class="ms-sponsor-logos">
                            <a href="https://www.jakarta.go.id" target="_blank" class="ms-sponsor-logo-link" title="DKI Jakarta">
                                <img src="{{ asset('img/sponsor/logo-dki-jakarta-raya-black.png') }}" alt="DKI Jakarta">
                            </a>
                            <a href="https://www.pertamina.com" target="_blank" class="ms-sponsor-logo-link" title="Pertamina Patra Niaga">
                                <img src="{{ asset('img/sponsor/PT_Pertamina_Patra_Niaga.svg-1024x576.png') }}" alt="Pertamina" style="height: 60px; max-width: 160px;">
                            </a>
                            <a href="https://chery.co.id" target="_blank" class="ms-sponsor-logo-link" title="Chery">
                                <img src="{{ asset('img/sponsor/95Logo_Chery_Mobil.png') }}" alt="Chery">
                            </a>
                            <a href="https://www.sarinah.co.id" target="_blank" class="ms-sponsor-logo-link" title="Sarinah">
                                <img src="{{ asset('img/sponsor/Sarinah png.png') }}" alt="Sarinah">
                            </a>
                            <a href="https://www.injourney.id" target="_blank" class="ms-sponsor-logo-link" title="InJourney">
                                <img src="{{ asset('img/sponsor/ias-logo-7_eaFq_i.png') }}" alt="InJourney">
                            </a>
                            <a href="https://www.hyundai.com/id" target="_blank" class="ms-sponsor-logo-link" title="Hyundai">
                                <img src="{{ asset('img/sponsor/hyundai.svg') }}" alt="Hyundai">
                            </a>
                        </div>
                        <div class="ms-sponsor-kemitraan">
                            <a href="{{ route('advertise') }}" class="ms-kemitraan-link">Advertise With Us</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="toggle">
                <input type="checkbox" name="toggle-nav" id="">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="logo">
                <a href="{{ route('home') }}" class="logoImg"><img src="{{ asset('img/LOGO.jpeg') }}" alt=""></a>
            </div>
            <ul class="desk">
                <li class="mega">ALL <i class="fal fa-angle-down"></i></li>
                <li><a href="{{ route('publikasi.index') }}">PUBLIKASI</a></li>
                <li><a href="{{ route('pustaka.index') }}">GERAI</a></li>
                <li><a href="{{ route('magz.index') }}">MAGZ</a></li>
                <li><a href="{{ (\Illuminate\Support\Facades\Auth::guard('pengguna')->check() && \Illuminate\Support\Facades\Auth::guard('pengguna')->user()->isPremium()) ? route('user.profile', ['tab' => 'kirim-tulisan']) : route('getting_published') }}">KIRIM TULISAN</a></li>
                
            </ul>
            <div class="akun" style="display: flex; align-items: center;">
                {{-- ===== SEARCH ICON BUTTON ===== --}}
                <button id="searchToggleBtn" onclick="openSearchOverlay()" aria-label="Search" style="
                    background: transparent;
                    border: none;
                    color: #fff;
                    cursor: pointer;
                    padding: 8px 10px;
                    display: flex;
                    align-items: center;
                    font-size: 18px;
                    transition: opacity 0.2s;
                    margin-right: 5px;
                    outline: none;
                ">
                    <i class="fal fa-search"></i>
                </button>
                
                {{-- ===== CART ICON BUTTON ===== --}}
                @auth('pengguna')
                <a href="{{ route('cart.index') }}" aria-label="Keranjang" style="
                    position: relative;
                    background: transparent;
                    border: none;
                    color: #fff;
                    cursor: pointer;
                    padding: 8px 10px;
                    display: flex;
                    align-items: center;
                    font-size: 18px;
                    text-decoration: none;
                    transition: opacity 0.2s;
                    margin-right: 2px;
                ">
                    <i class="fal fa-shopping-cart"></i>
                    @php
                        $cartCount = \App\Models\CartItem::where('pengguna_id', Auth::guard('pengguna')->id())->count();
                    @endphp
                    @if($cartCount > 0)
                    <span class="cart-badge" style="
                        position:absolute;top:2px;right:4px;
                        background:#e31837;color:#fff;
                        font-size:9px;font-weight:700;
                        width:16px;height:16px;
                        border-radius:50%;
                        display:inline-flex;align-items:center;justify-content:center;
                        line-height:1;
                    ">{{ $cartCount }}</span>
                    @else
                    <span class="cart-badge" style="
                        position:absolute;top:2px;right:4px;
                        background:#e31837;color:#fff;
                        font-size:9px;font-weight:700;
                        width:16px;height:16px;
                        border-radius:50%;
                        display:none;align-items:center;justify-content:center;
                        line-height:1;
                    "></span>
                    @endif
                </a>
                @endauth

                @auth('pengguna')
                    {{-- ===== Profile Dropdown (saat login) - Premium Design ===== --}}
                    @php $user = Auth::guard('pengguna')->user(); @endphp
                    <div class="profile-wrap" id="profileWrap">
                        <button class="profile-btn" id="profileBtn" onclick="toggleProfileMenu()" aria-expanded="false">
                            @if($user->foto_profil)
                                <img src="{{ asset('storage/profile/' . $user->foto_profil) }}" class="profile-avatar-premium" style="object-fit: cover; padding: 0;" alt="Profile">
                            @else
                                <div class="profile-avatar-premium">
                                    {{ strtoupper(substr($user->nama, 0, 1)) }}
                                </div>
                            @endif
                            <span class="profile-name-premium">{{ Str::limit(explode(' ', $user->nama)[0], 12) }}</span>
                            <i class="fal fa-angle-down profile-chevron-premium" id="profileChevron"></i>
                        </button>

                        <div class="profile-dropdown-premium" id="profileDropdown">
                            <div class="pdp-header">
                                <p class="pdp-greeting">Welcome back,</p>
                                <p class="pdp-name">{{ $user->nama }}</p>
                                <p class="pdp-email">{{ $user->email }}</p>
                                @if(!$user->hasVerifiedEmail())
                                    <a href="{{ route('user.verification.notice') }}" class="pdp-badge unverified">
                                        <i class="fas fa-exclamation-triangle"></i> Verify Email
                                    </a>
                                @else
                                    <span class="pdp-badge verified"><i class="fas fa-check-circle"></i> Verified Member</span>
                                @endif
                            </div>
                            
                            <div class="pdp-menu">
                                <a href="{{ route('user.profile', ['tab' => 'akun']) }}" class="pdp-item">
                                    <i class="fal fa-user"></i> <span>My Profile</span>
                                </a>
                                <a href="{{ route('subscribe') }}" class="pdp-item highlight">
                                    <i class="fal fa-crown"></i> <span>Premium Subscription</span>
                                </a>
                                <a href="{{ route('user.profile', ['tab' => 'simpanan']) }}" class="pdp-item">
                                    <i class="fal fa-bookmark"></i> <span>Saved Articles</span>
                                </a>
                                <a href="{{ route('user.profile', ['tab' => 'koleksi']) }}" class="pdp-item">
                                    <i class="fal fa-book-open"></i> <span>My Collection</span>
                                </a>
                                <a href="{{ route('cart.index') }}" class="pdp-item">
                                    <i class="fal fa-shopping-cart"></i> <span>Keranjang</span>
                                </a>
                                <div class="pdp-divider"></div>
                                <form action="{{ route('user.signout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="pdp-item pdp-signout">
                                        <i class="fal fa-sign-out"></i> <span>Sign Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- ===== Tombol Sign In & Subscribe ===== --}}
                    <a href="{{ route('user.signin') }}" class="btn-auth-signin">Sign In</a>
                    <a href="{{ route('subscribe') }}" class="btn-auth-sub">Subscribe</a>
                @endauth
            </div>
            
            <style>
                /* ===== AUTH BUTTONS (Not Logged In) ===== */
                .btn-auth-signin {
                    font-family: 'Source Sans 3', sans-serif;
                    font-size: 0.75rem !important; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px;
                    color: #fff !important; text-decoration: none; padding: 8px 12px !important;
                    transition: color 0.2s; background: transparent !important;
                    white-space: nowrap;
                }
                .btn-auth-signin:hover { color: #bbb !important; }
                
                header .container .akun a.btn-auth-sub {
                    font-family: 'Source Sans 3', sans-serif;
                    font-size: 0.7rem !important; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;
                    color: #111 !important; background: #fff !important; text-decoration: none;
                    padding: 8px 18px !important; margin-left: 10px; border-radius: 0 !important;
                    transition: background 0.2s, transform 0.2s;
                    white-space: nowrap;
                }
                header .container .akun a.btn-auth-sub:hover { background: #eee !important; transform: translateY(-1px); }

                @media (max-width: 768px) {
                    #searchToggleBtn {
                        display: none !important;
                    }
                }

                @media (max-width: 576px) {
                    .btn-auth-signin {
                        padding: 6px 4px !important;
                        font-size: 0.7rem !important;
                        letter-spacing: 1px;
                    }
                    header .container .akun a.btn-auth-sub {
                        padding: 6px 10px !important;
                        font-size: 0.65rem !important;
                        letter-spacing: 1px;
                        margin-left: 5px;
                    }
                    header .container .akun {
                        display: flex;
                        align-items: center;
                        justify-content: flex-end;
                        gap: 2px;
                    }
                }

                /* ===== PROFILE BUTTON (Logged In) ===== */
                .profile-wrap { position: relative; display: flex; align-items: center; }

                .profile-btn {
                    display: flex; align-items: center; gap: 10px;
                    background: transparent; border: 1px solid rgba(255,255,255,0.2);
                    padding: 4px 12px 4px 4px; border-radius: 50px; cursor: pointer;
                    transition: all 0.2s ease; outline: none;
                }
                .profile-btn:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.4); }

                .profile-avatar-premium {
                    width: 32px; height: 32px; border-radius: 50%;
                    background: #fff; color: #111;
                    font-family: 'Playfair Display', serif; font-size: 0.95rem; font-weight: 900;
                    display: flex; align-items: center; justify-content: center;
                    box-shadow: inset 0 0 0 2px #e03a3c;
                }
                .profile-name-premium {
                    font-family: 'Source Sans 3', sans-serif; font-size: 0.8rem;
                    color: #fff; font-weight: 600; letter-spacing: 0.5px;
                }
                .profile-chevron-premium {
                    color: rgba(255,255,255,0.6); font-size: 0.8rem;
                    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                }
                .profile-btn[aria-expanded="true"] .profile-chevron-premium { transform: rotate(180deg); color: #fff; }

                /* ===== DROPDOWN PANEL ===== */
                .profile-dropdown-premium {
                    visibility: hidden; opacity: 0; transform: translateY(10px);
                    position: absolute; top: calc(100% + 14px); right: 0;
                    background: #fff; min-width: 260px;
                    box-shadow: 0 12px 40px rgba(0,0,0,0.25);
                    border: 1px solid #e5e5e5; z-index: 999;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    text-align: center;
                    border-radius: 6px;
                }
                .profile-dropdown-premium.open { visibility: visible; opacity: 1; transform: translateY(0); }

                /* Dropdown Header */
                .pdp-header {
                    padding: 24px 20px 20px;
                    border-bottom: 1px solid #f0f0f0;
                }
                .pdp-greeting {
                    font-family: 'Source Sans 3', sans-serif; font-size: 0.65rem;
                    text-transform: uppercase; letter-spacing: 2px; color: #888;
                    margin-bottom: 6px; font-weight: 700;
                }
                .pdp-name {
                    font-family: 'Playfair Display', Georgia, serif;
                    font-size: 1.25rem; font-weight: 700; color: #111;
                    line-height: 1.1; margin-bottom: 4px; text-transform: none;
                }
                .pdp-email {
                    font-family: 'Source Sans 3', sans-serif; font-size: 0.75rem;
                    color: #777; margin-bottom: 14px; text-transform: none; letter-spacing: 0;
                }
                header .container .akun a.pdp-badge {
                    display: inline-flex; align-items: center; gap: 6px;
                    padding: 4px 10px !important; border-radius: 4px !important;
                    font-family: 'Source Sans 3', sans-serif; font-size: 0.65rem !important;
                    font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
                }
                header .container .akun a.pdp-badge.unverified {
                    background: #fff8e6 !important; color: #c8820a !important; text-decoration: none;
                    border: 1px solid #f5e0b5 !important; transition: background 0.2s;
                }
                header .container .akun a.pdp-badge.unverified:hover { background: #fdf0d5 !important; }
                
                .pdp-badge.verified {
                    display: inline-flex; align-items: center; gap: 6px;
                    padding: 4px 10px; border-radius: 4px;
                    font-family: 'Source Sans 3', sans-serif; font-size: 0.65rem;
                    font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
                    background: #f0f9f0; color: #2a7a2a; border: 1px solid #c3e6c3;
                }

                /* Dropdown Menu Items (Overriding header.css) */
                .pdp-menu { padding: 8px 0; display: flex; flex-direction: column; }
                
                header .container .akun a.pdp-item, 
                header .container .akun button.pdp-item {
                    display: flex; align-items: center; gap: 14px;
                    padding: 12px 24px !important; font-size: 0.85rem !important;
                    color: #444 !important; text-decoration: none;
                    font-family: 'Source Sans 3', sans-serif; font-weight: 600;
                    background: transparent !important; border: none !important; width: 100%;
                    cursor: pointer; transition: all 0.2s; border-radius: 0 !important;
                    text-align: left; text-transform: none; letter-spacing: 0;
                    box-sizing: border-box;
                }
                header .container .akun a.pdp-item i,
                header .container .akun button.pdp-item i { 
                    width: 16px; text-align: center; color: #aaa !important; font-size: 1rem; transition: color 0.2s; 
                }
                header .container .akun a.pdp-item:hover,
                header .container .akun button.pdp-item:hover { 
                    background: #f9f9f9 !important; color: #111 !important; padding-left: 28px !important; 
                }
                header .container .akun a.pdp-item:hover i,
                header .container .akun button.pdp-item:hover i { color: #111 !important; }
                
                header .container .akun a.pdp-item.highlight { color: #e03a3c !important; }
                header .container .akun a.pdp-item.highlight i { color: #e03a3c !important; }
                header .container .akun a.pdp-item.highlight:hover { background: #fff5f5 !important; color: #c00 !important; }
                header .container .akun a.pdp-item.highlight:hover i { color: #c00 !important; }

                .pdp-divider { height: 1px; background: #f0f0f0; margin: 8px 0; width: 100%; }
                
                header .container .akun button.pdp-signout { color: #888 !important; }
                header .container .akun button.pdp-signout i { color: #888 !important; }
                header .container .akun button.pdp-signout:hover { background: #f5f5f5 !important; color: #111 !important; }
                header .container .akun button.pdp-signout:hover i { color: #111 !important; }

                /* Dropdown Arrow */
                .profile-dropdown-premium::before {
                    content: ''; position: absolute; top: -6px; right: 24px;
                    width: 12px; height: 12px;
                    background: #fff; border-left: 1px solid #e5e5e5; border-top: 1px solid #e5e5e5;
                    transform: rotate(45deg);
                }
            </style>
            <script>
                function toggleProfileMenu() {
                    var dd  = document.getElementById('profileDropdown');
                    var btn = document.getElementById('profileBtn');
                    var isOpen = dd.classList.contains('open');
                    
                    if (isOpen) {
                        dd.classList.remove('open');
                        btn.setAttribute('aria-expanded', 'false');
                    } else {
                        dd.classList.add('open');
                        btn.setAttribute('aria-expanded', 'true');
                    }
                }
                
                // Tutup jika klik di luar
                document.addEventListener('click', function(e) {
                    var wrap = document.getElementById('profileWrap');
                    if (wrap && !wrap.contains(e.target)) {
                        var dd = document.getElementById('profileDropdown');
                        var btn = document.getElementById('profileBtn');
                        if (dd && dd.classList.contains('open')) {
                            dd.classList.remove('open');
                            btn.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
            </script>

            <div class="reNav">
                <div class="container">
                    <div class="row" style="display:flex;width:100%;border-top:1px solid rgba(255,255,255,.2);padding:20px 0px;">
                        <form action="{{ route('search') }}" method="get" style="width: 100%;display:flex;justify-content:space-between;">
                            <input type="text" class="inputSearch" name="search" style="padding:3px 5px 3px 10px;width:80%;" placeholder="Cari artikel...">
                            <button type="submit" class="btnCari" style="padding:3px 5px 3px 5px;background:transparent;border:none;"><i class="fal fa-search" style="color: white;"></i></button>
                        </form>
                    </div>
                    <div class="row" style="display:flex;width:100%;border-top:1px solid rgba(255,255,255,.2);padding:20px 0px;">
                        <style>
                            .reNavOl li { font-size: 14px; }
                            .reNavOl li a { color: white; text-decoration: none; }
                        </style>
                        <ol class="reNavOl" style="color: white;display:flex;list-style-type:none;justify-content:center;width:100%;gap:20px;">
                            <li><a href="{{ route('publikasi.index') }}">Publikasi</a></li>
                            <li><a href="{{ route('pustaka.index') }}">Pustaka</a></li>
                            <li><a href="{{ route('magz.index') }}">Magz</a></li>
                            <li><a href="{{ (\Illuminate\Support\Facades\Auth::guard('pengguna')->check() && \Illuminate\Support\Facades\Auth::guard('pengguna')->user()->isPremium()) ? route('user.profile', ['tab' => 'kirim-tulisan']) : route('getting_published') }}">Kirim Tulisan</a></li>
                        </ol>
                    </div>
                    <h3 style="color: red; padding:20px 0px;border-top:1px solid rgba(255,255,255,.2);width:100%;">Section </h3>
                    <ul>
                        <div class="col" style="width: 50%;">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ url('/page/buku') }}">Buku</a></li>
                            <li><a href="{{ url('/page/fiksi') }}">Fiksi</a></li>
                            <li><a href="{{ url('/page/gairah') }}">Gairah</a></li>
                            <li><a href="{{ url('/page/pemikiran') }}">Pemikiran</a></li>
                            <li><a href="{{ url('/page/submission') }}">Memikirkan Kata</a></li>
                            <li><a href="{{ url('/page/siapakahjkt') }}">Siapakah Jakarta</a></li>
                        </div>
                        <div class="col" style="width: 50%;">
                            <li><a href="{{ url('/page/coffeeshophia') }}">Coffeesophia</a></li>
                            <li><a href="{{ url('/page/writingTips') }}">Writing Tips</a></li>
                            <li><a href="{{ url('/page/inspirasi') }}">Inspirasi</a></li>
                            <li><a href="{{ url('/page/jktplus') }}">Jakarta+</a></li>
                            <li><a href="{{ url('/page/puisi') }}">Puisi</a></li>
                            <li><a href="{{ url('/page/prosa') }}">Prosa</a></li>
                            <li><a href="{{ route('donate') }}" style="color: red; font-weight: bold;">Support us</a></li>
                            <li><a href="{{ route('publikasi.index') }}">Publikasi</a></li>
                            <li><a href="{{ route('pustaka.index') }}">Pustaka</a></li>
                        </div>
                    </ul>
                </div>
                <div style="margin-top:auto;width:100%;border-top:2px solid rgba(255,255,255,.3);padding:20px 0px;display:flex;justify-content:center;position:relative;">
                    <button style="background:transparent;border:none;color:white;position:absolute;right:15px;top:15px;"><i class="fal fa-close"></i></button>
                    <a href="{{ route('subscribe') }}" style="text-decoration: none;">
                        <h5 style="padding: 5px 0px 5px 0px;border-bottom:2px solid red;width:fit-content;color:white;text-align:center;margin:0; cursor:pointer;">Subscribe for unlimited access</h5>
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- ===== SEARCH OVERLAY ===== --}}
    <div id="searchOverlay" role="dialog" aria-modal="true" aria-label="Search">
        <div id="searchOverlayPanel">
            <div id="searchOverlayHeader">
                <div id="searchInputWrapper">
                    <i class="fal fa-search" id="searchIconLeft"></i>
                    <input type="text" id="searchOverlayInput" placeholder="Cari artikel..." autocomplete="off" />
                    <button id="searchClearBtn" onclick="clearSearchInput()" aria-label="Clear"><i class="fal fa-times"></i></button>
                    <button id="searchSubmitBtn" aria-label="Search" onclick="submitSearch()"><i class="fal fa-search"></i></button>
                </div>
                <button id="searchCloseBtn" onclick="closeSearchOverlay()" aria-label="Close">
                    <i class="fal fa-times"></i>
                </button>
            </div>
            <div id="searchLiveResults"></div>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <!-- footer -->
    <footer>
        <div class="container">
            <div class="row">
                <style>
                    footer .sosmed a { color: #b70d0f !important; transition: 0.3s; }
                    footer .sosmed a:hover { color: #555 !important; }
                </style>
                <div class="sosmed">
                    <a href="https://x.com/galeribuku_jkt" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="https://www.facebook.com/galeribukujakarta.inc/" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/galeribuku_jkt/" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/watch?v=5yFM647bup4" target="_blank"><i class="fab fa-youtube"></i></a>
                </div>
                <ul class="about">
                    <li>
                        <a href="{{ route('tentang') }}">Tentang</a>
                        <a href="{{ url('/page/redaksi') }}">Redaksi</a>
                        <a href="{{ url('/page/penerbitan') }}">Penerbitan</a>
                    </li>
                    <li>
                        <a href="{{ route('advertise') }}">Advertise With Us</a>
                        <a href="{{ route('donate') }}">Support us</a>
                        <a href="https://id.shp.ee/PLrzfWhi">Marchandise</a>
                    </li>
                    <li>
                        <a href="{{ url('/page/submission') }}">Submission</a>
                        <a href="{{ route('siapakah_jakarta') }}">Siapakah Jakarta</a>
                        <a href="{{ route('editorial_team') }}">Editorial Team</a>
                    </li>
                    <li>
                        <a href="{{ route('sponsorship') }}">Sponsorship</a>
                        <a href="{{ route('pustaka.index') }}">Bookstore</a>
                        <a href="{{ route('kontak') }}">Kontak</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <img src="{{ asset('img/footerfix.png') }}" alt="">
            </div>
            <div class="row" style="font-family: Arial, sans-serif;">
                <a href="" style="font-family: Arial, sans-serif;">©2026 GALERI BUKU JAKARTA</a>
                <a href="{{ url('/page/disclaimer') }}" style="font-family: Arial, sans-serif;">Disclaimer</a>
                <a href="{{ route('privacy') }}" style="font-family: Arial, sans-serif;">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        AOS.init();

        const mega = document.querySelector('.mega');
        const logoImg = document.querySelector('.logoImg');
        const ms = document.querySelector('.ms');
        const megaIkon = mega.querySelector('i');
        const toggle = document.querySelector('.toggle input');
        const reNav = document.querySelector('.reNav');

        if(toggle) {
            toggle.addEventListener('click', function() {
                reNav.classList.toggle('navRight')
                if (reNav.classList.contains('navRight')) {
                    logoImg.style.display = "none";
                } else {
                    logoImg.style.display = "block";
                }
            });
        }

        if(mega) {
            mega.addEventListener('click', function() {
                ms.classList.toggle('d')
                megaIkon.classList.toggle('fa-angle-down')
                megaIkon.classList.toggle('fa-times')
            });
            document.addEventListener('click', function(event) {
                if (!ms.contains(event.target) && !mega.contains(event.target)) {
                    ms.classList.remove('d');
                    megaIkon.classList.remove('fa-times');
                    megaIkon.classList.add('fa-angle-down');
                }
            });
        }

        // --- PRELOADER SCRIPT ---
        // Menunggu seluruh aset web (gambar, font, css) selesai dimuat
        window.addEventListener('load', function() {
            const preloader = document.getElementById('global-preloader');
            if (preloader) {
                // Beri sedikit jeda halus
                setTimeout(() => {
                    preloader.classList.add('loaded');
                    // Sembunyikan sepenuhnya dari DOM setelah fade out
                    setTimeout(() => {
                        preloader.style.display = 'none';
                    }, 500);
                }, 300);
            }
        });
    </script>
    @stack('scripts')
    <script>
    // ===== SEARCH OVERLAY =====
    const LIVE_SEARCH_URL = '{{ route("search.live") }}';
    const FULL_SEARCH_URL = '{{ route("search") }}';
    let searchDebounceTimer = null;

    function openSearchOverlay() {
        const overlay = document.getElementById('searchOverlay');
        overlay.style.display = 'block';
        // Force reflow for animation
        void overlay.offsetWidth;
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('searchOverlayInput').focus(), 100);
    }

    function closeSearchOverlay() {
        const overlay = document.getElementById('searchOverlay');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
        setTimeout(() => {
            overlay.style.display = 'none';
            document.getElementById('searchLiveResults').innerHTML = '';
            document.getElementById('searchOverlayInput').value = '';
        }, 380);
    }

    function clearSearchInput() {
        document.getElementById('searchOverlayInput').value = '';
        document.getElementById('searchLiveResults').innerHTML = '';
        document.getElementById('searchOverlayInput').focus();
    }

    function submitSearch() {
        const q = document.getElementById('searchOverlayInput').value.trim();
        if (q) window.location.href = FULL_SEARCH_URL + '?search=' + encodeURIComponent(q);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('searchOverlayInput');
        if (!input) return;

        // Close on background click
        document.getElementById('searchOverlay').addEventListener('click', function(e) {
            if (e.target === this) closeSearchOverlay();
        });

        // Close on Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeSearchOverlay();
            if (e.key === 'Enter' && document.getElementById('searchOverlay').classList.contains('active')) {
                submitSearch();
            }
        });

        // Live search on input
        input.addEventListener('input', function() {
            clearTimeout(searchDebounceTimer);
            const q = this.value.trim();
            if (q.length < 2) {
                document.getElementById('searchLiveResults').innerHTML = '';
                return;
            }
            searchDebounceTimer = setTimeout(() => fetchLiveResults(q), 280);
        });
    });

    function fetchLiveResults(q) {
        fetch(LIVE_SEARCH_URL + '?q=' + encodeURIComponent(q))
            .then(r => r.json())
            .then(data => renderResults(data, q))
            .catch(() => {});
    }

    function renderResults(data, q) {
        const box = document.getElementById('searchLiveResults');
        const artikels = (data && data.artikel) ? data.artikel : [];
        const pustakas = (data && data.pustaka) ? data.pustaka : [];

        if (artikels.length === 0 && pustakas.length === 0) {
            box.innerHTML = '<div class="slr-empty">Tidak ada hasil ditemukan untuk <strong>"' + q + '"</strong></div>';
            box.classList.add('has-results');
            return;
        }

        function makeArtikelItem(item) {
            const img = item.gambar
                ? '<img class="slr-img" src="' + item.gambar + '" alt="" loading="lazy">'
                : '<div class="slr-img-placeholder"><i class="fal fa-image"></i></div>';
            return '<a href="' + item.url + '" class="slr-item">' +
                img +
                '<div class="slr-text">' +
                    '<div class="slr-kategori">' + (item.kategori || 'Artikel') + '</div>' +
                    '<div class="slr-judul">' + item.judul + '</div>' +
                    '<div class="slr-penulis">By ' + (item.penulis || '-') + '</div>' +
                '</div>' +
                '<i class="fal fa-chevron-right slr-arrow"></i>' +
                '</a>';
        }

        function makePustakaItem(item) {
            const img = item.gambar
                ? '<img class="slr-img" src="' + item.gambar + '" alt="" loading="lazy" style="object-fit:contain; background:#f5f5f5;">'
                : '<div class="slr-img-placeholder"><i class="fal fa-book"></i></div>';
            return '<a href="' + item.url + '" class="slr-item slr-item-pustaka">' +
                img +
                '<div class="slr-text">' +
                    '<div class="slr-kategori">' + (item.tipe || 'Pustaka') + '</div>' +
                    '<div class="slr-judul">' + item.judul + '</div>' +
                '</div>' +
                '<i class="fal fa-chevron-right slr-arrow"></i>' +
                '</a>';
        }

        let artikelHtml = artikels.length > 0
            ? artikels.map(makeArtikelItem).join('')
            : '<div class="slr-empty" style="padding:16px 0; font-size:13px;">Tidak ada artikel</div>';

        let pustakaHtml = pustakas.length > 0
            ? pustakas.map(makePustakaItem).join('')
            : '<div class="slr-empty" style="padding:16px 0; font-size:13px;">Tidak ada pustaka</div>';

        let html = '<div class="slr-columns">' +
            '<div class="slr-col">' +
                '<div class="slr-col-heading">Artikel</div>' +
                artikelHtml +
            '</div>' +
            '<div class="slr-col">' +
                '<div class="slr-col-heading">Pustaka</div>' +
                pustakaHtml +
            '</div>' +
            '</div>';

        html += '<div id="slr-footer" onclick="submitSearch()">' +
            '<span>Lihat semua hasil untuk <strong>"' + q + '"</strong></span>' +
            '<i class="fal fa-arrow-right"></i>' +
            '</div>';

        box.innerHTML = html;
        box.classList.add('has-results');
    }
    </script>

    @auth('pengguna')
    @php $floatCartCount = \App\Models\CartItem::where('pengguna_id', Auth::guard('pengguna')->id())->count(); @endphp
    {{-- ===== FLOATING CART BUTTON ===== --}}
    <a href="{{ route('cart.index') }}" id="floating-cart-btn" aria-label="Keranjang" style="
        position: fixed;
        bottom: 32px;
        right: 32px;
        z-index: 9990;
        width: 58px;
        height: 58px;
        background: #111;
        color: #fff;
        border-radius: 50%;
        display: {{ $floatCartCount > 0 ? 'flex' : 'none' }};
        align-items: center;
        justify-content: center;
        font-size: 22px;
        text-decoration: none;
        box-shadow: 0 6px 24px rgba(0,0,0,0.22);
        transition: background 0.2s, transform 0.2s;
    "
    onmouseover="this.style.background='#e31837';this.style.transform='scale(1.08)'"
    onmouseout="this.style.background='#111';this.style.transform='scale(1)'">
        <i class="fas fa-shopping-cart"></i>
        <span id="floating-cart-badge" style="
            position: absolute;
            top: -4px;
            right: -4px;
            background: #e31837;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            min-width: 20px;
            height: 20px;
            border-radius: 10px;
            display: {{ $floatCartCount > 0 ? 'inline-flex' : 'none' }};
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            border: 2px solid #fff;
            line-height: 1;
            font-family: 'Source Sans 3', sans-serif;
        ">{{ $floatCartCount > 0 ? $floatCartCount : '' }}</span>
    </a>
    <style>
        @media (max-width: 576px) {
            #floating-cart-btn {
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
                font-size: 19px;
            }
        }
    </style>
    @endauth

</body>
</html>
