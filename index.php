<?php

require_once './Telegram.php';
require_once './Model/User.php';
require_once './page/Page.php';
// Replace 'YOUR_API_TOKEN' with the actual API token provided by BotFather
$apiToken = '6959983012:AAFXxr0y2HB2AcutbHFgVy7aSacZq73P4Nw';

$telegram = new Telegram('6959983012:AAFXxr0y2HB2AcutbHFgVy7aSacZq73P4Nw');

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


