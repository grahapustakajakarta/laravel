<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class DonationController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = config('services.midtrans.is_sanitized');
        Config::$is3ds        = config('services.midtrans.is_3ds');
    }

    public function createSnapToken(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $orderId = 'DONATE-' . strtoupper(Str::random(8)) . '-' . time();
        $amount = (int) $request->amount;

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => 'Generous',
                'last_name'  => 'Donor',
            ],
            'item_details' => [
                [
                    'id'       => 'DONATION',
                    'price'    => $amount,
                    'quantity' => 1,
                    'name'     => 'Donasi untuk Galeri Buku Jakarta',
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            // Simpan record donation ke database sebagai pending
            Donation::create([
                'order_id'   => $orderId,
                'amount'     => $amount,
                'status'     => 'pending',
                'donor_name' => 'Generous Donor',
            ]);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id'   => $orderId,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function notification(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (!$orderId) return response()->json(['message' => 'Invalid'], 400);

        $donation = Donation::where('order_id', $orderId)->first();
        if (!$donation) return response()->json(['message' => 'Not Found'], 404);

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            if ($transactionStatus == 'capture' && $fraudStatus != 'accept') {
                return response()->json(['message' => 'Fraud detected'], 400);
            }
            $donation->update(['status' => 'success']);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $donation->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'OK']);
    }
}
