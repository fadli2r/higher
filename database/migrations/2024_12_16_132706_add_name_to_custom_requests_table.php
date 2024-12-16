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
        Schema::table('custom_requests', function (Blueprint $table) {
            $table->string('name')->after('user_id')->nullable(); // Tambahkan kolom name
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_requests', function (Blueprint $table) {
            $table->dropColumn('name'); // Hapus kolom name jika rollback
        });
    }
};
