<?php

namespace App\Helpers;

use Exception;
use Twilio\Rest\Client;

class SMSHelper
{
    public static function sendSMS($receiverNumber, $message)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $messagingServiceSid = env('TWILIO_MESSAGING_SERVICE_SID');

        try {
            $client = new Client($sid, $token);
            $client->messages->create($receiverNumber, [
                'messagingServiceSid' => $messagingServiceSid,
                'body' => $message
            ]);

            return 'SMS Sent Successfully.';
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
