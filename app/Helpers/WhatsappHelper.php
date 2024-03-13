<?php

namespace App\Helpers;

use Exception;
use Twilio\Rest\Client;

class WhatsappHelper
{
    public static function sendWhatsapp($receiverNumber, $message, $contentSid)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $messageSid = env('TWILIO_MESSAGING_SERVICE_SID');

        try {
            $client = new Client($sid, $token);
            $client->messages->create("whatsapp:$receiverNumber", // to
            [
                "contentSid" => $contentSid,
                "from" => $messageSid,
                "contentVariables" => json_encode($message)
            ]);

            return 'SMS Sent Successfully.';
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
