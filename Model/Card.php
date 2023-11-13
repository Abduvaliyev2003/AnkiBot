<?php

require_once './db/DB.php';


class Card 
{
    public $pdos;
    public $chatID;

    public function __construct($chatID)
    {
        global $pdo;
        $this->chatID = $chatID;
        $this->pdos = $pdo;
    }

    public function storeCard($text)
    {
        $data = ['chat_id' => $this->chatID, 'name' => $text];
        $return = $this->setValue("INSERT INTO `cart` (`chat_id`, `name`) VALUES (:chat_id ,:name)", $data);
        return  $return;
    }

    public function getCard(){
        return $this->getData();
    }

    public function getOne($key, $text)
    {
        $data =  $this->getData();

        $dataFill = array_filter($data, function ($value) use ($text, $key) {
            return  $value['name'] == $text;
        });

        $filteredData = [];
        foreach ($dataFill as $item) {
            $filteredData[] = $item;
        }

        return $filteredData;
    }
     
    public function setValue($sql, $data)
    {
        $result =  $this->pdos->prepare($sql);
        $result->execute($data);
        $data = $result->fetchAll();
        return $this->pdos->lastInsertId();
    }

    private function getData()
    {
        $chatID = $this->chatID;
        $result = $this->pdos->prepare("SELECT * FROM `cart` WHERE chat_id=:chat_id");
        $result->execute([':chat_id' => $chatID]);
        $arr = $result->fetchAll();

        return $arr;
    }
    
}



?>