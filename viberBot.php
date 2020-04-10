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

if (!empty($text)) {
    $text = $firstSmile . ' ' . $text . ' ' . $secondSmile;;
} elseif (!empty($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'cron') {
    $startText = $_SERVER['argv'][2] ?? 'Ты мне очень';
    $text = $firstSmile . ' ' . $startText . ', ' . $name . '! ' . $secondSmile;
} else {
    $text = 'Пиши, что хочешь, ' . $name .'! ' . $firstSmile . PHP_EOL . $secondSmile . ' Ты мне очень! ';
}

$sender = $sender ?? getRandom('sender.txt');
if (empty($avatar)) {
    $avatarList = glob(__DIR__ . '/avatar/*.*');
    $avatarKey = array_rand($avatarList);
    $avatarPath = $avatarList[$avatarKey];
    $avatar = 'https://miradmin.ru/viber/avatar/' . basename($avatarPath);
}

$method = 'POST';
$logErrorFile = 'log/viber_error.txt';
$logSuccessFile = 'log/viber_result.txt';
$customHeaders = ["X-Viber-Auth-Token: " . $token];

foreach ($idList as $id) {
    $postMessage = json_encode([
        'receiver' => $id,
        'sender' => [
            'name' => $sender,
            'avatar' => $avatar
        ],
        'type' => 'text',
        'text' => $text
    ]);

    include('httpClient.php');
}
