<?php

$appId = 'f7732694493faafa9bb55a5a8ccaec37';
$url = 'http://api.openweathermap.org/data/2.5/forecast?id=499099&units=metric&lang=ru&appid=' . $appId;
$method = 'GET';
$logErrorFile = 'log/weather_notifier_error.txt';
$logSuccessFile = 'log/weather_notifier_result.txt';

include_once('httpClient.php');

$weather = [];
$responseArray = json_decode($response, true);
$list = $responseArray['list'];

$morningTime = date('Y-m-d') . ' 09:00:00';
$morningTempKey = array_keys(array_column($list, 'dt_txt'), $morningTime);
$morningArray = $list[$morningTempKey[0]];

$dayTime = date('Y-m-d') . ' 15:00:00';
$dayTempKey = array_keys(array_column($list, 'dt_txt'), $dayTime);
$dayArray = $list[$dayTempKey[0]];

$eveningTime = date('Y-m-d') . ' 21:00:00';
$eveningTemp = array_keys(array_column($list, 'dt_txt'), $eveningTime);
$eveningArray = $list[$eveningTemp[0]];

//$weather['morning'] = $morningArray['main']['temp'];
//$weather['day'] = $dayArray['main']['temp'];
//$weather['evening'] = $eveningArray['main']['temp'];
//file_put_contents('data/' . date("Y-m-d") . '_weather.txt', implode(PHP_EOL, $weather), FILE_APPEND);

$morningText = 'Сегодня утром будет ' . round($morningArray['main']['temp']) . '℃, ' . $morningArray['weather'][0]['description'] . ($morningArray['wind']['speed'] > 9 ? '. Ветрено.' : '.') . PHP_EOL;
$dayText = 'Днём ' . round($dayArray['main']['temp']) . '℃, ' . $dayArray['weather'][0]['description'] . ($dayArray['wind']['speed'] > 9 ? '. Ветрено.' : '.') . PHP_EOL;
$eveningText = 'А вечером ' . round($eveningArray['main']['temp']) . '℃, ' . $eveningArray['weather'][0]['description'] . ($eveningArray['wind']['speed'] > 9 ? '. Ветрено.' : '.') . PHP_EOL;

$text = $morningText . $dayText . $eveningText . 'Береги себя, пожалуйста';
$sender = 'Погодник';
$avatar = 'https://miradmin.ru/viber/picture/weather.jpg';

include_once('viberBot.php');