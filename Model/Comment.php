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

    public function setComment($chat_id)
    {
        $store =   $this->pdo->prepare("INSERT INTO `comments` (`chat_id`) VALUES (:chat_id)");
        $store->bindParam(':chat_id',$chat_id, PDO::PARAM_INT);
        $store->execute();
        return true;
    }
}

?>