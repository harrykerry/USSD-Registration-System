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
                'apikey' => '809d1ed2028ecb31954ec7a87f5bc864',
                'partnerID' => '1110',
                'mobile' => $data,
                'message' => 'You are registered for Love Festival Nairobi',
                'shortcode' => 'JuaMobile',
                'pass_type' => 'plain',
            ],
        ]
    );

    

    return $response;

}
    

    }
}
