<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    public function sendNotification($title, $message)
    {
        try {
            $serverKey = 'AAAAhbOe1cQ:APA91bFAQy6_kgW3zit26uNjPboL_g19tELuic8BhrDa5Ex89IDRo-FR58krLUc7wT4gDixn4JT4Qt5kc8ZkygzYupzNfmjSqi9TEnhDIPujxUD4I6bTnAp_8ymSgGPFf508uw1OGhsa'; // Replace with your Firebase Server Key
            $fcmToken = Auth::user()->fcm_id; // Replace with the recipient's FCM token

            $client = new Client();

            $response = $client->post('https://fcm.googleapis.com/fcm/send', [
                'headers' => [
                    'Authorization' => 'key=' . $serverKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'to' => $fcmToken,
                    'notification' => [
                        'title' => 'Hello from Guzzle',
                        'body' => 'This is a test notification sent via Guzzle HTTP.',
                    ],
                ],
            ]);

            // Check the response for errors or success
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                Log::debug('Success code: ' . $statusCode);
                return true;
            } else {
                Log::error('Status code error: ' . $statusCode);
                return throw new \Exception('Notification failed to send');
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
