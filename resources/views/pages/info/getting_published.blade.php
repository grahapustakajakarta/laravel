<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Getting Published - Galeri Buku Jakarta</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        .gp-container {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            background: #ffffff;
        }
        .gp-left {
            width: 68%;
            height: 100vh;
        }
        .gp-left img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        .gp-right {
            width: 32%;
            height: 100vh;
            background: #ffffff;
            padding: 4% 5% 5% 5%;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .gp-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-weight: 700;
            font-size: 2.5rem; /* slightly larger for serif */
            color: #000;
            margin-bottom: 25px;
            letter-spacing: 0.5px;
        }
        .gp-text {
            font-family: 'Garamond', serif;
            font-size: 1.15rem; /* slightly larger since Garamond renders smaller */
            line-height: 1.4;
            color: #000;
            margin-bottom: 35px;
            text-align: left;
        }
        .gp-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: nowrap;
            margin-top: 10px;
        }
        .gp-btn {
            background: #cc2b2b;
            color: #ffffff;
            padding: 12px 15px;
            text-decoration: none;
            font-family: 'Arial', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            transition: background 0.3s;
            text-align: center;
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }
        .gp-btn:hover {
            background: #a31e1e;
        }
        .gp-bottom-links {
            position: absolute;
            bottom: 30px;
            right: 40px;
            display: flex;
            gap: 20px;
        }
        .gp-back {
            font-family: 'Arial', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #000;
            text-decoration: none;
        }
        .gp-back:hover {
            text-decoration: underline;
        }

        @media (max-width: 1024px) {
            .gp-left { width: 50%; }
            .gp-right { width: 50%; padding: 5%; }
        }

        @media (max-width: 768px) {
            .gp-container {
                flex-direction: column;
                overflow: auto;
                height: auto;
            }
            .gp-left, .gp-right {
                width: 100%;
                height: auto;
            }
            .gp-left {
                height: 50vh;
            }
            .gp-right {
                padding: 40px 20px 80px 20px;
            }
            .gp-bottom-links {
                bottom: 20px;
                right: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="gp-container">
        <div class="gp-left">
            <!-- Using existing image -->
            <img src="{{ asset('pustaka/siapakajakarta.jpeg') }}" alt="Getting Published">
        </div>
        <div class="gp-right">
            <h1 class="gp-title">Getting Published</h1>
            <p class="gp-text">
                Bersama merayakan kata dan kota. Pembaca dapat berkontribusi menulis dan mempublikasikan karya bersama kami. Sebagai dukungan dan pengayaan diri; dengan menulis untuk Galeri Buku Jakarta—yang hanya diperuntukkan untuk pembaca yang berlangganan sebagai komitmen dan dukungan pada kerja cinta kami. Galeri Buku Jakarta selalu memiliki misi ganda: untuk mempromosikan penulis yang paling menarik dan untuk mendukung pembaca yang ambisius dan ingin tahu. Kisah-kisah itu penting dan membawa para pembaca pada kedalaman dan kebermaknaan.
            </p>
            <div class="gp-buttons">
                <!-- If not logged in, redirect to sign in, else go to subscribe page -->
                @if(auth('pengguna')->check())
                    <a href="{{ route('subscribe') }}" class="gp-btn">BERLANGGANAN</a>
                @else
                    <a href="{{ route('user.signin') }}" class="gp-btn">BERLANGGANAN</a>
                @endif
                
                @if(auth('pengguna')->check() && auth('pengguna')->user()->isPremium())
                    <a href="{{ route('user.profile', ['tab' => 'kirim-tulisan']) }}" class="gp-btn">KIRIM TULISAN</a>
                @elseif(!auth('pengguna')->check())
                    <a href="{{ route('user.signin') }}" class="gp-btn">KIRIM TULISAN</a>
                @else
                    <a href="{{ route('subscribe') }}" class="gp-btn">KIRIM TULISAN</a>
                @endif
            </div>
            
            <div class="gp-bottom-links">
                <a href="{{ url('/page/submission') }}" class="gp-back">SUBMISSION GUIDELINE</a>
                <a href="{{ url('/') }}" class="gp-back">BACK TO HOME</a>
            </div>
        </div>
    </div>
</body>
</html>
