<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Student;
// use App\Services\FaceRecognition;
use App\Services\WhatsappSend;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ApiAbsenController extends Controller
{
    // private function verifWajah($imageFileName)
    // {
    //     $client = new Client();
    //     $response = $client->post('https://faceanalyzer-ai.p.rapidapi.com/search-face-in-repository', [
    //         'headers' => [
    //             'X-RapidAPI-Key' => 'b4be004592mshb22c85be5de9b6dp12adc8jsn066352357f9e',
    //             'X-RapidAPI-Host' => 'faceanalyzer-ai.p.rapidapi.com',
    //         ],
    //         'multipart' => [
    //             [
    //                 'name' => 'repository_id',
    //                 'contents' => 'SMKN1TILKAM',
    //             ],
    //             [
    //                 'name' => 'image',
    //                 'contents' => fopen(storage_path("app/public/$imageFileName"), 'r'),
    //             ],
    //         ],
    //     ]);
    //     // return response()->json(json_decode($response->getBody()));
    // }

    private function checkAccount()
    {
        $response = Http::get('http://api.skybiometry.com/fc/account/users', [
            'namespaces' => 'SMKN1TILKAM',
            'api_key' => env('API_KEY_skybiometry'),
            'api_secret' => env('API_SECRET_skybiometry'),
        ]);

        // Menampilkan respons HTTP
        echo $response->body();
    }
    private function faceDetect($imageFileName)
    {
        $response = Http::attach(
            'files',
            fopen(storage_path("app/public/$imageFileName"), 'r'),
            'image/jpeg'
        )
            ->post('http://api.skybiometry.com/fc/faces/detect.json', [
                'api_key' => env('API_KEY_skybiometry'),
                'api_secret' => env('API_SECRET_skybiometry'),
                'detector' => 'Aggressive',
                'attributes' => 'all',
            ]);

        $responseData = json_decode($response->getBody(), true);

        if ($responseData['status'] == 'success') {
            $photo = $responseData['photos'][0];

            if (!empty($photo['tags'])) {
                $firstTag = $photo['tags'][0];
                $tid = $firstTag['tid'];

                return [
                    'tid' => $tid
                ];
            } else {
                echo "Error: Tidak ada tag dalam foto.\n";
            }
        } else {
            // Handle jika status tidak sukses
            echo "Error: {$responseData['status']}\n";
        }
    }

    private function faceSave($tid, $uid, $label)
    {
        // TEMP_F@0e7bb9934e2489440f0dff5106ea095f_07183343be758_51.22_52.06_0_1
        $response = http::get('http://api.skybiometry.com/fc/tags/save.json', [
            'api_key' => env('API_KEY_skybiometry'),
            'api_secret' => env('API_SECRET_skybiometry'),
            'tids' => $tid,
            'uid' => $uid . '@SMKN1TILKAM',
            'label' => $label
        ]);
        // echo $response->body();
    }

    private function faceTrain($uids)
    {
        $response = http::get('http://api.skybiometry.com/fc/faces/train.json', [
            'api_key' => env('API_KEY_skybiometry'),
            'api_secret' => env('API_SECRET_skybiometry'),
            'uids' => $uids . '@SMKN1TILKAM',
        ]);
        // echo $response->body();
    }

    private function faceRecognize($uids, $imageFileName)
    {
        $response = Http::attach(
            'files',
            fopen(storage_path("app/public/$imageFileName"), 'r'),
            'image/jpeg'
        )
            ->post('http://api.skybiometry.com/fc/faces/recognize.json', [
                'api_key' => env('API_KEY_skybiometry'),
                'api_secret' => env('API_SECRET_skybiometry'),
                'uids' => $uids . '@SMKN1TILKAM',
                'detector' => 'Aggressive',
            ]);
        $responseData = json_decode($response->body(), true);

        if ($responseData['status'] == 'success') {
            $photo = $responseData['photos'][0];

            foreach ($photo['tags'] as $tag) {
                $uid = $tag['uids'][0]['uid'];
                $confidence = $tag['uids'][0]['confidence'];
                $label = $tag['label'];

                // Now you can use $uid, $confidence, and $label as needed
                return [
                    'uid' => $uid . '@SMKN1TILKAM',
                    'confidence' => $confidence,
                    'label' => $label,
                ];
            }
        } else {
            // Handle error if the status is not success
            echo "Error: {$responseData['status']}\n";
        }
    }

    public function masuk(Request $request)
    {
        $request->validate([
            'uid' => 'required',
        ]);
        $student = Student::where('uid', $request->uid)->first();
        $now = Carbon::now()->toDateString();
        $imageData = base64_decode($request->image);
        $fileName = $student->name . '_' . $now . '.jpeg';
        Storage::disk('public')->put($fileName, $imageData);
        if ($student === null) {
            return response()->json([
                'nama' => "unknown card",
                'ket' => "Not found",
            ]);
        }

        $absenResponse = $this->handleAttendance($student, $fileName);
        // $absenResponse = $this->handleAttendance($student);

        if ($student->hp_ortu && $absenResponse['ket'] !== 'Tidak Bisa Ambil Absen, Silahkan Pergi ke Ruang BK' && $absenResponse['ket'] !== 'Sudah Ambil Absen') {
            $this->sendWhatsAppMessage($student);
        }
        if ($absenResponse['ket'] !== 'Wajah Tidak Cocok') {
            // echo"test";die;
            $tid = $this->faceDetect($fileName);
            $uids = $request->uid;
            $label = $student->name;
            $this->faceSave($tid['tid'], $uids, $label);
            $this->faceTrain($uids);
        }

        return response()->json($absenResponse);
    }
    private function handleAttendance(Student $student, $imageFileName)
    // private function handleAttendance(Student $student)
    {
        $now = Carbon::now();
        $today = Carbon::today();
        $tgl = $now->format('Y-m-d H:i');
        $waktu_masuk = Carbon::createFromTime(7, 30, 0);
        $ket = ($now->isAfter($waktu_masuk)) ? "Terlambat" : "Hadir";

        $absen = Absen::where('student_id', $student->id)
            ->whereDate('jam_masuk', $today)
            ->first();

        if ($absen) {
            return [
                'nama' => $student->name,
                'ket' => 'Sudah Ambil Absen',
            ];
        }

        $faceRecognize = $this->faceRecognize($student->uid, $imageFileName);
        if ($faceRecognize['confidence'] < 85) {
            return [
                'nama' => $student->name,
                'ket' => 'Wajah Tidak Cocok',
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
            'image' => $imageFileName,
        ]);
        // dd($store);
        // die;
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
