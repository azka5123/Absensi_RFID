<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BkController extends Controller
{
    public function show_bk()
    {
        $student = Student::where('alfa', 3)->orWhere('terlambat', 3)->get();
        return view('bk.bk_show', compact('student'));
    }

    public function restore_acc($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return back()->with('error', 'Siswa tidak ditemukan.');
        }

        $now = now();
        $tgl = $now->toDateTimeString();
        $keterangan = 'Hadir(BK)';

        if ($student->alfa == 3) {
            $student->update(['alfa' => 0]);
        } else {
            $student->update(['terlambat' => 0]);
        }

        Absen::create([
            'student_id' => $id,
            'keterangan' => $keterangan,
            'jam_masuk' => $tgl,
        ]);

        return back()->with('success', 'Absen berhasil dipulihkan.');
    }
}
