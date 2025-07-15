<!DOCTYPE html>
<html>
<head>
    <title>Checkout iPaymu</title>
</head>
<body>
<h1>Checkout</h1>
@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif
<form method="POST" action="/checkout/process">
    @csrf
    <label>Nama</label><br>
    <input type="text" name="name" value="Putu Made Nyoman Ketut"><br>

    <label>Telepon</label><br>
    <input type="text" name="phone" value="081234567890"><br>

    <label>Email</label><br>
    <input type="email" name="email" value="test@example.com"><br>

    <label>Amount</label><br>
    <input type="number" name="amount" value="100000"><br><br>

    <button type="submit">Bayar Sekarang</button>
</form>
</body>
</html>
