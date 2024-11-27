<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pekerjas', function (Blueprint $table) {
            $table->unsignedBigInteger('job_descs_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('pekerjas', function (Blueprint $table) {
            $table->unsignedBigInteger('job_descs_id')->nullable(false)->change();
        });
    }
};

