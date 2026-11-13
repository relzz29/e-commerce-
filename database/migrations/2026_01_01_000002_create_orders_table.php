<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('resi')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('customer_address');
            $table->string('payment_method')->default('qris');
            $table->string('payment_status')->default('paid');
            $table->string('delivery_status')->default('in_transit');
            $table->decimal('total_amount', 12, 2)->default(0);
            
            // Kolom Kurir & Live GPS
            $table->string('courier_name')->nullable();
            $table->string('courier_phone')->nullable();
            $table->string('courier_plate')->nullable();
            $table->decimal('last_lat', 10, 7)->nullable();
            $table->decimal('last_lng', 10, 7)->nullable();
            
            // Paperless QR Verification
            $table->boolean('is_paperless_scanned')->default(false);
            $table->timestamp('scanned_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

