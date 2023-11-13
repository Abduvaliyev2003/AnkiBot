<?php

require_once './Telegram.php';
require_once './Model/User.php';
require_once './page/Page.php';
require_once './Function/Func.php';
require_once './Model/Text.php';
require_once './Model/Comment.php';
// Replace 'YOUR_API_TOKEN' with the actual API token provided by BotFather
$apiToken = "6959983012:AAFXxr0y2HB2AcutbHFgVy7aSacZq73P4Nw";

$telegram = new Telegram($apiToken);

$chat_id = $telegram->ChatID();
$text = $telegram->Text();
$messageID = $telegram->MessageID();
$user = new User($chat_id);
$func = new Func($telegram, $chat_id);
$texts = new Text($user->getLang());
$comment = new Comment();

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
                    // Handle other cases or show an error message
                    break;
            }
            break;
        case Page::PAGE_MAIN:
            switch ($text) {
                case '🗂 Kartalar':
                    $func->allCard();
                    break;
                case '🗳 Yaratish karta':
                    // Handle '🗳 Yaratish karta'
                    $func->addCard();
                    break;
                case '🗃 So`zlar':
                    $func->words();
                    break;
                case '📊 Statistika':
                    // Handle '📊 Statistika'
                    break;
                case '⚙️ Sozlamalar':
                    $func->setting();
                    break;
                case '📝 Izoh':
                    $func->comment();
                    break;
                default:
                    $func->showStart();
                    break;
            }
            break;
        case Page::PAGE_COMMENT:
            if ($text == '🔙 Orqaga') {
                $func->showMenu();
            } elseif ($text !== '📝 Izoh') {
                $comment->setComment($chat_id, $text);
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => "Izoh uchun rahmat"
                ]);
                $func->showMenu();
            }
            break;
        case Page::PAGE_SETTING:
            switch($text){
                case 'Til':
                    $func->lang();
                    break;
                case  '🔙 Orqaga' : 
                    $func->showMenu();
                    break;
                default:
                    // Handle other cases or show an error message
                    break;   
            }
            break;
        case Page::PAGE_LANG:
            switch($text){
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
                case  '🔙 Orqaga' : 
                    $func->showMenu();
                    break;    
                default:
                    // Handle other cases or show an error message
                    break;   
            }
            break; 
        case Page::PAGE_ADD_CARD: 
            switch($text){
                case '🔙 Orqaga':
                    $func->showMenu();
                    break;
                case 'Cardni toldrish':
                    $func->addWordPage();
                    break;   
                case $text: 
                    $func->addCardName($text);
                    break;    
            }  
            break;  
        case Page::PAGE_ADD_WORD: 
            switch($text){
                case '🔙 Orqaga':
                    $func->showMenu();
                    break;
                case $text:
                    if (strpos($text, '=')) {
                        $func->storeWord($text);
                    } else {
                        $telegram->sendMessage([
                            'chat_id' => $chat_id,
                            'text' => "[so'z] = [tarjima] shu mormatda yozing"
                        ]);
                    }
                    break;   
                  
            }  
            break;    
        case Page::PAGE_ALL_CARDS: 
                switch($text){
                    case '🔙 Orqaga':
                        $func->showMenu();
                        break;
                    case '🗳 Yaratish karta':
                        // Handle '🗳 Yaratish karta'
                        $func->addCard();
                        break;
                    case $text:
                        $func->cardWords($text);  
                        break;      
                }  
                break;  
        case Page::PAGE_WORDS:
            switch($text){
                case '🔙 Orqaga':
                    $func->allCard();
                    break; 
                case 'Cardni toldrish':
                    $func->addWordPage();
                    break;    
            } 
            break;                
        default:
            // Handle the default case
            break;
    }
    
}


