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
        Schema::create('attencances', function (Blueprint $table) {
            $table->id();
            $table->integer('rooms_id')->unsigned()->nullable();
            $table->date('bulan');
            $table->tinyInteger('izin');
            $table->tinyInteger('sakit');
            $table->tinyInteger('alpa');
            $table->tinyInteger('jumlah_absen');
            $table->tinyInteger('hari_efektif');
            $table->tinyInteger('jumlah_siswa');
            $table->decimal('rata-rata', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attencances');
    }
};
