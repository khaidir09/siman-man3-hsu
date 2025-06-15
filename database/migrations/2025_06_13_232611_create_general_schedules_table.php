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
        Schema::create('general_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']);
            $table->foreignId('time_slot_id_mulai')->constrained('time_slots'); // Jam mulai
            $table->foreignId('time_slot_id_selesai')->constrained('time_slots'); // Jam selesai
            $table->foreignId('academic_period_id')->constrained('academic_periods');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_schedules');
    }
};
