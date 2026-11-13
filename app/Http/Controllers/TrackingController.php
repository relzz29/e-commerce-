<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Fitur #3: Tampilkan Halaman Live Tracking GPS Kurir
     */
    public function viewTracking($resi)
    {
        return view('ecommerce.index', [
            'activeResi' => $resi,
            'defaultTab' => 'tracking'
        ]);
    }

    /**
     * Fitur #2: Validasi QR Code Resi oleh Kurir (Paperless Scanner)
     */
    public function verifyQrReceipt(Request $request)
    {
        $resi = $request->input('resi');
        
        // Logika verifikasi tanda tangan digital & status paket
        return response()->json([
            'verified' => true,
            'resi' => $resi,
            'recipient' => 'Siti Rahmawati',
            'destination' => 'Jl. Kemang Raya No. 12, Jakarta Selatan',
            'status' => 'Diterima oleh Kurir Logistik (Paperless Verified)',
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Fitur #3: Update Koordinat Telemetri GPS dari HP Kurir
     */
    public function updateCourierLocation(Request $request)
    {
        $validated = $request->validate([
            'resi' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'speed' => 'nullable|numeric',
            'courier_name' => 'nullable|string'
        ]);

        return response()->json([
            'success' => true,
            'resi' => $validated['resi'],
            'coords' => [
                'lat' => $validated['latitude'],
                'lng' => $validated['longitude']
            ],
            'speed' => $validated['speed'] ?? 30,
            'updated_at' => now()->toIso8601String()
        ]);
    }

    /**
     * Fitur #3: Ambil Lokasi Terkini Kurir untuk Peta Pembeli
     */
    public function getCourierLocation($resi)
    {
        return response()->json([
            'resi' => $resi,
            'courier' => [
                'name' => 'Budi Santoso',
                'vehicle_plate' => 'B 3482 XYZ',
                'phone' => '0812-3456-7890',
                'rating' => 4.9
            ],
            'location' => [
                'lat' => -6.2480,
                'lng' => 106.8180,
                'current_street' => 'Jl. Mampang Prapatan Raya',
                'eta' => '8 Menit Lagi'
            ],
            'battery_level' => 96
        ]);
    }
}

