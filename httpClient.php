<?php
$curl = curl_init();

$headers = [
    "Cache-Control: no-cache",
    "Content-Type: application/JSON"
];

if (!empty($customHeaders)) {
    $headers = array_merge($customHeaders, $headers);
}

curl_setopt_array(
    $curl,
    [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers
    ]
);

if (!empty($postMessage)) {
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postMessage);
}

$response = curl_exec($curl);
$error = curl_error($curl);
curl_close($curl);

if ($error) {
    file_put_contents($logErrorFile, date('Y-m-d h:i:s') . ' error: ' . $error . PHP_EOL, FILE_APPEND);
} else {
    file_put_contents($logSuccessFile, date('Y-m-d h:i:s') . ' response: ' . $response . PHP_EOL, FILE_APPEND);
}