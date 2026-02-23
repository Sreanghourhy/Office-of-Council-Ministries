<?php

namespace App\Services;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

class GmailService
{
    public function sendOTP(string $to, string $otp)
    {
        $client = new Client();
        $client->setAuthConfig(
            storage_path('app/google/gmail_credentials.json')
        );
        $client->addScope(Gmail::GMAIL_SEND);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        $tokenPath = storage_path('app/google/token.json');

        if (file_exists($tokenPath)) {
            $client->setAccessToken(
                json_decode(file_get_contents($tokenPath), true)
            );
        }

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken(
                $client->getRefreshToken()
            );
            file_put_contents(
                $tokenPath,
                json_encode($client->getAccessToken())
            );
        }

        $service = new Gmail($client);

        $rawMessage =
            "To: <$to>\r\n" .
            "Subject: Your OTP Code\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/plain; charset=utf-8\r\n\r\n" .
            "Your OTP code is: $otp";

        $message = new Message();
        $message->setRaw(
            rtrim(strtr(base64_encode($rawMessage), '+/', '-_'), '=')
        );

        return $service->users_messages->send('me', $message);
    }
}