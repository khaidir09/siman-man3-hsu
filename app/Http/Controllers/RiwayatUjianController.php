<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Room;
use App\Models\User;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\ExamScore;
use Illuminate\Http\Request;
use App\Models\AcademicPeriod;
use Illuminate\Support\Facades\Auth;

class RiwayatUjianController extends Controller
{
    public function index()
    {
        $studentId = Auth::user()->student->id;

        $scores = ExamScore::where('student_id', $studentId)
            ->with(['exam.subject']) // Eager load untuk menampilkan nama mapel
            ->orderByDesc('created_at')
            ->get();

        return view('ujian.riwayat-saya', compact('scores'));
    }
}
