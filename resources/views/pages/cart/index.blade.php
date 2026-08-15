@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<style>
    #cart-scope {
        font-family: "Open Sans", sans-serif;
        background: #fafafa;
        min-height: 70vh;
    }
    #cart-scope * { box-sizing: border-box; }

    .cart-container {
        max-width: 980px;
        margin: 0 auto;
        padding: 48px 24px;
    }

    .cart-heading {
        font-family: "Playfair Display", serif;
        font-size: 28px;
        font-weight: 700;
        color: #111;
        margin: 0 0 8px;
    }
    .cart-subtitle {
        font-size: 13px;
        color: #888;
        margin: 0 0 36px;
    }

    /* ── Layout ── */
    .cart-layout {
        display: flex;
        gap: 32px;
        align-items: flex-start;
    }
    .cart-items-col {
        flex: 1;
        min-width: 0;
    }
    .cart-summary-col {
        flex: 0 0 300px;
    }

    /* ── Item Card ── */
    .cart-item-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 10px;
        padding: 18px 20px;
        display: flex;
        gap: 18px;
        align-items: flex-start;
        margin-bottom: 16px;
        transition: box-shadow 0.2s;
    }
    .cart-item-card:hover { box-shadow: 0 4px 18px rgba(0,0,0,0.08); }

    .cart-item-img {
        width: 70px;
        height: 95px;
        object-fit: cover;
        border-radius: 4px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        flex-shrink: 0;
    }
    .cart-item-img-placeholder {
        width: 70px;
        height: 95px;
        background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #bbb;
        font-size: 24px;
        flex-shrink: 0;
    }

    .cart-item-info {
        flex: 1;
        min-width: 0;
    }
    .cart-item-badge {
        display: inline-block;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 2px 8px;
        border-radius: 20px;
        margin-bottom: 6px;
    }
    .badge-magz { background: #fff3e0; color: #e65100; }
    .badge-pustaka { background: #e8f5e9; color: #2e7d32; }

    .cart-item-title {
        font-size: 15px;
        font-weight: 600;
        color: #111;
        margin: 0 0 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cart-item-price {
        font-size: 15px;
        font-weight: 700;
        color: #c0392b;
    }
    .cart-item-price.free { color: #27ae60; }

    .cart-item-remove {
        background: none;
        border: none;
        cursor: pointer;
        color: #ccc;
        font-size: 18px;
        padding: 4px;
        transition: color 0.2s;
        flex-shrink: 0;
        line-height: 1;
    }
    .cart-item-remove:hover { color: #e31837; }

    /* ── Empty state ── */
    .cart-empty {
        text-align: center;
        padding: 80px 24px;
    }
    .cart-empty-icon { font-size: 64px; color: #ddd; margin-bottom: 20px; }
    .cart-empty h2 { font-size: 20px; font-weight: 600; color: #333; margin: 0 0 10px; }
    .cart-empty p { font-size: 14px; color: #888; margin: 0 0 28px; }
    .cart-empty .btn-browse {
        display: inline-block;
        padding: 11px 28px;
        background: #111;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        transition: background 0.2s;
    }
    .cart-empty .btn-browse:hover { background: #e31837; }

    /* ── Summary Box ── */
    .cart-summary-box {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 10px;
        padding: 24px;
        position: sticky;
        top: 100px;
    }
    .cart-summary-box h3 {
        font-size: 15px;
        font-weight: 700;
        color: #111;
        margin: 0 0 20px;
        padding-bottom: 14px;
        border-bottom: 1px solid #f0f0f0;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        color: #555;
        margin-bottom: 10px;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        font-size: 16px;
        font-weight: 700;
        color: #111;
        padding-top: 14px;
        border-top: 1px solid #f0f0f0;
        margin-top: 8px;
        margin-bottom: 20px;
    }
    .btn-checkout {
        display: block;
        width: 100%;
        padding: 13px;
        background: #e31837;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        transition: background 0.2s, transform 0.1s;
    }
    .btn-checkout:hover { background: #c0122e; }
    .btn-checkout:active { transform: scale(0.98); }
    .btn-checkout:disabled { background: #ddd; cursor: not-allowed; }

    .btn-continue {
        display: block;
        text-align: center;
        margin-top: 12px;
        font-size: 12px;
        color: #888;
        text-decoration: none;
    }
    .btn-continue:hover { color: #e31837; }

    /* Flash messages */
    .cart-alert {
        padding: 12px 18px;
        border-radius: 8px;
        font-size: 13px;
        margin-bottom: 20px;
    }
    .cart-alert.success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .cart-alert.info    { background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9; }
    .cart-alert.error   { background: #ffebee; color: #b71c1c; border: 1px solid #ef9a9a; }

    @media (max-width: 700px) {
        .cart-layout { flex-direction: column; }
        .cart-summary-col { flex: none; width: 100%; }
    }
</style>

<div id="cart-scope">
<div class="cart-container">

    <h1 class="cart-heading">🛒 Keranjang Belanja</h1>
    <p class="cart-subtitle">Tinjau item pilihan Anda sebelum melakukan pembayaran.</p>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="cart-alert success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="cart-alert info">{{ session('info') }}</div>
    @endif
    @if(session('error'))
        <div class="cart-alert error">{{ session('error') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <div class="cart-empty">
            <div class="cart-empty-icon">🛒</div>
            <h2>Keranjang Anda Kosong</h2>
            <p>Tambahkan Magz atau Pustaka yang ingin Anda beli.</p>
            <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
                <a href="{{ route('magz.index') }}" class="btn-browse">Jelajahi Magz</a>
                <a href="{{ route('pustaka.index') }}" class="btn-browse" style="background:#333;">Jelajahi Pustaka</a>
            </div>
        </div>
    @else
        <div class="cart-layout">
            {{-- Items Column --}}
            <div class="cart-items-col" id="cartItemsContainer">
                @foreach($cartItems as $ci)
                    @php $item = $ci->item; @endphp
                    @if($item)
                    <div class="cart-item-card" id="cart-item-{{ $ci->id }}">
                        {{-- Cover --}}
                        @php
                            $coverUrl = null;
                            if ($ci->item_type === 'magz' && $item->cover) {
                                $coverUrl = asset('storage/' . $item->cover);
                            } elseif ($ci->item_type === 'pustaka' && $item->gambar_1) {
                                $coverUrl = asset('img/' . $item->gambar_1);
                            }
                        @endphp
                        @if($coverUrl)
                            <img src="{{ $coverUrl }}" alt="{{ $ci->judul }}" class="cart-item-img">
                        @else
                            <div class="cart-item-img-placeholder"><i class="fas fa-book"></i></div>
                        @endif

                        {{-- Info --}}
                        <div class="cart-item-info">
                            <span class="cart-item-badge {{ $ci->item_type === 'magz' ? 'badge-magz' : 'badge-pustaka' }}">
                                {{ strtoupper($ci->item_type) }}
                            </span>
                            <div class="cart-item-title">{{ $ci->judul }}</div>
                            @if($ci->harga > 0)
                                <div class="cart-item-price">Rp {{ number_format($ci->harga, 0, ',', '.') }}</div>
                            @else
                                <div class="cart-item-price free">Gratis</div>
                            @endif
                        </div>

                        {{-- Remove --}}
                        <button class="cart-item-remove" onclick="removeCartItem({{ $ci->id }})" title="Hapus">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endif
                @endforeach
            </div>

            {{-- Summary Column --}}
            <div class="cart-summary-col">
                <div class="cart-summary-box">
                    <h3>Ringkasan Pesanan</h3>

                    @foreach($cartItems as $ci)
                        @if($ci->item)
                        <div class="summary-row">
                            <span style="max-width:170px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ $ci->judul }}
                            </span>
                            <span>
                                @if($ci->harga > 0)
                                    Rp {{ number_format($ci->harga, 0, ',', '.') }}
                                @else
                                    Gratis
                                @endif
                            </span>
                        </div>
                        @endif
                    @endforeach

                    <div class="summary-total">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-checkout">
                            Bayar Sekarang
                        </button>
                    </form>
                    <a href="{{ route('magz.index') }}" class="btn-continue">← Lanjut Belanja</a>
                </div>
            </div>
        </div>
    @endif
</div>
</div>

<script>
function removeCartItem(id) {
    if (!confirm('Hapus item dari keranjang?')) return;

    fetch('/keranjang/' + id + '/remove', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.status === 'success') {
            const el = document.getElementById('cart-item-' + id);
            if (el) {
                el.style.transition = 'opacity 0.3s, transform 0.3s';
                el.style.opacity = '0';
                el.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    el.remove();
                    updateCartBadge(data.cartCount);
                    // If cart is empty, reload
                    const remaining = document.querySelectorAll('[id^="cart-item-"]');
                    if (remaining.length === 0) location.reload();
                }, 300);
            }
        }
    });
}

function updateCartBadge(count) {
    const badges = document.querySelectorAll('.cart-badge, #floating-cart-badge');
    badges.forEach(b => {
        if (count > 0) {
            b.textContent = count;
            b.style.display = 'inline-flex';
        } else {
            b.style.display = 'none';
        }
    });
    const floatBtn = document.getElementById('floating-cart-btn');
    if (floatBtn) {
        floatBtn.style.display = count > 0 ? 'flex' : 'none';
    }
}
</script>
@endsection
