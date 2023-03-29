<?php

ini_set('max_execution_time', 0);
include 'vendor/autoload.php';

class Content extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }
  public function txtToArray($file)
  {
    if ($file == '') {
      echo "File not found";
      return;
    }
    $fileRef = fopen($file, "r");
    $textData = fread($fileRef, filesize($file));
    fclose($fileRef);

    return $arrayText = array(
      'normalText' => $textData,
      'arrayText' => preg_split('/\s+/', $textData),
    );
  }
  public function dicToArray($file)
  {
    if ($file == '') {
      echo "File not found";
      return;
    }
    $fileRef = fopen($file, "r");
    $textData = fread($fileRef, filesize($file));
    fclose($fileRef);

    return preg_split('/\s+/', $textData);
  }
  public function docToText($file)
  {
    if (file_exists($file)) {

      if (($fh = fopen($file, 'r')) !== false) {

        $headers = fread($fh, 0xA00);

        // 1 = (ord(n)*1) ; Document has from 0 to 255 characters
        $n1 = (ord($headers[0x21C]) - 1);

        // 1 = ((ord(n)-8)*256) ; Document has from 256 to 63743 characters
        $n2 = ((ord($headers[0x21D]) - 8) * 256);

        // 1 = ((ord(n)*256)*256) ; Document has from 63744 to 16775423 characters
        $n3 = ((ord($headers[0x21E]) * 256) * 256);

        // 1 = (((ord(n)*256)*256)*256) ; Document has from 16775424 to 4294965504 characters
        $n4 = (((ord($headers[0x21F]) * 256) * 256) * 256);

        // Total length of text in the document
        $textLength = ($n1 + $n2 + $n3 + $n4);

        $textData = fread($fh, $textLength);

        // if you want to see your paragraphs in a new line, do this
        // return nl2br($extracted_plaintext);
        //return preg_split('/\s+/', $textData);
        //return $textData;
        return $arrayText = array(
          'normalText' => $textData,
          'arrayText' => preg_split('/\s+/', $textData),
        );
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
  public function docxToText($file)
  {
    $stripedContent = '';
    $content = '';

    if (!$file || !file_exists($file)) {
      return;
    }

    $zip = zip_open($file);

    if (!$zip || is_numeric($zip)) {
      return;
    }

    while ($zip_entry = zip_read($zip)) {
      if (zip_entry_open($zip, $zip_entry) == false) {
        continue;
      }
      if (zip_entry_name($zip_entry) != "word/document.xml") {
        continue;
      }

      $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
      zip_entry_close($zip_entry);
    } // end while

    zip_close($zip);

    $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
    $content = str_replace('</w:r></w:p>', "\r\n", $content);
    $stripedContent = strip_tags($content);

    return $arrayText = array(
      'normalText' => $stripedContent,
      'arrayText' => preg_split('/\s+/', $stripedContent),
    );
  }
  public function pdfToText($file)
  {
    if (!empty($file)) {
      $parser = new \Smalot\PdfParser\Parser();
      $pdf = $parser->parseFile($file);
      $text = $pdf->getText();
      return $arrayText = array(
        'normalText' => $text,
        'arrayText' => preg_split(
          "/[\s,]*\\\"([^\\\"]+)\\\"[\s,]*|" . "[\s,]*'([^']+)'[\s,]*|" . "[\s,]+/",
          $text,
          0,
          PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
        ),
      );
    } else {
      return false;
    }
  }
  public function textAreaToArray($textarea)
  {
    $txtareaArray = array_map('trim', explode("\n", $textarea)); // to remove extra spaces from each value of array
    //print_r($txtareaArray);
    return $txtareaArray;
  }
  public function binarraySearch($item, $table)
  {
    $data = $this->model->findWord($table, $item);
    if ($data > 0) {
      return $data;
    } else {
      return -1;
    }
  }
  public function binarraySearchFile($item, $array)
  {
    $low = 0;
    $n = count($array) - 1;
    // the binary search is correct, but this 2 steps were time consuming 
    // unnecessary to repeat over and over 
    // $dict = array_map(null, (array_column($array, 'words')));
    // sort($dict);
    $high = $n;
    //print_r($dict);

    while ($low <= $high) {
      if ($low == $n)
        break;
      $mid = $low + (floor(($high - $low) / 2));
      $word = strClean($array[$mid]);

      if (strcmp($word, $item) === 0) {
        return $mid;
      } else if (strcmp($item, $word) < 0) {
        $high = $mid - 1;
      } else {
        $low = $mid + 1;
      }
    }
    return -1;
  }
  public function setDictionary($lenguage)
  {
    $dict = $this->model->getDict($lenguage);
    if (!empty($dict)) {
      return $dict;
    } else {
      $res = array('msg' => 'DICTIONARY NOT FOUND', 'type' => 'error');
      return $res;
    }
  }
  public function addToDictionary($word, $table)
  {
    $result = $this->binarraySearch($word, $table);
    if ($result > 0) {
      $res = array('msg' => $word . ' ALREADY EXISTS', 'type' => 'error');
    } else {
      $data = $this->model->addToDic($word, $table);
      if ($data > 0) {
        $res = array('msg' => $word . ' WAS REGISTERED', 'type' => 'success');
      } else {
        $res = array('msg' => $word . ' WAS NOT REGISTERED', 'type' => 'error');
      }
    }
    return $res;
  }
  public function essaySave(
    $name,
    $location,
    $errorAmount,
    $errorValue,
    $wordsAmount,
    $wordsValue,
    $essayGrade,
    $finalGrade
  ) {
    $data = $this->model->saveEssay(
      $name,
      $location,
      $errorAmount,
      $errorValue,
      $wordsAmount,
      $wordsValue,
      $essayGrade,
      $finalGrade
    );
    if ($data > 0) {
      $res = array('msg' => 'ESSAY WAS REGISTERED', 'type' => 'success');
    } else {
      $res = array('msg' => 'ESSAY WAS NOT REGISTERED', 'type' => 'error');
    }
    return $res;
  }
}
$content = new Content();
$lenguageDic = 'english';
$json = file_get_contents('php://input');
$data = json_decode($json, true);
$convertedFile = array();
$normalText = '';

if (
  isset($data["fileCheckName"]) && $data["fileCheckName"] != '' &&
  $data["fileExtension"] != 'select'
) {
  $essayWords = array();
  $fileName = $data["fileCheckName"];
  $nameFile = "assets/essayFiles/" . $data["fileCheckName"];
  $file_info = pathinfo($nameFile);
  $fileExt = $file_info['extension'];

  if ($data["fileExtension"] == 'txt' && $fileExt == 'txt') {
    
    $convertedFile = $content->txtToArray($nameFile);
    $normalText = $convertedFile['normalText'];
    $essayWords = array_map(null, $convertedFile['arrayText']);

  } else if ($data["fileExtension"] == 'doc' && $fileExt == 'doc') {
    
    $convertedFile = $content->docToText($nameFile);
    $normalText = $convertedFile['normalText'];
    $essayWords = array_map(null, $convertedFile['arrayText']);

  } else if ($data["fileExtension"] == 'docx' && $fileExt == 'docx') {
    
    $convertedFile = $content->docxToText($nameFile);
    $normalText = $convertedFile['normalText'];
    $essayWords = array_map(null, $convertedFile['arrayText']);

  } else if ($data["fileExtension"] == 'pdf' && $fileExt == 'pdf') {
    
    $convertedFile = $content->pdfToText($nameFile);
    $normalText = $convertedFile['normalText'];
    $essayWords = array_map(null, $convertedFile['arrayText']);
  }
  if (!empty($data['findWords'])) {
    $textArea = $content->textAreaToArray($data['findWords']);
  } else {
    $textArea = '';
  }
}
