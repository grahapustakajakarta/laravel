@extends('layouts.app')

@push('styles')
<style>
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
    .cat-page-btn:hover { color: #e03a3c; border-color: #e03a3c; text-decoration: none; }
    .cat-page-btn.disabled { color: #ccc; border-color: #eee; pointer-events: none; cursor: default; }
    .cat-page-info { font-family: var(--font-sans); font-size: 0.8rem; color: #888; }

    /* existing fiksi overrides */
    #fiksinpuisi .body .content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 24px 0;
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }
    #fiksinpuisi .body .content .desc { width: 65%; }
    #fiksinpuisi .body .content img { width: 200px; height: 150px; object-fit: cover; flex-shrink: 0; }
    #fiksinpuisi .body .iklan img { width: 100%; height: auto; }
</style>
@endpush

@section('content')
<section id="fiksinpuisi">
    <div class="container">
        <div class="head">
            <div class="slider2">
                @foreach ($head as $row_head)
                    <div class="img" style="background:url('{{ asset('img/'.$row_head->gambar_pertama) }}');background-size:cover;background-position:center;"></div>
                @endforeach
            </div>
            <div class="desc">
                <ul>
                    @foreach ($head as $row_head)
                        <li>
                            <h3><a class="h3puisi" href="">{{ $rubrikNama }}</a></h3>
                            <p><a href="{{ url('/artikel/'.$row_head->slug) }}">{{ $row_head->judul }}</a></p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="body">
            <div class="isi">
                <div class="row">
                    <h3 style="font-family: var(--font-serif);">ALL STORIES</h3>
                </div>
                <div class="row">
                    <div class="artikel">
                        <div class="fiksi-slider-viewport" style="overflow: hidden; width: 100%;">
                            <div class="fiksi-slider-track" id="fiksi-slider-track" style="display: flex; transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1); width: 100%;">
                                @php $chunks = $body->chunk(5); @endphp
                                @foreach($chunks as $chunk)
                                <div class="fiksi-slide" style="flex: 0 0 100%; width: 100%;">
                                    @foreach ($chunk as $row_body)
                                        <div class="content border">
                                            <div class="desc">
                                                <h1>{{ strtoupper($rubrikNama) }}</h1>
                                                <h3><a href="{{ url('/artikel/'.$row_body->slug) }}">{{ $row_body->judul }}</a></h3>
                                                <p><a href="{{ url('/artikel/'.$row_body->slug) }}">{{ Str::limit(strip_tags($row_body->sinopsis), 120) }}</a></p>
                                            </div>
                                            <img src="{{ asset('img/'.$row_body->gambar_pertama) }}" style="object-fit: cover;" alt="{{ $row_body->judul }}">
                                        </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- JS PAGINATION --}}
                        @if($chunks->count() > 1)
                        <div class="cat-pagination">
                            <button class="cat-page-btn disabled" id="fiksi-prev">← Sebelumnya</button>
                            <span class="cat-page-info" id="fiksi-info">Halaman 1 / {{ $chunks->count() }}</span>
                            <button class="cat-page-btn" id="fiksi-next">Selanjutnya →</button>
                        </div>
                        @endif

                    </div>
                    <div class="iklan">
                        <img src="{{ asset('img/a1.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const li = document.querySelectorAll("#fiksinpuisi .container .head .desc ul li");
    const imgfnp = document.querySelectorAll("#fiksinpuisi .container .head .slider2 .img");

    if(li.length > 0 && imgfnp.length > 0) {
        li.forEach((item, index) => {
            item.addEventListener('mouseover', function () {
                imgfnp.forEach((img, i) => {
                    if (i === index) {
                        img.style.opacity = "100";
                        if(li[i]) li[i].classList.add("lihover");
                    } else {
                        img.style.opacity = "0";
                        if(li[i]) li[i].classList.remove("lihover");
                    }
                });
            });
        });

        function lfnp() {
            if(imgfnp[0]) imgfnp[0].style.opacity = "100";
            if(li[0]) li[0].classList.add("lihover");
            setTimeout(function () {
                if(imgfnp[0]) imgfnp[0].style.opacity = "0";
                if(imgfnp[1]) imgfnp[1].style.opacity = "100";
                if(li[0]) li[0].classList.remove("lihover");
                if(li[1]) li[1].classList.add("lihover");
            }, 5000);
            setTimeout(function () {
                if(imgfnp[1]) imgfnp[1].style.opacity = "0";
                if(imgfnp[2]) imgfnp[2].style.opacity = "100";
                if(li[1]) li[1].classList.remove("lihover");
                if(li[2]) li[2].classList.add("lihover");
            }, 10000);
            setTimeout(function () {
                if(imgfnp[2]) imgfnp[2].style.opacity = "0";
                if(imgfnp[0]) imgfnp[0].style.opacity = "100";
                if(li[2]) li[2].classList.remove("lihover");
                if(li[0]) li[0].classList.add("lihover");
            }, 15000);
        }
        setInterval(lfnp, 15000);
        lfnp();
    }

    // Fiksi List JS Slider Logic
    const fiksiTrack = document.getElementById('fiksi-slider-track');
    const fiksiPrev = document.getElementById('fiksi-prev');
    const fiksiNext = document.getElementById('fiksi-next');
    const fiksiInfo = document.getElementById('fiksi-info');
    
    if (fiksiTrack && fiksiPrev && fiksiNext) {
        let currentSlide = 0;
        const totalSlides = {{ isset($chunks) ? $chunks->count() : 1 }};

        function updateSlider() {
            // Geser track ke kiri berdasarkan persentase
            fiksiTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            // Update teks halaman
            fiksiInfo.textContent = `Halaman ${currentSlide + 1} / ${totalSlides}`;
            
            // Atur tombol prev
            if (currentSlide === 0) fiksiPrev.classList.add('disabled');
            else fiksiPrev.classList.remove('disabled');
            
            // Atur tombol next
            if (currentSlide === totalSlides - 1) fiksiNext.classList.add('disabled');
            else fiksiNext.classList.remove('disabled');
            
            // Scroll sedikit ke atas agar list artikel baru terlihat (opsional)
            const sliderTop = document.querySelector('.isi .row:nth-child(1)').getBoundingClientRect().top + window.scrollY - 120;
            window.scrollTo({ top: sliderTop, behavior: 'smooth' });
        }

        fiksiNext.addEventListener('click', () => {
            if (currentSlide < totalSlides - 1) {
                currentSlide++;
                updateSlider();
            }
        });

        fiksiPrev.addEventListener('click', () => {
            if (currentSlide > 0) {
                currentSlide--;
                updateSlider();
            }
        });
    }
</script>
@endpush
