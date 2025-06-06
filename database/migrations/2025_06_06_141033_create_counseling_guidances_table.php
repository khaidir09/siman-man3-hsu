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
        Schema::create('counseling_guidances', function (Blueprint $table) {
            $table->id();
            $table->string('nama_siswa', 255);
            $table->integer('classes_id')->unsigned();
            $table->date('tanggal');
            $table->longText('uraian_masalah');
            $table->longText('pemecahan_masalah');
            $table->tinyInteger('is_pribadi');
            $table->tinyInteger('is_sosial');
            $table->tinyInteger('is_karir');
            $table->tinyInteger('is_belajar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counseling_guidances');
    }
};
