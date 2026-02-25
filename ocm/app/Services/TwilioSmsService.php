<?php

namespace App\Services;

use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;
use Exception;
use Illuminate\Support\Facades\Log;

class TwilioSmsService
{
    protected Client $client;
    protected string $from;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        $this->from = config('services.twilio.from');
    }

    public function send(string $to, string $message): bool
    {
        try {
            $this->client->messages->create($to, [
                'from' => $this->from,
                'body' => $message,
            ]);

            return true;
        } catch (TwilioException $e) {
            // Log the error
            \Log::error('Twilio SMS Error: ' . $e->getMessage());
            throw new Exception('Failed to send SMS: ' . $e->getMessage());
        }
    }
}