<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EcommerceController;
use App\Http\Controllers\StockSyncController;
use App\Http\Controllers\TrackingController;

/*
|--------------------------------------------------------------------------
| Web Routes - RizkyMerch Laravel 12
|--------------------------------------------------------------------------
*/

// Halaman Utama E-Commerce (Katalog, Live GPS, QR Resi, Auto-Sync)
Route::get('/', [EcommerceController::class, 'index'])->name('ecommerce.index');

// Aksi Pemesanan & Checkout
Route::post('/order/checkout', [EcommerceController::class, 'checkout'])->name('ecommerce.checkout');

// Halaman Cek Resi & QR Digital
Route::get('/order/{resi}/receipt', [EcommerceController::class, 'showReceipt'])->name('ecommerce.receipt');

// Halaman Live Tracking GPS Kurir
Route::get('/order/{resi}/track', [TrackingController::class, 'viewTracking'])->name('ecommerce.track');

