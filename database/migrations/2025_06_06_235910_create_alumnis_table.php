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
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->string('no_induk', 255);
            $table->string('nama_siswa', 255);
            $table->string('tempat_lahir', 255);
            $table->integer('rooms_id')->unsigned();
            $table->date('tanggal_lahir');
            $table->integer('academic_periods_id')->unsigned();
            $table->string('melanjutkan', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
