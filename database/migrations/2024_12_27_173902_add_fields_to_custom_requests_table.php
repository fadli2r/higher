<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('custom_requests', function (Blueprint $table) {
        $table->string('whatsapp')->nullable()->after('user_id'); // No. WhatsApp
        $table->string('brand_name')->nullable()->after('whatsapp'); // Nama PT atau Brand
        $table->string('color_recommendation')->nullable()->after('description'); // Rekomendasi Warna
        $table->text('direction')->nullable()->after('color_recommendation'); // Arahan Lainnya
        $table->string('design_reference')->nullable()->after('direction'); // Referensi Desain
    });
}

public function down()
{
    Schema::table('custom_requests', function (Blueprint $table) {
        $table->dropColumn(['whatsapp', 'brand_name', 'color_recommendation', 'direction', 'design_reference']);
    });
}

};
