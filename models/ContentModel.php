<?php

class ContentModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getDict($table)
    {
        $sql = "SELECT * FROM $table";
        return $this->selectAll($sql);
    }
    public function getDictionary($table, $char)
    {
        $sql = "SELECT * FROM $table WHERE words LIKE '$char%'  ORDER BY words ASC";
        return $this->selectAll($sql);
    }
    public function findWord($table, $data)
    {
        $sql = "SELECT words FROM `$table` WHERE words = '$data'";
        return $this->select($sql);
    }
    public function addToDic($word, $table)
    {
        $sql = "INSERT INTO `$table` (words) VALUES (?)";
        $array = array($word);

        return $this->insertWord($sql, $array);
    }
    public function saveEssay(
        $name,
        $location,
        $errorAmount,
        $errorValue,
        $wordsAmount,
        $wordsValue,
        $essayGrade,
        $finalGrade
    ) {
        $sql = "INSERT INTO `gradedessay`
        (essayname,
        location,
        erroramount,
        errorvalue,
        wordsamount,
        wordsvalue,
        essaygrade,
        finalgrade) VALUES (?,?,?,?,?,?,?,?)";
        $array = array(
            $name,
            $location,
            $errorAmount,
            $errorValue,
            $wordsAmount,
            $wordsValue,
            $essayGrade,
            $finalGrade
        );

        return $this->insert($sql, $array);
    }
}
