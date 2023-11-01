<?php

require_once './Telegram.php';
require_once './Model/User.php';
require_once './page/Page.php';
require_once './Function/Func.php';
require_once './Model/Text.php';
// Replace 'YOUR_API_TOKEN' with the actual API token provided by BotFather
$apiToken = "6959983012:AAFXxr0y2HB2AcutbHFgVy7aSacZq73P4Nw";

$telegram = new Telegram($apiToken);

$chat_id = $telegram->ChatID();
$text = $telegram->Text();
$messageID = $telegram->MessageID();
$user = new User($chat_id);
$func = new Func($telegram, $chat_id);
$texts = new Text($user->getLang());

// Respond to a specific command
if ($text === '/start') {
  $func->showStart();
} else {
    switch ($user->getPage()){
        case Page::START:
            switch ($text) {
                case "🇺🇿 O'zbekcha":
                    $user->setLang('uz');
                    $texts = new Text($user->getLang());
                    $func->showMenu();
                    break;
                case "🇷🇺 Русский":
                    $user->setLang('ru');
                    $texts = new Text($user->getLang());
                   
                    $func->showMenu();
                    break;
                default:
                   
                    $func->showStart();
                    break;
            }
            break;
    }
}


