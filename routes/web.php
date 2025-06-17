<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExtracurricularController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\JadwalUmumController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KedisiplinanController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KesehatanController;
use App\Http\Controllers\KonselingController;
use App\Http\Controllers\KoperasiController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PrestasiAkademikController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\WaktuMapelController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('pengguna', PenggunaController::class);
Route::resource('jurusan', JurusanController::class);
Route::resource('kelas', KelasController::class);
Route::resource('semester', SemesterController::class);
Route::resource('prestasi-akademik', PrestasiAkademikController::class);
Route::post('/laporan/prestasi-akademik/cetak', [PrestasiAkademikController::class, 'cetakPrestasiAkademik'])->name('prestasi.cetak');
Route::resource('terlambat', KedisiplinanController::class);
Route::resource('kehadiran', KehadiranController::class);
Route::resource('konseling', KonselingController::class);
Route::post('/laporan/konseling/cetak', [KonselingController::class, 'cetakKonseling'])->name('konseling.cetak');
Route::resource('inventaris', InventarisController::class);
Route::resource('kesehatan', KesehatanController::class);
Route::resource('unit-usaha', KoperasiController::class);
Route::resource('alumni', AlumniController::class);
Route::resource('siswa', StudentController::class);
Route::resource('ekstrakurikuler', ExtracurricularController::class);
// Route untuk menambah anggota
Route::post('ekstrakurikuler/{ekstrakurikuler}/add-member', [ExtracurricularController::class, 'addMember'])
    ->name('ekstrakurikuler.addMember')->middleware('auth');

// Route untuk menghapus anggota
Route::delete('ekstrakurikuler/{ekstrakurikuler}/remove-member/{student}', [ExtracurricularController::class, 'removeMember'])
    ->name('ekstrakurikuler.removeMember')->middleware('auth');

Route::put('ekstrakurikuler/{ekstrakurikuler}/update-member/{student}', [ExtracurricularController::class, 'updateMember'])
    ->name('ekstrakurikuler.updateMember')->middleware('auth');

Route::resource('prestasi-ekskul', AchievementController::class);

Route::get('/get-ekskul-members/{ekskul}', [AchievementController::class, 'getMembersAjax'])
    ->name('ekskul.getMembers')->middleware('auth');

Route::resource('mapel', MapelController::class);
Route::resource('waktu-mapel', WaktuMapelController::class);
Route::resource('jadwal', ScheduleController::class);
Route::post('/jadwal/{schedule}/clone', [ScheduleController::class, 'clone'])->name('jadwal.clone')->middleware('auth');

Route::resource('jadwal-umum', JadwalUmumController::class);

require __DIR__ . '/auth.php';
