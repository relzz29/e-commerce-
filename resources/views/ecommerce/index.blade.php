<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rizky Shoes & Footwear - Toko Sepatu Modern Ramah Pengguna</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
                        },
                        shopee: '#ee4d2d',
                        tiktok: '#010101',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Leaflet CSS for Live GPS Tracking -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            -webkit-tap-highlight-color: transparent;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .pulse-ring {
            box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.7);
            animation: pulse-ring 2s infinite;
        }
        @keyframes pulse-ring {
            0% {
                box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.7);
            }
            70% {
                box-shadow: 0 0 0 14px rgba(79, 70, 229, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(79, 70, 229, 0);
            }
        }
    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-brand-500 selection:text-white"
      x-data="ecommerceApp()" 
      x-init="initApp()">

    <!-- NOTIFIKASI TOAST (Sangat Ramah Pengguna Gaptek) -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col gap-2 max-w-sm w-full pointer-events-none">
        <template x-for="(toast, index) in toasts" :key="index">
            <div x-show="toast.show" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="pointer-events-auto p-4 rounded-xl shadow-xl flex items-center gap-3 border text-sm font-medium"
                 :class="{
                    'bg-slate-900 text-white border-slate-700': toast.type === 'info',
                    'bg-emerald-600 text-white border-emerald-500': toast.type === 'success',
                    'bg-amber-600 text-white border-amber-500': toast.type === 'warning',
                    'bg-rose-600 text-white border-rose-500': toast.type === 'error'
                 }">
                <i :class="toast.icon" class="text-lg"></i>
                <span class="flex-1" x-text="toast.message"></span>
                <button @click="toast.show = false" class="text-white/80 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </template>
    </div>

    <!-- PANDUAN BANNER ATAS KHUSUS PEMULA / GAPTEK -->
    <div class="bg-gradient-to-r from-brand-600 via-indigo-600 to-purple-600 text-white py-2 px-4 text-xs sm:text-sm">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center gap-2">
                <span class="bg-white/20 text-white font-bold px-2 py-0.5 rounded-full text-[11px]">Garansi Ukuran Pas</span>
                <span>👟 Sepatu kekecilan / kebesaran? <strong>Bisa tukar ukuran gratis</strong> cukup tunjukkan QR Resi ke kurir!</span>
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold">
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-shoe-prints text-amber-300"></i> Sol Anti Slip &amp; Empuk</span>
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-truck-fast text-emerald-300"></i> Resi Digital Tanpa Kertas</span>
            </div>
        </div>
    </div>

    <!-- NAVBAR UTAMA -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center gap-4">
                
                <!-- Logo & Tagline -->
                <div class="flex items-center gap-3 cursor-pointer" @click="changeTab('shop')">
                    <div class="w-12 h-12 bg-gradient-to-tr from-brand-600 to-indigo-500 rounded-2xl flex items-center justify-center text-white text-xl font-extrabold shadow-md shadow-brand-500/20">
                        <i class="fa-solid fa-shoe-prints"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-1">
                            Rizky Shoes<span class="text-brand-600">.</span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium">Toko Sepatu Nyaman &amp; Stok Otomatis</p>
                    </div>
                </div>

                <!-- Navigasi Menu Ramah Pengguna -->
                <nav class="hidden md:flex items-center gap-1 lg:gap-2 bg-slate-100 p-1.5 rounded-2xl border border-slate-200">
                    <button @click="changeTab('shop')" 
                            :class="currentTab === 'shop' ? 'bg-white text-brand-600 font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 font-medium'" 
                            class="px-4 py-2 rounded-xl text-sm transition-all flex items-center gap-2">
                        <i class="fa-solid fa-bag-shopping text-base"></i>
                        <span>Katalog Belanja</span>
                    </button>
                    
                    <button @click="changeTab('tracking')" 
                            :class="currentTab === 'tracking' ? 'bg-white text-brand-600 font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 font-medium'" 
                            class="px-4 py-2 rounded-xl text-sm transition-all flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot text-base text-rose-500"></i>
                        <span>Live GPS Kurir</span>
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                    </button>

                    <button @click="changeTab('receipt')" 
                            :class="currentTab === 'receipt' ? 'bg-white text-brand-600 font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 font-medium'" 
                            class="px-4 py-2 rounded-xl text-sm transition-all flex items-center gap-2">
                        <i class="fa-solid fa-qrcode text-base text-emerald-600"></i>
                        <span>QR Resi Digital</span>
                    </button>

                    <button @click="changeTab('sync')" 
                            :class="currentTab === 'sync' ? 'bg-white text-brand-600 font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900 font-medium'" 
                            class="px-4 py-2 rounded-xl text-sm transition-all flex items-center gap-2">
                        <i class="fa-solid fa-arrows-rotate text-base text-indigo-600"></i>
                        <span>Auto-Sync Stok</span>
                        <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-1.5 py-0.5 rounded-md">Live</span>
                    </button>
                </nav>

                <!-- Tombol Aksi Kanan (Pencarian & Keranjang Belanja Jelas) -->
                <div class="flex items-center gap-3">
                    
                    <!-- Tombol Keranjang Belanja (Besar & Jelas untuk Gaptek) -->
                    <button @click="cartOpen = true" 
                            class="relative flex items-center gap-2.5 bg-brand-50 hover:bg-brand-100 text-brand-700 px-4 py-2.5 rounded-2xl font-bold border border-brand-200 transition-all active:scale-95">
                        <div class="relative">
                            <i class="fa-solid fa-cart-shopping text-lg"></i>
                            <span x-show="totalCartItems > 0" 
                                  x-text="totalCartItems"
                                  class="absolute -top-2.5 -right-2.5 bg-rose-600 text-white text-xs font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-xs">
                            </span>
                        </div>
                        <span class="hidden sm:inline text-sm">Keranjang</span>
                        <span class="text-xs font-extrabold text-brand-800 hidden lg:inline" x-text="formatRupiah(cartTotal)"></span>
                    </button>

                    <!-- Profil / Bantuan -->
                    <button @click="openHelpModal()" 
                            class="w-11 h-11 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition-colors"
                            title="Panduan Cara Belanja">
                        <i class="fa-solid fa-circle-question text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Bar Tab (di bawah navbar pada layar kecil) -->
            <div class="flex md:hidden overflow-x-auto py-2 gap-2 border-t border-slate-100 text-xs font-semibold">
                <button @click="changeTab('shop')" :class="currentTab === 'shop' ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg whitespace-nowrap">Katalog</button>
                <button @click="changeTab('tracking')" :class="currentTab === 'tracking' ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg whitespace-nowrap">GPS Kurir</button>
                <button @click="changeTab('receipt')" :class="currentTab === 'receipt' ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg whitespace-nowrap">QR Resi</button>
                <button @click="changeTab('sync')" :class="currentTab === 'sync' ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg whitespace-nowrap">Sync Shopee & TikTok</button>
            </div>
        </div>
    </header>

    <!-- KONTEN UTAMA: 4 TAB INTERAKTIF -->

    <!-- ========================================== -->
    <!-- TAB 1: KATALOG BELANJA PRODUK (CLEAN & SIMPLE) -->
    <!-- ========================================== -->
    <main x-show="currentTab === 'shop'" x-transition:enter="transition ease-out duration-300" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Hero Banner Informatif -->
        <div class="relative bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl overflow-hidden mb-10 shadow-xl border border-slate-800">
            <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#4f46e5_1px,transparent_1px)] [background-size:16px_16px]"></div>
            
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center p-8 sm:p-12">
                <div class="lg:col-span-7 text-white">
                    <div class="inline-flex items-center gap-2 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-3.5 py-1 rounded-full text-xs font-semibold mb-4 backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Stok Sepatu Real-Time: Website + Shopee + TikTok
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight mb-4">
                        Sepatu Nyaman Anti Pegal, Melangkah Makin Percaya Diri.
                    </h1>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-6 max-w-xl">
                        Koleksi Sneakers, Flatshoes &amp; Loafers dengan insole busa empuk. Belanja tenang tanpa takut salah ukuran: <strong>Gratis tukar ukuran via QR Resi Digital!</strong>
                    </p>
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="#katalog" class="bg-brand-600 hover:bg-brand-500 text-white px-6 py-3.5 rounded-2xl font-bold shadow-lg shadow-brand-500/30 transition-all flex items-center gap-2 text-sm sm:text-base">
                            <i class="fa-solid fa-shoe-prints"></i>
                            <span>Pilih Model Sepatu</span>
                        </a>
                        <button @click="sizeGuideOpen = true" class="bg-white/10 hover:bg-white/20 text-white border border-white/20 px-5 py-3.5 rounded-2xl font-semibold backdrop-blur-md transition-all text-sm flex items-center gap-2">
                            <i class="fa-solid fa-ruler-combined text-amber-300"></i>
                            <span>Panduan Ukuran Kaki (Size Chart)</span>
                        </button>
                    </div>
                </div>

                <!-- Banner Feature Cards -->
                <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="bg-white/10 border border-white/15 backdrop-blur-md p-4 rounded-2xl text-white">
                        <div class="w-10 h-10 rounded-xl bg-shopee/20 text-shopee flex items-center justify-center text-xl mb-3 border border-shopee/30">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                        <h4 class="font-bold text-sm">Shopee Auto-Sync</h4>
                        <p class="text-slate-300 text-xs mt-1">Stok ukuran sepatu sinkron otomatis dari Shopee.</p>
                    </div>

                    <div class="bg-white/10 border border-white/15 backdrop-blur-md p-4 rounded-2xl text-white">
                        <div class="w-10 h-10 rounded-xl bg-cyan-400/20 text-cyan-300 flex items-center justify-center text-xl mb-3 border border-cyan-400/30">
                            <i class="fa-brands fa-tiktok"></i>
                        </div>
                        <h4 class="font-bold text-sm">TikTok Shop Sync</h4>
                        <p class="text-slate-300 text-xs mt-1">Live streaming TikTok langsung potong stok di sini.</p>
                    </div>

                    <div class="bg-white/10 border border-white/15 backdrop-blur-md p-4 rounded-2xl text-white">
                        <div class="w-10 h-10 rounded-xl bg-emerald-400/20 text-emerald-300 flex items-center justify-center text-xl mb-3 border border-emerald-400/30">
                            <i class="fa-solid fa-qrcode"></i>
                        </div>
                        <h4 class="font-bold text-sm">QR Resi &amp; Retur Size</h4>
                        <p class="text-slate-300 text-xs mt-1">Tukar ukuran sepatu tinggal tunjukkan QR ke kurir.</p>
                    </div>

                    <div class="bg-white/10 border border-white/15 backdrop-blur-md p-4 rounded-2xl text-white">
                        <div class="w-10 h-10 rounded-xl bg-rose-400/20 text-rose-300 flex items-center justify-center text-xl mb-3 border border-rose-400/30">
                            <i class="fa-solid fa-motorcycle"></i>
                        </div>
                        <h4 class="font-bold text-sm">Live GPS Tracking</h4>
                        <p class="text-slate-300 text-xs mt-1">Pantau posisi kurir pengantar sepatu di peta.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 LANGKAH CARA PESAN (Sangat Membantu Pembeli Gaptek) -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 mb-10 shadow-xs">
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-brand-600"></i> Cara Mudah Pesan Sepatu di Rizky Shoes
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-start gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-brand-100 text-brand-700 font-extrabold flex items-center justify-center shrink-0">1</div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">Pilih Model &amp; Ukuran Sepatu</h4>
                        <p class="text-slate-500 text-xs mt-0.5">Pilih nomor ukuran (36-44). Gunakan menu <strong>Panduan Ukuran</strong> jika ragu.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-700 font-extrabold flex items-center justify-center shrink-0">2</div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">Isi Alamat Rumah Sederhana</h4>
                        <p class="text-slate-500 text-xs mt-0.5">Tuliskan nama penerima dan nomor WhatsApp aktif agar kurir mudah menghubungi.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 font-extrabold flex items-center justify-center shrink-0">3</div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">Lacak Kurir &amp; Garansi Pas</h4>
                        <p class="text-slate-500 text-xs mt-0.5">Pantau kurir di peta. Jika ukuran sepatu tidak pas saat dicoba, tukar gratis pakai Resi QR!</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Kategori Sepatu & Pencarian -->
        <div id="katalog" class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Koleksi Sepatu Pilihan</h2>
                <p class="text-slate-500 text-sm">Stok ukuran di bawah selalu sinkron otomatis dengan Shopee &amp; TikTok</p>
            </div>

            <!-- Filter Buttons Kategori Sepatu -->
            <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                <button @click="selectedCategory = 'all'" 
                        :class="selectedCategory === 'all' ? 'bg-slate-900 text-white font-bold' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all">
                    Semua Sepatu
                </button>
                <button @click="selectedCategory = 'sneakers'" 
                        :class="selectedCategory === 'sneakers' ? 'bg-slate-900 text-white font-bold' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all">
                    Sneakers
                </button>
                <button @click="selectedCategory = 'flatshoes'" 
                        :class="selectedCategory === 'flatshoes' ? 'bg-slate-900 text-white font-bold' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all">
                    Flatshoes &amp; Mules
                </button>
                <button @click="selectedCategory = 'loafers'" 
                        :class="selectedCategory === 'loafers' ? 'bg-slate-900 text-white font-bold' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all">
                    Loafers &amp; Formal
                </button>
                <button @click="selectedCategory = 'care'" 
                        :class="selectedCategory === 'care' ? 'bg-slate-900 text-white font-bold' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all">
                    Perawatan Sepatu
                </button>
            </div>
        </div>

        <!-- DAFTAR PRODUK (GRID) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <template x-for="product in filteredProducts" :key="product.id">
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col group">
                    
                    <!-- Gambar & Badge Multi-Channel Sync -->
                    <div class="relative h-64 bg-slate-100 overflow-hidden cursor-pointer" @click="openProductDetail(product)">
                        <img :src="product.image" :alt="product.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        
                        <!-- Badge Auto-Sync Stok -->
                        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                            <span class="inline-flex items-center gap-1.5 bg-white/95 backdrop-blur-md text-emerald-700 text-[11px] font-bold px-2.5 py-1 rounded-lg shadow-sm border border-emerald-200">
                                <i class="fa-solid fa-arrows-rotate text-emerald-600 text-xs animate-spin-slow"></i>
                                <span>Stok Sync: <strong x-text="product.stock"></strong> pcs</span>
                            </span>
                            <span x-show="product.badge" 
                                  class="inline-flex items-center gap-1 bg-amber-500 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-md shadow-sm w-fit"
                                  x-text="product.badge">
                            </span>
                        </div>

                        <!-- Badge Channel Info -->
                        <div class="absolute bottom-3 right-3 flex items-center gap-1 bg-slate-900/80 backdrop-blur-sm text-white px-2 py-1 rounded-md text-[10px] font-semibold">
                            <span class="text-shopee"><i class="fa-solid fa-bag-shopping"></i> Shopee</span>
                            <span class="text-slate-400">•</span>
                            <span class="text-cyan-400"><i class="fa-brands fa-tiktok"></i> TikTok</span>
                        </div>
                    </div>

                    <!-- Informasi Produk -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                                <span class="uppercase tracking-wider font-semibold" x-text="product.category"></span>
                                <div class="flex items-center gap-1 text-amber-500">
                                    <i class="fa-solid fa-star text-xs"></i>
                                    <span class="font-bold text-slate-700" x-text="product.rating"></span>
                                    <span class="text-slate-400" x-text="'(' + product.sold + ' terjual)'"></span>
                                </div>
                            </div>

                            <h3 @click="openProductDetail(product)" class="text-slate-900 font-bold text-base hover:text-brand-600 transition-colors cursor-pointer line-clamp-1" x-text="product.name"></h3>
                            <p class="text-slate-500 text-xs mt-1 line-clamp-2" x-text="product.description"></p>
                        </div>

                        <!-- Harga & Tombol Beli Ramah Pemula -->
                        <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-slate-400 block line-through" x-show="product.originalPrice" x-text="formatRupiah(product.originalPrice)"></span>
                                <span class="text-lg font-black text-brand-700" x-text="formatRupiah(product.price)"></span>
                            </div>

                            <button @click="addToCart(product)" 
                                    class="bg-brand-600 hover:bg-brand-500 active:scale-95 text-white px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold shadow-md shadow-brand-500/20 transition-all flex items-center gap-2">
                                <i class="fa-solid fa-cart-plus"></i>
                                <span>+ Beli</span>
                            </button>
                        </div>
                    </div>

                </div>
            </template>
        </div>

    </main>

    <!-- ========================================== -->
    <!-- TAB 2: LIVE TRACKING GPS KURIR LOGISTIK -->
    <!-- ========================================== -->
    <main x-show="currentTab === 'tracking'" style="display: none;" x-transition:enter="transition ease-out duration-300" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-6 flex flex-col sm:flex-row justify-between sm:items-end gap-3">
            <div>
                <div class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-600 bg-rose-50 border border-rose-200 px-3 py-1 rounded-full mb-2">
                    <span class="w-2 h-2 rounded-full bg-rose-600 animate-ping"></span>
                    Fitur #3: Live Tracking GPS Satelit Kurir
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900">Pantau Posisi Kurir Secara Langsung</h2>
                <p class="text-slate-500 text-sm">Tidak perlu khawatir paket hilang. Lihat rute dan koordinat GPS sepeda motor kurir secara real-time.</p>
            </div>

            <!-- Kontrol Simulasi Kurir -->
            <div class="flex items-center gap-2">
                <button @click="toggleCourierSimulation()" 
                        class="px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm shadow-md transition-all flex items-center gap-2"
                        :class="isSimulating ? 'bg-amber-600 hover:bg-amber-500 text-white' : 'bg-emerald-600 hover:bg-emerald-500 text-white'">
                    <i :class="isSimulating ? 'fa-solid fa-pause' : 'fa-solid fa-play'"></i>
                    <span x-text="isSimulating ? 'Jeda Simulasi Motor' : 'Jalankan Perjalanan Kurir'"></span>
                </button>
                <button @click="resetCourierRoute()" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-3 py-2.5 rounded-xl text-xs font-bold transition-all" title="Ulangi dari Gudang">
                    <i class="fa-solid fa-rotate-left"></i>
                </button>
            </div>
        </div>

        <!-- Grid Tracking: Detail Pesanan + Peta Leaflet GPS Real -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Kolom Kiri: Status Paket & Info Kurir (4 Kolom) -->
            <div class="lg:col-span-4 flex flex-col gap-6">
                
                <!-- Card Status Pengiriman Saat Ini -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs">
                    <div class="flex justify-between items-center mb-4 pb-4 border-b border-slate-100">
                        <div>
                            <span class="text-xs text-slate-400 font-bold block uppercase">No. Resi Pengiriman</span>
                            <span class="text-base font-extrabold text-slate-900 font-mono" x-text="activeOrder.resi"></span>
                        </div>
                        <span class="px-3 py-1 bg-brand-100 text-brand-700 text-xs font-extrabold rounded-full flex items-center gap-1.5">
                            <i class="fa-solid fa-motorcycle text-brand-600"></i>
                            <span x-text="courierStatusText"></span>
                        </span>
                    </div>

                    <!-- Indikator Estimasi Tiba (Jelas untuk orang tua/gaptek) -->
                    <div class="bg-gradient-to-r from-brand-50 to-indigo-50 border border-brand-100 rounded-2xl p-4 mb-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold text-brand-700">Estimasi Tiba di Rumah:</span>
                                <div class="text-2xl font-black text-brand-900" x-text="courierETA"></div>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-brand-600 text-white flex items-center justify-center text-xl shadow-md shadow-brand-500/30">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                        </div>
                        <div class="w-full bg-brand-200 rounded-full h-2 mt-3 overflow-hidden">
                            <div class="bg-brand-600 h-2 rounded-full transition-all duration-500" :style="'width: ' + courierProgressPercent + '%'"></div>
                        </div>
                        <div class="flex justify-between items-center text-[11px] text-slate-500 mt-1.5 font-medium">
                            <span>Gudang RizkyMerch</span>
                            <span x-text="courierProgressPercent + '% Perjalanan'"></span>
                            <span>Rumah Anda</span>
                        </div>
                    </div>

                    <!-- Profil Kurir & Tombol Hubungi Cepat -->
                    <div class="border border-slate-200 rounded-2xl p-4 bg-slate-50/50">
                        <div class="flex items-center gap-3.5 mb-3">
                            <div class="relative">
                                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=120&q=80" 
                                     alt="Foto Kurir" 
                                     class="w-13 h-13 rounded-2xl object-cover border-2 border-white shadow-sm">
                                <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-slate-900 text-sm">Budi Santoso</h4>
                                <p class="text-xs text-slate-500">Kurir Prioritas J&amp;T Express</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="bg-slate-200 text-slate-800 text-[10px] font-mono font-bold px-2 py-0.5 rounded">B 3482 XYZ</span>
                                    <span class="text-amber-500 text-xs font-bold"><i class="fa-solid fa-star"></i> 4.9</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Hubungi Kurir (Sangat mudah diklik) -->
                        <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-200/60">
                            <a href="https://wa.me/6281234567890?text=Halo%20Pak%20Budi,%20saya%20penerima%20paket%20RizkyMerch%20nomor%20resi%20RM-TRX-202611-8892" 
                               target="_blank"
                               class="bg-emerald-600 hover:bg-emerald-500 text-white py-2 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-colors">
                                <i class="fa-brands fa-whatsapp text-sm"></i>
                                <span>WhatsApp Kurir</span>
                            </a>
                            <a href="tel:081234567890" 
                               class="bg-slate-800 hover:bg-slate-700 text-white py-2 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-colors">
                                <i class="fa-solid fa-phone text-xs"></i>
                                <span>Telepon Langsung</span>
                            </a>
                        </div>
                    </div>

                    <!-- Info Paket yang Dikirim -->
                    <div class="mt-5">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Barang dalam Pengiriman</h4>
                        <div class="flex items-center gap-3 p-3 bg-white border border-slate-200 rounded-2xl">
                            <img :src="activeOrder.itemImage" class="w-12 h-12 rounded-xl object-cover">
                            <div class="flex-1 min-w-0">
                                <h5 class="text-xs font-bold text-slate-900 truncate" x-text="activeOrder.itemName"></h5>
                                <p class="text-[11px] text-slate-500" x-text="activeOrder.itemVariant"></p>
                                <span class="text-xs font-extrabold text-brand-600" x-text="formatRupiah(activeOrder.price)"></span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Telemetri GPS Kurir (Kecepatan, Baterai GPS, Titik Terakhir) -->
                <div class="bg-slate-900 text-white rounded-3xl p-5 shadow-xs">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-satellite-dish text-emerald-400"></i>
                        <span>Sensor GPS Telemetri Kurir</span>
                    </h4>
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div class="bg-slate-800/80 p-3 rounded-xl border border-slate-700">
                            <span class="text-[10px] text-slate-400 block">Kecepatan</span>
                            <span class="text-base font-extrabold text-emerald-400" x-text="courierSpeed + ' km/h'"></span>
                        </div>
                        <div class="bg-slate-800/80 p-3 rounded-xl border border-slate-700">
                            <span class="text-[10px] text-slate-400 block">Baterai GPS</span>
                            <span class="text-base font-extrabold text-cyan-400">96%</span>
                        </div>
                        <div class="bg-slate-800/80 p-3 rounded-xl border border-slate-700">
                            <span class="text-[10px] text-slate-400 block">Jarak Sisa</span>
                            <span class="text-base font-extrabold text-amber-400" x-text="courierRemainingDistance + ' km'"></span>
                        </div>
                    </div>
                    <div class="mt-3 text-[11px] text-slate-400 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        <span>Koordinat Live: <span class="font-mono text-slate-300" x-text="currentCourierCoords.lat.toFixed(4) + ', ' + currentCourierCoords.lng.toFixed(4)"></span></span>
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: PETA LEAFLET INTERAKTIF (8 Kolom) -->
            <div class="lg:col-span-8 bg-white border border-slate-200 rounded-3xl p-4 sm:p-6 shadow-xs flex flex-col">
                <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                    <div>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg flex items-center gap-2">
                            <i class="fa-solid fa-map-location-dot text-rose-500"></i>
                            Peta Rute Perjalanan Motor Kurir
                        </h3>
                        <p class="text-xs text-slate-500">Rute dari Gudang RizkyMerch menuju Alamat Penerima</p>
                    </div>

                    <!-- Legend Peta -->
                    <div class="flex items-center gap-3 text-xs font-semibold bg-slate-100 px-3 py-1.5 rounded-xl">
                        <span class="flex items-center gap-1.5 text-slate-700">
                            <span class="w-3 h-3 rounded-full bg-indigo-600"></span> Gudang
                        </span>
                        <span class="flex items-center gap-1.5 text-slate-700">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span> Kurir Motor
                        </span>
                        <span class="flex items-center gap-1.5 text-slate-700">
                            <span class="w-3 h-3 rounded-full bg-rose-600"></span> Rumah Penerima
                        </span>
                    </div>
                </div>

                <!-- CONTAINER PETA INTERAKTIF LEAFLET -->
                <div class="relative w-full h-[450px] sm:h-[520px] rounded-2xl overflow-hidden border border-slate-200">
                    <div id="liveGpsMap" class="w-full h-full z-10"></div>

                    <!-- Floating Map Overlay Card -->
                    <div class="absolute bottom-4 left-4 z-20 bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-xl border border-slate-200/80 max-w-xs">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-900 mb-1">
                            <i class="fa-solid fa-compass text-brand-600 animate-spin"></i>
                            <span x-text="courierLocationNote"></span>
                        </div>
                        <p class="text-[11px] text-slate-500">Posisi kurir diperbarui otomatis setiap detik via sensor GPS.</p>
                    </div>
                </div>

                <!-- Petunjuk Ramah Pengguna -->
                <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-xs flex items-center gap-2.5">
                    <i class="fa-solid fa-lightbulb text-base text-amber-600"></i>
                    <span><strong>Tips Pengguna:</strong> Kamu bisa memperbesar (zoom in) dan menggeser peta dengan menyentuh layar atau menggunakan mouse untuk melihat jalan raya secara detail.</span>
                </div>
            </div>

        </div>

    </main>

    <!-- ========================================== -->
    <!-- TAB 3: QR CODE RESI (PENGGANTI KERTAS) -->
    <!-- ========================================== -->
    <main x-show="currentTab === 'receipt'" style="display: none;" x-transition:enter="transition ease-out duration-300" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <div class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full mb-2">
                <i class="fa-solid fa-leaf text-emerald-600"></i>
                Fitur #2: E-Resi Digital Paperless (Pengganti Kertas 100%)
            </div>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900">QR Code Resi Digital & Bukti Pengiriman</h2>
            <p class="text-slate-500 text-sm">Tidak perlu mencetak kertas resi lagi. Cukup tunjukkan kode QR ini pada kurir saat penjemputan, pengantaran, atau retur.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Kolom Kiri: Kartu Resi Digital Modern (Mirip Boarding Pass/AWB) (7 Kolom) -->
            <div class="lg:col-span-7 bg-white border border-slate-200 rounded-3xl shadow-lg overflow-hidden">
                
                <!-- Header Resi Digital -->
                <div class="bg-gradient-to-r from-slate-900 to-indigo-950 p-6 text-white flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center font-black text-brand-400">
                            RM
                        </div>
                        <div>
                            <h3 class="font-bold text-base">E-Waybill & Resi Digital</h3>
                            <p class="text-xs text-slate-400">Official Paperless Shipping Label</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-xs font-bold px-3 py-1 rounded-full">
                            TERVERIFIKASI
                        </span>
                    </div>
                </div>

                <!-- Badan Resi -->
                <div class="p-6 sm:p-8">
                    
                    <!-- Garis Pengirim & Penerima -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-slate-100">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Pengirim (Toko)</span>
                            <h4 class="font-extrabold text-slate-900 text-sm">RizkyMerch Official Store</h4>
                            <p class="text-xs text-slate-600 mt-1">Gudang Utama Jakarta Selatan, DKI Jakarta</p>
                            <span class="text-xs text-brand-600 font-semibold block mt-1">WA: 0812-3456-7890</span>
                        </div>

                        <div class="p-4 bg-brand-50/50 rounded-2xl border border-brand-100">
                            <span class="text-[10px] font-bold text-brand-600 uppercase tracking-wider block mb-1">Penerima (Anda)</span>
                            <h4 class="font-extrabold text-slate-900 text-sm" x-text="activeOrder.customerName"></h4>
                            <p class="text-xs text-slate-600 mt-1" x-text="activeOrder.customerAddress"></p>
                            <span class="text-xs text-slate-800 font-semibold block mt-1" x-text="'Telp: ' + activeOrder.customerPhone"></span>
                        </div>
                    </div>

                    <!-- QR Code Besar & Jelas untuk Di-scan Kurir -->
                    <div class="py-8 text-center flex flex-col items-center justify-center">
                        <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider mb-2">Scan QR untuk Verifikasi Paket / Retur</span>
                        
                        <div class="relative p-4 bg-white border-4 border-slate-900 rounded-3xl shadow-xl mb-4 group cursor-pointer" @click="simulateScanCourier()">
                            <!-- Gambar QR Code Dinamis -->
                            <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=240x240&data=' + encodeURIComponent('RIZKYMERCH|' + activeOrder.resi + '|' + activeOrder.customerName)" 
                                 alt="QR Code Resi Digital" 
                                 class="w-48 h-48 sm:w-56 sm:h-56">

                            <div class="absolute inset-0 bg-brand-600/90 rounded-2xl flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity p-4">
                                <i class="fa-solid fa-qrcode text-4xl mb-2"></i>
                                <span class="font-bold text-sm">Simulasikan Scan Kurir</span>
                                <span class="text-[11px] text-brand-100 text-center mt-1">Klik untuk melihat bagaimana kurir memindai resi ini</span>
                            </div>
                        </div>

                        <!-- Nomor Resi Format Jelas -->
                        <div class="bg-slate-100 px-4 py-2 rounded-xl text-center">
                            <span class="text-[10px] text-slate-500 uppercase block font-semibold">Kode Unik E-Resi:</span>
                            <span class="text-lg font-black font-mono text-slate-900 tracking-wider" x-text="activeOrder.resi"></span>
                        </div>
                    </div>

                    <!-- Detail Rincian Barang & Keuangan -->
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 text-xs">
                        <div class="flex justify-between items-center py-1">
                            <span class="text-slate-500">Nama Barang:</span>
                            <span class="font-bold text-slate-800" x-text="activeOrder.itemName"></span>
                        </div>
                        <div class="flex justify-between items-center py-1">
                            <span class="text-slate-500">Varian / Ukuran:</span>
                            <span class="font-bold text-slate-800" x-text="activeOrder.itemVariant"></span>
                        </div>
                        <div class="flex justify-between items-center py-1">
                            <span class="text-slate-500">Metode Pembayaran:</span>
                            <span class="font-bold text-emerald-600">LUNAS (QRIS Instant)</span>
                        </div>
                        <div class="flex justify-between items-center py-1">
                            <span class="text-slate-500">Logistik Pengiriman:</span>
                            <span class="font-bold text-indigo-600">J&amp;T Express Regular (Garansi Sampai)</span>
                        </div>
                    </div>

                    <!-- Tombol Aksi Ramah Pengguna -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-6">
                        <button @click="downloadQrCode()" class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-4 rounded-xl text-xs sm:text-sm flex items-center justify-center gap-2 transition-all">
                            <i class="fa-solid fa-download"></i>
                            <span>Simpan ke HP</span>
                        </button>
                        <button @click="shareReceiptWA()" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 px-4 rounded-xl text-xs sm:text-sm flex items-center justify-center gap-2 transition-all">
                            <i class="fa-brands fa-whatsapp"></i>
                            <span>Kirim ke WA</span>
                        </button>
                        <button @click="openReturnModal()" class="bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold py-3 px-4 rounded-xl text-xs sm:text-sm flex items-center justify-center gap-2 transition-all">
                            <i class="fa-solid fa-arrow-rotate-left"></i>
                            <span>Ajukan Retur</span>
                        </button>
                    </div>

                </div>

            </div>

            <!-- Kolom Kanan: Simulator Scanner Kurir & Manfaat Paperless (5 Kolom) -->
            <div class="lg:col-span-5 flex flex-col gap-6">
                
                <!-- Simulasi Scanner Kurir (Interactive Demo) -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-barcode-read"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm sm:text-base">Simulator Pemindai Kurir</h3>
                            <p class="text-xs text-slate-500">Uji coba bagaimana kurir memindai QR resi ini</p>
                        </div>
                    </div>

                    <p class="text-xs text-slate-600 mb-4 leading-relaxed">
                        Saat kurir sampai di depan rumah Anda, kurir tidak perlu menulis manual di kertas. Kurir cukup membuka aplikasi dan memindai QR resi dari layar HP Anda.
                    </p>

                    <button @click="simulateScanCourier()" class="w-full bg-brand-600 hover:bg-brand-500 text-white font-bold py-3 px-4 rounded-2xl text-xs sm:text-sm flex items-center justify-center gap-2 shadow-md shadow-brand-500/20 transition-all">
                        <i class="fa-solid fa-camera"></i>
                        <span>Buka Simulator Scan Kurir</span>
                    </button>

                    <!-- Riwayat Hasil Scan Kurir Terakhir -->
                    <div x-show="lastScanResult" class="mt-4 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-900 text-xs">
                        <div class="flex items-center gap-2 font-bold mb-1">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                            <span>Resi Berhasil Diverifikasi!</span>
                        </div>
                        <p class="text-[11px] text-emerald-800">Paket valid diserahkan ke kurir Budi Santoso tanpa cetak kertas kuitansi satu lembar pun.</p>
                    </div>
                </div>

                <!-- Keunggulan Tanpa Kertas (Edukasi Gaptek) -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs">
                    <h3 class="font-bold text-slate-900 text-sm sm:text-base mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        Kenapa Pakai Resi QR Lebih Nyaman?
                    </h3>

                    <ul class="space-y-3.5 text-xs text-slate-600">
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 font-bold text-[10px]">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <span><strong>Tidak Takut Kertas Resi Hilang:</strong> Selalu tersimpan aman di HP Anda kapan saja dibutuhkan.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 font-bold text-[10px]">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <span><strong>Retur Tanpa Ribet:</strong> Jika ukuran flatshoes tidak pas, tinggal klik "Ajukan Retur" & tunjukkan QR yang sama.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 font-bold text-[10px]">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <span><strong>Ramah Lingkungan (Go Green):</strong> Menyelamatkan pohon dengan 0% pemborosan kertas termal.</span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

    </main>

    <!-- ========================================== -->
    <!-- TAB 4: AUTO-SYNC STOK SHOPEE & TIKTOK -->
    <!-- ========================================== -->
    <main x-show="currentTab === 'sync'" style="display: none;" x-transition:enter="transition ease-out duration-300" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8 flex flex-col sm:flex-row justify-between sm:items-end gap-3">
            <div>
                <div class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-700 bg-brand-50 border border-brand-200 px-3 py-1 rounded-full mb-2">
                    <i class="fa-solid fa-network-wired text-brand-600"></i>
                    Fitur #1: Omnichannel Stock Synchronization Engine
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900">Auto-Sync Stok Shopee & TikTok Shop</h2>
                <p class="text-slate-500 text-sm">Sistem cerdas yang menyamakan stok toko online kami secara otomatis di semua marketplace secara real-time.</p>
            </div>

            <button @click="triggerManualSync()" 
                    :disabled="isSyncing"
                    class="bg-brand-600 hover:bg-brand-500 disabled:opacity-50 text-white font-bold px-5 py-3 rounded-2xl text-xs sm:text-sm shadow-md shadow-brand-500/20 transition-all flex items-center gap-2">
                <i class="fa-solid fa-arrows-rotate" :class="isSyncing ? 'animate-spin' : ''"></i>
                <span x-text="isSyncing ? 'Menghubungkan API...' : 'Sinkronkan Sekarang'"></span>
            </button>
        </div>

        <!-- 3 Channel Kartu Status Koneksi -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <!-- Channel 1: RizkyMerch Web Store -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs relative overflow-hidden">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-brand-100 text-brand-700 flex items-center justify-center text-xl font-black">
                        RM
                    </div>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Master Gudang
                    </span>
                </div>
                <h3 class="font-bold text-slate-900 text-base">Toko Website RizkyMerch</h3>
                <p class="text-xs text-slate-500 mt-1">Pusat data induk persediaan barang & penjualan langsung.</p>
                
                <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center text-xs">
                    <span class="text-slate-500">Total Stok Tersedia:</span>
                    <span class="font-black text-slate-900 text-sm" x-text="totalAllStock + ' Unit'"></span>
                </div>
            </div>

            <!-- Channel 2: Shopee Store -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs relative overflow-hidden">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-shopee/10 text-shopee flex items-center justify-center text-2xl font-black">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> API Terhubung
                    </span>
                </div>
                <h3 class="font-bold text-slate-900 text-base">Shopee Mall / Star Store</h3>
                <p class="text-xs text-slate-500 mt-1">Shopee Open Platform v2 (Latency: 38ms)</p>

                <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center text-xs">
                    <span class="text-slate-500">Sinkron Terakhir:</span>
                    <span class="font-semibold text-slate-700" x-text="lastSyncTime"></span>
                </div>
            </div>

            <!-- Channel 3: TikTok Shop -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs relative overflow-hidden">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-slate-900 text-cyan-400 flex items-center justify-center text-2xl font-black">
                        <i class="fa-brands fa-tiktok"></i>
                    </div>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Webhook Aktif
                    </span>
                </div>
                <h3 class="font-bold text-slate-900 text-base">TikTok Shop Partner</h3>
                <p class="text-xs text-slate-500 mt-1">TikTok Shop Open API 2026 (Live Streaming Sync)</p>

                <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center text-xs">
                    <span class="text-slate-500">Status Live Sale:</span>
                    <span class="font-semibold text-emerald-600">Siap Auto-Deduct</span>
                </div>
            </div>

        </div>

        <!-- SIMULATOR INTERAKTIF PENJUALAN DI SHOPEE & TIKTOK -->
        <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white rounded-3xl p-6 sm:p-8 mb-8 shadow-xl border border-slate-800">
            <div class="max-w-2xl mb-6">
                <span class="text-xs font-bold text-brand-300 uppercase tracking-wider block mb-1">Uji Coba Sistem Secara Langsung</span>
                <h3 class="text-xl sm:text-2xl font-black">Simulasikan Penjualan di Marketplace</h3>
                <p class="text-slate-300 text-xs sm:text-sm mt-1">
                    Coba klik tombol di bawah untuk melihat bagaimana stok di Website otomatis berkurang seketika ketika ada pembeli yang belanja di Shopee atau TikTok Live!
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button @click="simulateSaleMarketplace('Shopee', products[0])" 
                        class="bg-shopee hover:bg-orange-600 text-white font-bold py-3 px-5 rounded-2xl text-xs sm:text-sm flex items-center gap-2 shadow-lg shadow-shopee/30 transition-all active:scale-95">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span>Simulasi Order di Shopee (-1 Stok)</span>
                </button>

                <button @click="simulateSaleMarketplace('TikTok Shop', products[1])" 
                        class="bg-slate-800 hover:bg-slate-700 text-cyan-300 border border-cyan-400/30 font-bold py-3 px-5 rounded-2xl text-xs sm:text-sm flex items-center gap-2 shadow-lg transition-all active:scale-95">
                    <i class="fa-brands fa-tiktok"></i>
                    <span>Simulasi Order di TikTok Shop (-1 Stok)</span>
                </button>
            </div>
        </div>

        <!-- TABEL STOK REAL-TIME PER PRODUK -->
        <div class="bg-white border border-slate-200 rounded-3xl shadow-xs overflow-hidden mb-8">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Tabel Sinkronisasi Multi-Channel Produk</h3>
                    <p class="text-xs text-slate-500">Stok selalu seimbang di ketiga kanal penjualan</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase text-[11px] tracking-wider">
                        <tr>
                            <th class="py-4 px-6">Produk</th>
                            <th class="py-4 px-4">Kode SKU</th>
                            <th class="py-4 px-4 text-center">Stok Web</th>
                            <th class="py-4 px-4 text-center">Stok Shopee</th>
                            <th class="py-4 px-4 text-center">Stok TikTok</th>
                            <th class="py-4 px-4 text-center">Status Sinkron</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <template x-for="prod in products" :key="prod.id">
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-4 px-6 flex items-center gap-3">
                                    <img :src="prod.image" class="w-10 h-10 rounded-xl object-cover">
                                    <div>
                                        <span class="font-bold text-slate-900 block" x-text="prod.name"></span>
                                        <span class="text-xs text-slate-400" x-text="prod.category"></span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-mono text-xs text-slate-500 font-semibold" x-text="prod.sku"></td>
                                <td class="py-4 px-4 text-center font-extrabold text-slate-900" x-text="prod.stock"></td>
                                <td class="py-4 px-4 text-center font-extrabold text-shopee" x-text="prod.stock"></td>
                                <td class="py-4 px-4 text-center font-extrabold text-slate-900" x-text="prod.stock"></td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
                                        <i class="fa-solid fa-check text-[10px]"></i> 100% Selaras
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <button @click="triggerProductSync(prod)" class="bg-slate-100 hover:bg-brand-50 hover:text-brand-600 text-slate-700 font-bold px-3 py-1.5 rounded-lg text-xs transition-colors">
                                        Cek API
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- LOG RIWAYAT SINKRONISASI OTOMATIS -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs">
            <h3 class="font-bold text-slate-900 text-base mb-4 flex items-center gap-2">
                <i class="fa-solid fa-clipboard-list text-brand-600"></i>
                Catatan Aktivitas Sinkronisasi Otomatis Terkini
            </h3>

            <div class="space-y-3">
                <template x-for="(log, idx) in syncLogs" :key="idx">
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs"
                                 :class="{
                                    'bg-shopee/10 text-shopee': log.channel === 'Shopee',
                                    'bg-slate-900 text-cyan-400': log.channel === 'TikTok Shop',
                                    'bg-brand-100 text-brand-700': log.channel === 'System'
                                 }">
                                <i :class="log.icon"></i>
                            </div>
                            <div>
                                <span class="font-bold text-slate-900" x-text="log.action"></span>
                                <span class="text-slate-500 block text-[11px]" x-text="log.detail"></span>
                            </div>
                        </div>
                        <span class="text-slate-400 font-mono text-[11px]" x-text="log.time"></span>
                    </div>
                </template>
            </div>
        </div>

    </main>

    <!-- ========================================== -->
    <!-- SLIDE-OVER DRAWER KERANJANG BELANJA (CART) -->
    <!-- ========================================== -->
    <div x-show="cartOpen" 
         class="fixed inset-0 z-50 overflow-hidden" 
         style="display: none;"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:leave="transition-opacity ease-linear duration-300">
        
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-xs" @click="cartOpen = false"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div class="w-screen max-w-md bg-white shadow-2xl flex flex-col">
                
                <!-- Header Cart -->
                <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-700 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-bag-shopping text-lg"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-lg">Keranjang Belanja</h3>
                            <p class="text-xs text-slate-500" x-text="totalCartItems + ' barang dipilih'"></p>
                        </div>
                    </div>
                    <button @click="cartOpen = false" class="text-slate-400 hover:text-slate-700 p-2 text-lg">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Daftar Barang di Keranjang -->
                <div class="flex-1 overflow-y-auto p-6 space-y-4">
                    <template x-if="cart.length === 0">
                        <div class="text-center py-16">
                            <div class="w-20 h-20 bg-slate-100 text-slate-300 rounded-3xl flex items-center justify-center mx-auto text-3xl mb-4">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </div>
                            <h4 class="font-bold text-slate-800 text-base">Keranjang Anda Masih Kosong</h4>
                            <p class="text-xs text-slate-500 mt-1 max-w-xs mx-auto">Yuk lihat katalog flatshoes dan merchandise kami dan tambahkan ke sini.</p>
                            <button @click="cartOpen = false; changeTab('shop')" class="mt-4 bg-brand-600 text-white font-bold px-5 py-2.5 rounded-xl text-xs">
                                Mulai Belanja Sekarang
                            </button>
                        </div>
                    </template>

                    <template x-for="(item, index) in cart" :key="index">
                        <div class="flex items-center gap-4 p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                            <img :src="item.image" class="w-16 h-16 rounded-xl object-cover shrink-0">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-slate-900 text-xs sm:text-sm truncate" x-text="item.name"></h4>
                                <span class="text-xs font-black text-brand-700 block mt-0.5" x-text="formatRupiah(item.price)"></span>
                                <span class="text-[11px] text-slate-400" x-text="'Stok Tersedia: ' + item.stock"></span>
                            </div>

                            <!-- Kontrol Jumlah Tambah / Kurang (Besar & Jelas) -->
                            <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl p-1">
                                <button @click="decreaseQty(index)" class="w-7 h-7 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg flex items-center justify-center font-bold text-xs">
                                    -
                                </button>
                                <span class="w-6 text-center font-bold text-xs text-slate-900" x-text="item.qty"></span>
                                <button @click="increaseQty(index)" class="w-7 h-7 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg flex items-center justify-center font-bold text-xs">
                                    +
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Footer Cart & Tombol Lanjut Checkout -->
                <div x-show="cart.length > 0" class="p-6 border-t border-slate-100 bg-slate-50">
                    <div class="space-y-2 mb-4 text-xs">
                        <div class="flex justify-between text-slate-500">
                            <span>Subtotal Barang:</span>
                            <span class="font-semibold text-slate-800" x-text="formatRupiah(cartTotal)"></span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>Biaya Pengiriman:</span>
                            <span class="font-bold text-emerald-600">GRATIS ONGKIR</span>
                        </div>
                        <div class="flex justify-between text-sm font-black text-slate-900 pt-2 border-t border-slate-200">
                            <span>Total Pembayaran:</span>
                            <span class="text-brand-700 text-base" x-text="formatRupiah(cartTotal)"></span>
                        </div>
                    </div>

                    <button @click="cartOpen = false; checkoutOpen = true" 
                            class="w-full bg-brand-600 hover:bg-brand-500 active:scale-95 text-white font-extrabold py-3.5 px-4 rounded-2xl text-sm shadow-xl shadow-brand-500/25 flex items-center justify-center gap-2 transition-all">
                        <span>Lanjut ke Pembayaran Mudah</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL CHECKOUT SEDERHANA (RAMAH GAPTEK) -->
    <!-- ========================================== -->
    <div x-show="checkoutOpen" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         x-transition:enter="transition-opacity ease-linear duration-300">
        
        <div class="min-h-screen px-4 text-center flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="checkoutOpen = false"></div>

            <div class="inline-block w-full max-w-xl p-6 sm:p-8 my-8 text-left bg-white rounded-3xl shadow-2xl transform transition-all relative z-10">
                
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-100">
                    <div>
                        <h3 class="font-black text-slate-900 text-xl">Selesaikan Pemesanan</h3>
                        <p class="text-xs text-slate-500">Cukup isi data singkat di bawah ini, pesanan langsung dikirim!</p>
                    </div>
                    <button @click="checkoutOpen = false" class="text-slate-400 hover:text-slate-700 p-2">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form @submit.prevent="processCheckout()" class="space-y-4">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Anda (Penerima Paket)</label>
                        <input type="text" x-model="checkoutForm.name" required placeholder="Contoh: Ibu Siti Rahmawati" 
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-500 outline-none">
                    </div>

                    <!-- Nomor WhatsApp / HP -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor WhatsApp / HP Aktif</label>
                        <input type="tel" x-model="checkoutForm.phone" required placeholder="Contoh: 081234567890" 
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-500 outline-none">
                        <span class="text-[11px] text-slate-400 mt-1 block">Kurir akan menelepon / WhatsApp ke nomor ini saat sudah dekat rumah.</span>
                    </div>

                    <!-- Alamat Pengiriman -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Lengkap Rumah</label>
                        <textarea x-model="checkoutForm.address" required rows="2" placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, kelurahan, dan patokan rumah..." 
                                  class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-500 outline-none"></textarea>
                    </div>

                    <!-- Pilihan Pembayaran Sederhana -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Cara Pembayaran yang Paling Gampang</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                            <label class="border-2 rounded-2xl p-3 flex flex-col items-center text-center cursor-pointer transition-all"
                                   :class="checkoutForm.paymentMethod === 'qris' ? 'border-brand-600 bg-brand-50 text-brand-900 font-bold' : 'border-slate-200 text-slate-600'">
                                <input type="radio" name="payment" value="qris" x-model="checkoutForm.paymentMethod" class="hidden">
                                <i class="fa-solid fa-qrcode text-xl mb-1 text-indigo-600"></i>
                                <span class="text-xs">QRIS / GoPay</span>
                            </label>
                            
                            <label class="border-2 rounded-2xl p-3 flex flex-col items-center text-center cursor-pointer transition-all"
                                   :class="checkoutForm.paymentMethod === 'transfer' ? 'border-brand-600 bg-brand-50 text-brand-900 font-bold' : 'border-slate-200 text-slate-600'">
                                <input type="radio" name="payment" value="transfer" x-model="checkoutForm.paymentMethod" class="hidden">
                                <i class="fa-solid fa-building-columns text-xl mb-1 text-emerald-600"></i>
                                <span class="text-xs">Transfer Bank</span>
                            </label>

                            <label class="border-2 rounded-2xl p-3 flex flex-col items-center text-center cursor-pointer transition-all"
                                   :class="checkoutForm.paymentMethod === 'cod' ? 'border-brand-600 bg-brand-50 text-brand-900 font-bold' : 'border-slate-200 text-slate-600'">
                                <input type="radio" name="payment" value="cod" x-model="checkoutForm.paymentMethod" class="hidden">
                                <i class="fa-solid fa-hand-holding-dollar text-xl mb-1 text-amber-600"></i>
                                <span class="text-xs">COD (Bayar di Tempat)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Ringkasan Total Biaya -->
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 flex justify-between items-center">
                        <span class="text-xs font-bold text-slate-600">Total Pembayaran:</span>
                        <span class="text-lg font-black text-brand-700" x-text="formatRupiah(cartTotal)"></span>
                    </div>

                    <!-- Tombol Konfirmasi -->
                    <button type="submit" 
                            class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold py-4 px-6 rounded-2xl text-base shadow-xl shadow-emerald-600/25 flex items-center justify-center gap-2 transition-all">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Pesan Sekarang & Dapatkan Resi QR</span>
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL PANDUAN UKURAN SEPATU (SIZE CHART RAMAH GAPTEK) -->
    <!-- ========================================== -->
    <div x-show="sizeGuideOpen" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         x-transition:enter="transition-opacity ease-linear duration-300">
        
        <div class="min-h-screen px-4 text-center flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="sizeGuideOpen = false"></div>

            <div class="inline-block w-full max-w-xl p-6 sm:p-8 my-8 text-left bg-white rounded-3xl shadow-2xl transform transition-all relative z-10">
                <button @click="sizeGuideOpen = false" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 p-2 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-ruler-combined"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900">Panduan Ukuran Sepatu (Size Chart)</h3>
                        <p class="text-xs text-slate-500">Cara mudah mengukur kaki di rumah dengan penggaris biasa</p>
                    </div>
                </div>

                <!-- 3 Langkah Ukur Kaki -->
                <div class="bg-amber-50/70 border border-amber-200/80 rounded-2xl p-4 mb-6 text-xs text-amber-900">
                    <h4 class="font-extrabold text-sm mb-2 flex items-center gap-1.5 text-amber-800">
                        <i class="fa-solid fa-lightbulb"></i> Cara Ukur Panjang Telapak Kaki:
                    </h4>
                    <ol class="space-y-1.5 list-decimal list-inside text-amber-800/90 leading-relaxed">
                        <li>Letakkan selembar kertas di lantai dan tempelkan tumit di dinding.</li>
                        <li>Tandai ujung jari kaki yang paling panjang menggunakan pulpen / pensil.</li>
                        <li>Ukur panjang dari tumit ke tanda ujung jari dengan <strong>penggaris biasa (dalam cm)</strong>.</li>
                    </ol>
                    <div class="mt-2.5 pt-2 border-t border-amber-200 text-[11px] font-semibold text-amber-800">
                        💡 <strong>Tips Tambahan:</strong> Jika bentuk kaki Anda cenderung lebar atau punggung kaki tebal, sangat disarankan memilih <strong>1 nomor lebih besar (upsize)</strong> agar nyaman.
                    </div>
                </div>

                <!-- Tabel Ukuran -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden mb-6">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[11px]">
                            <tr>
                                <th class="py-3 px-4">Panjang Kaki (cm)</th>
                                <th class="py-3 px-4">Ukuran Sepatu (EU)</th>
                                <th class="py-3 px-4">Kategori Model</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            <tr class="hover:bg-slate-50">
                                <td class="py-2.5 px-4 font-mono font-bold">22.5 cm</td>
                                <td class="py-2.5 px-4 font-black text-brand-600">Size 36</td>
                                <td class="py-2.5 px-4 text-slate-500">Flatshoes / Sneakers Wanita</td>
                            </tr>
                            <tr class="hover:bg-slate-50 bg-slate-50/50">
                                <td class="py-2.5 px-4 font-mono font-bold">23.0 cm</td>
                                <td class="py-2.5 px-4 font-black text-brand-600">Size 37</td>
                                <td class="py-2.5 px-4 text-slate-500">Flatshoes / Sneakers Wanita</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-2.5 px-4 font-mono font-bold">23.5 cm</td>
                                <td class="py-2.5 px-4 font-black text-brand-600">Size 38</td>
                                <td class="py-2.5 px-4 text-slate-500">Flatshoes / Sneakers</td>
                            </tr>
                            <tr class="hover:bg-slate-50 bg-slate-50/50">
                                <td class="py-2.5 px-4 font-mono font-bold">24.0 cm</td>
                                <td class="py-2.5 px-4 font-black text-brand-600">Size 39</td>
                                <td class="py-2.5 px-4 text-slate-500">Flatshoes / Sneakers</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-2.5 px-4 font-mono font-bold">24.5 - 25.0 cm</td>
                                <td class="py-2.5 px-4 font-black text-brand-600">Size 40</td>
                                <td class="py-2.5 px-4 text-slate-500">Sneakers / Loafers Pria &amp; Wanita</td>
                            </tr>
                            <tr class="hover:bg-slate-50 bg-slate-50/50">
                                <td class="py-2.5 px-4 font-mono font-bold">25.5 cm</td>
                                <td class="py-2.5 px-4 font-black text-brand-600">Size 41</td>
                                <td class="py-2.5 px-4 text-slate-500">Sneakers / Loafers Pria</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-2.5 px-4 font-mono font-bold">26.0 cm</td>
                                <td class="py-2.5 px-4 font-black text-brand-600">Size 42</td>
                                <td class="py-2.5 px-4 text-slate-500">Sneakers / Loafers Pria</td>
                            </tr>
                            <tr class="hover:bg-slate-50 bg-slate-50/50">
                                <td class="py-2.5 px-4 font-mono font-bold">26.5 cm</td>
                                <td class="py-2.5 px-4 font-black text-brand-600">Size 43</td>
                                <td class="py-2.5 px-4 text-slate-500">Sneakers / Loafers Pria</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-3.5 mb-6 text-xs text-emerald-900 flex items-center gap-3">
                    <i class="fa-solid fa-shield-check text-2xl text-emerald-600 shrink-0"></i>
                    <div>
                        <span class="font-bold block">Garansi Tukar Ukuran 100% Gratis!</span>
                        <p class="text-[11px] text-emerald-800">Jika saat dicoba sepatu masih sempit atau longgar, Anda bisa menukar ke ukuran lain tanpa biaya tambahan lewat Resi QR.</p>
                    </div>
                </div>

                <button @click="sizeGuideOpen = false" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3.5 rounded-2xl text-sm">
                    Sudah Paham, Kembali Pilih Sepatu
                </button>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL DETAIL PRODUK -->
    <!-- ========================================== -->
    <div x-show="detailModalOpen" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         x-transition:enter="transition-opacity ease-linear duration-300">
        
        <div class="min-h-screen px-4 text-center flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="detailModalOpen = false"></div>

            <div class="inline-block w-full max-w-2xl p-6 sm:p-8 my-8 text-left bg-white rounded-3xl shadow-2xl transform transition-all relative z-10" x-show="selectedProduct">
                <button @click="detailModalOpen = false" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 p-2 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="rounded-2xl overflow-hidden bg-slate-100">
                        <img :src="selectedProduct?.image" class="w-full h-72 object-cover">
                    </div>

                    <div class="flex flex-col justify-between">
                        <div>
                            <div class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold px-2.5 py-1 rounded-lg mb-2">
                                <i class="fa-solid fa-arrows-rotate text-emerald-600"></i>
                                <span>Stok Terhubung Real-Time</span>
                            </div>
                            <h3 class="text-xl font-black text-slate-900" x-text="selectedProduct?.name"></h3>
                            <p class="text-xs text-slate-500 mt-2 leading-relaxed" x-text="selectedProduct?.description"></p>
                            
                            <div class="mt-4">
                                <span class="text-2xl font-black text-brand-700" x-text="formatRupiah(selectedProduct?.price || 0)"></span>
                            </div>

                            <!-- Pilihan Ukuran / Varian -->
                            <div class="mt-4">
                                <span class="text-xs font-bold text-slate-700 block mb-2">Pilih Ukuran:</span>
                                <div class="flex gap-2">
                                    <template x-for="size in ['36', '37', '38', '39', '40']" :key="size">
                                        <button class="w-10 h-10 rounded-xl border border-slate-200 font-bold text-xs hover:border-brand-600 hover:bg-brand-50 focus:border-brand-600 focus:bg-brand-50" x-text="size"></button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex gap-3">
                            <button @click="addToCart(selectedProduct); detailModalOpen = false;" 
                                    class="flex-1 bg-brand-600 hover:bg-brand-500 text-white font-bold py-3 rounded-xl text-sm flex items-center justify-center gap-2">
                                <i class="fa-solid fa-cart-plus"></i>
                                <span>Masukkan Keranjang</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- FLOATING WHATSAPP BUTTON (BANTUAN GAPTEK) -->
    <!-- ========================================== -->
    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20RizkyMerch,%20saya%20butuh%20bantuan%20cara%20belanja" 
       target="_blank"
       class="fixed bottom-6 left-6 z-40 bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-3 rounded-full shadow-2xl flex items-center gap-3 transition-transform hover:scale-105 active:scale-95 group">
        <i class="fa-brands fa-whatsapp text-2xl"></i>
        <div class="text-left hidden sm:block">
            <span class="text-[10px] block font-bold text-emerald-200 uppercase leading-none">Butuh Bantuan?</span>
            <span class="text-xs font-black leading-tight">Chat Admin WhatsApp</span>
        </div>
    </a>

    <!-- JAVASCRIPT LOGIC & SIMULATOR ENGINE -->
    <script>
        function ecommerceApp() {
            return {
                currentTab: 'shop',
                cartOpen: false,
                checkoutOpen: false,
                detailModalOpen: false,
                sizeGuideOpen: false,
                selectedCategory: 'all',
                selectedProduct: null,
                isSyncing: false,
                isSimulating: false,
                simulationInterval: null,
                leafletMap: null,
                courierMarker: null,
                routePolyline: null,
                lastScanResult: false,
                lastSyncTime: 'Baru saja (Real-time)',
                
                // DATA PRODUK SEPATU DENGAN DUKUNGAN MULTI-CHANNEL SYNC
                products: [
                    {
                        id: 1,
                        name: 'Classic Black Flatshoes Ergonomic',
                        category: 'flatshoes',
                        sku: 'RM-FS-BLK-01',
                        price: 185000,
                        originalPrice: 225000,
                        stock: 14,
                        rating: 4.9,
                        sold: 1420,
                        badge: 'Paling Laris',
                        image: 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                        description: 'Sepatu flatshoes wanita dengan bantalan memory foam empuk ekstra nyaman untuk jalan seharian tanpa lecet tumit.'
                    },
                    {
                        id: 2,
                        name: 'Soft Velvet Mules Shoes Cream',
                        category: 'flatshoes',
                        sku: 'RM-FS-CRM-02',
                        price: 195000,
                        originalPrice: 250000,
                        stock: 8,
                        rating: 4.8,
                        sold: 840,
                        badge: 'Diskon 22%',
                        image: 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                        description: 'Sentuhan bahan beludru premium dengan sol karet anti slip, sangat pas untuk kerja kantor maupun acara santai.'
                    },
                    {
                        id: 3,
                        name: 'CloudWalk Air White Sneakers Ultralight',
                        category: 'sneakers',
                        sku: 'RM-SN-WHT-03',
                        price: 245000,
                        originalPrice: 299000,
                        stock: 18,
                        rating: 4.9,
                        sold: 2310,
                        badge: 'Sneakers Favorit',
                        image: 'https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                        description: 'Sneakers putih kasual super ringan dengan sol bantalan udara peredam guncangan, nyaman untuk kuliah dan jalan-jalan.'
                    },
                    {
                        id: 4,
                        name: 'Urban Oxford Leather Loafers Mocca',
                        category: 'loafers',
                        sku: 'RM-LF-MCC-04',
                        price: 295000,
                        originalPrice: 350000,
                        stock: 12,
                        rating: 4.9,
                        sold: 910,
                        badge: 'Kulit Premium',
                        image: 'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                        description: 'Sepatu loafers formal bahan kulit sintetis lembut dengan sol lentur, memberikan kesan rapi dan elegan.'
                    },
                    {
                        id: 5,
                        name: 'Retro Chunky Sport Runner Sneakers',
                        category: 'sneakers',
                        sku: 'RM-SN-RET-05',
                        price: 265000,
                        originalPrice: 320000,
                        stock: 15,
                        rating: 4.8,
                        sold: 730,
                        badge: 'Model Korea',
                        image: 'https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                        description: 'Sepatu sneakers gaya retro modern dengan sol tebal proporsional yang menambah kenyamanan pijakan kaki.'
                    },
                    {
                        id: 6,
                        name: 'All-in-One Shoe Cleaner & Nano Waterproof Spray',
                        category: 'care',
                        sku: 'RM-CR-CLN-06',
                        price: 58000,
                        originalPrice: 75000,
                        stock: 24,
                        rating: 5.0,
                        sold: 3450,
                        badge: 'Perawatan Sepatu',
                        image: 'https://images.unsplash.com/photo-1595341888016-a392ef81b7de?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                        description: 'Paket pembersih busa praktis tanpa bilas air dan semprotan anti air pelindung sepatu dari kotoran dan hujan.'
                    }
                ],

                // KERANJANG BELANJA
                cart: [
                    {
                        id: 1,
                        name: 'Classic Black Flatshoes Ergonomic',
                        price: 185000,
                        stock: 14,
                        qty: 1,
                        image: 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
                    }
                ],

                // FORM CHECKOUT
                checkoutForm: {
                    name: 'Siti Rahmawati',
                    phone: '0812-3456-7890',
                    address: 'Jl. Kemang Raya No. 12, RT 04 / RW 02, Mampang Prapatan, Jakarta Selatan',
                    paymentMethod: 'qris'
                },

                // PESANAN AKTIF (UNTUK LIVE GPS & RESI QR)
                activeOrder: {
                    resi: 'RM-TRX-202611-8892',
                    customerName: 'Siti Rahmawati',
                    customerPhone: '0812-3456-7890',
                    customerAddress: 'Jl. Kemang Raya No. 12, Jakarta Selatan',
                    itemName: 'Classic Black Flatshoes Ergonomic',
                    itemVariant: 'Warna Hitam, Ukuran 38',
                    price: 185000,
                    itemImage: 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80',
                },

                // STATUS LIVE GPS KURIR
                courierStatusText: 'Dalam Perjalanan Menuju Anda',
                courierETA: '14:35 WIB (8 Menit Lagi)',
                courierSpeed: 34,
                courierRemainingDistance: '1.2',
                courierProgressPercent: 65,
                courierLocationNote: 'Kurir melintas di Jl. Mampang Prapatan Raya',
                
                // KOORDINAT RUTE (Gudang -> Rumah Pembeli Jakarta)
                routeCoords: [
                    { lat: -6.2250, lng: 106.8000, note: 'Gudang RizkyMerch Kebayoran Baru' },
                    { lat: -6.2350, lng: 106.8100, note: 'Simpang Tiga Jl. Kapten Tendean' },
                    { lat: -6.2480, lng: 106.8180, note: 'Lampu Merah Mampang Prapatan' },
                    { lat: -6.2600, lng: 106.8150, note: 'Memasuki Jl. Kemang Raya (Dekat Rumah Anda)' },
                    { lat: -6.2650, lng: 106.8140, note: 'Sampai di Alamat Penerima' }
                ],
                currentCourierIndex: 2,
                currentCourierCoords: { lat: -6.2480, lng: 106.8180 },

                // LOG RIWAYAT AUTO-SYNC SHOPEE & TIKTOK
                syncLogs: [
                    {
                        channel: 'Shopee',
                        action: 'Stok Terjual di Shopee Mall',
                        detail: '1x Classic Black Flatshoes dibeli via Shopee. Stok Web & TikTok otomatis berkurang.',
                        time: '12 menit lalu',
                        icon: 'fa-solid fa-bag-shopping'
                    },
                    {
                        channel: 'TikTok Shop',
                        action: 'Live Shopping Stream Sync',
                        detail: 'Sinkronisasi stok 4 SKU produk dari TikTok Shop Partner API berhasil.',
                        time: '45 menit lalu',
                        icon: 'fa-brands fa-tiktok'
                    },
                    {
                        channel: 'System',
                        action: 'Master Stock Heartbeat Check',
                        detail: 'Pengecekan integritas persediaan multi-channel: Semua channel seimbang 100%.',
                        time: '1 jam lalu',
                        icon: 'fa-solid fa-server'
                    }
                ],

                // TOAST NOTIFIKASI
                toasts: [],

                // INITIALIZATION
                initApp() {
                    console.log('RizkyMerch E-Commerce Loaded');
                },

                // GANTI TAB
                changeTab(tab) {
                    this.currentTab = tab;
                    if (tab === 'tracking') {
                        this.$nextTick(() => {
                            this.initLeafletMap();
                        });
                    }
                },

                // GETTERS
                get filteredProducts() {
                    if (this.selectedCategory === 'all') return this.products;
                    return this.products.filter(p => p.category === this.selectedCategory);
                },

                get totalCartItems() {
                    return this.cart.reduce((total, item) => total + item.qty, 0);
                },

                get cartTotal() {
                    return this.cart.reduce((total, item) => total + (item.price * item.qty), 0);
                },

                get totalAllStock() {
                    return this.products.reduce((acc, p) => acc + p.stock, 0);
                },

                // FORMAT RUPIAH
                formatRupiah(number) {
                    return 'Rp ' + Number(number).toLocaleString('id-ID');
                },

                // TOAST
                showToast(message, type = 'info', icon = 'fa-solid fa-circle-info') {
                    const toast = { message, type, icon, show: true };
                    this.toasts.push(toast);
                    setTimeout(() => {
                        toast.show = false;
                    }, 4000);
                },

                // CART ACTIONS
                addToCart(product) {
                    const existing = this.cart.find(item => item.id === product.id);
                    if (existing) {
                        if (existing.qty < product.stock) {
                            existing.qty++;
                            this.showToast(`Ditambahkan lagi 1 ${product.name} ke keranjang!`, 'success', 'fa-solid fa-cart-circle-check');
                        } else {
                            this.showToast(`Batas stok tercapai (${product.stock} pcs)`, 'warning', 'fa-solid fa-triangle-exclamation');
                        }
                    } else {
                        this.cart.push({
                            id: product.id,
                            name: product.name,
                            price: product.price,
                            stock: product.stock,
                            qty: 1,
                            image: product.image
                        });
                        this.showToast(`${product.name} berhasil dimasukkan ke keranjang!`, 'success', 'fa-solid fa-circle-check');
                    }
                },

                increaseQty(index) {
                    if (this.cart[index].qty < this.cart[index].stock) {
                        this.cart[index].qty++;
                    } else {
                        this.showToast('Jumlah melebihi stok yang tersedia', 'warning');
                    }
                },

                decreaseQty(index) {
                    if (this.cart[index].qty > 1) {
                        this.cart[index].qty--;
                    } else {
                        this.cart.splice(index, 1);
                        this.showToast('Barang dihapus dari keranjang', 'info');
                    }
                },

                openProductDetail(product) {
                    this.selectedProduct = product;
                    this.detailModalOpen = true;
                },

                openHelpModal() {
                    this.showToast('Jika butuh bantuan, hubungi WhatsApp kami kapan saja!', 'info', 'fa-solid fa-circle-question');
                },

                // CHECKOUT PROCESS
                processCheckout() {
                    const newResi = 'RM-TRX-' + Math.floor(100000 + Math.random() * 900000);
                    this.activeOrder.resi = newResi;
                    this.activeOrder.customerName = this.checkoutForm.name;
                    this.activeOrder.customerPhone = this.checkoutForm.phone;
                    this.activeOrder.customerAddress = this.checkoutForm.address;
                    
                    if (this.cart.length > 0) {
                        this.activeOrder.itemName = this.cart[0].name;
                        this.activeOrder.price = this.cart[0].price;
                        this.activeOrder.itemImage = this.cart[0].image;
                    }

                    // Kurangi stok lokal & trigger auto sync
                    this.products.forEach(p => {
                        const inCart = this.cart.find(c => c.id === p.id);
                        if (inCart) {
                            p.stock = Math.max(0, p.stock - inCart.qty);
                        }
                    });

                    this.cart = [];
                    this.checkoutOpen = false;
                    this.showToast('Pesanan Berhasil Dibuat! Kode Resi QR siap digunakan.', 'success', 'fa-solid fa-qrcode');
                    
                    // Alihkan ke Tab Resi
                    this.changeTab('receipt');
                },

                // LEAFLET MAP INITIALIZATION & LIVE GPS
                initLeafletMap() {
                    const mapContainer = document.getElementById('liveGpsMap');
                    if (!mapContainer) return;

                    if (this.leafletMap) {
                        this.leafletMap.invalidateSize();
                        return;
                    }

                    // Pusat Jakarta Selatan
                    this.leafletMap = L.map('liveGpsMap').setView([-6.2480, 106.8180], 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(this.leafletMap);

                    // Marker Gudang (Origin)
                    const warehouseIcon = L.divIcon({
                        className: 'custom-icon',
                        html: '<div style="background:#4f46e5;color:white;width:34px;height:34px;border-radius:12px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 6px -1px rgba(0,0,0,0.2);"><i class="fa-solid fa-warehouse"></i></div>',
                        iconSize: [34, 34],
                        iconAnchor: [17, 17]
                    });
                    L.marker([-6.2250, 106.8000], { icon: warehouseIcon }).addTo(this.leafletMap)
                        .bindPopup('<b>Gudang RizkyMerch</b><br>Paket diberangkatkan dari sini.');

                    // Marker Rumah Penerima (Destination)
                    const homeIcon = L.divIcon({
                        className: 'custom-icon',
                        html: '<div style="background:#e11d48;color:white;width:34px;height:34px;border-radius:12px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 6px -1px rgba(0,0,0,0.2);"><i class="fa-solid fa-house"></i></div>',
                        iconSize: [34, 34],
                        iconAnchor: [17, 17]
                    });
                    L.marker([-6.2650, 106.8140], { icon: homeIcon }).addTo(this.leafletMap)
                        .bindPopup('<b>Alamat Penerima</b><br>Jl. Kemang Raya No. 12');

                    // Rute Garis Putus-putus
                    const latlngs = this.routeCoords.map(c => [c.lat, c.lng]);
                    this.routePolyline = L.polyline(latlngs, {
                        color: '#4f46e5',
                        weight: 5,
                        opacity: 0.7,
                        dashArray: '8, 8'
                    }).addTo(this.leafletMap);

                    // Marker Motor Kurir (Dinamis Bergerak)
                    const courierIcon = L.divIcon({
                        className: 'custom-icon',
                        html: '<div class="pulse-ring" style="background:#f59e0b;color:white;width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:16px;border:3px solid white;"><i class="fa-solid fa-motorcycle"></i></div>',
                        iconSize: [38, 38],
                        iconAnchor: [19, 19]
                    });

                    this.courierMarker = L.marker([this.currentCourierCoords.lat, this.currentCourierCoords.lng], { icon: courierIcon }).addTo(this.leafletMap)
                        .bindPopup('<b>Kurir: Budi Santoso</b><br>Posisi Live GPS');

                    setTimeout(() => {
                        this.leafletMap.invalidateSize();
                    }, 200);
                },

                // SIMULASI PERJALANAN MOTOR KURIR
                toggleCourierSimulation() {
                    this.isSimulating = !this.isSimulating;

                    if (this.isSimulating) {
                        this.showToast('Simulasi perjalanan kurir dijalankan!', 'info', 'fa-solid fa-play');
                        this.simulationInterval = setInterval(() => {
                            if (this.currentCourierIndex < this.routeCoords.length - 1) {
                                this.currentCourierIndex++;
                            } else {
                                this.currentCourierIndex = 0;
                            }

                            const point = this.routeCoords[this.currentCourierIndex];
                            this.currentCourierCoords = { lat: point.lat, lng: point.lng };
                            this.courierLocationNote = point.note;

                            if (this.courierMarker) {
                                this.courierMarker.setLatLng([point.lat, point.lng]);
                                this.leafletMap.panTo([point.lat, point.lng]);
                            }

                            // Update stats
                            this.courierProgressPercent = Math.round((this.currentCourierIndex / (this.routeCoords.length - 1)) * 100);
                            this.courierSpeed = Math.floor(28 + Math.random() * 15);
                            this.courierRemainingDistance = ((this.routeCoords.length - 1 - this.currentCourierIndex) * 0.8).toFixed(1);

                            if (this.courierProgressPercent === 100) {
                                this.courierStatusText = 'Kurir Telah Sampai di Depan Rumah!';
                                this.showToast('Kurir telah sampai di alamat tujuan Anda!', 'success', 'fa-solid fa-bell');
                            } else {
                                this.courierStatusText = 'Dalam Perjalanan Menuju Anda';
                            }
                        }, 2500);
                    } else {
                        clearInterval(this.simulationInterval);
                        this.showToast('Simulasi dijeda', 'info', 'fa-solid fa-pause');
                    }
                },

                resetCourierRoute() {
                    this.currentCourierIndex = 0;
                    const point = this.routeCoords[0];
                    this.currentCourierCoords = { lat: point.lat, lng: point.lng };
                    this.courierLocationNote = point.note;
                    this.courierProgressPercent = 0;
                    if (this.courierMarker) {
                        this.courierMarker.setLatLng([point.lat, point.lng]);
                        this.leafletMap.panTo([point.lat, point.lng]);
                    }
                    this.showToast('Posisi kurir direset ke Gudang', 'info');
                },

                // QR CODE RESI ACTIONS
                downloadQrCode() {
                    this.showToast('Resi QR berhasil disimpan ke galeri foto HP!', 'success', 'fa-solid fa-circle-down');
                },

                shareReceiptWA() {
                    const text = `Halo, ini bukti Resi Digital RizkyMerch nomor ${this.activeOrder.resi} untuk penerima ${this.activeOrder.customerName}. Tanpa kertas kuitansi.`;
                    window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
                },

                openReturnModal() {
                    this.showToast('Permintaan retur dicatat! Tunjukkan QR Code yang sama kepada kurir penjemput.', 'info', 'fa-solid fa-rotate-left');
                },

                simulateScanCourier() {
                    this.lastScanResult = true;
                    this.showToast('BEEP! QR Code Berhasil Terbaca oleh Scanner HP Kurir!', 'success', 'fa-solid fa-barcode');
                },

                // AUTO-SYNC SHOPEE & TIKTOK ACTIONS
                openQuickSyncModal() {
                    this.changeTab('sync');
                },

                triggerManualSync() {
                    this.isSyncing = true;
                    this.showToast('Menghubungi Shopee Open Platform & TikTok Shop Partner API...', 'info', 'fa-solid fa-arrows-rotate');

                    setTimeout(() => {
                        this.isSyncing = false;
                        this.lastSyncTime = new Date().toLocaleTimeString('id-ID') + ' WIB';
                        this.syncLogs.unshift({
                            channel: 'System',
                            action: 'Manual Refresh Multi-Channel Sync',
                            detail: 'Sinkronisasi menyeluruh Shopee, TikTok Shop, dan Web selesai tanpa selisih stok.',
                            time: 'Baru saja',
                            icon: 'fa-solid fa-arrows-rotate'
                        });
                        this.showToast('Sinkronisasi Sukses: Stok di Web, Shopee, & TikTok 100% Sesuai!', 'success', 'fa-solid fa-check-double');
                    }, 1200);
                },

                triggerProductSync(product) {
                    this.showToast(`Memvalidasi stok SKU ${product.sku} di server Shopee & TikTok...`, 'info');
                    setTimeout(() => {
                        this.showToast(`SKU ${product.sku} terverifikasi aman & selaras di semua channel.`, 'success');
                    }, 800);
                },

                simulateSaleMarketplace(platform, product) {
                    if (product.stock > 0) {
                        product.stock--;
                        const logMsg = `1x ${product.name} terjual di ${platform}. Stok Web & kanal lainnya otomatis berkurang dari ${product.stock + 1} menjadi ${product.stock}.`;
                        
                        this.syncLogs.unshift({
                            channel: platform,
                            action: `Penjualan Real-time di ${platform}`,
                            detail: logMsg,
                            time: 'Baru saja',
                            icon: platform === 'Shopee' ? 'fa-solid fa-bag-shopping' : 'fa-brands fa-tiktok'
                        });

                        this.showToast(`[Auto-Sync ${platform}] Stok berkurang otomatis: sisa ${product.stock} unit.`, 'warning', 'fa-solid fa-arrows-rotate');
                    } else {
                        this.showToast(`Stok ${product.name} sudah habis di semua channel!`, 'error');
                    }
                }
            };
        }
    </script>
</body>
</html>
