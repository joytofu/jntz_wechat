<?php
class DB{
    private $host = 'localhost';
    private $username = 'a0617095733';
    private $password = '99819433';
    private $database =  'a0617095733';
    static private $instance;
    static private $conn;

    private function __construct()
    {

    }

    static function getInstance(){
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function connect(){
        if(!self::$conn) {
            self::$conn = @mysql_connect($this->host, $this->username, $this->password) or die(mysql_error());
        }
        mysql_select_db($this->database, self::$conn);
        mysql_query("set names 'utf8'",self::$conn);
        return self::$conn;
    }
}


