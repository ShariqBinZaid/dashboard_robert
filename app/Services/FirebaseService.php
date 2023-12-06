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
            $serverKey = 'AAAAzaKIuak:APA91bG-EMUlN1qmjx8SV8kEwBRbUvtkRau0tFRB06K442Ofs3IjG5AJJHpjpYhlrV6kEWfboE1NjjmxQrYOhNnYM18oeltlRa1UIngiUmO5sJ6njTwLM-vyFoz2dnbUo0BqeqN5JgJ3'; // Replace with your Firebase Server Key
            $fcmToken = Auth::user()->fcm_id; // Replace with the recipient's FCM token

            $client = new Client();

            $response = $client->post('https://fcm.googleapis.com/fcm/send', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $serverKey,
                    'Content-MD5' => 'application/json',
                ],
                'json' => [
                    'to' => $fcmToken,
                    'notification' => [
                        'title' => '"'.$title.'"',
                        'body' => '"'.$message.'"',
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
