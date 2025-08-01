<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\KoperasiController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\KesehatanController;
use App\Http\Controllers\KonselingController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\JadwalUmumController;
use App\Http\Controllers\NilaiUjianController;
use App\Http\Controllers\WaktuMapelController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\KedisiplinanController;
use App\Http\Controllers\RiwayatUjianController;
use App\Http\Controllers\ExtracurricularController;
use App\Http\Controllers\Guru\MapelDiampuController;
use App\Http\Controllers\Guru\NilaiAkhirController;
use App\Http\Controllers\PembelajaranController;
use App\Http\Controllers\PrestasiAkademikController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\TujuanPembelajaranController;

Route::redirect('/', 'login');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('pengguna', PenggunaController::class);
Route::resource('jurusan', JurusanController::class);
Route::resource('kelas', KelasController::class);
Route::resource('semester', SemesterController::class);
Route::resource('prestasi-akademik', PrestasiAkademikController::class);
Route::post('/laporan/prestasi-akademik/cetak', [PrestasiAkademikController::class, 'cetakPrestasiAkademik'])->name('prestasi.cetak');
Route::resource('terlambat', KedisiplinanController::class);
Route::post('/laporan/kedisiplinan/cetak', [KedisiplinanController::class, 'cetakKedisiplinan'])->name('kedisiplinan.cetak');
Route::resource('kehadiran', KehadiranController::class);
Route::post('/laporan/kehadiran/cetak', [KehadiranController::class, 'cetakKehadiran'])->name('kehadiran.cetak');
Route::resource('konseling', KonselingController::class);
Route::post('/laporan/konseling/cetak', [KonselingController::class, 'cetakKonseling'])->name('konseling.cetak');
Route::resource('inventaris', InventarisController::class);
Route::post('/laporan/inventaris/cetak', [InventarisController::class, 'cetakInventaris'])->name('inventaris.cetak');
Route::resource('kesehatan', KesehatanController::class);
Route::post('/laporan/kesehatan/cetak', [KesehatanController::class, 'cetakKesehatan'])->name('kesehatan.cetak');
Route::resource('unit-usaha', KoperasiController::class);
Route::post('/laporan/unit-usaha/cetak', [KoperasiController::class, 'cetakKoperasi'])->name('unit-usaha.cetak');
Route::resource('alumni', AlumniController::class);
Route::post('/laporan/alumni/cetak', [AlumniController::class, 'cetakAlumni'])->name('alumni.cetak');
Route::resource('siswa', StudentController::class);
Route::resource('ekstrakurikuler', ExtracurricularController::class);
Route::post('/laporan/ekstrakurikuler/cetak-detail', [ExtracurricularController::class, 'cetakDetail'])
    ->name('cetak-detail-ekskul')
    ->middleware('auth');
Route::post('/laporan/ekstrakurikuler/cetak-rangkuman', [ExtracurricularController::class, 'cetakLaporanRangkuman'])
    ->name('cetak-rangkuman-ekskul')
    ->middleware('auth');
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
Route::resource('pembelajaran', PembelajaranController::class);
Route::resource('waktu-mapel', WaktuMapelController::class);
Route::resource('jadwal', ScheduleController::class);
Route::post('/laporan/jadwal-pelajaran/cetak', [ScheduleController::class, 'cetakJadwalKelas'])
    ->name('cetak-jadwal-kelas')
    ->middleware('auth');

Route::post('/jadwal/{schedule}/clone', [ScheduleController::class, 'clone'])->name('jadwal.clone')->middleware('auth');

Route::resource('jadwal-umum', JadwalUmumController::class);

Route::get('/presensi/{schedule}/create', [PresensiController::class, 'create'])->name('presences.create');
Route::post('/presensi/{schedule}/store', [PresensiController::class, 'store'])->name('presences.store');

Route::get('/presensi/riwayat', [PresensiController::class, 'showHistory'])
    ->name('presensi.riwayat')
    ->middleware('auth');

Route::resource('ujian', UjianController::class);

Route::get('/ujian/{exam}/input-nilai', [NilaiUjianController::class, 'edit'])->name('input-nilai-ujian');

// Route untuk memproses penyimpanan nilai ujian
Route::patch('/ujian/{exam}/input-nilai', [NilaiUjianController::class, 'update'])->name('simpan-nilai-ujian');

Route::get('/riwayat-ujian', [RiwayatUjianController::class, 'index'])
    ->name('riwayat-ujian-saya')
    ->middleware(['auth']);

Route::get('/mapel-diampu', [MapelDiampuController::class, 'index'])->name('mapel-diampu');

// Route::resource('tujuan-pembelajaran', TujuanPembelajaranController::class);
Route::prefix('pembelajaran/{learning}')->name('tujuan-pembelajaran.')->group(function () {
    Route::get('/tujuan-pembelajaran', [TujuanPembelajaranController::class, 'index'])->name('index');
    Route::get('/tujuan-pembelajaran/create', [TujuanPembelajaranController::class, 'create'])->name('create');
    Route::post('/tujuan-pembelajaran', [TujuanPembelajaranController::class, 'store'])->name('store');
    Route::get('/tujuan-pembelajaran/{tujuan_pembelajaran}/edit', [TujuanPembelajaranController::class, 'edit'])->name('edit');
    Route::patch('/tujuan-pembelajaran/{tujuan_pembelajaran}', [TujuanPembelajaranController::class, 'update'])->name('update');
    Route::delete('/tujuan-pembelajaran/{tujuan_pembelajaran}', [TujuanPembelajaranController::class, 'destroy'])->name('destroy');
});

// routes/web.php -> TETAP SAMA
Route::get('/finalisasi-nilai/{learning}', [NilaiAkhirController::class, 'edit'])->name('nilai-akhir.edit');
Route::post('/finalisasi-nilai/{learning}', [NilaiAkhirController::class, 'store'])->name('nilai-akhir.store');

Route::get('/rapor/kelas-saya', [RaportController::class, 'showClass'])
    ->name('rapor.kelas')
    ->middleware(['auth']);

Route::get('/rapor/proses/{student}/{period}', [RaportController::class, 'process'])
    ->name('rapor.process');

// 3. Aksi untuk menyimpan catatan dan memfinalisasi rapor
// Menggunakan {reportCard} untuk Route Model Binding
Route::patch('/rapor/finalisasi/{reportCard}', [RaportController::class, 'finalize'])
    ->name('rapor.finalize');

Route::get('/rapor/cetak/{reportCard}', [RaportController::class, 'printPdf'])
    ->name('raport.print')
    ->middleware('auth');

require __DIR__ . '/auth.php';
