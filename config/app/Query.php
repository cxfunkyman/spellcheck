<?php

class Query extends Connection
{
    private $pdo, $conn;

    public function __construct()
    {
        $this->pdo = new Connection();
        $this->conn = $this->pdo->connect();
    }
    public function select($sql)
    {
        $result = $this->conn->prepare($sql);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    public function selectAll($sql)
    {
        $result = $this->conn->prepare($sql);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert($sql, $array)
    {
        $result = $this->conn->prepare($sql);
        $data = $result->execute($array);

        if ($data) {
            $res = $this->conn->lastInsertId();
        } else {
            $res = 0;
        }
        return $res;
    }
    public function insertWord($sql, $array)
    {
        $result = $this->conn->prepare($sql);
        $data = $result->execute($array);

        if ($data) {
            $res = 1;
        } else {
            $res = 0;
        }
        return $res;
    }
    public function save($sql, $array)
    {
        $result = $this->conn->prepare($sql);
        $data = $result->execute($array);

        if ($data) {
            $res = 1;
        } else {
            $res = 0;
        }
        return $res;
    }
}
