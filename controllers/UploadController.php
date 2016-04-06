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

    private function mergeImages($imgId, $filterId)
    {
        define("WIDTH", 640);
        define("HEIGHT", 480);

        $dest_image = imagecreatetruecolor(WIDTH, HEIGHT);

        imagesavealpha($dest_image, true);

        imagefill($dest_image, 0, 0, imagecolorallocatealpha($dest_image, 0, 0, 0, 127));

        $a = imagecreatefrompng(ROOT.'img/uploads/'.$imgId.'.png');
        $b = imagecreatefrompng(ROOT.'img/filters/'.$filterId.'.png');

        imagecopy($dest_image, $a, 0, 0, 0, 0, WIDTH, HEIGHT);
        imagecopy($dest_image, $b, 0, 0, 0, 0, WIDTH, HEIGHT);

        imagepng($dest_image, ROOT.'img/uploads/'.$imgId.'.png');

        imagedestroy($a);
        imagedestroy($b);
        imagedestroy($dest_image);
    }

    public function uploadImage()
    {
        if (!empty($_POST) && isset($_SESSION['loggedin']))
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

                $json['last_insert_id'] = $postedId;

                imagepng(imagecreatefromstring(file_get_contents($_FILES['fileToUpload']['tmp_name'])), ROOT.'img/uploads/'.$postedId.'.png');

                $this->mergeImages($postedId, $_POST['filterId']);
            }

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            {
                if (!empty($errors))
                    echo json_encode($errors);
                else
                {
                    $json['state'] = true;
                    echo json_encode($json);
                }
                die();
            }
            else
            {
                if (empty($errors))
                    header('Location: '.WEBROOT.'pic/'.$postedId);
                else
                {
                    $v['errors'] = $errors;
                    $this->set($v);
                    $this->render('uploadFile.php');
                }

            }
        }
        else
            header('Location: '.WEBROOT);
    }

    public function uploadImageFromWebcam()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            if (!empty($_POST) && isset($_SESSION['loggedin'])) {
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

                    $this->mergeImages($postedId, $_POST['filterId']);
                }

                if (!empty($errors))
                    echo json_encode($errors);
                else
                    echo json_encode(true);
                die();
            }
            else
                header('Location: '.WEBROOT);
        }
        else
            $this->render('404.php');
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