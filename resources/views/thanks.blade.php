<!DOCTYPE html>
<html>
<head>
    <title>Terima Kasih</title>
</head>
<body>
<h1>Transaksi Berhasil!</h1>
<p>Session ID: {{ $payment['SessionId'] }}</p>
<p>Transaction ID: {{ $payment['TransactionId'] }}</p>
<p>Reference ID: {{ $payment['ReferenceId'] }}</p>
<p>VA: {{ $payment['PaymentNo'] }}</p>
<p>Channel: {{ $payment['Channel'] }}</p>
<p>Total: Rp {{ number_format($payment['Total'], 0, ',', '.') }}</p>
<p>Bayar sebelum: {{ $payment['Expired'] }}</p>

<p>Silakan transfer ke VA di atas sebelum waktu expired.</p>
</body>
</html>
