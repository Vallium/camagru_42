<?php

namespace controller;

use item\Img;

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
    }
}