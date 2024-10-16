<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'xxxx' => [
        'xxxWHATs_URLxxx' => 'https://whatsapp.ihsancrm.com/api',
        'xxxWHATs_KEYxxx' => 'api_adminn@2291',
        'xxWHATS_HOOKxx' => env('xxWHATS_HOOKxx'),
        'xxBOTTRAINERxx' => env('xxBOTTRAINERxx'),
        'xxWEBxBOTxx' =>'https://bot.ihsancrm.com/ihsanai',
        'xxWEBxKEYxx' =>'za-3BlbkFJMlz7MC0VJi42dh1l19ZaTDJMlz7cWBwCZaTDFKTFJ',
        'xxSMSAIxx' => 'https://smsbot.ihsancrm.com/api/sms',
        'xxSMSAI_READxx' => 'https://smsbot.ihsancrm.com/api/read',
        'xxSMSKEYxx' => 'sk-h1l19ZDFKTUUpx5USDP3BlbkMC0VJi42dFJMlaTz7cWBwCGD',
        'xxFBxAIxx' => 'https://facebook.ihsancrm.com/api/face',
        'xxFBxKEYxx' => 'za-lz7MC0VJDJMlz7cWi42dCZaTDFKTFJh1l13BlbkFJM9ZaTBw',

    ],
];
