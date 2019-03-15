<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public static function sendTo($address, $subject, $content)
    {
        try {
            Mail::raw('【HashGate】' . $content, function ($message) use ($address, $subject) {
                $message->to($address)
                    ->subject($subject);
            });
        } catch (\Exception $e) {
            Log::error("Error send email to {$address}");
        }

    }

    public static function sendToAdmin($subject, $content)
    {
        self::sendTo(env('MAIL_ADMIN'), $subject, $content);
    }

    public function sendTemplateMail($template, $address, $subject, $notifyData = [])
    {
        try{
            $data = [
                'address' => $address,
                'subject' => $subject
            ];

            Mail::send($template, $notifyData, function ($message) use ($data){

                $message ->to($data['address'])->subject($data['subject']);
            });

            return true;

        }catch (\Exception $e){

            Log::error("Error send email to { $address }");
        }
    }

}