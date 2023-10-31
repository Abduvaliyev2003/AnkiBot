<?php

require_once './Telegram.php';
require_once './Model/User.php';
// Replace 'YOUR_API_TOKEN' with the actual API token provided by BotFather
$apiToken = "';

$telegram = new Telegram($apiToken);

$chat_id = $telegram->ChatID();
$text = $telegram->Text();
$messageID = $telegram->MessageID();

// Respond to a specific command
if ($text === '/start') {
    $check = User::create($chat_id);
    if($check){
        $telegram->sendMessage(['chat_id' => $chat_id,  'text' => '32']);
    } else {
        $telegram->sendMessage(['chat_id' => $chat_id,  'text' => '1']);
    }

} elseif ($text === '/help') {
    $telegram->sendMessage(['chat_id' =>$chat_id,  'text' => 'Welcome to your Telegram Bot!']);
} else {
    $telegram->sendMessage(['chat_id' =>$chat_id,  'text' => 'Welcome to your Telegram Bot!']);
}


