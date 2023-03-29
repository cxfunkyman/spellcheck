<?php

class UploadFile extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function uploadfile()
    {
        //file upload path
        $targetDir = "assets/essayfiles/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        if (!empty($_FILES["file"]["name"])) {

            //allow certain file formats
            $allowTypes = array('pdf', 'doc', 'docx', 'txt');
            if (in_array($fileType, $allowTypes)) {
                //upload file to server
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                    $res = array(
                        'msg' => 'The file ' . $fileName . ' has been uploaded.', 'type' => 'success', 'fileName' => $fileName
                    );
                } else {
                    $res = array('msg' => 'Sorry, there was an error uploading your file.', 'type' => 'error');
                }
            } else {
                $res = array('msg' => 'Sorry, only PDF, DOC, DOCX & TXT files are allowed to upload.', 'type' => 'warning');
            }
        } else {
            $res = array('msg' => 'Please select a file to upload', 'type' => 'warning');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
