@extends('layouts.app')

@push('meta')
    <meta property="og:title" content="{{ $artikel->judul }}" />
    <meta property="og:description" content="{{ $artikel->sinopsis ?? Str::limit(strip_tags($artikel->konten), 150) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    @php
        $ogImage = '';
        if(isset($artikel) && $artikel->gambar->first()) {
            $rawFile = $artikel->gambar->first()->file_gambar;
            $ogImage = Str::startsWith($rawFile, 'http') ? $rawFile : asset('img/'.$rawFile);
        }
    @endphp
    <meta property="og:image" content="{{ $ogImage }}" />
    <meta property="og:type" content="article" />
@endpush

    @push('styles')
    <style>
        /* ===== NORMALISASI GAMBAR & TEKS — artikel3 (scoped) ===== */
        #artikel3 {
            color: #1a1a1a;
            background-color: #ffffff;
            font-family: var(--font-serif), 'Georgia', serif;
            padding-top: 40px;
            padding-bottom: 60px;
        }
        
        #artikel3 .header-container {
            display: flex;
            border-top: 1px solid #ccc;
            padding-top: 25px;
            margin-bottom: 30px;
        }
        
        #artikel3 .header-left {
            flex: 1;
            padding-right: 40px;
            border-right: 1px solid #ccc;
        }
        
        #artikel3 .header-right {
            width: 250px;
            padding-left: 25px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        #artikel3 .category {
            text-transform: uppercase;
            font-family: var(--font-sans), 'Arial', sans-serif;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #666;
            margin-bottom: 25px;
        }

        /* Hover rubrik — penanda bisa diklik */
        #artikel3 .category a {
            cursor: pointer;
            transition: color 0.2s ease, letter-spacing 0.2s ease;
        }
        #artikel3 .category a:hover {
            color: #b70d0f !important;
            letter-spacing: 2px;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        #artikel3 .date {
            text-transform: uppercase;
            font-family: var(--font-sans), 'Arial', sans-serif;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #666;
        }

        #artikel3 .title {
            font-size: 40px;
            font-weight: bold;
            line-height: 1.1;
            margin-bottom: 25px;
            font-family: var(--font-serif), 'Georgia', serif;
        }

        #artikel3 .author-info {
            max-width: 80%;
            text-transform: uppercase;
            font-size: 11px;
            font-family: var(--font-sans), 'Arial', sans-serif;
            letter-spacing: 1px;
            line-height: 1.5;
            color: #555;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        #artikel3 .author-info strong {
            color: #000;
            font-weight: 900;
        }

        /* Share and Save Buttons (replacing old actions) */
        .action-buttons-container {
            position: relative;
        }
        .action-buttons {
            display: flex;
            gap: 15px;
            align-items: center;
            justify-content: flex-end; /* right align in desktop */
        }
        .action-buttons button {
            background: transparent;
            border: 1px solid #ccc;
            padding: 8px 15px;
            border-radius: 20px;
            font-family: var(--font-sans), 'Arial', sans-serif;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            color: #1a1a1a;
        }
        .action-buttons button:hover {
            background: #f0f0f0;
        }
        
        .share-popup3 {
            display: none;
            position: absolute;
            top: 100%;
            right: 0; /* right align relative to container */
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 10px;
            z-index: 100;
            flex-direction: column;
            gap: 10px;
            min-width: 150px;
            margin-top: 10px;
        }
        .share-popup3.active {
            display: flex;
        }
        .share-popup3 a {
            text-decoration: none;
            color: #1a1a1a;
            font-family: var(--font-sans), 'Arial', sans-serif;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .share-popup3 a:hover {
            background: #f0f0f0;
        }

        #artikel3 .main-img-container {
            margin-bottom: 10px;
            width: 100%;
        }

        #artikel3 .main-img {
            width: 100%;
            height: 600px;
            display: block;
            object-fit: cover;
        }

        #artikel3 .img-caption {
            font-family: var(--font-serif), 'Georgia', serif;
            font-size: 8px;
            color: #888;
            margin-bottom: 50px;
            text-transform: none;
            letter-spacing: 0;
        }

        #artikel3 .content-area {
            margin: 0;
            padding-left: 8%;
            max-width: 100%;
            font-family: 'EB Garamond', Garamond, Georgia, serif;
            font-size: 20px;
            line-height: 1.4;
            white-space: normal;
        }
        
        /* Setiap paragraf/baris puisi dipaksa satu baris */
        #artikel3 .content-area p {
            margin-bottom: 0px;
            white-space: normal; /* Biarkan teks turun (wrap) ke baris baru jika layar sempit */
        }
        /* Jangan sembunyikan br — ini adalah line break puisi dari nl2br() */

        /* Author Bio Section */
        #artikel3 .author-bio-section {
            margin: 50px 0 50px;
            padding-left: 8%;
            max-width: 750px;
            font-family: var(--font-sans), 'Arial', sans-serif;
        }
        #artikel3 .author-bio-divider {
            border: 0;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
        #artikel3 .author-bio-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        #artikel3 .author-bio-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }
        #artikel3 .author-bio-text {
            flex: 1;
        }
        #artikel3 .author-bio-name {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 8px;
            color: #000;
            margin-top: 0;
        }
        #artikel3 .author-bio-desc {
            font-size: 14px;
            line-height: 1.6;
            color: #444;
            margin: 0;
        }
        
        #artikel3 .content-area h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            margin-top: 40px;
            color: #000;
        }
        #artikel3 .content-area h4,
        #artikel3 .content-area h5,
        #artikel3 .content-area h6 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #000;
        }

        #artikel3 .content-area p {
            /* Sama dengan rule di atas — margin sudah di-set, tambah color saja */
            color: #1a1a1a;
        }
        
        #artikel3 .content-area img {
            max-width: 100%;
            height: auto;
            margin: 20px 0;
            display: block;
        }
        .readmore-section {
            position: relative;
            margin-top: 20px; /* Diperkecil agar lebih mepet ke atas */
            padding: 40px 0;
            background: #fff;
            border-top: 2px solid #000;
        }
        .readmore-section .container {
            padding: 0 5%; /* Memberi jarak dari tepi layar */
            max-width: 100%;
        }
        .readmore-layout {
            display: flex;
            gap: 30px;
            align-items: center;
        }
        .readmore-sidebar {
            flex: 0 0 250px; /* Lebar tetap untuk teks di kiri */
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-right: 2px solid #f0f0f0;
            padding-right: 20px;
        }
        .readmore-section .section-title {
            font-family: var(--font-sans), 'Arial', sans-serif;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #000;
            margin: 0 0 20px 0;
            white-space: normal;
            word-wrap: break-word;
            line-height: 1.4;
        }
        .readmore-nav {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            position: relative;
            z-index: 10;
        }
        .readmore-btn {
            background: #f0f0f0;
            color: #000;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            outline: none;
        }
        .readmore-btn:hover {
            background: #b70d0f;
            color: #fff;
        }
        .readmore-content {
            flex: 1;
            min-width: 0; /* Penting agar flex child bisa mengecil */
            overflow: hidden;
        }
        .readmore-track {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
            width: 100%;
            gap: 20px;
            padding-bottom: 10px;
        }
        .readmore-track::-webkit-scrollbar {
            display: none;
        }
        .readmore-card {
            flex: 0 0 calc(25% - 15px); /* 4 items in view */
            scroll-snap-align: start;
        }
        .readmore-card a {
            display: block;
            text-decoration: none;
            color: #1a1a1a;
            background: transparent;
            transition: opacity 0.3s;
        }
        .readmore-card a:hover {
            opacity: 0.7;
        }
        .readmore-card img {
            width: 100%;
            aspect-ratio: 4/3; /* proporsional, tidak terlalu pendek */
            object-fit: cover;
            display: block;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .readmore-card h3 {
            font-family: var(--font-serif), 'Georgia', serif;
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 8px 0;
            line-height: 1.4;
            color: #000;
        }
        .readmore-card .penulis {
            font-family: var(--font-sans), 'Arial', sans-serif;
            font-size: 11px;
            text-transform: uppercase;
            color: #666;
        }
        .readmore-card .penulis span {
            color: #b70d0f;
            font-weight: bold;
        }
        @media (max-width: 768px) {
            /* Tambah padding di mobile agar teks tidak mentok tepi */
            #artikel3 .container {
                padding-left: 15px !important;
                padding-right: 15px !important;
                overflow-x: hidden;
            }
            /* Gambar full lay out di mobile */
            #artikel3 .main-img-container {
                margin-left: -15px !important;
                margin-right: -15px !important;
                width: calc(100% + 30px) !important;
            }
            
            /* Fix header layout mobile */
            #artikel3 .header-container {
                flex-direction: column;
                border-top: none;
                padding-top: 10px;
            }
            #artikel3 .header-left {
                padding-right: 0;
                border-right: none;
                border-bottom: 1px solid #ccc;
                padding-bottom: 20px;
                margin-bottom: 20px;
            }
            #artikel3 .header-right {
                width: 100%;
                padding-left: 0;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
            /* Tombol share & save: letakkan popup di kiri bawah tombol saat mobile */
            #artikel3 .action-buttons {
                justify-content: flex-start;
            }
            #artikel3 .share-popup3 {
                right: auto;
                left: 0;
            }
            /* Perkecil ukuran tombol di mobile */
            #artikel3 .action-buttons button {
                padding: 6px 12px !important;
                font-size: 12px !important;
            }
            #artikel3 .title {
                font-size: 28px !important;
                margin-bottom: 15px;
            }
            #artikel3 .content-area,
            #artikel3 .author-bio-section {
                padding-left: 0;
            }
            #artikel3 .content-area {
                font-size: 16px !important;
            }
            #artikel3 .content-area p {
                margin-bottom: 5px;
            }
            #artikel3 .main-img {
                height: auto;
                max-height: 400px;
            }

            .readmore-layout {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
                width: 100%;
            }
            .readmore-sidebar {
                flex: 0 0 auto;
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #eee;
                padding-right: 0;
                padding-bottom: 20px;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
            .readmore-content { width: 100%; max-width: 100%; }
            .readmore-section .section-title { margin: 0; }
            .readmore-card { flex: 0 0 calc(50% - 10px) !important; max-width: calc(50% - 10px) !important; width: calc(50% - 10px) !important; }
        }
        @media (max-width: 480px) {
            .readmore-card { flex: 0 0 calc(50% - 10px) !important; max-width: calc(50% - 10px) !important; width: calc(50% - 10px) !important; }
            .readmore-card h3 { font-size: 13px; margin-bottom: 6px; line-height: 1.35; }
            .readmore-card .penulis { font-size: 9px; }
            .readmore-card img { margin-bottom: 10px; border-radius: 0; width: 100% !important; aspect-ratio: 4/3 !important; object-fit: cover !important; }
        }

    </style>
    @endpush

    @section('content')
    <section id="artikel3">
        <div class="container" style="max-width: 1100px; margin: 0 auto;">
            <!-- Header -->
            <div class="header-container">
                <div class="header-left">
                    <div class="category">
                        @if(isset($artikel->kategori))
                            <a href="{{ route('page.show', $artikel->kategori->slug) }}" style="text-decoration: none; color: inherit;">{{ strtoupper($artikel->kategori->nama) }}</a>
                        @else
                            POETRY
                        @endif
                    </div>
                    <h1 class="title">{{ $artikel->judul }}</h1>
                    <div class="author-info">
                        @php
                            $topPhoto = null;
                            $topPath = '';
                            
                            if (isset($artikel->penulis) && $artikel->penulis->foto_profil) {
                                $topPhoto = $artikel->penulis->foto_profil;
                                $topPath = asset('storage/penulis/' . $topPhoto);
                            } else {
                                $penggunaTulisan = \App\Models\PenggunaTulisan::where('artikel_id', $artikel->id)->with('pengguna')->first();
                                if ($penggunaTulisan && $penggunaTulisan->pengguna && $penggunaTulisan->pengguna->foto_profil) {
                                    $topPhoto = $penggunaTulisan->pengguna->foto_profil;
                                    $topPath = asset('storage/profile/' . $topPhoto);
                                }
                            }
                        @endphp

                        @if($topPhoto)
                            <img src="{{ $topPath }}" alt="Foto Penulis" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                        @endif
                        <div>
                            <strong>{{ strtoupper($artikel->penulis->nama ?? 'OLIVIA CRAIGHEAD') }}</strong>, A NEWS WRITER FOR THE CUT WHO COVERS POP CULTURE AND CELEBRITY.
                        </div>
                    </div>
                </div>
                <div class="header-right">
                    <div class="date tgl">{{ strtoupper(\Carbon\Carbon::parse($artikel->tanggal_publikasi)->format('M. d, Y')) }}</div>
                    <div class="action-buttons-container">
                        <div class="action-buttons">
                            <button class="btn-share3" onclick="document.getElementById('sharePopup3').classList.toggle('active')">
                                <i class="fas fa-share"></i> Share
                            </button>
                            <button class="btn-save3" id="btnSaveArticle" onclick="saveArticle({{ $artikel->id }})">
                                @php
                                    $isSaved = false;
                                    if(Auth::guard('pengguna')->check()) {
                                        $isSaved = \App\Models\PenggunaSimpanArtikel::where('pengguna_id', Auth::guard('pengguna')->id())
                                            ->where('artikel_id', $artikel->id)->exists();
                                    }
                                @endphp
                                <i class="{{ $isSaved ? 'fas' : 'far' }} fa-bookmark"></i> <span id="saveText">{{ $isSaved ? 'Saved' : 'Save' }}</span>
                            </button>
                        </div>
                        <div class="share-popup3" id="sharePopup3">
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($artikel->judul . ' ' . url()->current()) }}" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                            <a href="https://x.com/intent/tweet?text={{ urlencode($artikel->judul) }}&url={{ urlencode(url()->current()) }}" target="_blank"><i class="fa-brands fa-x-twitter"></i> X / Twitter</a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Image -->
            <div class="main-img-container">
                @php
                    $gbrPertamaUrl = Str::startsWith($artikel->gambar_pertama ?? '', 'data:image') ? $artikel->gambar_pertama : asset('img/'.$artikel->gambar_pertama);
                @endphp
                <img src="{{ $gbrPertamaUrl }}" alt="Main Image" class="main-img">
            </div>
            <div class="img-caption">
                @php
                    $gambar_pertama_obj = $artikel->gambar->first();
                    $deskripsi_pertama = $gambar_pertama_obj ? $gambar_pertama_obj->deskripsi : '';
                @endphp
                {{ $deskripsi_pertama ?: 'Photo-Illustration: Vulture; Photos: Publisher' }}
            </div>

            @php
                $konten = $artikel->konten;
                $footnotes = [];
                $konten = preg_replace_callback('/\[\[(.*?)\]\]/', function($matches) use (&$footnotes) {
                    $footnotes[] = $matches[1];
                    $index = count($footnotes);
                    return '<sup id="ref-'.$index.'"><a href="#fn-'.$index.'" style="text-decoration:none; color:#b70d0f; font-weight:bold;">['.$index.']</a></sup>';
                }, $konten);
            @endphp
            <div class="content-area" style="word-wrap: break-word;">{!! $konten !!}
                
                @if(isset($hasAccess) && !$hasAccess)
                    @include('components.paywall')
                @endif

                @if(count($footnotes) > 0)
                <div class="catatan-kaki mt-5 pt-4" style="border-top: 1px solid #ddd; font-size: 0.85em; color: #555; font-family: var(--font-sans), sans-serif; line-height: 1.6; text-align: left;">
                    @foreach($footnotes as $idx => $fn)
                        <div id="fn-{{ $idx+1 }}" class="mb-2">
                            <span style="color:#b70d0f; font-weight:bold;">{{ $idx+1 }}.</span> {!! nl2br(e($fn)) !!} <a href="#ref-{{ $idx+1 }}" style="text-decoration:none; color:#b70d0f; margin-left: 5px;">&#8617;</a>
                        </div>
                    @endforeach
                </div>
            @endif
            </div>

            @php
                $bioPhoto = null;
                $bioPath = '';
                
                if ($artikel->penulis && $artikel->penulis->foto_profil) {
                    $bioPhoto = $artikel->penulis->foto_profil;
                    $bioPath = asset('storage/penulis/' . $bioPhoto);
                } elseif (isset($userProfilePhoto) && $userProfilePhoto) {
                    $bioPhoto = $userProfilePhoto;
                    $bioPath = asset('storage/profile/' . $bioPhoto);
                }
            @endphp

            @if($artikel->penulis && ($bioPhoto || $artikel->penulis->biografi))
            <div class="author-bio-section">
                <hr class="author-bio-divider">
                <div class="author-bio-content">
                    @if($bioPhoto)
                    <img src="{{ $bioPath }}" alt="{{ $artikel->penulis->nama }}" class="author-bio-img">
                    @endif
                    <div class="author-bio-text">
                        <h4 class="author-bio-name">{{ strtoupper($artikel->penulis->nama) }}</h4>
                        <p class="author-bio-desc">{{ $artikel->penulis->biografi }}</p>
                    </div>
                </div>
                <hr class="author-bio-divider">
            </div>
            @endif
        </div>
    </section>

    <section class="readmore-section">
        <div class="container">
            <div class="readmore-layout">
                <div class="readmore-sidebar">
                    <h3 class="section-title">Lebih Banyak dari<br>{{ $artikel->kategori->nama ?? 'Rubrik Ini' }}</h3>
                    <div class="readmore-nav">
                        <button id="rm-prev" class="readmore-btn">&#10094;</button>
                        <button id="rm-next" class="readmore-btn">&#10095;</button>
                    </div>
                </div>
                <div class="readmore-content">
                    <div class="readmore-track">
                        @foreach ($relatedSlider as $rs)
                        <div class="readmore-card">
                            <a href="{{ url('/artikel/'.$rs->slug) }}">
                                <img src="{{ asset('img/'.$rs->gambar_pertama) }}" alt="{{ $rs->judul }}">
                                <h3>{{ $rs->judul }}</h3>
                                <div class="penulis">By <span>{{ $rs->penulis->nama ?? '-' }}</span></div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection

    @push('scripts')
    <script>
        const artikelArray = @json($relatedSlider);

        document.addEventListener('DOMContentLoaded', () => {
            const track = document.querySelector('.readmore-track');
            const prevBtn = document.getElementById('rm-prev');
            const nextBtn = document.getElementById('rm-next');

            if (track && prevBtn && nextBtn) {
                nextBtn.addEventListener('click', () => {
                    const card = track.querySelector('.readmore-card');
                    if (card) {
                        const cardWidth = card.offsetWidth + 20;
                        track.scrollBy({ left: cardWidth, behavior: 'smooth' });
                    }
                });
                prevBtn.addEventListener('click', () => {
                    const card = track.querySelector('.readmore-card');
                    if (card) {
                        const cardWidth = card.offsetWidth + 20;
                        track.scrollBy({ left: -cardWidth, behavior: 'smooth' });
                    }
                });
            }
        });

        // Close share popup when clicking outside
        document.addEventListener('click', function(event) {
            const shareBtn3 = document.querySelector('.btn-share3');
            const popup3 = document.getElementById('sharePopup3');
            if (shareBtn3 && popup3) {
                if (!shareBtn3.contains(event.target) && !popup3.contains(event.target)) {
                    popup3.classList.remove('active');
                }
            }
        });

        const articleMeta = document.querySelector('.tgl');
        if (articleMeta) {
            const dateText = articleMeta.textContent;
            const date = new Date(dateText);
            if(!isNaN(date)) {
                function formatDate(date) {
                    const months = [
                        "JAN.", "FEB.", "MAR.", "APR.", "MAY", "JUNE", 
                        "JULY", "AUG.", "SEPT.", "OCT.", "NOV.", "DEC."
                    ];
                    const month = months[date.getMonth()];
                    const day = date.getDate();
                    const year = date.getFullYear();
                    return `${month} ${day}, ${year}`;
                }
                articleMeta.textContent = formatDate(date);
            }
        }

        function saveArticle(id) {
            @if(!Auth::guard('pengguna')->check())
                window.location.href = "{{ route('user.signin') }}";
                return;
            @endif

            fetch("{{ url('/profile/simpan-artikel') }}/" + id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                let icon = document.querySelector('#btnSaveArticle i');
                let text = document.querySelector('#saveText');
                if(data.status === 'saved') {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    text.textContent = 'Saved';
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    text.textContent = 'Save';
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
    @endpush
