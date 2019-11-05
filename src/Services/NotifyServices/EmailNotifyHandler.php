<?php
namespace TM30\Notify\Services\NotifyServices;

use Illuminate\Support\Facades\Log;
use TM30\Notify\Services\GuzzleService;

class EmailNotifyHandler implements NotifyInterface {
    protected $email_send_api, $guzzleService;
    
    public function __construct(GuzzleService $guzzleService)
    {
        $this->email_send_api = config("notify.email.send");
        $this->guzzleService = $guzzleService;

        Log::debug("EMAIL NOTIFY API'S ", [
            'EMAIL_SEND_API' => $this->email_send_api
        ]);
    }
    public function sendMessage($data) {
        $req = $this->guzzleService
                ->postRequest($this->email_send_api, $data);
        if($req['status'] === 200) {
            // Message was sent
            return true;
        } else {
            // Error sending message
            return false;
        }
    }
}