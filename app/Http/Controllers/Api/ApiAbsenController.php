<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Student;
use App\Services\WhatsappSend;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ApiAbsenController extends Controller
{
    public function masuk(Request $request)
    {
        $request->validate([
            'uid' => 'required',
        ]);

        $student = Student::where('uid', $request->uid)->first();

        if ($student === null) {
            return response()->json([
                'nama' => "unknown card",
                'ket' => "Not found",
            ]);
        }

        $absenResponse = $this->handleAttendance($student);

        if ($student->hp_ortu && $absenResponse['ket'] !== 'Tidak Bisa Ambil Absen, Silahkan Pergi ke Ruang BK' && $absenResponse['ket'] !== 'Sudah Ambil Absen') {
            $this->sendWhatsAppMessage($student);
        }

        return response()->json($absenResponse);
    }

    private function handleAttendance(Student $student)
    {
        $now = Carbon::now();
        $today = Carbon::today();
        $tgl = $now->format('Y-m-d H:i');
        $ket = ($now->hour > 7 && $now->minute >= 30) ? "Terlambat" : "Hadir";

        $absen = Absen::where('student_id', $student->id)
            ->whereDate('jam_masuk', $today)
            ->first();

        if ($absen) {
            return [
                'nama' => $student->name,
                'ket' => 'Sudah Ambil Absen',
            ];
        }

        if ($student->alfa == 3 || $student->terlambat == 3) {
            return [
                'nama' => $student->name,
                'ket' => 'Tidak Bisa Ambil Absen, Silahkan Pergi ke Ruang BK',
            ];
        }

        if ($ket == 'Terlambat') {
            $student->terlambat = $student->terlambat + 1;
            $student->save();
        }

        $store = new Absen([
            'student_id' => $student->id,
            'jam_masuk' => $tgl,
            'keterangan' => $ket,
        ]);
        $store->save();

        return [
            'nama' => $student->name,
            'ket' => $ket,
        ];
    }

    private function sendWhatsAppMessage(Student $student)
    {
        try {
            $reqParams = [
                'token' => env('API_TOKEN_WA'),
                'url' => 'https://api.kirimwa.id/v1/messages',
                'method' => 'POST',
                'payload' => json_encode([
                    'message' => 'Halo, Anak Bernama ' . $student->name . ' telah mengambil absen',
                    'phone_number' => $student->hp_ortu,
                    'message_type' => 'text',
                    'device_id' => 'iphone-x-pro',
                ]),
            ];

            $kirimwaSender = new WhatsappSend();
            $kirimwaSender->apiKirimWaRequest($reqParams);
        } catch (Exception $e) {
            print_r($e);
        }
    }



    public function keluar(Request $request)
    {
        $request->validate([
            'uid' => 'required'
        ]);

        $student = Student::where('uid', $request->uid)->first();

        if ($student === null) {
            return response()->json([
                'nama' => "unknown card",
                'ket' => "Not found"
            ]);
        }

        $today = Carbon::today();
        $now = Carbon::now();
        $tgl = $now->format('Y-m-d H:i');

        $store = Absen::where('student_id', $student->id)
            ->whereDate('jam_masuk', $today)
            ->first();

        if (!$store) {
            return response()->json([
                'nama' => $student->name,
                'ket' => 'Belum Absen Masuk'
            ]);
        }
        if ($store->jam_keluar) {
            return response()->json([
                'nama' => $student->name,
                'ket' => 'Sudah Ambil Absen'
            ]);
        }

        $store->jam_keluar = $tgl;
        $store->update();

        return response()->json([
            'nama' => $student->name,
            'ket' => 'Pulang'
        ]);
    }

    public function izin(Request $request)
    {
        $request->validate([
            'uid' => 'required'
        ]);

        $student = Student::where('uid', $request->uid)->first();

        if ($student === null) {
            return response()->json([
                'nama' => "unknown card",
                'ket' => "Not found"
            ]);
        }

        $today = Carbon::today();
        $now = Carbon::now();
        $tgl = $now->format('Y-m-d H:i');

        $store = Absen::where('student_id', $student->id)
            ->whereDate('jam_masuk', $today)
            ->first();

        if (!$store) {
            return response()->json([
                'nama' => $student->name,
                'ket' => 'Belum Absen Masuk'
            ]);
        }

        $jml_izin = $store->izin = $store->izin + 1;
        $store->update();

        return response()->json([
            'nama' => $student->name,
            'ket' => 'izin ' . $jml_izin
        ]);
    }

    // public function cekSiswa(Request $request)
    // {
    //     $request->validate([
    //         'uid' => 'required'
    //     ]);
    //     $murid = Student::where('uid', $request->uid)->first();
    //     if ($murid == null) {
    //         return response()->json("Murid tidak ditemukan");
    //     } else {
    //         return response()->json("Murid ditemukan");
    //     }
    // }


}
