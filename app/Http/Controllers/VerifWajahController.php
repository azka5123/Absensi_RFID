<?php

namespace App\Http\Controllers;

use App\Models\Student;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class VerifWajahController extends Controller
{
    public function show()
    {
        $user = Student::select('name', 'uid', 'id','kelas','jurusan')->get();
        return view('verifWajah.verifwajah_show', compact('user'));
    }

    public function faceDetectAndSave(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $image = $request->file('image');
        $id = $request->idSiswa;
        $student = Student::find($id);

        // Pastikan siswa dengan ID yang diberikan ditemukan
        if (!$student) {
            return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
        }

        $response = Http::attach(
            'files',
            file_get_contents($image->path()),
            $image->getClientOriginalName()
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

                // Proses untuk menyimpan TID
                $saveResponse = Http::get('http://api.skybiometry.com/fc/tags/save.json', [
                    'api_key' => env('API_KEY_skybiometry'),
                    'api_secret' => env('API_SECRET_skybiometry'),
                    'tids' => $tid,
                    'uid' => $student->uid . '@SMKN1TILKAM',
                    'label' => $student->name
                ]);

                $trainResponse = http::get('http://api.skybiometry.com/fc/faces/train.json', [
                    'api_key' => env('API_KEY_skybiometry'),
                    'api_secret' => env('API_SECRET_skybiometry'),
                    'uids' => $student->uid . '@SMKN1TILKAM',
                    'namespace' => 'SMKN1TILKAM'
                ]);

                // Kembalikan respons JSON dari proses penyimpanan TID
                // return response()->json($saveResponse    ->json());
            } else {
                return response()->json(['error' => 'Tidak ada tag dalam foto'], 400);
            }
        } else {
            // Handle jika status tidak sukses
            return response()->json(['error' => $responseData['status']], 400);
        }
        return redirect()->back()->with('success', 'Data Wajah Berhasil Ditambahkan');
    }
}
