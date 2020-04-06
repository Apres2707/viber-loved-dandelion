<?php

$token = '4b513f06fe67dda6-b7f823bf388a7c91-75736c5f5c380c01';

$url = 'https://chatapi.viber.com/pa/send_message';

$idList = [
    'Kate' => 'k0wAdhpuIJLFCq57/mHwRA==',
    'i' => 'ViaO+LAk/SG4QqpBL1calQ=='
];

function getRandom($filePath)
{
    $itemList = file($filePath, FILE_USE_INCLUDE_PATH | FILE_IGNORE_NEW_LINES);
    $itemKey = array_rand($itemList);
    return $itemList[$itemKey];
}

$firstSmile = getRandom('smile.txt');
$secondSmile = getRandom('smile.txt');
$name = getRandom('name.txt');

$avatarList = glob(__DIR__ . '/avatar/*.*');
$avatarKey = array_rand($avatarList);
$avatar = $avatarList[$avatarKey];

if (!empty($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'cron') {
    $startText = $_SERVER['argv'][2] ?? 'Ты мне очень';
    $text = $firstSmile . ' ' . $startText . ', ' . $name . '! ' . $secondSmile;
} else {
    $text = 'Пиши, что хочешь, ' . $name .'! ' . $firstSmile . PHP_EOL . $secondSmile . ' Ты мне очень! ';
}

$sender = getRandom('sender.txt');

foreach ($idList as $id) {
    $message = [
        'receiver' => $id,
        'sender' => [
            'name' => $sender,
            'avatar' => 'https://miradmin.ru/viber/avatar/' . basename($avatar)
        ],
        'type' => 'text',
        'text' => $text
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
    	file_put_contents('viber_error.txt', date('Y-m-d h:i:s') . ' error: ' . $error . PHP_EOL, FILE_APPEND);
    } else {
    	file_put_contents('viber_result.txt', date('Y-m-d h:i:s') . ' response: ' . $response . PHP_EOL, FILE_APPEND);
    }
}