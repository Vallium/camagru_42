<?php

namespace controller;

use item\Comment;
use item\Like;

$nb_img_on_gallery_load = 6;

class GalleryController extends Controller
{
    public function index() {
        $this->loadModel('ImageModel');

        $v['gallery'] = array(
            'images' => $this->ImageModel->getLast($GLOBALS['nb_img_on_gallery_load'])
        );

        $this->set($v);
        $this->render('gallery.php');
    }

    public function loadMore($actual_nb_image, $nb_to_load)
    {
        $GLOBALS['nb_img_on_gallery_load'] = $nb_to_load;
        $this->loadModel('ImageModel');
        $images = $this->ImageModel->loadMore($actual_nb_image, $nb_to_load);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            if (!empty($images))
                echo json_encode($images);
            else
                echo json_encode(false);
            die();
        }
        else
        {
            $v['gallery'] = array(
                'images' => $images
            );
            $this->set($v);
            $this->render('gallery.php');
        }
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
        $this->loadModel('UserModel');

        $v['pic'] = array(
            'picture' => $this->ImageModel->getImageById($id),
            'comments' => $this->CommentModel->getLastComments($id, 20),
            'likes' => $this->LikeModel->countLikesByImageId($id)
        );
//        echo '<pre>';
//        print_r($v['pic']['picture'][0]->users_id);
//        die;

        $v['pic']['author'] = $this->UserModel->getById($v['pic']['picture'][0]->users_id);


        if (isset($_SESSION['loggedin']))
            $v['pic']['is_liked'] = $this->LikeModel->isLiked($id, $_SESSION['id']);

        $this->set($v);
        $this->render('pic.php');
    }

    public function postComment()
    {
        if (isset($_SESSION['loggedin']))
        {
            if (isset($_POST)) {
                $this->loadModel('CommentModel');

                $errors = array();

                if (empty($_POST['content']) || !is_string($_POST['content']))
                    $errors['content'] = true;

                if (empty($errors)) {
                    $comment = new Comment();

                    $comment->setContent($_POST['content']);
                    $comment->setImagesId($_POST['images_id']);
                    $comment->setUsersId($_POST['users_id']);
                    $this->CommentModel->save($comment);

                    $json = true;
                }
                else
                    $json = false;
            }
        }
        else
            $json = "noUserConnected";

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            echo json_encode($json);
            die();
        }
        $this->pic($_POST['images_id']);
    }

    public function like($image_id)
    {
        if (isset($_SESSION['loggedin']))
        {
            $this->loadModel('LikeModel');
            if ($this->LikeModel->isLiked($image_id, $_SESSION['id'])[0]->isLiked)
            {
                $this->LikeModel->deleteLike($this->LikeModel->findLikeId($image_id, $_SESSION['id'])[0]->id);
                $json = false;
            }
            else
            {
                $like = new Like();

                $like->setImagesId($image_id);
                $like->setUsersId($_SESSION['id']);
                $this->LikeModel->save($like);
                $json = true;
            }
        }
        else
            $json = "noUserConnected";

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            echo json_encode($json);
            die();
        }
        $this->pic($image_id);
    }
}