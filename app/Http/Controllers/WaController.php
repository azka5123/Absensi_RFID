<?php

namespace App\Http\Controllers;

use App\Services\WhatsappSend;
use Exception;
use Illuminate\Http\Request;

class WaController extends Controller
{
    public function getDevice()
    {
        try {
            $reqParams = [
                'token' => 'Fk4eLVYsuwHv5pgef01JRB3LTYVlnvVK52M3ao+0hTfr8v31y5sCHmAFgbJqVBM6-azka',
                'url' => 'https://api.kirimwa.id/v1/devices'
            ];

            $kirimwaSender = new WhatsappSend();
            $response = $kirimwaSender->apiKirimWaRequest($reqParams);
            return view('whatsapp.wa', compact('response'));
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function postDevice()
    {
        try {
            $reqParams = [
                'token' => 'Fk4eLVYsuwHv5pgef01JRB3LTYVlnvVK52M3ao+0hTfr8v31y5sCHmAFgbJqVBM6-azka',
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

    public function deleteDevice()
    {
        try {
            $reqParams = [
                'token' => 'Fk4eLVYsuwHv5pgef01JRB3LTYVlnvVK52M3ao+0hTfr8v31y5sCHmAFgbJqVBM6-azka',
                'url' => sprintf('https://api.kirimwa.id/v1/devices/%s', getenv('DEVICE_ID')),
                'method' => 'DELETE'
            ];

            $kirimwaSender = new WhatsappSend();
            $response = $kirimwaSender->apiKirimWaRequest($reqParams);
            return back();
        } catch (Exception $e) {
            print_r($e);
        }
    }

    public function getQrCode()
    {
        try {
            $query = http_build_query(['device_id' => 'iphone-x-pro']);
            $reqParams = [
                'token' => 'Fk4eLVYsuwHv5pgef01JRB3LTYVlnvVK52M3ao+0hTfr8v31y5sCHmAFgbJqVBM6-azka',
                'url' => sprintf('https://api.kirimwa.id/v1/qr?%s', $query)
            ];

            $kirimwaSender = new WhatsappSend();
            $response = $kirimwaSender->apiKirimWaRequest($reqParams);
            return view('whatsapp.qr_code', compact('response'));
        } catch (Exception $e) {
            print_r($e);
        }
    }

    public function reconnectDevice()
    {
        try {
            $reqParams = [
                'token' => 'Fk4eLVYsuwHv5pgef01JRB3LTYVlnvVK52M3ao+0hTfr8v31y5sCHmAFgbJqVBM6-azka',
                'url' => 'https://api.kirimwa.id/v1/reconnect',
                'method' => 'POST',
                'payload' => json_encode([
                    'device_id' => 'iphone-x-pro'
                ])
            ];

            $kirimwaSender = new WhatsappSend();
            $test = $kirimwaSender->apiKirimWaRequest($reqParams);
            return back();
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
