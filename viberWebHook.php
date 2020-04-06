<?php

$token = '4b513f06fe67dda6-b7f823bf388a7c91-75736c5f5c380c01';

$url = 'https://chatapi.viber.com/pa/set_webhook';

$message = [
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
];

$curl = curl_init();
curl_setopt_array(
	$curl,
	[
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => json_encode($message),

		CURLOPT_HTTPHEADER => [
			"Cache-Control: no-cache",
			"Content-Type: application/JSON",
			"X-Viber-Auth-Token: " . $token
		]
	]
);

$response = curl_exec($curl);
$error = curl_error($curl);
curl_close($curl);

if ($error) {
	file_put_contents('viber_error.txt', date('Y-m-d h:i:s') . 'error: ' . $error . PHP_EOL, FILE_APPEND);
} else {
	file_put_contents('viber_result.txt', date('Y-m-d h:i:s') . 'response: ' . $response . PHP_EOL, FILE_APPEND);
}