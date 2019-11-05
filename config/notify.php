<?php

return [
    /**
     * SMS Notification Service
     */

     'sms' => [
        'send' => env('NOTIFY_SERVICE_SMS_SEND')
     ],

     /**
      * Email Notification Service
      */
      'email' => [
        'send' => env('NOTIFY_SERVICE_EMAIL_SEND')
      ],
      /** 
       * Whatsapp Notification Service
       */
      'whatsapp' => [
        'send' => env('NOTIFY_SERVICE_WHATSAPP_SEND')
      ],
];