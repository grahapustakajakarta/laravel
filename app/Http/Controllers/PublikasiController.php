<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use App\Models\Magz;
use App\Models\MagzTransaction;
use App\Models\PenggunaKoleksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class PublikasiController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = config('services.midtrans.is_sanitized');
        Config::$is3ds        = config('services.midtrans.is_3ds');
    }

    public function index(Request $request)
    {
        $query = Publikasi::orderBy('created_at', 'desc');

        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }

        $publikasi = $query->paginate(5)->withQueryString();
        $kategoris = Publikasi::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('pages.publikasi.index', compact('publikasi', 'kategoris'));
    }

    public function magz(Request $request)
    {
        $query = Magz::orderBy('created_at', 'desc');

        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }

        $publikasi = $query->paginate(5)->withQueryString();
        $kategoris = Magz::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        $purchasedMagzIds = [];
        if (Auth::guard('pengguna')->check()) {
            $purchasedMagzIds = PenggunaKoleksi::where('pengguna_id', Auth::guard('pengguna')->id())
                ->where('item_type', 'magz')
                ->pluck('item_id')->toArray();
        }

        return view('pages.magz.index', compact('publikasi', 'kategoris', 'purchasedMagzIds'));
    }

    public function show(Publikasi $publikasi)
    {
        if (!\Illuminate\Support\Facades\Auth::guard('pengguna')->check()) {
            return redirect()->route('user.signin')->with('info', 'Silakan login atau daftar gratis untuk mengunduh publikasi ini.');
        }

        // Tampilkan PDF secara inline (preview) tanpa simpan otomatis
        $filePath = public_path('pdf/' . $publikasi->file_pdf);
        $cpanelPath = base_path('../public_html/pdf/' . $publikasi->file_pdf);

        if (!file_exists($filePath) && file_exists($cpanelPath)) {
            $filePath = $cpanelPath;
        }

        if (file_exists($filePath)) {
            return response()->file($filePath);
        }
        
        return redirect()->back()->with('error', 'File PDF tidak ditemukan.');
    }

    public function download(Publikasi $publikasi)
    {
        if (!\Illuminate\Support\Facades\Auth::guard('pengguna')->check()) {
            return redirect()->route('user.signin')->with('info', 'Silakan login atau daftar gratis untuk mengunduh publikasi ini.');
        }

        $userId = \Illuminate\Support\Facades\Auth::guard('pengguna')->id();
        \App\Models\PenggunaKoleksi::firstOrCreate([
            'pengguna_id' => $userId,
            'item_type' => 'publikasi',
            'item_id' => $publikasi->id
        ]);

        // Unduh langsung (force download)
        $filePath = public_path('pdf/' . $publikasi->file_pdf);
        $cpanelPath = base_path('../public_html/pdf/' . $publikasi->file_pdf);

        if (!file_exists($filePath) && file_exists($cpanelPath)) {
            $filePath = $cpanelPath;
        }

        if (file_exists($filePath)) {
            return response()->download($filePath, \Illuminate\Support\Str::slug($publikasi->judul) . '.pdf');
        }
        
        return redirect()->back()->with('error', 'File PDF tidak ditemukan.');
    }

    public function preview($slug)
    {
        $magz = Magz::where('slug', $slug)->firstOrFail();
        
        $hasAccess = false;
        if (Auth::guard('pengguna')->check()) {
            $userId = Auth::guard('pengguna')->id();
            if ($magz->harga <= 0) {
                $hasAccess = true;
            } else {
                $hasAccess = \App\Models\PenggunaKoleksi::where('pengguna_id', $userId)
                                     ->where('item_type', 'magz')
                                     ->where('item_id', $magz->id)
                                     ->exists();
            }
        }

        return view('pages.magz.preview', compact('magz', 'hasAccess'));
    }

    public function beli(Request $request, $slug)
    {
        if (!Auth::guard('pengguna')->check()) {
            return redirect()->route('user.signin')->with('info', 'Silakan login atau daftar gratis untuk mengakses Magz ini.');
        }

        $magz = Magz::where('slug', $slug)->firstOrFail();
        $userId = Auth::guard('pengguna')->id();

        // Fallback untuk localhost testing (menangkap status dari URL)
        $orderId  = $request->query('order_id');
        $txStatus = $request->query('transaction_status');
        if ($orderId && ($txStatus == 'capture' || $txStatus == 'settlement')) {
            $tx = MagzTransaction::where('order_id', $orderId)->first();
            if ($tx && $tx->status == 'pending') {
                $tx->update(['status' => 'success']);
                PenggunaKoleksi::firstOrCreate([
                    'pengguna_id' => $tx->pengguna_id,
                    'item_type'   => 'magz',
                    'item_id'     => $tx->magz_id
                ]);
            }
        }

        // Cek akses via PenggunaKoleksi (sumber kebenaran tunggal)
        $hasAccess = false;
        if ($magz->harga <= 0) {
            // Gratis: langsung beri akses & masukkan koleksi
            PenggunaKoleksi::firstOrCreate([
                'pengguna_id' => $userId,
                'item_type'   => 'magz',
                'item_id'     => $magz->id
            ]);
            $hasAccess = true;
        } else {
            $hasAccess = PenggunaKoleksi::where('pengguna_id', $userId)
                ->where('item_type', 'magz')
                ->where('item_id', $magz->id)
                ->exists();
        }

        // Jika sudah punya akses, langsung arahkan ke unduh
        if ($hasAccess && !$request->query('order_id')) {
            return redirect()->route('magz.baca', $magz->slug);
        }

        return view('pages.magz.buy', compact('magz', 'hasAccess'));
    }

    public function prosesBayar($slug)
    {
        if (!Auth::guard('pengguna')->check()) {
            return redirect()->route('user.signin')->with('info', 'Silakan login atau daftar gratis terlebih dahulu.');
        }

        $magz = Magz::where('slug', $slug)->firstOrFail();
        $user = Auth::guard('pengguna')->user();

        // Jika gratis, langsung sukses dan masukkan koleksi
        if ($magz->harga <= 0) {
            PenggunaKoleksi::firstOrCreate([
                'pengguna_id' => $user->id,
                'item_type' => 'magz',
                'item_id' => $magz->id
            ]);
            return redirect()->route('magz.baca', $magz->slug)->with('success', 'Magz telah ditambahkan ke koleksi Anda.');
        }

        // Cek jika sudah pernah punya di koleksi
        $alreadyOwned = PenggunaKoleksi::where('pengguna_id', $user->id)
            ->where('item_type', 'magz')
            ->where('item_id', $magz->id)
            ->exists();
        if ($alreadyOwned) {
            return redirect()->route('magz.baca', $magz->slug)->with('info', 'Anda sudah memiliki Magz ini di koleksi.');
        }

        $orderId = 'MGZ-' . strtoupper(Str::random(6)) . '-' . time();

        $transaction = MagzTransaction::create([
            'pengguna_id' => $user->id,
            'magz_id' => $magz->id,
            'order_id' => $orderId,
            'gross_amount' => $magz->harga,
            'status' => 'pending'
        ]);

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $magz->harga,
            ],
            'customer_details' => [
                'first_name' => $user->nama,
                'email'      => $user->email,
            ],
            'item_details' => [
                [
                    'id'       => 'MAGZ-' . $magz->id,
                    'price'    => $magz->harga,
                    'quantity' => 1,
                    'name'     => Str::limit($magz->judul, 45),
                ]
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $hasAccess = false;
            return view('pages.magz.buy', compact('magz', 'snapToken', 'hasAccess'));
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

        $magzTx = MagzTransaction::where('order_id', $orderId)->first();
        if (!$magzTx) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $magzTx->update(['status' => 'success']);
            
            // Masukkan ke koleksi user
            PenggunaKoleksi::firstOrCreate([
                'pengguna_id' => $magzTx->pengguna_id,
                'item_type' => 'magz',
                'item_id' => $magzTx->magz_id
            ]);
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $magzTx->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'Notification processed successfully']);
    }

    public function bacaMagz($slug)
    {
        if (!Auth::guard('pengguna')->check()) {
            return redirect()->route('user.signin')->with('info', 'Silakan login terlebih dahulu.');
        }

        $magz = Magz::where('slug', $slug)->firstOrFail();
        $userId = Auth::guard('pengguna')->id();

        $hasAccess = false;
        if ($magz->harga <= 0) {
            $hasAccess = true;
        } else {
            // Cek via PenggunaKoleksi (sumber kebenaran tunggal)
            $hasAccess = PenggunaKoleksi::where('pengguna_id', $userId)
                ->where('item_type', 'magz')
                ->where('item_id', $magz->id)
                ->exists();
        }

        if (!$hasAccess) {
            return redirect()->route('magz.preview', $magz->slug)->with('info', 'Anda belum memiliki akses penuh. Silakan beli untuk membaca PDF.');
        }

        $filePath = public_path('pdf/' . $magz->file_pdf);
        $cpanelPath = base_path('../public_html/pdf/' . $magz->file_pdf);

        if (!file_exists($filePath) && file_exists($cpanelPath)) {
            $filePath = $cpanelPath;
        }

        if (file_exists($filePath)) {
            return response()->download($filePath, \Illuminate\Support\Str::slug($magz->judul) . '.pdf');
        }
        
        return redirect()->back()->with('error', 'File PDF tidak ditemukan.');
    }
}
