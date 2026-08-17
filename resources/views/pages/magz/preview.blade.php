@extends('layouts.app')

@section('content')
<style>
    /* Scope Styles to prevent conflict with global layout */
    #magz-preview-scope {
        font-family: "Crimson Text", serif;
        background-color: #ffffff;
        color: #333333;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        text-align: left;
    }

    #magz-preview-scope * {
        box-sizing: border-box;
    }

    #magz-preview-scope .magz-container {
        max-width: 1050px;
        margin: 60px auto;
        padding: 0 30px;
        width: 100%;
    }

    /* Header Utama */
    #magz-preview-scope .main-header {
        border-bottom: 1px solid #c8c8c8;
        padding-bottom: 10px;
        margin-bottom: 45px;
    }

    #magz-preview-scope .main-header h1 {
        font-size: 32px !important;
        font-weight: 400 !important;
        color: #444444 !important;
        letter-spacing: 0.5px;
        margin: 0;
        margin-bottom: 2px !important;
        line-height: 1.2;
    }

    #magz-preview-scope .main-header h1 span {
        color: #a0a0a0 !important;
        font-weight: 400 !important;
    }

    #magz-preview-scope .main-author {
        font-family: "Open Sans", sans-serif !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #c8c8c8 !important; 
        margin-top: 0;
        margin-left: 1px;
    }

    /* Tata Letak Utama (3 Kolom) */
    #magz-preview-scope .content-grid {
        display: grid;
        grid-template-columns: 260px 1fr 280px;
        gap: 50px;
    }

    /* Kolom 1: Gambar Buku */
    #magz-preview-scope .col-image {
        position: relative;
    }

    #magz-preview-scope .book-mockup {
        width: 100%;
        height: auto;
        display: block;
        box-shadow:
          -2px 0px 1px rgba(0, 0, 0, 0.1),
          -5px 5px 10px rgba(0, 0, 0, 0.15),
          -15px 15px 25px rgba(0, 0, 0, 0.25);
    }

    /* Kolom 2: Teks Utama */
    #magz-preview-scope .col-main-text .preview-text {
        font-size: 16px !important;
        line-height: 1.45 !important;
        color: #555555 !important;
        margin-bottom: 10px !important;
        font-family: "Crimson Text", serif !important;
        margin-top: 0;
    }
    #magz-preview-scope .col-main-text p {
        margin-bottom: 8px !important;
        margin-top: 0;
    }
    #magz-preview-scope .col-main-text .preview-text br + br {
        display: block;
        content: "";
        margin-top: -20px;
    }

    #magz-preview-scope .btn-subscribe {
        display: table;
        background-color: #e31837; 
        color: #ffffff !important;
        font-family: "Inter", sans-serif !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 12px 22px;
        border: none;
        cursor: pointer;
        margin-top: 35px;
        text-decoration: none;
        transition: background-color 0.2s;
    }

    #magz-preview-scope .btn-subscribe:hover {
        background-color: #c4122d;
    }

    /* Kolom 3: Sidebar Table of Contents */
    #magz-preview-scope .col-sidebar {
        text-align: left;
    }

    #magz-preview-scope .toc-header {
        font-family: "Inter", sans-serif;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #333;
        border-top: 1.5px solid #222;
        border-bottom: 1px solid #dcdcdc;
        padding: 12px 0;
        margin-bottom: 25px;
    }

    #magz-preview-scope .category-title {
        font-family: "Inter", sans-serif;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #333;
        margin-top: 30px;
        margin-bottom: 12px;
    }

    #magz-preview-scope .toc-list {
        list-style: none;
        padding-left: 0;
        margin: 0;
    }

    #magz-preview-scope .toc-list li {
        font-size: 16px !important;
        line-height: 1.2 !important;
        color: #555555 !important;
        margin-bottom: 6px !important;
        font-family: "Crimson Text", serif !important;
    }

    #magz-preview-scope .toc-list li em {
        font-style: italic;
    }

    /* Media Query Mobile */
    @media (max-width: 768px) {
        #magz-preview-scope .content-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        #magz-preview-scope .col-image {
            max-width: 300px;
            margin: 0 auto;
        }
    }
</style>

<div id="magz-preview-scope">
    <div class="magz-container">
      <div class="main-header">
        <h1>{{ $magz->judul }} @if($magz->edisi)<span>{{ $magz->edisi }}</span>@endif</h1>
        @if($magz->penulis)
            <div class="main-author">By {{ $magz->penulis }}</div>
        @endif
      </div>

      <div class="content-grid">
        <div class="col-image">
          @if($magz->cover_gambar)
          <img
            src="{{ asset('img/' . $magz->cover_gambar) }}"
            alt="{{ $magz->judul }} Cover"
            class="book-mockup"
          />
          @else
          <img
            src="https://picsum.photos/400/600?random={{ $magz->id }}"
            alt="{{ $magz->judul }} Cover"
            class="book-mockup"
          />
          @endif
        </div>

        <div class="col-main-text">
          <div class="preview-text">
            @foreach(explode("\n", str_replace("\r", "", $magz->isi_preview)) as $paragraph)
                @if(trim($paragraph) !== '')
                    <p>{{ $paragraph }}</p>
                @endif
            @endforeach
          </div>

          @if(isset($hasAccess) && $hasAccess)
              <div style="display: flex; gap: 12px; align-items: center; margin-top: 35px;">
                  <a href="{{ route('magz.baca', ['slug' => $magz->slug]) }}" class="btn-subscribe" style="margin-top: 0; background-color: #111; color: #fff; text-decoration: none; display: inline-flex; justify-content: center; align-items: center; gap: 6px; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#333'" onmouseout="this.style.backgroundColor='#111'">UNDUH <i class="fas fa-arrow-down" style="font-size: 0.9rem;"></i></a>
                  @if($magz->file_pdf_preview)
                  <a href="{{ route('magz.preview_pdf', ['slug' => $magz->slug]) }}" target="_blank" class="btn-subscribe" style="margin-top: 0; background-color: transparent; color: #111 !important; border: 1.5px solid #111;">PREVIEW PDF</a>
                  @endif
              </div>
          @else
              <div style="display: flex; gap: 12px; align-items: center; margin-top: 35px;">
                  <a href="{{ route('magz.beli', ['slug' => $magz->slug]) }}" class="btn-subscribe" style="margin-top: 0;">Beli</a>
                  @if($magz->file_pdf_preview)
                  <a href="{{ route('magz.preview_pdf', ['slug' => $magz->slug]) }}" target="_blank" class="btn-subscribe" style="margin-top: 0; background-color: transparent; color: #111 !important; border: 1.5px solid #111;">PREVIEW PDF</a>
                  @endif
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
                      onclick="addToCart('magz', {{ $magz->id }})"
                      id="btn-cart-magz-{{ $magz->id }}"
                      style="background:{{ $inCart ? '#ffebee' : '#fff' }};color:{{ $inCart ? '#dc3545' : '#111' }};border:1.5px solid {{ $inCart ? '#ef9a9a' : '#111' }};cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:8px; font-weight:700; font-family:'Inter',sans-serif; font-size:11px; text-transform:uppercase; letter-spacing:1px; padding:12px 22px; transition:all 0.3s ease; box-shadow:0 4px 15px rgba(0,0,0,0.08);">
                      <i class="fas fa-shopping-cart" style="font-size: 0.9rem;"></i> <span class="cart-text">{{ $inCart ? 'Hapus dari Keranjang' : 'Keranjang' }}</span>
                  </button>
              </div>
          @endif
        </div>

        <aside class="col-sidebar">
          <div class="toc-header">TABLE OF CONTENTS</div>
          @php
            $toc = is_array($magz->table_of_contents) ? $magz->table_of_contents : [];
            
            // Helper function to format line (Author - Title or Author, Title)
            if (!function_exists('formatTocLine')) {
                function formatTocLine($line) {
                    $line = trim($line);
                    if (strpos($line, ' - ') !== false) {
                        $parts = explode(' - ', $line, 2);
                        return e($parts[0]) . ' - <em>' . e($parts[1]) . '</em>';
                    } elseif (strpos($line, ', ') !== false) {
                        $parts = explode(', ', $line, 2);
                        return e($parts[0]) . ', <em>' . e($parts[1]) . '</em>';
                    }
                    return e($line);
                }
            }
          @endphp

          @if(!empty($toc['fiksi']))
          <div class="category-title">FICTION</div>
          <ul class="toc-list">
            @foreach(explode("\n", $toc['fiksi']) as $line)
              @if(trim($line))<li>{!! formatTocLine($line) !!}</li>@endif
            @endforeach
          </ul>
          @endif

          @if(!empty($toc['interview']))
          <div class="category-title">INTERVIEW</div>
          <ul class="toc-list">
            @foreach(explode("\n", $toc['interview']) as $line)
              @if(trim($line))<li>{!! formatTocLine($line) !!}</li>@endif
            @endforeach
          </ul>
          @endif

          @if(!empty($toc['puisi']))
          <div class="category-title">SAJAK & PUISI</div>
          <ul class="toc-list">
            @foreach(explode("\n", $toc['puisi']) as $line)
              @if(trim($line))<li>{!! formatTocLine($line) !!}</li>@endif
            @endforeach
          </ul>
          @endif

          @if(!empty($toc['essai']))
          <div class="category-title">ESSAI</div>
          <ul class="toc-list">
            @foreach(explode("\n", $toc['essai']) as $line)
              @if(trim($line))<li>{!! formatTocLine($line) !!}</li>@endif
            @endforeach
          </ul>
          @endif
        </aside>
      </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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
    .then(r => { if (r.status === 401) { window.location = '/signin'; return null; } return r.json(); })
    .then(data => {
        if (!data) return;
        if (btn) {
            btn.disabled = false;
            btn.style.transform = 'scale(1)';
        }
        
        if (data.status === 'success') {
            if (data.action === 'added') {
                if (btn) { btn.querySelector('.cart-text').innerHTML = 'Hapus dari Keranjang'; btn.style.background = '#ffebee'; btn.style.color = '#dc3545'; btn.style.borderColor = '#ef9a9a'; }
            } else if (data.action === 'removed') {
                if (btn) { btn.querySelector('.cart-text').innerHTML = 'Keranjang'; btn.style.background = '#fff'; btn.style.color = '#111'; btn.style.borderColor = '#111'; }
            }
            updateCartBadge(data.cartCount);
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
function showCartToast(message, type) {
    let toast = document.getElementById('cart-toast');
    if (!toast) { toast = document.createElement('div'); toast.id = 'cart-toast'; toast.style.cssText = 'position:fixed;bottom:30px;right:30px;z-index:9999;padding:14px 22px;border-radius:10px;font-family:Open Sans,sans-serif;font-size:14px;font-weight:600;box-shadow:0 4px 24px rgba(0,0,0,0.15);transition:opacity 0.4s;opacity:0;max-width:320px;'; document.body.appendChild(toast); }
    const colors = { success: ['#e8f5e9','#2e7d32'], info: ['#e3f2fd','#1565c0'], error: ['#ffebee','#b71c1c'] };
    const [bg, color] = colors[type] || colors.info;
    toast.style.background = bg; toast.style.color = color; toast.innerHTML = message; toast.style.opacity = '1';
    clearTimeout(toast._timeout);
    toast._timeout = setTimeout(() => { toast.style.opacity = '0'; }, 3500);
}
function updateCartBadge(count) {
    document.querySelectorAll('.cart-badge, #floating-cart-badge').forEach(b => { b.textContent = count; b.style.display = count > 0 ? 'inline-flex' : 'none'; });
    const floatBtn = document.getElementById('floating-cart-btn');
    if (floatBtn) floatBtn.style.display = count > 0 ? 'flex' : 'none';
}
</script>
@endpush
