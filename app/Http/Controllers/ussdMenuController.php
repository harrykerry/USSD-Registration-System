<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\eventRegistration;
use App\Http\Controllers\sendSMS\SmsAlertController;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ussdMenuController extends Controller
{
    //

    public function index(Request $request)
    {

        $sessionID = $request->input('SESSIONID');
        $ussdCode = $request->input('USSDCODE');
        $msisdn = $request->input('MSISDN');
        $input = $request->input('INPUT');


        $inputArray = explode("*", $input);
        $lastInput = end($inputArray);
        $currentTime = Carbon::now();
       

        if ($lastInput == "80") {

            $response = "CON Welcome to Love Nairobi Festival Launch. Please select an option\n1.Register";
            return response($response)->header('Content-Type', 'text/plain');
        } elseif ($lastInput == "1") {


            $mobile = DB::table('event_registrations')->where('mobile', $msisdn)->where('status','1')->first();

            if ($mobile) {
                $response = "END You are already registered";
                return response($response)->header('Content-Type', 'text/plain');
            } else {
                DB::table('event_registrations')->insertOrIgnore(['mobile' => $msisdn]);

                $response = "CON Enter Full Name";
                return response($response)->header('Content-Type', 'text/plain');
            }
        } elseif ($lastInput != '') {

            $registration = DB::table('event_registrations')->where('mobile', $msisdn)->where('status','0')->first();

            if (!$registration->name || !$registration->Church_Name) {

                DB::table('event_registrations')->where('mobile', $msisdn)->where('status','0')->update(['name' => $lastInput]);

                $response = "CON Enter Name Of Church/Organization represented";

                return  response($response)->header('Content-Type', 'text/plain');
            } else if (!$registration->Church_Name || !$registration->Sub_County  ) {
                DB::table('event_registrations')->where('mobile', $msisdn)->where('status','0')->update(['Church_Name' => $lastInput]);

                $response = "CON Enter Sub-County Name";

                return response($response)->header('Content-Type', 'text/plain');
            } else {

                DB::table('event_registrations')->where('mobile', $msisdn)->where('status','0')->update(['Sub_County' => $lastInput,'status' => '1']);
                $sendSMS = new SmsAlertController();
                $resp = $sendSMS->sendSMS($msisdn);

                $response = " END Registration Successful";
                return response($response)->header('Content-Type', 'text/plain');
            }
        }
    }
}
