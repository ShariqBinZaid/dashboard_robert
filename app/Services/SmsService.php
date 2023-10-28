<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class SmsService
{

    private $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
    }

    public function sendSMS($number, $message)
    {
        try {
            $message = $this->twilio->messages->create("$number", ["messagingServiceSid" => env('TWILIO_MESSAGE_SERVICE_ID'), "body" => "$message"]);
            Log::debug($message);
            return true;
        } catch (\Exception $e) {
            Log::error('Error on SendSMS: '.$e);
        }
    }
}
