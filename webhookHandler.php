<?php
$post = json_decode(file_get_contents('php://input'), true);
file_put_contents('log/viber_event_list.txt', date('Y-m-d h:i:s') . ' ' . json_encode($post) . PHP_EOL, FILE_APPEND);
header("HTTP/1.0 200 OK");

if ($post['event'] == 'message' && $post['sender']['id'] == 'k0wAdhpuIJLFCq57/mHwRA==') {
    include_once('./viberBot.php');
    file_put_contents('log/incoming_message_list.txt', date('Y-m-d h:i:s') . ' ' . $post['message']['text'] . PHP_EOL, FILE_APPEND);
}