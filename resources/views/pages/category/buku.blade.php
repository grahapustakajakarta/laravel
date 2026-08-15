@extends('layouts.app')

@push('styles')
<style>
    /* ─── BOOK CATEGORY STYLES ─── */
    #book-category {
        padding: 60px 5%;
        background-color: #fff;
    }
    
    /* TOP SECTION: FEATURED (LEFT) & CRITIC (RIGHT) */
    #book-category .top-section {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 60px;
        margin-bottom: 60px;
        padding-bottom: 60px;
        border-bottom: 1px solid #eee;
        align-items: start;
    }
    
    /* FEATURED BOOK (LEFT) */
    #book-category .featured-book {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 40px;
        align-items: center;
    }
    
    #book-category .featured-book .cover-wrapper {
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border-radius: 4px;
        overflow: hidden;
        transition: transform 0.4s ease;
    }
    
    #book-category .featured-book .cover-wrapper:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 45px rgba(0,0,0,0.15);
    }
    
    #book-category .featured-book img {
        width: 100%;
        height: auto;
        display: block;
        background-color: #f9f9f9;
    }
    
    #book-category .featured-book .info-wrapper h1 {
        font-family: var(--font-sans);
        font-size: 13px;
        font-weight: bold;
        color: #e03a3c;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 15px;
    }
    
    #book-category .featured-book .info-wrapper h2 {
        font-family: var(--font-serif);
        font-size: 38px;
        font-weight: 700;
        line-height: 1.15;
        color: #111;
        margin-bottom: 20px;
    }
    
    #book-category .featured-book .info-wrapper p {
        font-family: var(--font-serif);
        font-size: 18px;
        color: #555;
        margin-bottom: 30px;
        line-height: 1.6;
    }
    
    #book-category .featured-book .info-wrapper .btn-read {
        display: inline-block;
        padding: 12px 28px;
        background-color: #111;
        color: #fff;
        font-family: var(--font-sans);
        font-size: 13px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-decoration: none;
        border-radius: 40px;
        transition: background 0.3s;
    }
    
    #book-category .featured-book .info-wrapper .btn-read:hover {
        background-color: #e03a3c;
    }
    
    #book-category .top-right-list {
        display: flex;
        flex-direction: column;
        gap: 35px; /* Dikurangi agar tidak kepanjangan */
    }
    
    #book-category .top-right-item {
        display: flex;
        flex-direction: row; /* Bentuk baris (horizontal) */
        gap: 20px;
        align-items: center;
        text-decoration: none;
        color: #111;
        transition: transform 0.3s ease;
    }
    
    #book-category .top-right-item:hover {
        transform: translateX(5px);
    }
    
    #book-category .top-right-item .number {
        font-family: var(--font-serif);
        font-size: 90px; /* Dikecilkan sedikit */
        font-weight: bold;
        color: #111;
        line-height: 0.8;
        flex: 0 0 60px;
        text-align: center;
        border-right: 1px solid #ddd;
        padding-right: 20px;
    }
    
    #book-category .top-right-item .cover {
        flex: 0 0 85px; /* Dikecilkan sedikit */
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border-radius: 0; /* Hapus border radius */
        overflow: hidden;
        background-color: #f9f9f9;
    }
    
    #book-category .top-right-item .cover img {
        width: 100%;
        height: auto;
        display: block;
    }
    
    #book-category .top-right-item .info h3 {
        font-family: var(--font-serif);
        font-size: 18px; /* Kembali ke standar */
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 8px;
        color: #111;
    }
    
    #book-category .top-right-item .info p {
        font-family: var(--font-sans);
        font-size: 13px;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* SECONDARY BOOKS (THE CRITIC 4 COLUMNS) */
    #book-category .secondary-books {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* 4 kolom */
        gap: 30px;
        margin-bottom: 80px;
        align-items: start;
        padding: 0; 
    }

    
    /* ALL STORIES (BOTTOM) */
    .section-title {
        font-family: var(--font-sans);
        font-size: 16px;
        font-weight: bold;
        color: #111;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 40px;
        border-bottom: 2px solid #111;
        padding-bottom: 10px;
        display: inline-block;
    }
    
    #book-category .slider-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 25px;
        align-items: start;
        padding: 0;
    }
    
    #book-category .book-card {
        text-decoration: none;
        color: #111;
        display: block;
        transition: transform 0.3s ease;
    }
    
    #book-category .book-card:hover {
        transform: translateY(-6px);
    }
    
    #book-category .book-card .cover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 20px;
        background-color: #f9f9f9;
    }
    
    #book-category .book-card .cover img {
        width: 100%;
        height: auto;
        display: block;
    }
    
    #book-category .book-card h3 {
        font-family: var(--font-serif);
        font-size: 18px;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 8px;
        color: #111;
    }
    
    #book-category .book-card p {
        font-family: var(--font-sans);
        font-size: 13px;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    /* ─── PAGINATION STYLES ─── */
    .cat-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        padding: 50px 0 20px;
        border-top: 1px solid #eee;
        margin-top: 40px;
    }
    .cat-page-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: var(--font-sans);
        font-size: 0.85rem;
        font-weight: bold;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #111;
        text-decoration: none;
        background: none;
        border: none;
        border-bottom: 2px solid #111;
        padding: 0 0 2px 0;
        cursor: pointer;
        transition: color 0.2s, border-color 0.2s;
    }
    .cat-page-btn:hover {
        color: #e03a3c;
        border-color: #e03a3c;
        text-decoration: none;
    }
    .cat-page-btn.disabled {
        color: #ccc;
        border-color: #eee;
        pointer-events: none;
        cursor: default;
    }
    .cat-page-info {
        font-family: var(--font-sans);
        font-size: 0.8rem;
        color: #888;
    }
    
        @media (max-width: 992px) {
        #book-category .top-section {
            grid-template-columns: 1fr;
        }
        #book-category .featured-book {
            grid-template-columns: 1fr 1fr;
        }
        #book-category .top-right-list {
            flex-direction: row;
            overflow-x: auto;
        }
        #book-category .top-right-item {
            flex: 0 0 300px;
        }
        #book-category .secondary-books {
            grid-template-columns: repeat(2, 1fr);
        }
        #book-category .slider-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        #book-category {
            padding: 40px 15px;
        }
        #book-category .featured-book {
            grid-template-columns: 1fr;
            text-align: center;
        }
        #book-category .featured-book .cover-wrapper {
            max-width: 300px;
            margin: 0 auto;
        }
        #book-category .top-right-list {
            flex-direction: column;
        }
        #book-category .top-right-item {
            flex: 0 0 auto;
        }
        #book-category .secondary-books {
            grid-template-columns: repeat(2, 1fr);
            max-width: 100%;
            margin: 0 auto;
            gap: 15px;
        }
        #book-category .slider-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            overflow: hidden;
        }
        #book-category .book-card:nth-child(5) {
            display: none;
        }
        #book-category .book-card .cover img {
            aspect-ratio: 3/4;
            object-fit: contain;
            width: 100%;
            background-color: #f9f9f9;
        }
        #book-category .book-card h3 {
            font-size: 11px;
            line-height: 1.3;
            margin-bottom: 3px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        #book-category .book-card p {
            font-size: 9px;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }
    
    @media (max-width: 480px) {
        #book-category .slider-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 6px;
        }
    }
</style>
@endpush

@section('content')
<section id="book-category">
    <div class="container">
        
        <div class="top-section">
            <!-- FEATURED BOOK (LEFT) -->
            <div class="featured-left">
                @foreach ($head as $row_head)
                <div class="featured-book">
                    <div class="cover-wrapper">
                        <a href="{{ url('/artikel/'.$row_head->slug) }}">
                            <img src="{{ asset('img/'.$row_head->gambar_pertama) }}" alt="{{ $row_head->judul }}">
                        </a>
                    </div>
                    <div class="info-wrapper">
                        <h1 class="news">BUKU</h1>
                        <a href="{{ url('/artikel/'.$row_head->slug) }}" style="text-decoration: none;">
                            <h2>{{ $row_head->judul }}</h2>
                        </a>
                        <p>{{ Str::limit(strip_tags($row_head->sinopsis), 200) }}</p>
                        <a href="{{ url('/artikel/'.$row_head->slug) }}" class="btn-read">Baca Artikel</a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- 3 BOOKS (RIGHT) -->
            <div class="top-right-section">
                <div class="top-right-list">
                    @foreach ($footer->take(3) as $row_top_right)
                        <a href="{{ url('/artikel/'.$row_top_right->slug) }}" class="top-right-item">
                            <div class="number">{{ $loop->iteration }}</div>
                            <div class="cover">
                                <img src="{{ asset('img/'.$row_top_right->gambar_pertama) }}" alt="{{ $row_top_right->judul }}">
                            </div>
                            <div class="info">
                                <h3>{{ Str::limit($row_top_right->judul, 60) }}</h3>
                                <p>{{ $row_top_right->penulis->nama ?? 'Editorial Team' }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- THE CRITIC (4 COLUMNS) -->
        <div class="section-title">THE CRITIC</div>
        <div class="secondary-books">
            @foreach ($body->take(4) as $row_body)
                <a href="{{ url('/artikel/'.$row_body->slug) }}" class="book-card">
                    <div class="cover">
                        <img src="{{ asset('img/'.$row_body->gambar_pertama) }}" alt="{{ $row_body->judul }}">
                    </div>
                    <h3>{{ $row_body->judul }}</h3>
                    <p>{{ $row_body->penulis->nama ?? 'Editorial Team' }}</p>
                </a>
            @endforeach
        </div>

        <!-- ALL STORIES (FOOTER SLIDER) -->
        <div class="section-title">ALL STORIES</div>
        <div id="cat-slider-container">
            <div class="cat-slider-viewport" style="overflow: hidden; width: 100%;">
                <div class="cat-slider-track" id="cat-slider-track" style="display: flex; transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1); width: 100%;">
                    @php $chunks = $footer->chunk(5); @endphp
                    @foreach($chunks as $chunk)
                    <div class="cat-slide" style="flex: 0 0 100%; width: 100%;">
                        <div class="slider-grid">
                            @foreach ($chunk as $row_footer)
                                <a href="{{ url('/artikel/'.$row_footer->slug) }}" class="book-card">
                                    <div class="cover">
                                        <img src="{{ asset('img/'.$row_footer->gambar_pertama) }}" alt="{{ $row_footer->judul }}">
                                    </div>
                                    <h3>{{ $row_footer->judul }}</h3>
                                    <p>{{ $row_footer->penulis->nama ?? 'Editorial Team' }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- JS PAGINATION --}}
            <div class="cat-pagination">
                <button class="cat-page-btn disabled" id="cat-prev">← Sebelumnya</button>
                <span class="cat-page-info" id="cat-info">Halaman 1 / {{ $chunks->count() ?: 1 }}</span>
                <button class="cat-page-btn" id="cat-next">Selanjutnya →</button>
            </div>
        </div>

    </div>
</section>
@endsection

@push('scripts')
<script>
    const sliderTrack = document.getElementById('cat-slider-track');
    const btnPrev = document.getElementById('cat-prev');
    const btnNext = document.getElementById('cat-next');
    const sliderInfo = document.getElementById('cat-info');
    
    if (sliderTrack && btnPrev && btnNext) {
        let currentSlide = 0;
        const totalSlides = {{ isset($chunks) ? ($chunks->count() ?: 1) : 1 }};

        function updateSlider() {
            sliderTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
            sliderInfo.textContent = `Halaman ${currentSlide + 1} / ${totalSlides}`;
            
            if (currentSlide === 0) btnPrev.classList.add('disabled');
            else btnPrev.classList.remove('disabled');
            
            if (currentSlide === totalSlides - 1 || totalSlides <= 1) btnNext.classList.add('disabled');
            else btnNext.classList.remove('disabled');
            
            const sliderTop = document.getElementById('cat-slider-container').getBoundingClientRect().top + window.scrollY - 100;
            window.scrollTo({ top: sliderTop, behavior: 'smooth' });
        }

        btnNext.addEventListener('click', () => {
            if (currentSlide < totalSlides - 1) {
                currentSlide++;
                updateSlider();
            }
        });

        btnPrev.addEventListener('click', () => {
            if (currentSlide > 0) {
                currentSlide--;
                updateSlider();
            }
        });
    }
</script>
@endpush
