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
        Schema::table('rooms', function (Blueprint $table) {
            // Tambahkan kolom foreign key untuk wali kelas
            // Merujuk ke tabel 'users'
            $table->foreignId('wali_kelas_id')
                ->nullable() // Boleh kosong jika wali kelas belum ditunjuk
                ->constrained('users') // Merujuk ke kolom 'id' di tabel 'users'
                ->onDelete('set null'); // Jika user (guru) dihapus, wali_kelas_id menjadi NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Hapus foreign key constraint sebelum menghapus kolom
            $table->dropForeign(['wali_kelas_id']);
            $table->dropColumn('wali_kelas_id');
        });
    }
};
