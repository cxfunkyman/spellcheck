<?php

class Connection
{
    private $conn;

    public function __construct()
    {
        $pdo = "mysql:host=".HOST.";dbname=".DBNAME.";".CHARSET;

        try {
            $this->conn = new PDO($pdo, USER, PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
    }
    public function connect()
    {
        return $this->conn;
    }
}


?>