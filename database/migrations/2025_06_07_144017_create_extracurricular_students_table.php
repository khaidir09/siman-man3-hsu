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
        Schema::create('extracurricular_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('extracurricular_id')->constrained('extracurriculars')->onDelete('cascade');
            $table->string('jabatan')->default('Anggota');
            $table->char('nilai', 2)->nullable();
            $table->date('tanggal_bergabung');
            $table->timestamps();

            // Pastikan satu siswa tidak bisa join ke ekskul yang sama dua kali
            $table->unique(['student_id', 'extracurricular_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurricular_students');
    }
};
