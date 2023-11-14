<?php 

require_once './db/DB.php';


class Word {

    public $pdos;
    public $chatID;

    public function __construct($chatID)
    {
        global $pdo;
        $this->chatID = $chatID;
        $this->pdos = $pdo;
    }

    public function all() {
        $chatID = $this->chatID;
        $data = $this->groupBy(
           "SELECT  CONCAT(word1, ' - ', word2) AS word FROM `words` WHERE chat_id='$chatID'"
        );

        return $data;
    }
    
    public function addWord($text, $card_id)
    {
        list($word1, $word2) = explode(" = ", $text);
       return $this->setValue(
        "INSERT INTO `words` (`chat_id`, `cart_id`, `word1`, `word2` ) VALUES (:chat_id ,:cart_id, :word1, :word2)",
        [
            'chat_id' => $this->chatID,
            'cart_id' => $card_id,
            'word1' => $word1,
            'word2' => $word2
        ]
        );
    }
    public function getCount()
    {
        $chatID = $this->chatID;
        $data = $this->groupBy(
           "SELECT COUNT(*) FROM `words` WHERE chat_id='$chatID'"
        );

        return $data;
    }
    public function getOne( int $card_id){
        $chatID = $this->chatID;
        $data = $this->groupBy(
           "SELECT  CONCAT(word1, ' - ', word2) AS word FROM `words` WHERE chat_id='$chatID' AND cart_id='$card_id'"
        );

        return $data;
    }
    
    public function groupBy($sql){
       
        $result = $this->pdos->prepare($sql);
        $result->execute();
        $arr = $result->fetchAll();
        return $arr;
    }


    public function setValue($sql, $data)
    {
        $result =  $this->pdos->prepare($sql);
        $result->execute($data);
        $data =$result->fetchAll();
        return $this->pdos->lastInsertId();
    }

    private function getData()
    {
        $chatID = $this->chatID;
        $result = $this->pdos->prepare("SELECT * FROM `words` WHERE chat_id='$chatID'");
        $result->execute();
        $arr = $result->fetch();

        return $arr;
    }
}



?>