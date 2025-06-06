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
        Schema::create('health_cares', function (Blueprint $table) {
            $table->id();
            $table->string('nama_siswa', 255);
            $table->integer('rooms_id')->unsigned();
            $table->string('keluhan', 255);
            $table->string('orang_tua', 255);
            $table->text('alamat');
            $table->text('hasil_pemeriksaan');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_cares');
    }
};
