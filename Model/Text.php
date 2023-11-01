<?php 
require_once './db/DB.php';
class Text 
{
    private $lang;

    public function __construct($lang)
    {
        $this->lang = $lang;
    }

    function getText($keyword)
    {
        global $pdo;
        $res = "";
      
        $result = $pdo->prepare("SELECT * FROM `text` WHERE `keyword` = '{$keyword}' LIMIT 1");
        $result->execute();
        $arr = $result->fetch();
        if (isset($arr[$this->lang])) {
            $res = $arr[$this->lang];
        }
        return $res;
    }
}


?>