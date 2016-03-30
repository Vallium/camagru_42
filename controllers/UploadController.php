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

    public function uploadTest()
    {
        print_r($_FILES);
    }

    private function mergeImages($imgId, $filterId)
    {
        //define the width and height of our images
        define("WIDTH", 640);
        define("HEIGHT", 480);

        $dest_image = imagecreatetruecolor(WIDTH, HEIGHT);

        //make sure the transparency information is saved
        imagesavealpha($dest_image, true);

        //create a fully transparent background (127 means fully transparent)
        $trans_background = imagecolorallocatealpha($dest_image, 0, 0, 0, 127);

        //fill the image with a transparent background
        imagefill($dest_image, 0, 0, $trans_background);

        //take create image resources out of the 3 pngs we want to merge into destination image
        $a = imagecreatefrompng(ROOT.'img/uploads/'.$imgId.'.png');
        $b = imagecreatefrompng(ROOT.'img/filters/'.$filterId.'.png');

        //copy each png file on top of the destination (result) png
        imagecopy($dest_image, $a, 0, 0, 0, 0, WIDTH, HEIGHT);
        imagecopy($dest_image, $b, 0, 0, 0, 0, WIDTH, HEIGHT);

        //send the appropriate headers and output the image in the browser
        imagepng($dest_image, ROOT.'img/uploads/'.$imgId.'.png');

        //destroy all the image resources to free up memory
        imagedestroy($a);
        imagedestroy($b);
        imagedestroy($dest_image);
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

                imagepng(imagecreatefromstring(file_get_contents($_FILES['fileToUpload']['tmp_name'])), ROOT.'img/uploads/'.$postedId.'.png');

                $this->mergeImages($postedId, $_POST['filterId']);
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

                    $this->mergeImages($postedId, $_POST['filterId']);
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