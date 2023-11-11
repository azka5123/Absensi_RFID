<?php

namespace App\Http\Controllers;

use App\Exports\ExportAbsen;
use App\Models\Absen;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AbsenController extends Controller
{
    public function show_absen()
    {
        $absen = Absen::latest()->with('rStudent')->get();

        $absen = $absen->filter(function ($item) {
            $now = Carbon::now();
            $jamMasuk = Carbon::parse($item->jam_masuk);

            return $now->month == $jamMasuk->month;
        });
        return view('absen.absen_show', compact('absen'));
    }


    public function show_absen_tkj()
    {
        $now = Carbon::now();
        $currentMonth = $now->month;

        $absen_tkj = Absen::latest()
            ->whereHas('rStudent', function ($query) {
                $query->where('jurusan', 'TJKT');
            })
            ->whereMonth('jam_masuk', $currentMonth)
            ->with('rStudent')
            ->get();
        return view('absen.tkj.tkj_show', compact('absen_tkj'));
    }

    public function show_absen_tkr()
    {
        $absen_tkr = Absen::latest()->whereHas('rStudent', function ($query) {
            $query->where('jurusan', 'TKR');
        })->with('rStudent')->get();
        $absen_tkr = $absen_tkr->filter(function ($item) {
            $now = Carbon::now();
            $jamMasuk = Carbon::parse($item->jam_masuk);

            return $now->month == $jamMasuk->month;
        });
        return view('absen.tkr.tkr_show', compact('absen_tkr'));
    }

    public function show_absen_dpib()
    {
        $absen_dpib = Absen::latest()->whereHas('rStudent', function ($query) {
            $query->where('jurusan', 'DPIB');
        })->with('rStudent')->get();
        $absen_dpib = $absen_dpib->filter(function ($item) {
            $now = Carbon::now();
            $jamMasuk = Carbon::parse($item->jam_masuk);

            return $now->month == $jamMasuk->month;
        });
        return view('absen.dpib.dpib_show', compact('absen_dpib'));
    }

    public function show_absen_titl()
    {
        $absen_titl = Absen::latest()->whereHas('rStudent', function ($query) {
            $query->where('jurusan', 'TITL');
        })->with('rStudent')->get();
        $absen_titl = $absen_titl->filter(function ($item) {
            $now = Carbon::now();
            $jamMasuk = Carbon::parse($item->jam_masuk);

            return $now->month == $jamMasuk->month;
        });
        return view('absen.titl.titl_show', compact('absen_titl'));
    }

    public function edit_absen($id)
    {
        $edit = Absen::where('id', $id)->with('rStudent')->first();
        return view('absen.absen_edit', compact('edit'));
    }

    public function update_absen(Request $request, $id)
    {
        $update = Absen::where('id', $id)->first();
        // $request->validate([
        //     'jam_masuk' => 'required',
        //     'jam_keluar' => 'required',
        // ]);

        $update->jam_masuk = $request->masuk;
        $update->jam_keluar = $request->keluar;
        $update->keterangan = $request->keterangan;
        $update->update();
        return redirect()->route('absen')->with("success", "Data absen berhasil di edit");
    }

    public function delete_absen($id)
    {
        $delete = Absen::where('id', $id)->first();
        $delete->delete();
        return redirect()->route('absen')->with("success", "Data berhasil dihapus");
    }

    public function sakit_dan_izin()
    {
        $student = Student::all();
        return view('absen.sakit.sakit_dan_izin_show', compact('student'));
    }

    public function sakit($id)
    {
        $now = Carbon::now();
        $student_id = $id;
        $keterangan = "Sakit";

        $existingAbsen = Absen::where('student_id', $student_id)
            ->whereIn('keterangan', ['Sakit', 'Izin'])
            ->whereDate('jam_masuk', $now->toDateString())
            ->first();

        if (!$existingAbsen) {
            $absen = new Absen();
            $absen->student_id = $student_id;
            $absen->keterangan = $keterangan;
            $absen->jam_masuk = $now;
            $absen->save();

            return back()->with("success", "Data siswa sakit berhasil ditambahkan di tabel absen");
        } else {
            return back()->with("error", "Siswa sudah melakukan absen sakit atau izin");
        }
    }

    public function izin($id)
    {
        $now = Carbon::now();
        $student_id = $id;
        $keterangan = "Izin";

        $existingAbsen = Absen::where('student_id', $student_id)
            ->whereIn('keterangan', ['Sakit', 'Izin'])
            ->whereDate('jam_masuk', $now->toDateString()) // Compare the date part only
            ->first();

        if (!$existingAbsen) {
            // Create a new Absen record
            $absen = new Absen();
            $absen->student_id = $student_id;
            $absen->keterangan = $keterangan;
            $absen->jam_masuk = $now;
            $absen->save();

            return back()->with("success", "Data siswa Izin berhasil ditambahkan di tabel absen");
        } else {
            return back()->with("error", "Siswa sudah melakukan absen sakit atau izin");
        }
    }

    public function exportTest()
    {
        setlocale(LC_TIME, 'id_ID.utf8');
        $now = Carbon::now();
        $bulan = $now->subMonths(1)->isoFormat('MMMM');
        $tahun = $now->format('Y');
        return Excel::download(new ExportAbsen(), 'rekap absensi ' . $bulan . ' ' . $tahun . '.xlsx');
    }

    public function rekap()
    {
        $files = Storage::files('public/exports/excel');
        return view('absen.rekap', compact('files'));
    }
    public function download($file)
    {
        $path = storage_path('app/public/exports/excel/' . $file);
        // dd($path);
        // die;
        if (file_exists($path)) {
            return response()->download($path, $file);
        } else {
            // Handle jika file tidak ditemukan
            abort(404, 'File not found');
        }
    }
}
