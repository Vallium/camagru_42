<?php

namespace controller;

use item\Img;

$MAX_UPLOAD_SIZE = 10485760;

class UploadController extends Controller
{
    private function getLastPics()
    {
        $this->loadModel('ImageModel');

        $images = $this->ImageModel->getLast(6);

        foreach($images as $img)
        {
            if (file_exists(ROOT.'web'.DS.'img/uploads/'.$img->id.'.jpg'))
                $img->ext = '.jpg';
            elseif (file_exists(ROOT.'web'.DS.'img/uploads/'.$img->id.'.png'))
                $img->ext = '.png';
        }

        return $images;
    }

    public function index($errors = false)
    {
        if (isset($_SESSION['loggedin']))
        {
            $v['upload']['errors'] = $errors;
            $v['upload']['last_pics'] = $this->getLastPics();

            $this->set($v);
            $this->render('uploadFile.php');
        }
        else
            header('Location: '.WEBROOT.'user/signin');
    }

    public function takePicture($errors = false)
    {
        if (isset($_SESSION['loggedin']))
        {
            $v['upload']['errors'] = $errors;
            $v['upload']['last_pics'] = $this->getLastPics();

            $this->set($v);
            $this->render('takePicture.php');
        }
        else
            header('Location: '.WEBROOT.'user/signin');
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

            if ($_FILES['fileToUpload']['error'] > 0)
                $errors['upload'] = true;
            if ($_FILES['fileToUpload']['type'] != 'image/jpeg' && $_FILES['fileToUpload']['type'] != 'image/png')
                $errors['type'] = true;
            if ($_FILES['fileToUpload']['size'] > $GLOBALS['MAX_UPLOAD_SIZE'])
                $errors['size'] = true;

            if (empty($errors))
            {
                $filter_root = ROOT.'web/img/filters/'.$_POST['filterId'].'.png';
                $tmp_img = imagecreatefromstring(file_get_contents($_FILES['fileToUpload']['tmp_name']));

                list($width, $height) = getimagesize($_FILES['fileToUpload']['tmp_name']);
                list($filter_w, $filter_h) = getimagesize($filter_root);

                $tmp_filter = imagecreatefrompng($filter_root);
                $filter = imagecreatetruecolor($width, $height);

                imagealphablending($filter, false);
                imagesavealpha($filter, true);
                imagecolortransparent($filter);

                $a = imagecopyresampled($filter, $tmp_filter, 0, 0, 0, 0, $width, $height, $filter_w, $filter_h);
                $b = imagecopyresampled($tmp_img, $filter, 0, 0, 0, 0, $width, $height, $width, $height);

                if ($a == false || $b == false)
                    $errors['creation'] = true;

                imagedestroy($tmp_filter);
                imagedestroy($filter);

                if (empty($errors))
                {
                    $this->loadModel('ImageModel');
                    $img = new Img();

                    $img->setUsersId($_SESSION['id']);
                    $this->ImageModel->save($img);
                    $postedId = $this->ImageModel->getLastInsertId();

                    imagepng($tmp_img, ROOT.'web/img/uploads/'.$postedId.'.png');
                    imagedestroy($tmp_img);
                    header('Location: '.WEBROOT.'gallery/pic/'.$postedId);
                }
            }

            if (!empty($errors))
                $this->index($errors);
        }
        else
            header('Location: '.WEBROOT);
    }

    public function uploadImageFromWebcam()
    {
        if (!empty($_POST) && isset($_SESSION['loggedin']))
        {
            $errors = array();

            if ($_POST['base64img'] == 'none')
                $errors['base64img'] = true;

            if (empty($errors))
            {
                $filter_root = ROOT.'web/img/filters/'.$_POST['filterId'].'.png';
                $tmp_img = imagecreatefromstring(base64_decode(explode(',', $_POST['base64img'])[1]));

                $width = 640;
                $height = 480;
                list($filter_w, $filter_h) = getimagesize($filter_root);

                $tmp_filter = imagecreatefrompng($filter_root);
                $filter = imagecreatetruecolor($width, $height);

                imagealphablending($filter, false);
                imagesavealpha($filter, true);
                imagecolortransparent($filter);

                $a = imagecopyresampled($filter, $tmp_filter, 0, 0, 0, 0, $width, $height, $filter_w, $filter_h);
                $b = imagecopyresampled($tmp_img, $filter, 0, 0, 0, 0, $width, $height, $width, $height);

                if ($a == false || $b == false)
                    $errors['creation'] = true;

                imagedestroy($tmp_filter);
                imagedestroy($filter);

                if (empty($errors))
                {
                    $this->loadModel('ImageModel');
                    $img = new Img();

                    $img->setUsersId($_SESSION['id']);
                    $this->ImageModel->save($img);
                    $postedId = $this->ImageModel->getLastInsertId();

                    imagepng($tmp_img, ROOT.'web/img/uploads/'.$postedId.'.png');
                    imagedestroy($tmp_img);
                    header('Location: '.WEBROOT.'gallery/pic/'.$postedId);
                }
            }

            if (!empty($errors))
                $this->takePicture($errors);
        }
        else
            header('Location: '.WEBROOT);
    }

    public function deleteImage()
    {
        if (!empty($_POST))
        {
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