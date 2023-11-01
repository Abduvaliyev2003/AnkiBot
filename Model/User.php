<?php

require_once './db/DB.php';

class User {
    
    public $pdos;
    public $chatID;

    public function __construct($chatID)
    {
        global $pdo;
        $this->chatID = $chatID;
        $this->pdos = $pdo;
    }


    public  function create() 
    {
        $data = $this->getData();
        if (empty($data)) {
            $page = 'start';
            $store =   $this->pdos->prepare("INSERT INTO `users` (`chat_id`, `page`) VALUES (:chat_id, :page)");
            $store->bindParam(':chat_id',$this->chatID, PDO::PARAM_INT);
            $store->bindParam(':page',$page);
            $store->execute();
            return true;
        }
        return false;
    }

    function setPage($page)
    {
        return $this->setValue("page= $page");
    }

    public function getPage()
    {
        $data = $this->getData();
        return $data['page'];
    }
    
    public function setLang($lang){
        return $this->setValue("lang= $lang");
    }

    public function getLang(){
        $data = $this->getData();
        return $data['lang'];
    }

    
    public function setValue($data)
    {
        return $this->pdos->prepare("UPDATE `users` SET '{$data}' WHERE chat_id = '{$this->chatID}'");
    }
    
    public  function getKeyValue($key)
    {
        $data = $this->getData();
        return $data[$key];
    }

    private function getData()
    {
        $chatID = $this->chatID;
        $result = $this->pdos->prepare("SELECT * FROM `users` WHERE chat_id='$chatID'");
        $result->execute();
        $arr = $result->fetch();

        return $arr;
    }



}


?>