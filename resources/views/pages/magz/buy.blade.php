@extends('layouts.app')

@section('content')
<style>
    /* Scope Styles to prevent conflict with global layout */
    #magz-beli-scope {
        font-family: "Open Sans", sans-serif;
        background-color: #ffffff;
        color: #111111;
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
        text-align: left;
    }

    #magz-beli-scope * {
        box-sizing: border-box;
    }

    #magz-beli-scope .magz-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 30px;
        width: 100%;
    }

    /* --- BREADCRUMB --- */
    #magz-beli-scope .breadcrumb {
        font-family: "Open Sans", sans-serif !important;
        font-size: 11px !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 50px !important;
        color: #000 !important;
        background: none !important;
        padding: 0 !important;
    }

    #magz-beli-scope .breadcrumb a {
        color: #000;
        text-decoration: none;
        transition: color 0.2s;
    }
    #magz-beli-scope .breadcrumb a:hover {
        color: #e31837;
    }

    #magz-beli-scope .breadcrumb span {
        color: #555 !important;
    }

    /* --- TATA LETAK UTAMA (2 KOLOM) --- */
    #magz-beli-scope .product-layout {
        display: flex;
        gap: 60px;
        align-items: flex-start;
    }

    /* -----------------------------------------------------------
       PERBAIKAN EKSTRIM BAGIAN GAMBAR UTAMA (MENGHILANGKAN BOX)
       ----------------------------------------------------------- */
    
    #magz-beli-scope .product-image-container {
        flex: 0 0 340px;
        /* Memaksa kontainer benar-benar transparan tanpa efek bawaan */
        background: transparent !important;
        background-color: transparent !important;
        padding: 0 !important;
        margin: 0 !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }

    #magz-beli-scope .product-image {
        width: 100%;
        height: auto;
        display: block !important;
        
        /* RESET GAYA GLOBAL: Memaksa hilang padding dan background putih dari layouts.app */
        background: transparent !important;
        background-color: transparent !important;
        padding: 0 !important;
        border: none !important;
        outline: none !important;
        margin: 0 !important;
        
        /* Shadow estetis langsung melekat di ujung gambar */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25) !important;
        border-radius: 2px !important; /* Opsional: beri 0 jika ingin sudut lancip 100% */
    }

    /* ----------------------------------------------------------- */

    /* Kolom Kanan: Detail */
    #magz-beli-scope .product-details {
        flex: 1;
        padding-top: 10px;
    }

    #magz-beli-scope .product-title {
        font-family: "Crimson Text", serif !important;
        font-size: 32px !important;
        font-weight: 400 !important;
        color: #1a1a1a !important;
        margin-bottom: 2px !important;
        margin-top: 0 !important;
        line-height: 1.2;
    }

    #magz-beli-scope .product-author {
        font-family: "Open Sans", sans-serif !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #888888 !important; 
        margin-bottom: 25px !important;
        margin-left: 1px; /* Slight optical adjustment if needed, usually 0 is fine */
    }

    /* Harga & SKU */
    #magz-beli-scope .price-sku-row {
        display: flex;
        align-items: baseline;
        gap: 15px;
        margin-bottom: 30px;
    }

    #magz-beli-scope .product-price {
        font-family: "Open Sans", sans-serif !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #e31837; 
    }

    /* Garis Pembatas */
    #magz-beli-scope .divider {
        border: none;
        border-top: 1px solid #e0e0e0;
        margin-bottom: 30px;
    }

    /* Tombol BAYAR */
    #magz-beli-scope .btn-bayar {
        display: inline-block;
        background-color: #e31837; 
        color: #ffffff !important;
        border: none;
        padding: 12px 24px;
        font-family: "Open Sans", sans-serif !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        border-radius: 0;
        box-shadow: 0 4px 12px rgba(227, 24, 55, 0.25); /* Shadow tipis kemerahan */
        margin-bottom: 35px;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
    }

    #magz-beli-scope .btn-bayar:hover {
        background-color: #c4122d;
        box-shadow: 0 6px 16px rgba(227, 24, 55, 0.4);
        transform: translateY(-2px);
    }

    /* Deskripsi */
    #magz-beli-scope .product-description {
        font-family: "Crimson Text", serif !important;
        font-size: 16px !important;
        line-height: 1.45 !important;
        color: #555555 !important;
        margin-top: 10px !important;
    }
    
    #magz-beli-scope .product-description br + br {
        display: block;
        content: "";
        margin-top: -10px;
    }

    /* --- RECOMMENDATION SECTION (You May Also Like) --- */
    #magz-beli-scope .recommendation-section {
        margin-top: 80px;
        border-top: 1px solid #eaeaea;
        padding-top: 60px;
        padding-bottom: 40px;
    }
    
    #magz-beli-scope .section-title {
        font-family: "Crimson Text", serif !important;
        font-size: 24px;
        color: #111;
        text-align: center;
        margin-bottom: 40px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    #magz-beli-scope .carousel-wrapper {
        position: relative;
    }

    #magz-beli-scope .carousel {
        display: flex;
        gap: 24px;
        overflow-x: auto;
        padding: 10px 5px;
        scroll-behavior: smooth;
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    #magz-beli-scope .carousel::-webkit-scrollbar {
        display: none;
    }

    #magz-beli-scope .book-card {
        flex: 0 0 calc(20% - 20px);
        min-width: 140px;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s;
        cursor: pointer;
    }
    #magz-beli-scope .book-card:hover {
        transform: translateY(-5px);
    }
    
    /* Hapus juga background bawaan dari gambar carousel jika ada */
    #magz-beli-scope .book-card-image {
        width: 100%;
        aspect-ratio: 2/3;
        margin-bottom: 16px;
        background: transparent !important;
    }
    #magz-beli-scope .book-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        border-radius: 2px;
        background: transparent !important;
        padding: 0 !important;
        border: none !important;
    }
    
    #magz-beli-scope .book-card-author {
        font-family: "Open Sans", sans-serif !important;
        font-size: 0.8rem;
        color: #777;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 4px;
    }
    #magz-beli-scope .book-card-title {
        font-family: "Crimson Text", serif !important;
        font-size: 1.1rem !important;
        color: #111;
        margin-bottom: 8px !important;
        line-height: 1.3;
        font-weight: 400 !important;
    }
    #magz-beli-scope .book-card-price {
        font-family: "Open Sans", sans-serif !important;
        font-weight: 600;
        color: #111;
        font-size: 0.95rem;
        margin-top: auto;
    }
    
    /* Navigation Buttons */
    #magz-beli-scope .carousel-nav-left,
    #magz-beli-scope .carousel-nav-right {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: background-color 0.2s;
    }
    #magz-beli-scope .carousel-nav-left:hover,
    #magz-beli-scope .carousel-nav-right:hover {
        background-color: #f0f0f0;
    }
    #magz-beli-scope .carousel-nav-left { left: -15px; }
    #magz-beli-scope .carousel-nav-right { right: -15px; }

    /* --- RESPONSIVITAS UNTUK MOBILE --- */
    @media (max-width: 768px) {
        #magz-beli-scope .product-layout {
            flex-direction: column;
            gap: 40px;
        }
        #magz-beli-scope .product-image-container {
            flex: auto;
            width: 100%;
            max-width: 400px;
            margin: 0 auto !important;
        }
        #magz-beli-scope .price-sku-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        #magz-beli-scope .book-card {
            flex: 0 0 calc(45% - 12px);
            min-width: 110px;
        }
    }
</style>

<div id="magz-beli-scope">
    <div class="magz-container">
      <nav class="breadcrumb">
        <a href="{{ url('/') }}">HOME</a> / <a href="{{ route('magz.index') }}">Magazine</a> / <span>{{ strtoupper($magz->judul) }}</span>
      </nav>

      <div class="product-layout">
        <div class="product-image-container">
          @if($magz->cover_gambar)
          <img
            src="{{ asset('img/' . $magz->cover_gambar) }}"
            alt="{{ $magz->judul }} Cover"
            class="product-image"
          />
          @else
          <img
            src="https://picsum.photos/seed/{{ $magz->id }}/400/550"
            alt="{{ $magz->judul }} Cover"
            class="product-image"
          />
          @endif
        </div>

        <div class="product-details">
          <h1 class="product-title">{{ $magz->judul }}</h1>
          @if($magz->penulis)
              <div class="product-author">By {{ $magz->penulis }}</div>
          @endif

          <div class="price-sku-row">
            @if($magz->harga > 0)
            <div class="product-price">Rp {{ number_format($magz->harga, 0, ',', '.') }}</div>
            @else
            <div class="product-price" style="color: #28a745;">Gratis</div>
            @endif
          </div>

          <hr class="divider" />

          @if(isset($hasAccess) && $hasAccess)
              <a href="{{ route('magz.baca', $magz->slug) }}" class="btn-bayar" style="margin-bottom: 15px; display: inline-block; text-align: center; text-decoration: none; background-color: #111; color: #fff; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#333'" onmouseout="this.style.backgroundColor='#111'">UNDUH <i class="fas fa-arrow-down" style="font-size: 0.9rem; margin-left: 5px;"></i></a>
          @elseif(isset($snapToken))
              <button id="pay-button" class="btn-bayar" style="margin-bottom: 15px; background-color: #007bff;">SELESAIKAN PEMBAYARAN</button>
          @else
              <div style="display: flex; gap: 12px; align-items: stretch; margin-bottom: 15px;">
                  <form action="{{ route('magz.bayar', $magz->slug) }}" method="POST" style="margin: 0;">
                      @csrf
                      <button type="submit" class="btn-bayar" style="margin-bottom: 0; height: 100%;">BAYAR</button>
                  </form>
                  
                  @php
                      $inCart = false;
                      if(Auth::guard('pengguna')->check()) {
                          $inCart = \App\Models\CartItem::where('pengguna_id', Auth::guard('pengguna')->id())
                              ->where('item_type', 'magz')
                              ->where('item_id', $magz->id)
                              ->exists();
                      }
                  @endphp
                  <button
                      type="button"
                      onclick="addToCart('magz', {{ $magz->id }})"
                      id="btn-cart-magz-{{ $magz->id }}"
                      style="background:{{ $inCart ? '#ffebee' : '#fff' }};color:{{ $inCart ? '#dc3545' : '#111' }};border:1.5px solid {{ $inCart ? '#ef9a9a' : '#111' }};cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:8px; font-weight:700; font-family:'Open Sans',sans-serif; font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0 24px; transition:all 0.3s ease; box-shadow:0 4px 12px rgba(0,0,0,0.08); border-radius:0; height: 100%; min-height: 40px;">
                      <i class="fas fa-shopping-cart" style="font-size: 0.9rem;"></i> <span class="cart-text">{{ $inCart ? 'Hapus dari Keranjang' : 'Keranjang' }}</span>
                  </button>
              </div>
          @endif

          <div class="product-description">
            @foreach(explode("\n", str_replace("\r", "", $magz->deskripsi ?? 'Belum ada deskripsi.')) as $paragraph)
                @if(trim($paragraph) !== '')
                    <p style="margin-top: 0; margin-bottom: 8px;">{{ $paragraph }}</p>
                @endif
            @endforeach
          </div>
        </div>
      </div>
      
      <!-- BAGIAN BAWAH: REKOMENDASI (YOU MAY ALSO LIKE) -->
      <section class="recommendation-section">
          <h2 class="section-title">You May Also Like</h2>
          
          <div class="carousel-wrapper">
              <div class="carousel-nav-left" id="recNavLeft">
                  <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                      <polyline points="15 18 9 12 15 6"></polyline>
                  </svg>
              </div>

              <div class="carousel" id="recCarousel">
                  @foreach(\App\Models\Magz::where('id', '!=', $magz->id)->inRandomOrder()->limit(12)->get() as $rec)
                  <div class="book-card" onclick="window.location='{{ route('magz.preview', $rec->slug) }}'">
                      <div class="book-card-image">
                          @if($rec->cover_gambar)
                          <img src="{{ asset('img/' . $rec->cover_gambar) }}" alt="{{ $rec->judul }}">
                          @else
                          <img src="https://picsum.photos/seed/{{ $rec->id }}/200/300" alt="{{ $rec->judul }}">
                          @endif
                      </div>
                      <p class="book-card-author">{{ $rec->kategori ?? 'Magazine' }}</p>
                      <h3 class="book-card-title">{{ Str::limit($rec->judul, 35) }}</h3>
                      
                      @if($rec->harga > 0)
                      <p class="book-card-price">Rp {{ number_format($rec->harga, 0, ',', '.') }}</p>
                      @else
                      <p class="book-card-price" style="color: #28a745;">Gratis</p>
                      @endif
                  </div>
                  @endforeach
              </div>

              <div class="carousel-nav-right" id="recNavRight">
                  <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                      <polyline points="9 18 15 12 9 6"></polyline>
                  </svg>
              </div>
          </div>
      </section>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const recCarousel = document.getElementById('recCarousel');
        const recNavLeft = document.getElementById('recNavLeft');
        const recNavRight = document.getElementById('recNavRight');

        if (recCarousel && recNavLeft && recNavRight) {
            recNavRight.addEventListener('click', () => {
                recCarousel.scrollBy({ left: recCarousel.offsetWidth / 2, behavior: 'smooth' });
            });
            recNavLeft.addEventListener('click', () => {
                recCarousel.scrollBy({ left: -(recCarousel.offsetWidth / 2), behavior: 'smooth' });
            });
            
            const toggleNavButtons = () => {
                recNavLeft.style.display = recCarousel.scrollLeft > 0 ? 'flex' : 'none';
                const isEnd = recCarousel.scrollLeft + recCarousel.offsetWidth >= recCarousel.scrollWidth - 1;
                recNavRight.style.display = isEnd ? 'none' : 'flex';
            };
            
            recCarousel.addEventListener('scroll', toggleNavButtons);
            window.addEventListener('resize', toggleNavButtons);
            
            setTimeout(toggleNavButtons, 300); 
        }
    });

    function addToCart(itemType, itemId) {
        const btn = document.getElementById('btn-cart-' + itemType + '-' + itemId);
        if (btn) {
            btn.disabled = true;
            let isRemoving = btn.textContent.includes('Hapus');
            btn.querySelector('.cart-text').innerHTML = isRemoving ? 'Menghapus...' : 'Menambahkan...';
            btn.style.transform = 'scale(0.95)';
        }

        fetch('/keranjang/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify({ item_type: itemType, item_id: itemId })
        })
        .then(r => {
            if (r.status === 401) {
                window.location = '/signin';
                return null;
            }
            return r.json();
        })
        .then(data => {
            if (!data) return;
            if (btn) {
                btn.disabled = false;
                btn.style.transform = 'scale(1)';
            }
            
            if (data.status === 'success') {
                if (data.action === 'added') {
                    if (btn) {
                        btn.querySelector('.cart-text').innerHTML = 'Hapus dari Keranjang';
                        btn.style.background = '#ffebee';
                        btn.style.color = '#dc3545';
                        btn.style.borderColor = '#ef9a9a';
                    }
                } else if (data.action === 'removed') {
                    if (btn) {
                        btn.querySelector('.cart-text').innerHTML = 'Keranjang';
                        btn.style.background = '#fff';
                        btn.style.color = '#111';
                        btn.style.borderColor = '#111';
                    }
                }
                
                // Update cart badge if exists
                let b = document.getElementById('cart-badge');
                if (b) {
                    b.innerHTML = data.cartCount > 99 ? '99+' : data.cartCount;
                    b.style.display = data.cartCount > 0 ? 'flex' : 'none';
                }
                
            } else if (data.status === 'owned') {
                if (btn) { btn.querySelector('.cart-text').innerHTML = 'Dimiliki'; btn.disabled = true; }
                setTimeout(() => { window.location.reload(); }, 800);
            } else {
                if (btn) { btn.querySelector('.cart-text').innerHTML = 'Keranjang'; }
            }
        })
        .catch(() => {
            if (btn) { 
                btn.disabled = false; 
                btn.style.transform = 'scale(1)';
                btn.querySelector('.cart-text').innerHTML = 'Keranjang'; 
            }
        });
    }
</script>

@if(isset($snapToken))
<script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                alert("Pembayaran berhasil!");
                window.location.href = "{{ route('magz.beli', $magz->slug) }}?order_id=" + result.order_id + "&transaction_status=" + result.transaction_status;
            },
            onPending: function(result){
                alert("Menunggu pembayaran Anda!");
            },
            onError: function(result){
                alert("Pembayaran gagal!");
            },
            onClose: function(){
                console.log('Customer closed the popup without finishing the payment');
            }
        });
    };
    
    // Auto-trigger if we just redirected here
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById('pay-button').click();
    });
</script>
@endif

@endsection
