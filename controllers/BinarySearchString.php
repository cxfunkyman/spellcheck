<?php

require("Content.php");

class BinarySearchString extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  function binarrayDictionarraySearch($item, $table)
  {

    $word = strClean($item);
    $content = new Content();
    $value = $content->binarraySearch($word, $table);
    $time_start = microtime(true);
    $time_end = microtime(true);

    $execution_time = number_format(($time_end - $time_start), 4);

    if ($value != -1) {
      $res = array('msg' => $item . ' WAS SPELT CORRECTLY', 'type' => 'success');
    } else {
      $res = array('msg' => $item . ' WAS SPELT INCORRECTLY', 'type' => 'error');
    }
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }
}
$json = file_get_contents('php://input');
$spellWord = json_decode($json, true);
$languaje = $spellWord['language'];
$content = new Content();
$search = new BinarySearchString();
$search->binarrayDictionarraySearch($spellWord['checkWord'], $languaje);
