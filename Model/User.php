<?php

require_once './db/DB.php';

class User {
    
    public $pdos;
    public function __construct()
    {
        global $pdo;
        $this->pdos = $pdo;
    }

    public static function create($chat_id) 
    {
        $sql = new self();
        $check =   $sql->pdos->prepare("SELECT * FROM users WHERE chat_id = :chat_id");
        $check->bindParam(':chat_id', $chat_id, PDO::PARAM_INT);
        $check->execute();
        $data = $check->fetch();

        if (empty($data)) {
            $store =   $sql->pdos->prepare("INSERT INTO `users` (`chat_id`) VALUES (:chat_id)");
            $store->bindParam(':chat_id', $chat_id, PDO::PARAM_INT);
            $store->execute();
            return true;
        }
        return false;
    }

    public static function update($sqls , $data)
    {
        $sql = new self();
        $sql  = $sql->pdos->prepare($sqls);
        $sql->execute($data);
        $obj = $sql->fetchAll();

        return $obj;
    }
}


?>