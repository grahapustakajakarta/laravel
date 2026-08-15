@extends('layouts.app')

@push('styles')
<style>
    /* ── Samakan font & style dengan fiksi.blade.php ── */
    #knkhead .container .row:nth-child(2) .col:first-child .news {
        font-family: var(--font-sans);
        font-size: 13px;
        font-weight: bold;
        color: #e03a3c;
        text-transform: uppercase;
    }
    #knkhead .container .row:nth-child(2) .col:first-child .title {
        font-family: var(--font-serif);
        font-size: 30px;
        font-weight: bold;
    }
    #knkhead .container .row:nth-child(2) .col:nth-child(2) .bungkusContent .content .desc h2 {
        font-family: var(--font-serif);
        font-size: 16px;
        font-weight: 700;
    }
    #knkhead .container .row:nth-child(3) .col:first-child .stori .desc h3 {
        font-family: var(--font-serif);
        font-size: 25px;
    }
    #knkhead .container .row:nth-child(3) .col:first-child .stori .desc p.p {
        font-family: var(--font-sans);
        font-size: 17px;
        color: #101010be;
    }
    #knkhead .container .row:nth-child(3) .col:first-child .stori .desc .detail p {
        font-family: var(--font-sans);
        font-size: 13px;
        font-weight: bold;
        text-transform: uppercase;
    }

    /* ─── PAGINATION ─── */
    .cat-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        padding: 40px 0 20px;
        border-top: 1px solid #eee;
        margin-top: 20px;
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
    /* ????????? CAT META INFO ????????? */
    .cat-meta {
        font-family: var(--font-sans);
        font-size: 0.8rem;
        color: #777;
        margin-top: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        width: 100%;
        text-align: left;
    }
    .cat-meta strong {
        color: #111;
        font-weight: 700;
    }
    .cat-meta .divider {
        color: #e03a3c;
        margin: 0 6px;
    }
</style>
@endpush

@section('content')
<section id="knkhead">
    <div class="container">
        <div class="judul" style="display: none;"></div>
        <div class="row">
            <div class="col">
                @foreach ($head as $row_head)
                    <div class="img" style="background: url('{{ asset('img/'.$row_head->gambar_pertama) }}');background-size:cover;background-position:center;">
                      <a href="{{ url('/artikel/'.$row_head->slug) }}"></a>
                    </div>
                    <h1 class="news">{{ strtoupper($rubrikNama) }}</h1>
                    <h3 class="title"><a href="{{ url('/artikel/'.$row_head->slug) }}">{{ $row_head->judul }}</a></h3>
                    <p class="cat-meta">{{ \Carbon\Carbon::parse($row_head->created_at)->translatedFormat('d F Y') }}</p>
                @endforeach
            </div>
            
            <div class="col">
                <h3 class="judul2">POPULER</h3>
                <div class="bungkusContent">
                    @foreach ($body as $row_body)
                        <div class="content">
                            <div class="desc">
                                <a href="{{ url('/artikel/'.$row_body->slug) }}" style="text-decoration: none;">
                                    <h2>{{ $row_body->judul }}</h2>
                                </a>
                                <p class="cat-meta" style="margin-top: 6px; font-size: 0.7rem;">{{ \Carbon\Carbon::parse($row_body->created_at)->translatedFormat('d F Y') }}</p>
                            </div>
                            <img src="{{ asset('img/'.$row_body->gambar_pertama) }}" style="object-fit: cover;" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @if(isset($footer) && $footer->count() > 0)
        <div class="row" id="cat-slider-container">
            <div class="col">
                <div class="cat-slider-viewport" style="overflow: hidden; width: 100%;">
                    <div class="cat-slider-track" id="cat-slider-track" style="display: flex; transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1); width: 100%;">
                        @php $chunks = $footer->chunk(5); @endphp
                        @foreach($chunks as $chunk)
                        <div class="cat-slide" style="flex: 0 0 100%; width: 100%;">
                            @foreach ($chunk as $row_footer)
                                <div class="stori">
                                    <a href="{{ url('/artikel/'.$row_footer->slug) }}" style="text-decoration: none;">
                                    <img src="{{ asset('img/'.$row_footer->gambar_pertama) }}" style="object-fit: cover;" alt="">
                                    </a>
                                    <div class="desc">
                                        <a href="{{ url('/artikel/'.$row_footer->slug) }}" style="text-decoration: none;">
                                        <h3>{{ $row_footer->judul }}</h3>
                                        <p class="p">{{ Str::limit(strip_tags($row_footer->sinopsis), 120) }}</p>
                                        </a>
                                        <div class="detail">
                                            <a href="{{ url('/artikel/'.$row_footer->slug) }}" style="text-decoration: none;">
                                            <p>by {{ $row_footer->penulis->nama ?? '-' }}</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- JS PAGINATION --}}
                @if($chunks->count() > 1)
                <div class="cat-pagination">
                    <button class="cat-page-btn disabled" id="cat-prev">← Sebelumnya</button>
                    <span class="cat-page-info" id="cat-info">Halaman 1 / {{ $chunks->count() }}</span>
                    <button class="cat-page-btn" id="cat-next">Selanjutnya →</button>
                </div>
                @endif
            </div>
            <div class="col">
                <img src="{{ asset('img/sidebar.png') }}" alt="">
            </div>
        </div>
        @endif
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
        const totalSlides = {{ isset($chunks) ? $chunks->count() : 1 }};

        function updateSlider() {
            sliderTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
            sliderInfo.textContent = `Halaman ${currentSlide + 1} / ${totalSlides}`;
            
            if (currentSlide === 0) btnPrev.classList.add('disabled');
            else btnPrev.classList.remove('disabled');
            
            if (currentSlide === totalSlides - 1) btnNext.classList.add('disabled');
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
