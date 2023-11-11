<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WhatsappSend;
use Exception;
use Illuminate\Http\Request;

class ApiWaController extends Controller
{
    public function test()
    {
        try {
            $reqParams = [
                'token' => env('API_TOKEN_WA'),
                'url' => 'https://api.kirimwa.id/v1/devices',
                'method' => 'POST',
                'payload' => json_encode([
                    'device_id' => 'iphone-x-pro'
                ])
            ];

            $kirimwaSender = new WhatsappSend();
            $response = $kirimwaSender->apiKirimWaRequest($reqParams);
            echo $response['body'];
        } catch (Exception $e) {
            print_r($e);
        }
    }

    public function getDevice()
    {
        try {
            $reqParams = [
                'token' => env('API_TOKEN_WA'),
                'url' => 'https://api.kirimwa.id/v1/devices'
            ];

            $kirimwaSender = new WhatsappSend();
            $response = $kirimwaSender->apiKirimWaRequest($reqParams);
            echo $response['body'];
        } catch (Exception $e) {
            print_r($e);
        }
    }

    public function deleteDevice()
    {
        try {
            $reqParams = [
                'token' => env('API_TOKEN_WA'),
                'url' => sprintf('https://api.kirimwa.id/v1/devices/%s', getenv('DEVICE_ID')),
                'method' => 'DELETE'
            ];

            $kirimwaSender = new WhatsappSend();
            $response = $kirimwaSender->apiKirimWaRequest($reqParams);
            echo $response['body'];
        } catch (Exception $e) {
            print_r($e);
        }
    }

    public function getQrCode()
    {
        try {
            $query = http_build_query(['device_id' => 'iphone-x-pro']);
            $reqParams = [
                'token' => env('API_TOKEN_WA'),
                'url' => sprintf('https://api.kirimwa.id/v1/qr?%s', $query)
            ];

            $kirimwaSender = new WhatsappSend();
            $response = $kirimwaSender->apiKirimWaRequest($reqParams);
            echo $response['body'];
        } catch (Exception $e) {
            print_r($e);
        }
    }

    public function sendMessages()
    {
        try {
            $reqParams = [
                'token' => env('API_TOKEN_WA'),
                'url' => 'https://api.kirimwa.id/v1/messages',
                'method' => 'POST',
                'payload' => json_encode([
                    'message' => 'Halo ini adalah pesan dari api.kirimwa.id.',
                    'phone_number' => '6285215043495',
                    'message_type' => 'text',
                    'device_id' => 'iphone-x-pro'
                ])
            ];

            $kirimwaSender = new WhatsappSend();
            $response = $kirimwaSender->apiKirimWaRequest($reqParams);
            echo $response['body'];
        } catch (Exception $e) {
            print_r($e);
        }
    }

    public function quota()
    {
        try {
            $reqParams = [
                'token' => env('API_TOKEN_WA'),
                'url' => 'https://api.kirimwa.id/v1/quotas'
            ];

            $kirimwaSender = new WhatsappSend();
            $response = $kirimwaSender->apiKirimWaRequest($reqParams);
            echo $response['body'];
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
