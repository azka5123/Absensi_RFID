<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Broadcast;
use BeyondCode\LaravelWebSockets\Facades\Websockets;
use Illuminate\Http\Request;

class UIDWebSocketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function handle(Request $request)
    {
        return 'textx';
        // Menerima data dari koneksi WebSocket
        $data = json_decode($request->getContent(), true);

        if ($data && isset($data['uid'])) {
            // Lakukan sesuatu dengan data UID
            $uid = $data['uid'];

            // Misalnya, Anda dapat mencetak UID atau melakukan tindakan lain yang diperlukan
            // Anda juga dapat menyimpan data UID ke dalam database atau mengirimnya ke channel lain jika diperlukan.

            // Contoh menampilkan UID ke log
            // \Log::info('UID diterima: ' . $uid);
        }

        return response()->json(['message' => 'Data UID diterima']);
    }
}
