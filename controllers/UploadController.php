<?php

namespace controller;

use item\Img;

$MAX_UPLOAD_SIZE = 10485760;

class UploadController extends Controller
{
    public function index()
    {
        $this->render('uploadFile.php');
    }

    public function takePicture()
    {
        $this->render('takePicture.php');
    }

    public function uploadImage()
    {
        if (isset($_POST) && isset($_SESSION['loggedin']))
        {
            $errors = array();
            $this->loadModel('ImageModel');

            if ($_FILES['fileToUpload']['error'] > 0)
                $errors['upload'] = true;
            if ($_FILES['fileToUpload']['type'] != 'image/jpeg' && $_FILES['fileToUpload']['type'] != 'image/png')
                $errors['type'] = true;
            if ($_FILES['fileToUpload']['size'] > $GLOBALS['MAX_UPLOAD_SIZE'])
                $errors['size'] = true;

            if (empty($errors))
            {
                $img = new Img();

                $img->setUsersId($_SESSION['id']);
                $this->ImageModel->save($img);
                $postedId = $this->ImageModel->getLastInsertId();

                if ($_FILES['fileToUpload']['type'] != 'image/jpeg')
                    $ext = '.jpg';
                else
                    $ext = '.png';
                $postName = ROOT.'img/uploads/'.$postedId.$ext;
                move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $postName);
            }

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            {
                if (!empty($errors))
                    echo json_encode($errors);
                else
                    echo json_encode(true);
                die();
            }
        }
        $this->render('home.php');
    }


    public function uploadImageFromWebcam()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            if (isset($_POST) && isset($_SESSION['loggedin'])) {
                $errors = array();
                $this->loadModel('ImageModel');

                if ($_POST['base64img'] == 'none')
                    $errors['base64img'] = true;

                if (empty($errors)) {
                    $img = new Img();

                    $img->setUsersId($_SESSION['id']);
                    $this->ImageModel->save($img);
                    $postedId = $this->ImageModel->getLastInsertId();

                    $ifp = fopen('img/uploads/'.$postedId.'.png', "wb");

                    $base64str = $_POST['base64img'];
                    $data = explode(',', $base64str);

                    fwrite($ifp, base64_decode($data[1]));
                    fclose($ifp);
                }

                if (!empty($errors))
                    echo json_encode($errors);
                else
                    echo json_encode(true);
                die();
            }
        }
        else
            $this->render('404.php');

//        $this->render('home.php');
    }

    public function deleteImage()
    {
        if (isset($_POST))
        {
            $errors = array();
            if (isset($_SESSION['loggedin']) && $_SESSION['id'] == $_POST['imgUserId'])
            {
                $this->loadModel('ImageModel');

                $this->ImageModel->deleteImage($_POST['imgId']);
                if (file_exists(ROOT.'img'.DS.'uploads'.DS.$_POST['imgId'].'.jpg'))
                    unlink(ROOT.'img'.DS.'uploads'.DS.$_POST['imgId'].'.jpg');
                elseif (file_exists(ROOT.'img'.DS.'uploads'.DS.$_POST['imgId'].'.png'))
                    unlink(ROOT.'img'.DS.'uploads'.DS.$_POST['imgId'].'.png');
            }

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            {
                if (!empty($errors))
                    echo json_encode($errors);
                else
                    echo json_encode(true);
                die();
            }
        }
        header('Location: '.WEBROOT);
    }
}