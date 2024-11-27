<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('file_path'); // Lokasi file digital
            $table->decimal('price', 10, 2);
            $table->string('category')->nullable();
            $table->integer('downloads')->default(0); // Untuk menghitung jumlah unduhan
            $table->boolean('is_active')->default(true); // Status produk
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
