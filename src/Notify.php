<?php
namespace TM30\Notify;

use Response;
use Illuminate\Support\Facades\Log;
use TM30\Notify\Services\NotifyServices\EmailNotifyHandler;
use TM30\Notify\Services\NotifyServices\SmsNotifyHandler;
use TM30\Notify\Services\NotifyServices\WhatsappNotifyHandler;

class Notify  {

    public static function make() {
        return new static;
    }

    function send() {

    }
    
    function sendSMS(array $recipients, string $sender, string $content, string $network)
    {
        //Validate Request Data
        $request = [
            "to" => $recipients,
            "sender_id" => $sender,
            "content" => $content,
            "network" => $network
        ];

        $message = app(SmsNotifyHandler::class);
        $response = $message->sendMessage($request);
        if($response) {
            return Response::json([
                'status' => 'success',
                'message' => 'Message was sent'
            ], 200);
        } else  {
            return Response::json([
                'status' => 'error',
                'message' => 'There was an error sending this message'
            ], 400);
        }
    }

    public function sendEmail(array $recipients, string $sender, string $content, string $subject) {
        $request = [
            "to" => $recipients,
            "sender_id" => $sender,
            "content" => $content,
            "subject" => $subject
        ];

        $message = app(EmailNotifyHandler::class);
        $response = $message->sendMessage($request);
        if($response) {
            return Response::json([
                'status' => 'success',
                'message' => 'Message was sent'
            ], 200);
        } else  {
            return Response::json([
                'status' => 'error',
                'message' => 'There was an error sending this message'
            ], 400);
        }
    }

    public function sendWhatsappMessage(array $recipients, string $sender, string $message) {
        $request = [
            "to" => $recipients,
            "sender" => $sender,
            "message" => $message
        ];
        
        $message = app(WhatsappNotifyHandler::class);
        $response = $message->sendMessage($request);
        if($response) {
            return Response::json([
                'status' => 'success',
                'message' => 'Message was sent'
            ], 200);
        } else  {
            return Response::json([
                'status' => 'error',
                'message' => 'There was an error sending this message'
            ], 400);
        }
    }
}
