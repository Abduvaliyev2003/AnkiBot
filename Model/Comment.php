<?php 

require_once './db/DB.php';

class Comment 
{
    public $pdo;
   
    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function setComment($chat_id, $text)
    {
        $store =   $this->pdo->prepare("INSERT INTO `comments` (`chat_id`, `text`) VALUES (:chat_id,:text)");
        $store->bindParam(':chat_id',$chat_id, PDO::PARAM_INT);
        $store->bindParam(':text',$text);
        $store->execute();
        return true;
    }
}

?>