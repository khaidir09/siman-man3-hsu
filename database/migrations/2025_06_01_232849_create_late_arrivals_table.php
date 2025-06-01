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
        Schema::create('late_arrivals', function (Blueprint $table) {
            $table->id();
            $table->string('nama_siswa', 255);
            $table->string('guru_piket', 255);
            $table->integer('rooms_id')->unsigned()->nullable();
            $table->date('tanggal');
            $table->time('waktu_datang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('late_arrivals');
    }
};
