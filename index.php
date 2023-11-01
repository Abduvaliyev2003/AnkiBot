<?php

require_once './Telegram.php';
require_once './Model/User.php';
require_once './page/Page.php';
// Replace 'YOUR_API_TOKEN' with the actual API token provided by BotFather
$apiToken = "";

$telegram = new Telegram($apiToken);

$chat_id = $telegram->ChatID();
$text = $telegram->Text();
$messageID = $telegram->MessageID();
$user = new User($chat_id);

// Respond to a specific command
if ($text === '/start') {
  
} else {
    switch ($user->getPage()){
        case Page::START:

    }
}


