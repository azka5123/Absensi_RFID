<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FaceRecognition
{
    private $apiKey;
    private $apiSecret;

    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    public function checkAccount()
    {
        $response = Http::withHeaders([
            'X-RapidAPI-Key' => 'b4be004592mshb22c85be5de9b6dp12adc8jsn066352357f9e',
            'X-RapidAPI-Host' => 'face.p.rapidapi.com',
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])
            ->post('https://face.p.rapidapi.com/account/users', [
                'namespaces' => 'SMKN1TILKAM',
                'api_key' => $this->apiKey,
                'api_secret' => $this->apiSecret,
            ]);

        // Menampilkan respons
        dd($response);die;

        echo $response->body();
    }

    public function detectFaces($imagePath)
    {
        // Membuat permintaan HTTP ke API pengenalan wajah
        $response = Http::withHeaders([
            'X-RapidAPI-Key' => 'b4be004592mshb22c85be5de9b6dp12adc8jsn066352357f9e',
            'X-RapidAPI-Host' => 'face.p.rapidapi.com'
        ])
            ->attach('files', file_get_contents($imagePath), basename($imagePath))
            ->post('https://face.p.rapidapi.com/faces/detect', [
                'detector' => 'Aggressive',
                'attributes' => 'all',
                'api_key' => $this->apiKey,
                'api_secret' => $this->apiSecret
            ]);

        // Mengembalikan respons HTTP
        return $response->json();
    }
}
