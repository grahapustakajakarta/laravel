<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthUserController;
use App\Models\Pengguna;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class SubscribeController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = config('services.midtrans.is_sanitized');
        Config::$is3ds        = config('services.midtrans.is_3ds');
    }

    /* ----------------------------------------------------------------
     |  Halaman Subscribe
     | ---------------------------------------------------------------- */
    public function index()
    {
        return view('pages.subscribe.index');
    }

    /* ----------------------------------------------------------------
     |  Buat akun + kirim verifikasi + Snap Token
     | ---------------------------------------------------------------- */
    public function createSnapToken(Request $request)
    {
        $isNew = false;

        if (Auth::guard('pengguna')->check()) {
            // User sudah login, hanya butuh pilihan paket
            $request->validate([
                'paket' => 'required|in:bulanan,paket4bulan,paket6bulan',
            ]);
            $pengguna = Auth::guard('pengguna')->user();
        } else {
            // Guest — buat akun baru
            $request->validate([
                'nama'                  => 'required|string|max:100',
                'email'                 => 'required|email|unique:pengguna,email',
                'password'              => 'required|min:6|confirmed',
                'password_confirmation' => 'required',
                'paket'                 => 'required|in:bulanan,paket4bulan,paket6bulan',
            ], [
                'password.confirmed' => 'Konfirmasi password tidak sesuai.',
                'password.min'       => 'Password minimal 6 karakter.',
                'email.unique'       => 'Email sudah terdaftar. Silakan login terlebih dahulu.',
            ]);

            $pengguna = Pengguna::create([
                'nama'     => $request->nama,
                'email'    => $request->email,
                'password' => $request->password,
                'role'     => 'user',
            ]);
            $isNew = true;

            if (!$pengguna->hasVerifiedEmail()) {
                AuthUserController::sendVerificationNotification($pengguna);
            }

            Auth::guard('pengguna')->login($pengguna);
        }

        // ── Buat Snap Token Midtrans ──
        $harga     = 37500;
        $paketName = 'Monthly Digital';

        if ($request->paket === 'paket4bulan') {
            $harga     = 112500;
            $paketName = '4 Months Digital';
        } elseif ($request->paket === 'paket6bulan') {
            $harga     = 125000;
            $paketName = '6 Months Digital';
        }

        $orderId = 'SUB-' . strtoupper(Str::random(8)) . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $harga,
            ],
            'customer_details' => [
                'first_name' => $pengguna->nama,
                'email'      => $pengguna->email,
            ],
            'item_details' => [
                [
                    'id'       => 'PREMIUM-' . strtoupper($request->paket),
                    'price'    => $harga,
                    'quantity' => 1,
                    'name'     => 'Langganan ' . $paketName . ' — Galeri Buku Jakarta',
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            session([
                'pending_subscribe' => [
                    'pengguna_id' => $pengguna->id,
                    'nama'        => $pengguna->nama,
                    'email'       => $pengguna->email,
                    'paket'       => $request->paket,
                    'order_id'    => $orderId,
                ],
            ]);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id'   => $orderId,
                'is_new'     => $isNew,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /* ----------------------------------------------------------------
     |  Midtrans notification (server callback)
     | ---------------------------------------------------------------- */
    public function notification(Request $request)
    {
        $notif  = new \Midtrans\Notification();
        $status = $notif->transaction_status;
        $fraud  = $notif->fraud_status;

        if (($status === 'capture' && $fraud === 'accept') || $status === 'settlement') {
            \Illuminate\Support\Facades\Log::info('Midtrans: order ' . $notif->order_id . ' berhasil.');
        }

        return response()->json(['status' => 'ok']);
    }

    /* ----------------------------------------------------------------
     |  Halaman sukses setelah pembayaran
     |  3NF Refactor: query via pengguna_id (FK), bukan email string.
     |  Kalkulasi berlaku_hingga dipindah ke Subscriber::hitungBerlakuHingga().
     | ---------------------------------------------------------------- */
    public function success(Request $request)
    {
        $orderId = $request->query('order_id');
        $pending = session('pending_subscribe');

        if ($pending && isset($pending['order_id']) && $pending['order_id'] === $orderId) {

            // Cari subscriber yang ada via pengguna_id (3NF)
            $existing = Subscriber::where('pengguna_id', $pending['pengguna_id'])->first();

            // Hitung tanggal berlaku_hingga (logika ada di Model)
            $berlakuHingga = Subscriber::hitungBerlakuHingga($pending['paket'], $existing);

            if ($existing) {
                // Update record yang ada
                $existing->pengguna_id     = $pending['pengguna_id'];
                $existing->paket           = $pending['paket'];
                $existing->status          = 'aktif';
                $existing->berlaku_hingga  = $berlakuHingga;
                $existing->save();
            } else {
                // Insert record baru
                $sub = new Subscriber();
                $sub->pengguna_id    = $pending['pengguna_id'];
                $sub->paket          = $pending['paket'];
                $sub->status         = 'aktif';
                $sub->berlaku_hingga = $berlakuHingga;
                $sub->save();
            }
            
            // Simpan Riwayat
            $nominal = 37500;
            if($pending['paket'] === 'paket4bulan') $nominal = 112500;
            elseif($pending['paket'] === 'paket6bulan') $nominal = 125000;
            
            \App\Models\SubscriptionHistory::create([
                'pengguna_id' => $pending['pengguna_id'],
                'paket' => $pending['paket'],
                'nominal' => $nominal,
                'berlaku_hingga' => $berlakuHingga,
            ]);

            session()->forget('pending_subscribe');
        }

        return view('pages.subscribe.success', compact('orderId'));
    }
}
