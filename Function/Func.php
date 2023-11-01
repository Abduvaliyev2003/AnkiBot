<?php 

require_once './Model/User.php';
require_once './Model/Text.php';
require_once './page/Page.php';

class Func {
    private $telegram;
    private $chat_id;
    private $user;
    private $lang;
    public function __construct($telegram , $chat_id)
    {
        $this->telegram = $telegram;
        $this->chat_id = $chat_id;
        $this->user = new User($chat_id);
        $this->lang = new Text($this->user->getLang());
    }

    function showStart()
    {
        global $user;
        $this->user->setPage(Page::START);
        $buttons = ["🇷🇺 Русский", "🇺🇿 O'zbekcha"];
        $textToSend = "Пожалуйста выберите язык. 👇\n\nIltimos, tilni tanlang. 👇";
        $this->sendTextWithKeyboard($buttons, $textToSend);
    }



    protected function sendMessage ($text){
        $this->telegram->sendMessage([
            'chat_id'=> $this->chat_id,
            'text' => $text
        ]);
    }

    function sendTextWithKeyboard($buttons, $text, $backBtn = false)
    {
    
        $option = [];
        if (count($buttons) % 2 == 0) {
            for ($i = 0; $i < count($buttons); $i += 2) {
                $option[] = array($this->telegram->buildKeyboardButton($buttons[$i]), $this->telegram->buildKeyboardButton($buttons[$i + 1]));
            }
        } else {
            for ($i = 0; $i < count($buttons) - 1; $i += 2) {
                $option[] = array($this->telegram->buildKeyboardButton($buttons[$i]), $this->telegram->buildKeyboardButton($buttons[$i + 1]));
            }
            $option[] = array($this->telegram->buildKeyboardButton(end($buttons)));
        }
        if ($backBtn) {
            $option[] = [$this->telegram->buildKeyboardButton($text->getText("back_btn"))];
        }
        $keyboard = $this->telegram->buildKeyBoard($option, $onetime = false, $resize = true);
        $content = array('chat_id' => $this->chat_id, 'reply_markup' => $keyboard, 'text' => $text, 'parse_mode' => "HTML");
        $this->telegram->sendMessage($content);
    }

}




?>