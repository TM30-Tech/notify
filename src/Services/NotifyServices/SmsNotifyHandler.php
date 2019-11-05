<?php
namespace TM30\Notify\Services\NotifyServices;

use Illuminate\Support\Facades\Log;
use TM30\Notify\Services\GuzzleService;

class SmsNotifyHandler implements NotifyInterface {
    protected $sms_send_api, $guzzleService;
    
    public function __construct(GuzzleService $guzzleService)
    {
        $this->sms_send_api = config("notify.sms.send");
        $this->guzzleService = $guzzleService;

        Log::debug("SMS NOTIFY API'S ", [
            'SMS_SEND_API' => $this->sms_send_api
        ]);
    }
    public function sendMessage($data) {
        $req = $this->guzzleService
                ->postRequest($this->sms_send_api, $data);
        if($req['status'] === 200) {
            // Message was sent
            return true;
        } else {
            // Error sending message
            return false;
        }
    }
}
