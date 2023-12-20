<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function notification(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);
        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('midtrans.server_key'));
        if ($notification->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        // notifikasi webhook midtrans
        $paymentNotification = new \Midtrans\Notification();

        $transaction = $paymentNotification->transaction_status;
        $type = $paymentNotification->payment_type;
        $fraud = $paymentNotification->fraud_status;
        $vaNumber = '';
        $vendorName = '';
        if (!empty($paymentNotification->va_numbers[0])) {
            $vaNumber = $paymentNotification->va_numbers[0]->va_number;
            $vendorName = $paymentNotification->va_numbers[0]->bank;
        }else{
            $vaNumber = '';
            $vendorName = '';
        }
        $paymentStatus = '';

        $order = Order::where('kode', $request->order_id)->first();

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'accept') {
                    // TODO set payment status in merchant's database to 'Success'
                    $order->update(['status_pembayaran' => 1]);
                    $paymentStatus = 'capture';
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            $order->update(['status_pembayaran' => 1]);
            $paymentStatus = 'settlement';
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            $paymentStatus = 'pending';
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            $paymentStatus = 'deny';
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $paymentStatus = 'expire';
        } else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            $paymentStatus = 'cancel';
        }

        $cek_payment = Payment::where('order_id', $order->id)->first();
        $paymentParams = [
            'order_id' => $order->id,
            'amount' => $paymentNotification->gross_amount,
            'method' => 'midtrans',
            'status' => $paymentStatus,
            'transaction_token' => $paymentNotification->transaction_id,
            'payment_type' => $type,
            'va_number' => $vaNumber,
            'vendor_name' => $vendorName,
            'payloads' => $payload,
        ];
        if(empty($cek_payment)){
            Payment::create($paymentParams);
        }else{
            $cek_payment->update($paymentParams);
        }

        $message = 'Payment status is : ' . $transaction;
        $response = [
            'code' => 200,
            'message' => $message,
        ];
        return response($response, 200);
    }
}
