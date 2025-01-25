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
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('down_payment', 10, 2)->nullable()->default(0.0)->after('total_price');
            $table->decimal('remaining_payment', 10, 2)->nullable()->default(0.0)->after('down_payment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('down_payment');
            $table->dropColumn('remaining_payment');
        });
    }
};
