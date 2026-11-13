# 👟 Rizky Shoes - Modern Footwear E-Commerce (Laravel 12)

Aplikasi E-Commerce khusus **Toko Sepatu & Footwear** modern dengan desain yang bersih (*clean*), elegan, dan dirancang khusus agar **sangat mudah dipahami oleh pembeli pemula / awam teknologi (*user gaptek*)**. Dilengkapi fitur **Panduan Ukuran Kaki Sederhana (Size Chart)** dan **Garansi Bebas Tukar Ukuran Gratis** jika sepatu kekecilan atau kebesaran.

Dilengkapi dengan 3 fitur utama khusus:
1. **Auto-Sync Stok Shopee & TikTok Shop** (Stok nomor & ukuran sepatu multi-channel terpadu real-time)
2. **QR Code Resi Digital (Pengganti Kertas 100%)** (Paperless Airwaybill & Bukti Pengiriman/Retur Ukuran)
3. **Live Tracking GPS Kurir Logistik** (Peta interaktif Leaflet.js real-time & simulasi motor kurir pengantar sepatu)

---

## 🌟 Fitur-Fitur Utama

### 1. 🔄 Auto-Sync Stok Shopee & TikTok
* **Omnichannel Inventory Hub**: Persediaan barang di Website, Shopee Mall, dan TikTok Shop tersinkronisasi 100% otomatis secara real-time.
* **Webhook & Auto-Deduct**: Jika ada pesanan masuk di TikTok Live atau Shopee, stok di website otomatis berkurang saat itu juga sehingga mencegah *overselling* (kehabisan stok tanpa sadar).
* **Simulator Interaktif**: Tombol uji coba simulasi order marketplace langsung di halaman web untuk menguji pengurangan stok seketika.

### 2. 📱 QR Code Resi (Pengganti Kertas / Paperless)
* **Digital Shipping Label (E-Resi)**: Pengganti resi cetak kertas termal, ramah lingkungan (*eco-friendly*), dan tidak bisa hilang dari HP.
* **Simulator Scanner Kurir**: Kurir cukup memindai QR Code di layar HP pembeli untuk verifikasi serah terima paket.
* **Tombol Cepat**: Fitur simpan resi ke galeri HP, bagikan ke WhatsApp, dan form retur instan tanpa perlu mencetak formulir.

### 3. 🛵 Live Tracking GPS Kurir Logistik
* **Peta Interaktif Real-Time (Leaflet.js + OpenStreetMap)**: Menampilkan posisi Gudang RizkyMerch, sepeda motor kurir, dan rumah penerima.
* **Telemetri Kurir**: Dilengkapi informasi kecepatan motor, sisa jarak kilometer, estimasi waktu tiba (ETA), dan baterai GPS.
* **Kontak Langsung**: Tombol 1-klik untuk WhatsApp dan telepon kurir langsung jika butuh koordinasi alamat.

### 4. 👵 Desain Clean & Ramah Pengguna Gaptek
* **Navigasi Sederhana**: Tombol besar, teks kontras tinggi, dan istilah bahasa Indonesia sehari-hari.
* **Panduan 3 Langkah Belanja**: Panduan visual yang membimbing pembeli baru dari memilih produk hingga checkout.
* **Floating WhatsApp Button**: Bantuan cepat customer service yang selalu siap mendampingi pembeli.

---

## 📂 Struktur File Project

```text
rizkymerch/
├── app/
│   ├── Http/Controllers/
│   │   ├── EcommerceController.php   # Controller utama e-commerce & checkout
│   │   ├── StockSyncController.php   # Controller sinkronisasi Shopee & TikTok
│   │   └── TrackingController.php    # Controller Live GPS & verifikasi QR
│   └── Models/
│       ├── Product.php               # Model data produk & stok
│       ├── Order.php                 # Model pesanan & koordinat kurir
│       └── ChannelStock.php          # Model stok per marketplace
├── database/migrations/
│   ├── 2026_01_01_000001_create_products_table.php
│   ├── 2026_01_01_000002_create_orders_table.php
│   └── 2026_01_01_000003_create_channel_stocks_table.php
├── resources/
│   └── views/
│       └── ecommerce/
│           └── index.blade.php       # Tampilan frontend lengkap (Blade + Tailwind + Alpine.js + Leaflet)
├── routes/
│   ├── web.php                       # Routing halaman web
│   └── api.php                       # Webhook marketplace & API telemetri GPS
├── composer.json                     # Konfigurasi dependensi Laravel 12
└── .env.example                      # Template variabel lingkungan
```

---

## 🚀 Cara Menjalankan Project

### 1. Prasyarat
* PHP 8.2+
* Composer

### 2. Instalasi Dependensi
```bash
composer install
```

### 3. Jalankan Server Pengembangan
```bash
php artisan serve
```
Buka browser di: `http://localhost:8000`

> **Tips Cepat:** Anda juga dapat langsung membuka file [index.blade.php](file:///c:/Users/admin/OneDrive/Documents/rizkymerch/resources/views/ecommerce/index.blade.php) di browser untuk melihat preview interaktif antarmuka secara langsung tanpa server!

