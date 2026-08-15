<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\CartTransaction;
use App\Models\Magz;
use App\Models\Pustaka;
use App\Models\PenggunaKoleksi;
use App\Models\MagzTransaction;
use App\Models\PustakaTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class CartController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = config('services.midtrans.is_sanitized');
        Config::$is3ds        = config('services.midtrans.is_3ds');
    }

    // ── Tampilkan keranjang ──
    public function index(Request $request)
    {
        if (!Auth::guard('pengguna')->check()) {
            return redirect()->route('user.signin')->with('info', 'Silakan login untuk melihat keranjang belanja.');
        }

        $user = Auth::guard('pengguna')->user();

        // Handle localhost fallback setelah Midtrans redirect
        $orderId  = $request->query('order_id');
        $txStatus = $request->query('transaction_status');
        if ($orderId && ($txStatus == 'capture' || $txStatus == 'settlement')) {
            $this->processSuccessfulTransaction($orderId);
        }

        $cartItems = CartItem::where('pengguna_id', $user->id)->get();

        // Filter out items user already owns
        $filteredItems = $cartItems->filter(function ($ci) use ($user) {
            return !PenggunaKoleksi::where('pengguna_id', $user->id)
                ->where('item_type', $ci->item_type)
                ->where('item_id', $ci->item_id)
                ->exists();
        });

        // Remove items that are already owned from DB
        $alreadyOwned = $cartItems->diff($filteredItems);
        foreach ($alreadyOwned as $owned) {
            $owned->delete();
        }

        $cartItems = $filteredItems;

        $total = $cartItems->sum(fn($ci) => $ci->harga);

        return view('pages.cart.index', compact('cartItems', 'total'));
    }

    // ── Tambah item ke keranjang ──
    public function add(Request $request)
    {
        if (!Auth::guard('pengguna')->check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'login_required'], 401);
            }
            return redirect()->route('user.signin')->with('info', 'Silakan login untuk menambah ke keranjang.');
        }

        $request->validate([
            'item_type' => 'required|in:magz,pustaka',
            'item_id'   => 'required|integer',
        ]);

        $user     = Auth::guard('pengguna')->user();
        $itemType = $request->item_type;
        $itemId   = $request->item_id;

        // Verifikasi item ada
        $item = null;
        if ($itemType === 'magz') {
            $item = Magz::find($itemId);
        } elseif ($itemType === 'pustaka') {
            $item = Pustaka::find($itemId);
        }

        if (!$item) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Item tidak ditemukan'], 404);
            }
            return back()->with('error', 'Item tidak ditemukan.');
        }

        // Cek jika sudah punya
        $alreadyOwned = PenggunaKoleksi::where('pengguna_id', $user->id)
            ->where('item_type', $itemType)
            ->where('item_id', $itemId)
            ->exists();

        if ($alreadyOwned) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['status' => 'owned', 'message' => 'Item sudah ada di koleksi Anda.']);
            }
            return back()->with('info', 'Item sudah ada di koleksi Anda.');
        }

        // Tambah atau abaikan jika sudah di keranjang
        CartItem::firstOrCreate([
            'pengguna_id' => $user->id,
            'item_type'   => $itemType,
            'item_id'     => $itemId,
        ]);

        $cartCount = CartItem::where('pengguna_id', $user->id)->count();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status'    => 'success',
                'message'   => '"' . ($item->judul ?? $item->title) . '" berhasil ditambahkan ke keranjang!',
                'cartCount' => $cartCount,
            ]);
        }

        return back()->with('success', '"' . ($item->judul ?? $item->title) . '" berhasil ditambahkan ke keranjang!');
    }

    // ── Toggle item keranjang (Tambah/Hapus) ──
    public function toggle(Request $request)
    {
        if (!Auth::guard('pengguna')->check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'login_required'], 401);
            }
            return redirect()->route('user.signin');
        }

        $request->validate([
            'item_type' => 'required|in:magz,pustaka',
            'item_id'   => 'required|integer',
        ]);

        $user     = Auth::guard('pengguna')->user();
        $itemType = $request->item_type;
        $itemId   = $request->item_id;

        // Cek jika sudah punya
        $alreadyOwned = PenggunaKoleksi::where('pengguna_id', $user->id)
            ->where('item_type', $itemType)
            ->where('item_id', $itemId)
            ->exists();

        if ($alreadyOwned) {
            return response()->json(['status' => 'owned', 'message' => 'Item sudah ada di koleksi Anda.']);
        }

        $cartItem = CartItem::where('pengguna_id', $user->id)
            ->where('item_type', $itemType)
            ->where('item_id', $itemId)
            ->first();

        $action = '';
        if ($cartItem) {
            $cartItem->delete();
            $action = 'removed';
        } else {
            CartItem::create([
                'pengguna_id' => $user->id,
                'item_type'   => $itemType,
                'item_id'     => $itemId,
            ]);
            $action = 'added';
        }

        $cartCount = CartItem::where('pengguna_id', $user->id)->count();

        return response()->json([
            'status'    => 'success',
            'action'    => $action,
            'cartCount' => $cartCount,
        ]);
    }

    // ── Hapus item dari keranjang ──
    public function remove($id)
    {
        if (!Auth::guard('pengguna')->check()) {
            return response()->json(['status' => 'error'], 401);
        }

        $user = Auth::guard('pengguna')->user();
        $cartItem = CartItem::where('id', $id)->where('pengguna_id', $user->id)->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        $cartCount = CartItem::where('pengguna_id', $user->id)->count();
        return response()->json(['status' => 'success', 'cartCount' => $cartCount]);
    }

    // ── Proses checkout: buat Snap Token ──
    public function checkout(Request $request)
    {
        if (!Auth::guard('pengguna')->check()) {
            return redirect()->route('user.signin');
        }

        $user      = Auth::guard('pengguna')->user();
        $cartItems = CartItem::where('pengguna_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Pisahkan item gratis dan berbayar
        $freeItems  = $cartItems->filter(fn($ci) => $ci->harga <= 0);
        $paidItems  = $cartItems->filter(fn($ci) => $ci->harga > 0);

        // Proses item gratis langsung
        foreach ($freeItems as $ci) {
            PenggunaKoleksi::firstOrCreate([
                'pengguna_id' => $user->id,
                'item_type'   => $ci->item_type,
                'item_id'     => $ci->item_id,
            ]);
            $ci->delete();
        }

        // Jika semua gratis, redirect ke profil
        if ($paidItems->isEmpty()) {
            return redirect()->route('user.profile', ['tab' => 'koleksi'])->with('success', 'Semua item berhasil ditambahkan ke koleksi Anda!');
        }

        $total     = $paidItems->sum(fn($ci) => $ci->harga);
        $orderId   = 'CART-' . strtoupper(Str::random(8)) . '-' . time();

        // Simpan items snapshot
        $itemsSnapshot = $paidItems->map(fn($ci) => [
            'type' => $ci->item_type,
            'id'   => $ci->item_id,
        ])->values()->toArray();

        $cartTx = CartTransaction::create([
            'pengguna_id'  => $user->id,
            'order_id'     => $orderId,
            'gross_amount' => $total,
            'status'       => 'pending',
            'items'        => $itemsSnapshot,
        ]);

        // Build item details for Midtrans
        $itemDetails = [];
        foreach ($paidItems as $ci) {
            $item = $ci->item;
            $itemDetails[] = [
                'id'       => $ci->item_type . '-' . $ci->item_id,
                'price'    => (int) $ci->harga,
                'quantity' => 1,
                'name'     => mb_substr($ci->judul, 0, 50),
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $total,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $user->nama ?? $user->username ?? 'Pengguna',
                'email'      => $user->email ?? '',
            ],
            'callbacks' => [
                'finish' => route('cart.index'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('pages.cart.checkout', compact('cartItems', 'paidItems', 'total', 'snapToken', 'orderId'));
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    // ── Webhook Midtrans ──
    public function notification(Request $request)
    {
        $payload           = $request->all();
        $orderId           = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus       = $payload['fraud_status'] ?? null;

        if (!$orderId) return response()->json(['message' => 'Invalid'], 400);

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            if ($transactionStatus == 'capture' && $fraudStatus != 'accept') {
                return response()->json(['message' => 'Fraud detected'], 400);
            }
            $this->processSuccessfulTransaction($orderId);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            CartTransaction::where('order_id', $orderId)->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'OK']);
    }

    // ── Helper: proses transaksi sukses ──
    private function processSuccessfulTransaction(string $orderId)
    {
        $tx = CartTransaction::where('order_id', $orderId)->where('status', 'pending')->first();
        if (!$tx) return;

        $tx->update(['status' => 'success']);

        foreach ($tx->items as $itemData) {
            PenggunaKoleksi::firstOrCreate([
                'pengguna_id' => $tx->pengguna_id,
                'item_type'   => $itemData['type'],
                'item_id'     => $itemData['id'],
            ]);

            // Buat record transaksi spesifik agar tercatat di dashboard
            if ($itemData['type'] === 'magz') {
                $magz = Magz::find($itemData['id']);
                if ($magz) {
                    MagzTransaction::create([
                        'pengguna_id'  => $tx->pengguna_id,
                        'magz_id'      => $magz->id,
                        'order_id'     => $orderId . '-M' . $magz->id,
                        'gross_amount' => $magz->harga,
                        'status'       => 'success',
                    ]);
                }
            } elseif ($itemData['type'] === 'pustaka') {
                $pustaka = Pustaka::find($itemData['id']);
                if ($pustaka) {
                    PustakaTransaction::create([
                        'pengguna_id'  => $tx->pengguna_id,
                        'pustaka_id'   => $pustaka->id,
                        'order_id'     => $orderId . '-P' . $pustaka->id,
                        'gross_amount' => $pustaka->harga,
                        'status'       => 'success',
                    ]);
                }
            }

            // Hapus dari keranjang
            CartItem::where('pengguna_id', $tx->pengguna_id)
                ->where('item_type', $itemData['type'])
                ->where('item_id', $itemData['id'])
                ->delete();
        }
    }

    // ── AJAX: jumlah item keranjang ──
    public function count()
    {
        if (!Auth::guard('pengguna')->check()) {
            return response()->json(['count' => 0]);
        }
        $count = CartItem::where('pengguna_id', Auth::guard('pengguna')->id())->count();
        return response()->json(['count' => $count]);
    }
}
