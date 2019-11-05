<?php
namespace TM30\Notify\Services\NotifyServices;

use Illuminate\Support\Facades\Log;
use TM30\Notify\Services\GuzzleService;

class WhatsappNotifyHandler implements NotifyInterface {
    protected $whatsapp_send_api, $guzzleService;
    
    public function __construct(GuzzleService $guzzleService)
    {
        $this->whatsapp_send_api = config("notify.whatsapp.send");
        $this->guzzleService = $guzzleService;

        Log::debug("WHATSPP NOTIFY API'S ", [
            'WHATSAPP_SEND_API' => $this->whatsapp_send_api
        ]);
    }
    public function sendMessage($data) {
        $req = $this->guzzleService
                ->postRequest($this->whatsapp_send_api, $data);
        if($req['status'] === 200) {
            // Message was sent
            return true;
        } else {
            // Error sending message
            return false;
        }
    }
}
