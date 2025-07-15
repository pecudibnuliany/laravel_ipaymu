# 📦 Laravel 12 Payment Gateway Integration with iPaymu

**Bahasa Indonesia | English**

---

## 📌 Deskripsi

Proyek ini adalah contoh implementasi **Payment Gateway iPaymu** pada **Laravel 12**, mendukung:
- Virtual Account (VA) — contoh: BCA VA.
- Perhitungan biaya tambahan otomatis (1.8%).
- Signature generation aman sesuai standar iPaymu.
- Callback server-to-server untuk update status transaksi.
- Tes endpoint callback lokal dengan **Ngrok**.

---

## 🚀 Fitur Utama

✅ Laravel 12  
✅ Direct Payment API iPaymu (v2)  
✅ Virtual Account (VA) — Contoh BCA  
✅ Hitung fee dinamis 1.8%  
✅ Callback / Webhook handler  
✅ Logging callback ke `storage/logs/laravel.log`  
✅ Form checkout sederhana  
✅ Halaman `thanks` untuk menampilkan detail VA

---

## 📂 Struktur Utama

```

app/Http/Controllers/PaymentController.php
resources/views/checkout.blade.php
resources/views/thanks.blade.php
routes/web.php

````

---

## ⚙️ Requirements

- PHP >= 8.1
- Composer
- Laravel 12.x
- Ngrok (opsional, untuk tes callback di lokal)
- Database (MySQL, SQLite, atau PostgreSQL)

---

## 🔑 Konfigurasi Awal

1️⃣ **Clone repository**

```bash
git clone https://github.com/yourusername/your-repo.git
cd your-repo
````

2️⃣ **Install dependency**

```bash
composer install
```

3️⃣ **Copy file `.env`**

```bash
cp .env.example .env
php artisan key:generate
```

4️⃣ **Set konfigurasi di `.env`**

```env
IPAYMU_VA=YOUR_VA_NUMBER
IPAYMU_API_KEY=YOUR_API_KEY
IPAYMU_URL=https://sandbox.ipaymu.com/api/v2/payment/direct
```

---

## 🧾 Cara Kerja

1️⃣ User mengisi **form checkout**.
2️⃣ Laravel hit API iPaymu → signature dibuat dengan format **POST\:VA\:SHA256(BODY)\:APIKEY**.
3️⃣ iPaymu balas data VA (`PaymentNo`, `Expired`, dll).
4️⃣ Laravel redirect ke halaman **thanks**, menampilkan detail VA ke user.
5️⃣ User bayar ke VA.
6️⃣ iPaymu memanggil endpoint **callback** untuk update status order ke `paid`.

---

## 🌐 Jalankan Local Server

```bash
php artisan serve
```

Akses:

```
http://localhost:8000/checkout
```

---

## 🔔 Jalankan Callback dengan Ngrok

1️⃣ Jalankan Ngrok:

```bash
ngrok http 8000
```

2️⃣ Ganti `notifyUrl`:

```env
IPAYMU_NOTIFY_URL=https://your-ngrok-id.ngrok.io/callback
```

Atau di `PaymentController`:

```php
'notifyUrl' => 'https://your-ngrok-id.ngrok.io/callback'
```

3️⃣ Pastikan route `/callback` **bebas CSRF**:

```php
protected $except = [
    '/callback',
];
```

---

## ✅ Database & Orders

Contoh kolom:

* `reference_id` — ID unik order.
* `status` — `unpaid` | `paid`.
* `ipaymu_transaction_id`
* `paid_at`

Saat callback masuk, Laravel:

* Temukan `ReferenceId`
* Tandai `status = paid`
* Simpan `TransactionId` & `paid_at`.

---

## 📄 Contoh Tabel Orders

```php
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->string('reference_id')->unique();
    $table->string('status')->default('unpaid');
    $table->string('ipaymu_transaction_id')->nullable();
    $table->timestamp('paid_at')->nullable();
    $table->timestamps();
});
```

---

## ✅ Log Callback

Semua callback disimpan ke `storage/logs/laravel.log`:

```php
\Log::info('iPaymu Callback:', $data);
```

---

## ⚡ Tips Produksi

✔️ Gunakan HTTPS untuk `notifyUrl` (wajib).
✔️ Jangan expose API Key ke repo publik.
✔️ Gunakan `.env` untuk semua kredensial.
✔️ Simpan `reference_id` di database order agar callback bisa cocok.
✔️ Gunakan webhook tester (Ngrok) untuk develop di local.

---

## 📌 License

Open Source — bebas digunakan dan dimodifikasi.

---

## ✨ Kontak

Proyek ini dibuat untuk keperluan belajar.
Feel free untuk fork, clone, atau laporkan issue. 🚀

````

---

## ✅ **Cara Pakai**

1️⃣ Buat file `README.md` di root:  
```bash
touch README.md
````

2️⃣ Copy semua isi di atas, paste ke file itu.

3️⃣ Commit & push:

```bash
git add README.md
git commit -m "Add complete bilingual README"
git push origin main
```

---


