<?php

namespace controller;

use item\Img;

$MAX_UPLOAD_SIZE = 10485760;

class UploadController extends Controller
{
    public function index()
    {
        $this->render('upload.php');
    }

    public function UploadImage()
    {
        if (isset($_POST) && isset($_SESSION['loggedin']))
        {
            $errors = array();
            $this->loadModel('ImageModel');

            if ($_FILES['fileToUpload']['error'] > 0)
                $errors['upload'] = true;
            if ($_FILES['fileToUpload']['type'] != 'image/jpeg')
                $errors['type'] = true;
            if ($_FILES['fileToUpload']['size'] > $GLOBALS['MAX_UPLOAD_SIZE'])
                $errors['size'] = true;

            if (empty($errors))
            {
                $img = new Img();

                $img->setUsersId($_SESSION['id']);
                $this->ImageModel->save($img);
                $postedId = $this->ImageModel->getLastInsertId();

                $postName = ROOT.'img/uploads/'.$postedId.'.jpg';
                move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $postName);
            }
        }
        $this->render('upload.php');
    }
}