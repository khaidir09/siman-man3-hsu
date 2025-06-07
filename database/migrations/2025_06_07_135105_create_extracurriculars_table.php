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
        Schema::create('extracurriculars', function (Blueprint $table) {
            $table->id();
            $table->string('kelompok', 255);
            $table->string('nama', 255);
            $table->foreignId('pembina_id')->constrained('users');
            $table->longText('deskripsi')->nullable();
            $table->enum('jadwal_hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('jadwal_waktu');
            $table->string('lokasi');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->foreignId('tahun_ajaran_id')->constrained('academic_periods');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurriculars');
    }
};
