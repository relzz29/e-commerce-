<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockSyncController;
use App\Http\Controllers\TrackingController;

/*
|--------------------------------------------------------------------------
| API Routes - Multi-channel Webhook & Live Telemetry
|--------------------------------------------------------------------------
*/

// Fitur #1: Auto-Sync Shopee & TikTok Webhook Endpoints
Route::prefix('sync')->group(function () {
    Route::post('/shopee/webhook', [StockSyncController::class, 'handleShopeeWebhook']);
    Route::post('/tiktok/webhook', [StockSyncController::class, 'handleTikTokWebhook']);
    Route::get('/status', [StockSyncController::class, 'getSyncStatus']);
    Route::post('/trigger-manual', [StockSyncController::class, 'triggerManualSync']);
});

// Fitur #2: QR Code Resi Verification Scanner
Route::post('/resi/verify', [TrackingController::class, 'verifyQrReceipt']);

// Fitur #3: Live GPS Kurir Telemetry Stream
Route::prefix('courier')->group(function () {
    Route::post('/update-location', [TrackingController::class, 'updateCourierLocation']);
    Route::get('/location/{resi}', [TrackingController::class, 'getCourierLocation']);
});

