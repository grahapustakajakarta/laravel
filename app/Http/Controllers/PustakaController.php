<?php

namespace App\Http\Controllers;

use App\Models\Pustaka;
use App\Models\PustakaTransaction;
use App\Models\PenggunaKoleksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class PustakaController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = config('services.midtrans.is_sanitized');
        Config::$is3ds        = config('services.midtrans.is_3ds');
    }

    public function index()
    {
        $pustakas = Pustaka::with('penulis')->orderBy('created_at', 'desc')->get();
        return view('pages.pustaka.index', compact('pustakas'));
    }

    public function show($slug)
    {
        $pustaka = Pustaka::with('penulis')->where('slug', $slug)->firstOrFail();
        
        $hasAccess = false;
        if (Auth::guard('pengguna')->check()) {
            $user = Auth::guard('pengguna')->user();
            
            $inKoleksi = \App\Models\PenggunaKoleksi::where('pengguna_id', $user->id)
                                                    ->where('item_type', 'pustaka')
                                                    ->where('item_id', $pustaka->id)
                                                    ->exists();
                                                    
            if ($inKoleksi) {
                $hasAccess = true;
            } else {
                $harga = (float) preg_replace('/[^0-9]/', '', $pustaka->harga);
                if ($harga <= 0) {
                    $hasAccess = true;
                }
            }
        }
        
        return view('pages.pustaka.detail', compact('pustaka', 'hasAccess'));
    }

    public function beli(Request $request, $slug)
    {
        if (!Auth::guard('pengguna')->check()) {
            return redirect()->route('user.signin')->with('info', 'Silakan login atau daftar gratis terlebih dahulu.');
        }

        $pustaka = Pustaka::where('slug', $slug)->firstOrFail();
        $user = Auth::guard('pengguna')->user();

        // Fallback untuk localhost testing (menangkap status dari URL)
        $orderId = $request->query('order_id');
        $txStatus = $request->query('transaction_status');
        if ($orderId && ($txStatus == 'capture' || $txStatus == 'settlement')) {
            $tx = PustakaTransaction::where('order_id', $orderId)->first();
            if ($tx && $tx->status == 'pending') {
                $tx->update(['status' => 'success']);
                PenggunaKoleksi::firstOrCreate([
                    'pengguna_id' => $tx->pengguna_id,
                    'item_type' => 'pustaka',
                    'item_id' => $tx->pustaka_id
                ]);
            }
        }

        // Check access
        $hasAccess = false;
        $inKoleksi = \App\Models\PenggunaKoleksi::where('pengguna_id', $user->id)
                                                ->where('item_type', 'pustaka')
                                                ->where('item_id', $pustaka->id)
                                                ->exists();
        if ($inKoleksi) {
            $hasAccess = true;
        } else {
            $harga = (float) preg_replace('/[^0-9]/', '', $pustaka->harga);
            if ($harga <= 0) {
                $hasAccess = true;
            }
        }

        return view('pages.pustaka.beli', compact('pustaka', 'hasAccess'));
    }

    public function prosesBayar($slug)
    {
        if (!Auth::guard('pengguna')->check()) {
            return redirect()->route('user.signin')->with('info', 'Silakan login atau daftar gratis terlebih dahulu.');
        }

        $pustaka = Pustaka::where('slug', $slug)->firstOrFail();
        $user = Auth::guard('pengguna')->user();

        $harga = (float) preg_replace('/[^0-9]/', '', $pustaka->harga);

        if ($harga <= 0) {
            PenggunaKoleksi::firstOrCreate([
                'pengguna_id' => $user->id,
                'item_type' => 'pustaka',
                'item_id' => $pustaka->id
            ]);
            return redirect()->route('pustaka.baca', $pustaka->slug)->with('success', 'Buku telah ditambahkan ke koleksi Anda.');
        }

        $existing = \App\Models\PenggunaKoleksi::where('pengguna_id', $user->id)
                                               ->where('item_type', 'pustaka')
                                               ->where('item_id', $pustaka->id)
                                               ->exists();
        if ($existing) {
            return redirect()->route('pustaka.baca', $pustaka->slug)->with('info', 'Anda sudah memiliki buku ini di koleksi Anda.');
        }

        $orderId = 'PST-' . strtoupper(Str::random(6)) . '-' . time();

        $transaction = PustakaTransaction::create([
            'pengguna_id' => $user->id,
            'pustaka_id' => $pustaka->id,
            'order_id' => $orderId,
            'gross_amount' => $harga,
            'status' => 'pending'
        ]);

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $harga,
            ],
            'customer_details' => [
                'first_name' => $user->nama,
                'email'      => $user->email,
            ],
            'item_details' => [
                [
                    'id'       => 'PST-' . $pustaka->id,
                    'price'    => $harga,
                    'quantity' => 1,
                    'name'     => Str::limit($pustaka->judul, 45),
                ]
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $hasAccess = false;
            return view('pages.pustaka.beli', compact('pustaka', 'snapToken', 'hasAccess'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function notification(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        if (!$notification) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;

        $tx = PustakaTransaction::where('order_id', $orderId)->first();
        if (!$tx) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $tx->update(['status' => 'success']);
            
            PenggunaKoleksi::firstOrCreate([
                'pengguna_id' => $tx->pengguna_id,
                'item_type' => 'pustaka',
                'item_id' => $tx->pustaka_id
            ]);
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $tx->update(['status' => 'failed']);
        } elseif ($transactionStatus == 'pending') {
            $tx->update(['status' => 'pending']);
        }

        return response()->json(['message' => 'Notification processed successfully']);
    }

    public function bacaPustaka($slug)
    {
        $pustaka = Pustaka::where('slug', $slug)->firstOrFail();
        
        if (!Auth::guard('pengguna')->check()) {
            return redirect()->route('user.signin')->with('info', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::guard('pengguna')->user();
        $harga = (float) preg_replace('/[^0-9]/', '', $pustaka->harga);

        if ($harga > 0) {
            $inKoleksi = \App\Models\PenggunaKoleksi::where('pengguna_id', $user->id)
                                                    ->where('item_type', 'pustaka')
                                                    ->where('item_id', $pustaka->id)
                                                    ->exists();
            if (!$inKoleksi) {
                return redirect()->route('pustaka.beli', $pustaka->slug)->with('error', 'Anda belum membeli buku ini.');
            }
        }

        if (!$pustaka->file_pdf) {
            return back()->with('error', 'File PDF belum tersedia untuk buku ini.');
        }

        $path = public_path('pdf/pustaka/' . $pustaka->file_pdf);
        if (!file_exists($path)) {
            return back()->with('error', 'File PDF tidak ditemukan di server.');
        }

        return response()->file($path);
    }

    public function previewPdfPustaka($slug)
    {
        $pustaka = Pustaka::where('slug', $slug)->firstOrFail();
        
        if (!$pustaka->file_pdf_preview) {
            return abort(404);
        }

        $filePath = public_path('pdf/pustaka/' . $pustaka->file_pdf_preview);
        $cpanelPath = base_path('../public_html/pdf/pustaka/' . $pustaka->file_pdf_preview);

        if (!file_exists($filePath) && file_exists($cpanelPath)) {
            $filePath = $cpanelPath;
        }

        if (file_exists($filePath)) {
            return response()->file($filePath);
        }
        
        return abort(404);
    }
}
