<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showCheckout()
    {
        return view('checkout');
    }

    public function processCheckout(Request $request)
    {
        $va = env('IPAYMU_VA'); // VA iPaymu
        $apiKey = env('IPAYMU_API_KEY'); // API Key iPaymu
        $url = env('IPAYMU_URL'); // Sandbox atau Production

        // Ambil amount dari request
        $baseAmount = (float)($request->amount);

        // Tambahkan fee 1.8%
        $fee = $baseAmount * 0.018;
        $totalAmount = round($baseAmount + $fee); // Biasanya dibulatkan ke integer

        // Request Body
        $body = [
            'name' => trim($request->name),
            'phone' => trim($request->phone ),
            'email' => trim($request->email),
            'amount' => $totalAmount,
            'notifyUrl' => trim(url('/callback')),
            'referenceId' => '1234', // transaksi id
            'paymentMethod' => 'qris', // misal virtual account
            'paymentChannel' => 'mpm', // misal BCA
        ];

        // JSON body & hashed body
        $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody = strtolower(hash('sha256', $jsonBody));

        // Signature
        $stringToSign = strtoupper('POST') . ':' . $va . ':' . $requestBody . ':' . $apiKey;
        $signature = hash_hmac('sha256', $stringToSign, $apiKey);
        $timestamp = date('YmdHis');

        // Headers
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'va: ' . $va,
            'signature: ' . $signature,
            'timestamp: ' . $timestamp
        ];

        // cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return back()->with('error', 'cURL Error: ' . $err);
        }

        $result = json_decode($response, true);

        if ($result['Status'] == 200 && $result['Success'] === true) {
            // Simpan data VA ke session, database, dsb.
            return redirect()->route('checkout.thanks')->with('payment', $result['Data']);
        } else {
            return back()->with('error', 'Gagal memproses pembayaran: ' . json_encode($result));
        }
    }

    public function thanks()
    {
        $payment = session('payment');

        if (!$payment) {
            return 'Tidak ada data pembayaran.';
        }

        return view('thanks', compact('payment'));
    }
}
