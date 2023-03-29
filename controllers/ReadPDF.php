<?php

require(BASE_URL + '/controllers/class.pdf2text.php');

class ReadPDF extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function readPDF()
    {
        extract($_POST);

        if (isset($readpdf)) {

            if ($_FILES['file']['type'] == "application/pdf") {
                $a = new PDF2Text();
                $a->setFilename($_FILES['file']['tmp_name']);
                $a->decodePDF();
                echo $a->output();
                //echo nl2br($a->output());
            } else {
                echo "<p style='color:red; text-align:center'>
            Wrong file format</p>
";
            }
        }
    }
}
