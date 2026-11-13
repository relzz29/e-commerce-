<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Str;

class EcommerceController extends Controller
{
    /**
     * Tampilkan Halaman Utama E-Commerce RizkyMerch
     */
    public function index()
    {
        // Data katalog sepatu modern
        $products = [
            [
                'id' => 1,
                'name' => 'Classic Black Flatshoes Ergonomic',
                'category' => 'flatshoes',
                'sku' => 'RM-FS-BLK-01',
                'price' => 185000,
                'stock' => 14,
                'image' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'description' => 'Sepatu flatshoes wanita dengan bantalan memory foam empuk ekstra nyaman untuk jalan seharian tanpa lecet.'
            ],
            [
                'id' => 2,
                'name' => 'Soft Velvet Mules Shoes Cream',
                'category' => 'flatshoes',
                'sku' => 'RM-FS-CRM-02',
                'price' => 195000,
                'stock' => 8,
                'image' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'description' => 'Sentuhan bahan beludru premium dengan sol karet anti slip, sangat pas untuk kerja kantor maupun acara santai.'
            ],
            [
                'id' => 3,
                'name' => 'CloudWalk Air White Sneakers Ultralight',
                'category' => 'sneakers',
                'sku' => 'RM-SN-WHT-03',
                'price' => 245000,
                'stock' => 18,
                'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'description' => 'Sneakers putih kasual super ringan dengan bantalan udara peredam guncangan, nyaman untuk kuliah dan jalan-jalan.'
            ],
            [
                'id' => 4,
                'name' => 'Urban Oxford Leather Loafers Mocca',
                'category' => 'loafers',
                'sku' => 'RM-LF-MCC-04',
                'price' => 295000,
                'stock' => 12,
                'image' => 'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'description' => 'Sepatu loafers formal bahan kulit sintetis lembut dengan sol lentur, memberikan kesan rapi dan elegan.'
            ],
            [
                'id' => 5,
                'name' => 'Retro Chunky Sport Runner Sneakers',
                'category' => 'sneakers',
                'sku' => 'RM-SN-RET-05',
                'price' => 265000,
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'description' => 'Sepatu sneakers gaya retro modern dengan sol tebal proporsional yang menambah kenyamanan pijakan kaki.'
            ],
            [
                'id' => 6,
                'name' => 'All-in-One Shoe Cleaner & Waterproof Spray',
                'category' => 'care',
                'sku' => 'RM-CR-CLN-06',
                'price' => 58000,
                'stock' => 24,
                'image' => 'https://images.unsplash.com/photo-1595341888016-a392ef81b7de?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'description' => 'Paket pembersih busa praktis tanpa bilas air dan semprotan anti air pelindung sepatu dari kotoran dan hujan.'
            ]
        ];

        return view('ecommerce.index', compact('products'));
    }

    /**
     * Proses Pemesanan / Checkout Ringkas Ramah Pengguna
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_method' => 'required|string',
            'cart_items' => 'required|array'
        ]);

        $resiCode = 'RM-TRX-' . date('Ym') . '-' . strtoupper(Str::random(6));

        // Generate pesanan baru
        $order = [
            'resi' => $resiCode,
            'customer_name' => $validated['name'],
            'customer_phone' => $validated['phone'],
            'customer_address' => $validated['address'],
            'payment_method' => $validated['payment_method'],
            'status' => 'diproses',
            'created_at' => now()
        ];

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat! Kode Resi QR telah digenerate.',
            'order' => $order
        ]);
    }

    /**
     * Tampilkan E-Resi Digital & QR Code
     */
    public function showReceipt($resi)
    {
        return view('ecommerce.index', [
            'activeResi' => $resi,
            'defaultTab' => 'receipt'
        ]);
    }
}

