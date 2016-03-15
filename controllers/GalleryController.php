<?php

namespace controller;

class GalleryController extends Controller
{
    public function index() {
        $this->loadModel('ImageModel');

        $v['gallery'] = array(
            'images' => $this->ImageModel->getLast(12)
        );

        $this->set($v);
        $this->render('gallery.php');
    }

    public function load($actual_nb_image)
    {
        $this->loadModel('ImageModel');
        $images = $this->ImageModel->loadMore($actual_nb_image, 3);

        echo json_encode($images);
    }

    public function getLast()
    {
        header("Content-Type: text/plain");
        $this->render('home.php');

        $nbImages = isset($_POST['nbImages']) ? $_POST['nbImages'] : NULL;

        if ($nbImages)
            echo $nbImages;
        else
            echo 'Error';
    }

    public function pic($id)
    {
        $this->loadModel('ImageModel');
        $this->loadModel('CommentModel');
        $this->loadModel('LikeModel');

        $v['pic'] = array(
            'picture' => $this->ImageModel->getImageById($id),
            'comments' => $this->CommentModel->getCommentsByImageId($id),
            'likes' => $this->LikeModel->countLikesByImageId($id)
        );

        $this->set($v);
        $this->render('pic.php');
    }
}