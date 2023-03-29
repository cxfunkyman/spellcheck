<?php

include("Content.php");

class BinarySearchSpell extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  function binaraySearchEssay($item, $dictionary, $name, $textArea, $normalText)
  {
    $content = new Content();

    if (!empty($dictionary) && !empty($item)) {
      $time_start = microtime(true);
      $spellCount = 0;
      $spellCountTotal = 0;
      $foundcount = 0;
      $result = array();
      $occurrence['occurrence'] = array();
      $missPelled['missPelled'] = array();
      //print_r($array);

      for ($i = 0; $i < count($item); $i++) {
        if ($item[$i] != '') {
          $word = strClean($item[$i]);
          $value = $content->binarraySearchFile($word, $dictionary);

          if ($value == -1) {
            $value = $content->binarraySearchFile(strtolower($word), $dictionary);
            if ($value == -1) {
              $value = $content->binarraySearchFile(strtoupper($word), $dictionary);
            }
          }

          if ($value == -1) {
            $result['words'] = $word;
            array_push($missPelled['missPelled'], $result['words']);
            $spellCount++;
          }
        }
      }
      if (!empty($textArea)) {
        for ($i = 0; $i < count($textArea); $i++) {
          $foundcount = 0;
          $findtext = strClean($textArea[$i]);
          for ($j = 0; $j < count($item); $j++) {
            $word = strClean($item[$j]);
            if ($findtext == $word) {
              $foundcount++;
              $spellCountTotal++;
            }
          }
          if ($foundcount >= 0) {
            $result[$textArea[$i]] = $foundcount;
          }
        }
      }

      $time_end = microtime(true);
      $execution_time = number_format(($time_end - $time_start), 4);

      if (!empty($textArea)) {
        for ($i = 0; $i < count($textArea); $i++) {
          $array = array(
            'word' => $textArea[$i],
            'count' => $result[$textArea[$i]]
          );
          $result['occurrence'] = $array;
          array_push($occurrence['occurrence'], $result['occurrence']);
        }
      } else {
        $array = array(
          'word' => 'N/A',
          'count' => 0
        );
        $result['occurrence'] = $array;
        array_push($occurrence['occurrence'], $result['occurrence']);
      }
      $res = array(
        'fileName' => $name,
        'count' => $spellCount,
        'spellCount' => 'Found ' . $spellCount . ' misspelled words',
        'missPelledWords' => $missPelled,
        'spellTime' => $execution_time,
        'occurrence' => $occurrence,
        'found' => $foundcount,
        'totalFound' => $spellCountTotal,
        'normalText' => $normalText,
        'msg' => 'SPELL CHECK SUCCESSFUL',
        'type' => 'success',
        'status' => 'pass'
      );
    } else {
      $res = array(
        'msg' => 'WRONG FILE FORMAT',
        'type' => 'warning'
      );
    }
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }
}
$json = file_get_contents('php://input');
$spellWord = json_decode($json, true);
$content = new Content();
$languaje = $spellWord['language'];

if(empty($dict)) {
// i put the 2 process here and keep the dictionary on
//memory only check if is empty, this way call the 
//dictionary and database only once
$dictionary = $content->setDictionary($spellWord['language']);
$dict = array_map(null, (array_column($dictionary, 'words')));
sort($dict);
}
$search = new BinarySearchSpell();

$search->binaraySearchEssay($essayWords, $dict, $fileName, $textArea, $normalText);
