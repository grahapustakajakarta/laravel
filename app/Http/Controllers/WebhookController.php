<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? '';

        if (str_starts_with($orderId, 'DONATE-')) {
            return app(DonationController::class)->notification($request);
        } elseif (str_starts_with($orderId, 'CART-')) {
            return app(CartController::class)->notification($request);
        } elseif (str_starts_with($orderId, 'SUB-')) {
            return app(SubscribeController::class)->notification($request);
        } elseif (str_starts_with($orderId, 'PST-')) {
            return app(PustakaController::class)->notification($request);
        } elseif (str_starts_with($orderId, 'MGZ-')) {
            return app(PublikasiController::class)->notification($request);
        }

        Log::warning('Unhandled Midtrans Webhook: ' . $orderId);
        return response()->json(['message' => 'OK']); // Always return 200 to Midtrans to prevent retries
    }
}
