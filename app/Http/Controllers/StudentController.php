<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    private $uidData; // Properti untuk menyimpan data UID

    public function handle(Request $request)
    {
        // Menerima data dari koneksi WebSocket
        $data = json_decode($request->getContent(), true);

        if ($data && isset($data['uid'])) {
            // Lakukan sesuatu dengan data UID
            $uid = $data['uid'];

            // Misalnya, Anda dapat mencetak UID atau melakukan tindakan lain yang diperlukan
            // Anda juga dapat menyimpan data UID ke dalam database atau mengirimnya ke channel lain jika diperlukan.

            // Contoh menampilkan UID ke log
            // dd($uid);
            // die;
        }

        return response()->json(['message' => $uid]);
    }

    public function show_student()
    {
        $student = Student::all();
        return view('student.student_show', compact('student'));
    }

    public function create_student(Request $request)
    {
        $uid = session('uid', '');
        return view('student.student_create', ['uid' => $uid]);
    }

    public function store_student(Request $request)
    {
        $request->validate([
            'nomor_kartu' => 'required',
            'uid' => 'required',
            'nama' => 'required',
            'nis' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
        ]);

        $existingStudent = Student::where('uid', $request->uid)->first();
        if ($existingStudent) {
            return back()->with('error', 'UID Sudah ada di database');
        }
        $store = new Student();
        $store->nomor_kartu = $request->nomor_kartu;
        $store->uid = $request->uid;
        $store->name = $request->nama;
        $store->nis = $request->nis;
        $store->kelas = $request->kelas;
        $store->jurusan = $request->jurusan;
        if ($request->hp_ortu != null) {
            $store->hp_ortu = $request->hp_ortu;
        }
        $store->save();
        return redirect()->route('student')->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit_student($id)
    {
        $edit = Student::where('id', $id)->first();
        return view('student.student_edit', compact('edit'));
    }

    public function update_student(Request $request, $id)
    {
        $update = Student::where('id', $id)->first();
        $request->validate([
            'nomor_kartu' => 'required',
            'uid' => 'required',
            'nama' => 'required',
            'nis' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
        ]);

        $update->nomor_kartu = $request->nomor_kartu;
        $update->uid = $request->uid;
        $update->name = $request->nama;
        $update->nis = $request->nis;
        $update->kelas = $request->kelas;
        $update->jurusan = $request->jurusan;
        if ($request->hp_ortu == '') {
            $update->hp_ortu = null;
        } else {
            $update->hp_ortu = $request->hp_ortu;
        }
        $update->update();
        return redirect()->route('student');
    }

    public function delete_student($id)
    {
        $delete = Student::where('id', $id)->first();
        $delete->delete();
        return redirect()->route('student')->with('success', 'Data siswa berhasil di edit');
    }

    public function naik_kelas()
    {
        $student = Student::whereIn('kelas', ['X', 'XI', 'XII'])->get();

        $student->each(function ($student) {
            if ($student->kelas == 'XII') {
                $student->kelas = 'Lulus';
            } elseif ($student->kelas == 'XI') {
                $student->kelas = 'XII';
            } elseif ($student->kelas == 'X') {
                $student->kelas = 'XI';
            }

            $student->save();
        });
        return back()->with('success', 'Semua siswa dinaikan ke kelas selanjutnya');
    }
}
