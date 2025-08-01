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
        Schema::create('detail_learning_objective', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel report_card_details
            $table->foreignId('report_card_detail_id')
                ->constrained('report_card_details')
                ->cascadeOnDelete();

            // Foreign key ke tabel learning_objectives
            $table->foreignId('learning_objective_id')
                ->constrained('learning_objectives')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_learning_objective');
    }
};
