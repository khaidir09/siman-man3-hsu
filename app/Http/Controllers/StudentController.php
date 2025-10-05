<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ClassTransferLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Ambil user yang sedang login
        $user = Auth::user();



        // 2. Mulai query dasar dengan eager loading
        $query = Student::with('room.major')->get();

        // 3. Tambahkan kondisi JIKA user adalah 'wali kelas'
        if ($user->hasRole('wali kelas')) {
            // a. Cari ID kelas di mana user ini menjadi wali kelasnya
            //    Ini mengasumsikan tabel 'rooms' punya kolom 'wali_kelas_id'
            $roomId = Room::where('wali_kelas_id', $user->id)->value('id');

            // b. Filter query siswa berdasarkan room_id tersebut
            if ($roomId) {
                $query->where('room_id', $roomId);
            } else {
                // Jika guru ini tidak menjadi wali kelas manapun, tampilkan data kosong
                $query->where('id', -1); // Trik untuk mengembalikan koleksi kosong
            }
        }

        // 4. Jika user bukan 'wali kelas' (misal: kepala madrasah),
        //    maka kondisi if di atas tidak dijalankan, dan semua siswa akan ditampilkan.

        // 5. Eksekusi query dengan paginasi
        $students = $query;

        // Data rooms mungkin tidak lagi relevan jika wali kelas hanya melihat 1 kelas,
        // tapi bisa tetap dikirim untuk keperluan lain.
        $rooms = Room::all();
        return view('siswa.index', compact('students', 'rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data kelas untuk dropdown
        $rooms = Room::all();
        return view('siswa.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|max:50|unique:students,nisn',
            'room_id' => 'required|exists:rooms,id',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user
        $user = User::create([
            'name' => $request->input('nama_lengkap'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $role = 'siswa';

        /** assign the role to user */
        $user->assignRole($role);

        // Buat record siswa baru
        Student::create([
            'user_id' => $user->id,
            'nisn' => $request->input('nisn'),
            'nama_lengkap' => $request->input('nama_lengkap'),
            'room_id' => $request->input('room_id'),
            'status' => 'Aktif', // Set status default ke 'Aktif'
        ]);

        toast('Data Siswa berhasil dibuat.', 'success')->width('350');

        return redirect()->route('siswa.index');
    }

    /**
     * Display the specified resource.
     * (Halaman ini bisa menampilkan profil lengkap siswa, termasuk ekskul yang diikuti)
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $siswa = Student::findOrFail($id);
        $rooms = Room::all();
        return view('siswa.edit', compact('siswa', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $siswa)
    {
        // Validasi data (mirip dengan store, tapi unique diabaikan untuk record saat ini)
        $validatedData = $request->validate([
            'nisn' => 'required|string|max:50|unique:students,nisn,' . $siswa->id,
            'nama_lengkap' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'status' => ['required', Rule::in(['Aktif', 'Lulus', 'Pindah', 'Dikeluarkan'])],
        ]);

        // Update record
        $siswa->update($validatedData);

        toast('Data Siswa berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('siswa.index');
    }

    public function transfer(Request $request, Student $student)
    {
        $request->validate([
            'to_room_id' => 'required|exists:rooms,id',
            'transfer_date' => 'required|date',
            'reason' => 'nullable|string',
        ]);

        $fromRoomId = $student->room_id;

        DB::transaction(function () use ($request, $student, $fromRoomId) {
            // 1. Update kelas siswa
            $student->update(['room_id' => $request->to_room_id]);

            // 2. Buat log perpindahan (jika Anda membuat tabelnya)
            ClassTransferLog::create([
                'student_id' => $student->id,
                'from_room_id' => $fromRoomId,
                'to_room_id' => $request->to_room_id,
                'transfer_date' => $request->transfer_date,
                'reason' => $request->reason,
                'user_id' => auth()->id(),
            ]);
        });

        toast('Siswa berhasil dipindahkan.', 'success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);

        try {
            // Hapus record dari database
            $student->delete();

            // Kembalikan respons dalam format JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Data Siswa Berhasil Dihapus!'
            ]);
        } catch (\Exception $e) {
            // Jika terjadi error saat menghapus, kirim respons error
            // Log::error($e); // Opsional: catat error ke log
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus data. Terjadi kesalahan.'
            ], 500); // 500 = Internal Server Error
        }
    }
}
