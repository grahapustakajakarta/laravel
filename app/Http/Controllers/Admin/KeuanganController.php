<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MagzTransaction;
use App\Models\PustakaTransaction;
use App\Models\Donation;
use App\Models\Subscriber;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        // 0. Pengaturan Tanggal Filter
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Format untuk query (mulai hari dari jam 00:00:00 s/d 23:59:59)
        $startQuery = $startDate . ' 00:00:00';
        $endQuery   = $endDate . ' 23:59:59';

        // 1. Total Pendapatan MAGZ (yang statusnya settlement/success)
        $totalMagz = MagzTransaction::whereIn('status', ['settlement', 'success', 'capture'])
                        ->whereBetween('created_at', [$startQuery, $endQuery])
                        ->sum('gross_amount');

        // 2. Total Pendapatan Langganan (Estimasi dari tabel subscribers yang aktif di periode tsb)
        $subscribers = Subscriber::where('status', 'aktif')
                        ->whereBetween('created_at', [$startQuery, $endQuery])
                        ->get();
        $totalLangganan = 0;
        foreach ($subscribers as $sub) {
            if ($sub->paket === 'paket4bulan') {
                $totalLangganan += 112500;
            } elseif ($sub->paket === 'paket6bulan') {
                $totalLangganan += 125000;
            } else {
                $totalLangganan += 37500;
            }
        }

        // 3. Total Pendapatan Pustaka
        $totalPustaka = PustakaTransaction::whereIn('status', ['settlement', 'success', 'capture'])
                        ->whereBetween('created_at', [$startQuery, $endQuery])
                        ->sum('gross_amount');

        // 4. Total Pendapatan Donasi
        $totalDonasi = Donation::whereIn('status', ['settlement', 'success', 'capture'])
                        ->whereBetween('created_at', [$startQuery, $endQuery])
                        ->sum('amount');

        // 5. Total Keseluruhan
        $totalPendapatan = $totalMagz + $totalLangganan + $totalPustaka + $totalDonasi;

        // 6. Total Pengguna Premium Aktif
        $totalPremium = $subscribers->count();

        // 7. Data Transaksi Terbaru MAGZ
        $recentMagzTx = MagzTransaction::with(['pengguna', 'magz'])
            ->whereBetween('created_at', [$startQuery, $endQuery])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        // 8. Data Donasi Terbaru
        $recentDonations = Donation::whereBetween('created_at', [$startQuery, $endQuery])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        // 9. Data Langganan Terbaru
        $recentSubs = Subscriber::with(['pengguna', 'histories' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])
            ->whereBetween('created_at', [$startQuery, $endQuery])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();
        // 10. Data Pustaka Terbaru
        $recentPustakaTx = PustakaTransaction::with(['pengguna', 'pustaka'])
            ->whereBetween('created_at', [$startQuery, $endQuery])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return view('admin.keuangan.index', compact(
            'totalMagz', 'totalLangganan', 'totalPustaka', 'totalDonasi', 'totalPendapatan', 'totalPremium', 
            'recentMagzTx', 'recentSubs', 'recentDonations', 'recentPustakaTx', 'startDate', 'endDate'
        ));
    }

    public function syncMidtrans()
    {
        $synced = 0;

        // Sync Donations
        $pendingDonations = Donation::where('status', 'pending')->get();
        foreach ($pendingDonations as $d) {
            try {
                $status = \Midtrans\Transaction::status($d->order_id);
                if (isset($status->transaction_status) && in_array($status->transaction_status, ['settlement', 'capture'])) {
                    $d->update(['status' => 'success']);
                    $synced++;
                } elseif (isset($status->transaction_status) && in_array($status->transaction_status, ['expire', 'cancel'])) {
                    $d->update(['status' => 'failed']);
                }
            } catch (\Exception $e) {}
        }

        // Sync CartTransactions
        $pendingCarts = \App\Models\CartTransaction::where('status', 'pending')->get();
        foreach ($pendingCarts as $c) {
            try {
                $status = \Midtrans\Transaction::status($c->order_id);
                if (isset($status->transaction_status) && in_array($status->transaction_status, ['settlement', 'capture'])) {
                    // Trigger the success processor which creates Magz/Pustaka records!
                    app(\App\Http\Controllers\CartController::class)->processSuccessfulTransaction($c->order_id);
                    $synced++;
                } elseif (isset($status->transaction_status) && in_array($status->transaction_status, ['expire', 'cancel'])) {
                    $c->update(['status' => 'failed']);
                }
            } catch (\Exception $e) {}
        }

        // Sync MagzTransactions (yang langsung)
        $pendingMagz = MagzTransaction::where('status', 'pending')->get();
        foreach ($pendingMagz as $m) {
            try {
                $status = \Midtrans\Transaction::status($m->order_id);
                if (isset($status->transaction_status) && in_array($status->transaction_status, ['settlement', 'capture'])) {
                    $m->update(['status' => 'success']);
                    \App\Models\PenggunaKoleksi::firstOrCreate([
                        'pengguna_id' => $m->pengguna_id,
                        'publikasi_id' => $m->publikasi_id
                    ]);
                    $synced++;
                } elseif (isset($status->transaction_status) && in_array($status->transaction_status, ['expire', 'cancel'])) {
                    $m->update(['status' => 'failed']);
                }
            } catch (\Exception $e) {}
        }
        
        // Sync PustakaTransactions (yang langsung)
        $pendingPustaka = PustakaTransaction::where('status', 'pending')->get();
        foreach ($pendingPustaka as $p) {
            try {
                $status = \Midtrans\Transaction::status($p->order_id);
                if (isset($status->transaction_status) && in_array($status->transaction_status, ['settlement', 'capture'])) {
                    $p->update(['status' => 'success']);
                    \App\Models\PenggunaKoleksi::firstOrCreate([
                        'pengguna_id' => $p->pengguna_id,
                        'pustaka_id' => $p->pustaka_id
                    ]);
                    $synced++;
                } elseif (isset($status->transaction_status) && in_array($status->transaction_status, ['expire', 'cancel'])) {
                    $p->update(['status' => 'failed']);
                }
            } catch (\Exception $e) {}
        }

        return redirect()->back()->with('success', "Berhasil menyinkronkan $synced transaksi tertunda dengan Midtrans!");
    }
}
