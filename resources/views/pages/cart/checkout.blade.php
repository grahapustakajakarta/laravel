@extends('layouts.app')

@section('title', 'Checkout — Keranjang Belanja')

@section('content')
<style>
    #cart-checkout-scope {
        font-family: "Open Sans", sans-serif;
        background: #fafafa;
        min-height: 70vh;
    }
    .checkout-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 60px 24px;
        text-align: center;
    }
    .checkout-icon { font-size: 56px; margin-bottom: 16px; }
    .checkout-title {
        font-family: "Playfair Display", serif;
        font-size: 26px;
        font-weight: 700;
        color: #111;
        margin: 0 0 10px;
    }
    .checkout-sub {
        font-size: 14px;
        color: #666;
        margin: 0 0 32px;
    }
    .checkout-summary-box {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 10px;
        padding: 24px;
        text-align: left;
        margin-bottom: 28px;
    }
    .checkout-summary-box h3 {
        font-size: 14px;
        font-weight: 700;
        color: #111;
        margin: 0 0 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f0f0f0;
    }
    .co-item-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        color: #444;
        padding: 6px 0;
    }
    .co-total-row {
        display: flex;
        justify-content: space-between;
        font-size: 16px;
        font-weight: 700;
        color: #111;
        padding-top: 12px;
        border-top: 1px solid #f0f0f0;
        margin-top: 6px;
    }
    .btn-pay-now {
        display: inline-block;
        padding: 14px 40px;
        background: #e31837;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-pay-now:hover { background: #c0122e; }
    .btn-back {
        display: inline-block;
        margin-top: 16px;
        font-size: 13px;
        color: #888;
        text-decoration: none;
    }
    .btn-back:hover { color: #e31837; }
    .secure-info {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 12px;
        color: #aaa;
        margin-top: 20px;
    }
</style>

<div id="cart-checkout-scope">
<div class="checkout-container">
    <div class="checkout-icon">🔐</div>
    <h1 class="checkout-title">Selesaikan Pembayaran</h1>
    <p class="checkout-sub">Klik tombol di bawah untuk membuka halaman pembayaran Midtrans yang aman.</p>

    <div class="checkout-summary-box">
        <h3>Rincian Pemesanan</h3>
        @foreach($paidItems as $ci)
            @if($ci->item)
            <div class="co-item-row">
                <span>
                    <span style="font-size:10px;font-weight:700;background:{{ $ci->item_type==='magz'?'#fff3e0':'#e8f5e9' }};color:{{ $ci->item_type==='magz'?'#e65100':'#2e7d32' }};padding:2px 7px;border-radius:20px;margin-right:6px;">{{ strtoupper($ci->item_type) }}</span>
                    {{ $ci->judul }}
                </span>
                <span>Rp {{ number_format($ci->harga, 0, ',', '.') }}</span>
            </div>
            @endif
        @endforeach
        <div class="co-total-row">
            <span>Total</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>

    <button id="pay-button" class="btn-pay-now">
        <i class="fas fa-lock" style="margin-right:8px;"></i> Bayar Sekarang
    </button>
    <br>
    <a href="{{ route('cart.index') }}" class="btn-back">← Kembali ke Keranjang</a>

    <div class="secure-info">
        <i class="fas fa-shield-alt"></i>
        <span>Pembayaran diamankan oleh Midtrans</span>
    </div>
</div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function() {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location = '{{ route('cart.index') }}?order_id=' + result.order_id + '&transaction_status=' + result.transaction_status;
            },
            onPending: function(result) {
                alert('Pembayaran tertunda. Silakan selesaikan pembayaran Anda.');
            },
            onError: function(result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {
                // User closed the popup, stay on page
            }
        });
    });

    // Auto-open Snap popup
    window.onload = function() {
        setTimeout(function() {
            document.getElementById('pay-button').click();
        }, 500);
    };
</script>
@endsection
