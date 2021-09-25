<?php

class DBConnection{
    private static $instance = null;
    private $conn;
    
    private $servername = 'localhost';
    private $username = 'root';
    private $password = '';
    private $db = 'job_task2';

    private function __construct(){
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->db);
    }

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new DBConnection();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
