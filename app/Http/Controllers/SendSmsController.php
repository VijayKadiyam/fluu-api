<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendSmsController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' =>  'required',
            'otp'   =>  'required'
        ]);
        // Account details
        $apiKey = urlencode('/8CfjuxZgUU-YrVqYZ3zUE4GlAqVZLJzzohtwmWQDq');

        // Message details
        $numbers = urlencode('91' . $request->phone);
        $sender = urlencode('FLUU');
        $message = rawurlencode('FLUU: Please use this OTP: ' . $request->otp);
        // $message = rawurlencode('test');

        // Prepare data for POST request
        $data = 'apikey=' . $apiKey . '&numbers=' . $numbers . "&sender=" . $sender . "&message=" . $message;

        // Send the GET request with cURL
        $endpoint = "http://mobicomm.dove-sms.com//submitsms.jsp?user=PousseM&key=fc53bf6154XX&mobile=+91" . $request->phone . "&message=" . $message . "&senderid=POUSSE&accusage=1";
        $client = new \GuzzleHttp\Client();
        $client->request('GET', $endpoint);

        // Process your response here
        echo $response;
    }
}
