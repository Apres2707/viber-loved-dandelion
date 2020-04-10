<?php

$token = '4b513f06fe67dda6-b7f823bf388a7c91-75736c5f5c380c01';

$url = 'https://chatapi.viber.com/pa/set_webhook';

$postMessage = json_encode([
   'url' => 'https://miradmin.ru/viber/webhookHandler.php',
   'event_types' => [
		'delivered',
		'seen',
		'failed',
		'subscribed',
		'unsubscribed',
		'conversation_started',
		'message'
   ],
   'send_name' => true,
   'send_photo' => true
]);

$method = 'POST';
$logErrorFile = 'log/viber_error.txt';
$logSuccessFile = 'log/viber_result.txt';
$customHeaders = ["X-Viber-Auth-Token: " . $token];

include('httpClient.php');
