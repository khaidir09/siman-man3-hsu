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
        Schema::table('report_cards', function (Blueprint $table) {
            $table->integer('sakit')->unsigned()->default(0)->after('homeroom_teacher_notes');
            $table->integer('izin')->unsigned()->default(0)->after('sakit');
            $table->integer('alfa')->unsigned()->default(0)->after('izin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_cards', function (Blueprint $table) {
            //
        });
    }
};
