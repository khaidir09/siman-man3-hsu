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
        Schema::create('academic_achievements', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 255);
            $table->string('nama', 255);
            $table->string('ortu', 255);
            $table->integer('classes_id')->unsigned()->nullable();
            $table->string('jumlah_nilai', 255);
            $table->decimal('rata_rata', 5, 0);
            $table->tinyInteger('ranking');
            $table->integer('academic_periods_id')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_achievements');
    }
};
