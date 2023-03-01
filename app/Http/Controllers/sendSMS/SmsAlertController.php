<?php

namespace App\Http\Controllers\sendSMS;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Nixon\MobileNumber\MobileNumber;



class SmsAlertController extends Controller
{
    public function sendSMS($data){



        $network = MobileNumber::getNetwork($data);

        if($network == "Safaricom"){


        $client = new Client();
       $response = $client->post(
        'https://quicksms.advantasms.com/api/services/sendsms/',
        [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'apikey' => '64f46f5e7d59ab7d8f56b2797e99dd68',
                'partnerID' => '6911',
                'mobile' => $data,
                'message' => 'You are registered for Love Festival Nairobi',
                'shortcode' => '20133',
                'pass_type' => 'plain',
            ],
        ]
    );

    

    return $response;

}
    

    }
}
