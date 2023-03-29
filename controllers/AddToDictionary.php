<?php

include("Content.php");

class AddToDictionary extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function addtodictionary()
    {
        $json = file_get_contents('php://input');
        $addword = json_decode($json, true);

        if ($addword['addWord'] != '' && $addword['language'] != '') {
            $word = strClean($addword['addWord']);
            $table = $addword['language'];
            $content = new Content();
            $res = $content->addToDictionary($word, $table);
        } else {
            $res = array('msg' => 'INPUT THE WORD TO ADD OR SELECT A CORRECT LANGUAGE', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function saveEssay()
    {
        $json = file_get_contents('php://input');
        $saveEssay = json_decode($json, true);

        if ($saveEssay['essayName'] == '') {
            $res = array('msg' => 'FILE NAME IS REQUIRED', 'type' => 'warning');
        } else if ($saveEssay['errorAmount'] == '') {
            $res = array('msg' => 'ERROR AMOUNT IS REQUIRED', 'type' => 'warning');
        } else if ($saveEssay['errorValue'] == '') {
            $res = array('msg' => 'ERROR VALUE IS REQUIRED', 'type' => 'warning');
        } else if ($saveEssay['wordsAmount'] == '') {
            $res = array('msg' => 'WORDS AMOUNT IS REQUIRED', 'type' => 'warning');
        } else if ($saveEssay['wordsValue'] == '') {
            $res = array('msg' => 'WORDS VALUE IS REQUIRED', 'type' => 'warning');
        } else if ($saveEssay['essayGrade'] == '') {
            $res = array('msg' => 'ESSAY GRADE IS REQUIRED', 'type' => 'warning');
        } else if ($saveEssay['finalGrade'] == '') {
            $res = array('msg' => 'FINAL GRADE IS REQUIRED', 'type' => 'warning');
        } else {
            $name = $saveEssay['essayName'];
            $location = "assets/essayFiles/" . $saveEssay['essayName'];
            $errorAmount = $saveEssay['errorAmount'];
            $errorValue = $saveEssay['errorValue'];
            $wordsAmount = $saveEssay['wordsAmount'];
            $wordsValue = $saveEssay['wordsValue'];
            $essayGrade = $saveEssay['essayGrade'];
            $finalGrade = $saveEssay['finalGrade'];
            $content = new Content();
            $res = $content->essaySave(
                $name,
                $location,
                $errorAmount,
                $errorValue,
                $wordsAmount,
                $wordsValue,
                $essayGrade,
                $finalGrade
            );
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
