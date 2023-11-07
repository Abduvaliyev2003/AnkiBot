<?php 

require_once './Model/User.php';
require_once './Model/Text.php';
require_once './page/Page.php';
require_once './Model/Card.php';
require_once './Model/Word.php';

class Func {
    protected $telegram;
    protected $chat_id;
    protected $user;
    protected $lang;
    public $page;
    public $card;
    public $word;
    public function __construct($telegram , $chat_id)
    {
        $this->telegram = $telegram;
        $this->chat_id = $chat_id;
        $this->user = new User($chat_id);
        $this->card = new Card($chat_id);
        $this->lang = new Text($this->user->getLang());
        $this->word = new Word($chat_id);
        $this->page = new Page();
    }

    public function showStart()
    {
      
        $this->user->create();
        $buttons = ["🇷🇺 Русский", "🇺🇿 O'zbekcha"];
        $textToSend = "Пожалуйста выберите язык. 👇\n\nIltimos, tilni tanlang. 👇";
        $this->sendTextWithKeyboard($buttons, $textToSend);
    }
    

    public function showMenu()
    {
        $this->user->setPage($this->page::PAGE_MAIN);
        $buttons = [
            "🗂 Kartalar", 
            "🗳 Yaratish karta",
            "🗃 So`zlar",
            '📊 Statistika',
            '⚙️ Sozlamalar',
            "📝 Izoh"
        ];
        $textToSend = "
         🧠 Anki boti so'zlarni oraliq takrorlash bilan yodlashni osonlashtiradi. " . PHP_EOL;
        $textToSend .= 
        "🔮 Bot: 
        • so'zlarni iboralarni va ularning tarjimasini saqlash; 
        • so`zlarning tarjimasini ko`rsatish; 
        • so`z necha kundan keyin keyingi safar ko`rsatilishini belgilash "; 
        $this->sendTextWithKeyboard($buttons, $textToSend);

    }
    
    public function comment(){
        $this->user->setPage($this->page::PAGE_COMMENT);
        $this->sendTextWithKeyboard(['🔙 Orqaga'] ,'Botmiz haqida izoh qoldiring');
    }

    public function setting()
    {
        $this->user->setPage($this->page::PAGE_SETTING);
        $buttons = ['Til', '🔙 Orqaga'];
        $textToSend = "Shu tugmalarni bosing";
        $this->sendTextWithKeyboard($buttons, $textToSend);
    }

    public function lang()
    {
        $this->user->setPage($this->page::PAGE_LANG);
        $buttons = ["🇷🇺 Русский", "🇺🇿 O'zbekcha", '🔙 Orqaga'];
        $textToSend = "Tilni tanlang";
        $this->sendTextWithKeyboard($buttons, $textToSend);
    }
    
    public function addCard()
    {
        $this->user->setPage($this->page::PAGE_ADD_CARD);
        $buttons = ['🔙 Orqaga'];
        $textToSend = "Cardni nomini yozing";
        $this->sendTextWithKeyboard($buttons, $textToSend);
    }

    public function addCardName($text)
    {
        $buttons = ['🔙 Orqaga', 'Cardni toldrish'];
        $card_id = $this->card->storeCard($text);
       
        $this->user->updateBox($card_id);
        $textToSend = "Card yaratildi";
        $this->sendTextWithKeyboard($buttons, $textToSend);
    }


    public function addWordPage()
    {  
        $this->user->setPage($this->page::PAGE_ADD_WORD);
        $buttons = ['🔙 Orqaga'];
        $textToSend = "✍️ Yangi so`z qo`shish uchun quyidagilarni yozing:
        [so'z] = [tarjima]";
        $this->sendTextWithKeyboard($buttons, $textToSend);
    }

    public function storeWord($text)
    {
        $data=   $this->user->getKeyValue('cart_id');
       
        $word = $this->word->addWord($text, $data );
        $this->sendMessage('✍️ Yozib olindi');
    }


    protected function sendMessage ($text){
        $this->telegram->sendMessage([
            'chat_id'=> $this->chat_id,
            'text' => $text
        ]);
    }

    protected function sendTextWithKeyboard($buttons, $text, $backBtn = false)
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
            $option[] = [$this->telegram->buildKeyboardButton($this->lang->getText("back_btn"))];
        }
        $keyboard = $this->telegram->buildKeyBoard($option, $onetime = false, $resize = true);
        $content = array('chat_id' => $this->chat_id, 'reply_markup' => $keyboard, 'text' => $text, 'parse_mode' => "HTML");
        $this->telegram->sendMessage($content);
    }

}




?>