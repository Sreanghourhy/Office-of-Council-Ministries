<?php
<?php

namespace App\Services;

use Telegram\Bot\Api;

class TelegramService
{
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Api(config('services.telegram.bot_token'));
    }

    /**
     * Send OTP message via Telegram
     */
    public function sendOTP($telegramUserId, $otp, $expiresInMinutes = 15)
    {
        $message = "🔐 *លេខកូដសម្ងាត់របស់អ្នក*\n\n";
        $message .= "លេខកូដ OTP: `{$otp}`\n\n";
        $message .= "⏰ កូដនេះមានសុពលភាពរយៈពេល {$expiresInMinutes} នាទី\n";
        $message .= "⚠️ សូមកុំចែករំលែកលេខកូដនេះជាមួយនរណាម្នាក់ឡើយ!";

        try {
            $this->telegram->sendMessage([
                'chat_id' => $telegramUserId,
                'text' => $message,
                'parse_mode' => 'Markdown'
            ]);
            return true;
        } catch (\Exception $e) {
            \Log::error('Telegram OTP Send Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get bot info for testing
     */
    public function getBotInfo()
    {
        try {
            return $this->telegram->getMe();
        } catch (\Exception $e) {
            \Log::error('Telegram Bot Info Error: ' . $e->getMessage());
            return null;
        }
    }
}