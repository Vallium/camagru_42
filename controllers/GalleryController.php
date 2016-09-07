<?php

namespace controller;

use item\Comment;
use item\Like;
use core\EMail;

class GalleryController extends Controller
{
    public function index($page = 1) {
        $this->loadModel('ImageModel');

        $nb_pages = ceil($this->ImageModel->countAll() / 12);

        if (!$nb_pages)
            $nb_pages = 1;

        if (!is_numeric($page) || $page <= 0 || $page > $nb_pages)
            return $this->render('404.php');

        $v['gallery'] = array(
            'images' => $this->ImageModel->getPics($page, 12),
            'nb_pages' => $nb_pages,
            'page' => $page
        );

        $this->set($v);
        $this->render('gallery.php');
    }

    public function page($page = 1)
    {
        return $this->index($page);
    }

    public function loadMore($actual_nb_image, $nb_to_load)
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            if ($actual_nb_image < 0 || $nb_to_load <= 0 || !is_numeric($actual_nb_image) || !is_numeric($nb_to_load))
                return $this->render('404.php');

            $GLOBALS['nb_img_on_gallery_load'] = $nb_to_load;
            $this->loadModel('ImageModel');

            $images = $this->ImageModel->loadMore($actual_nb_image, $nb_to_load);
            if (!empty($images))
            {
                foreach ($images as $img)
                {
                    if (file_exists(ROOT.'web'.DS.'img/uploads/'.$img->id.'.jpg'))
                        $img->ext = '.jpg';
                    elseif (file_exists(ROOT.'web'.DS.'img/uploads/'.$img->id.'.png'))
                        $img->ext = '.png';
                }
                echo json_encode($images);
            }
            else
                echo json_encode(false);
                die();
        }

        return $this->render('404.php');
    }

    public function pic($id = null, $errors = null)
    {
        if ($id == null || $id < 0 || !is_numeric($id))
            header('Location: '.WEBROOT);

        $this->loadModel('ImageModel');
        $this->loadModel('CommentModel');
        $this->loadModel('LikeModel');
        $this->loadModel('UserModel');

        $picture = $this->ImageModel->getImageById($id);

        if (empty($picture))
        {
            $this->render('404.php');
            return;
        }

        $v['pic'] = array(
            'picture' => $picture,
            'comments' => $this->CommentModel->getLastComments($id),
            'likes' => $this->LikeModel->countLikesByImageId($id)
        );

        $v['pic']['author'] = $this->UserModel->getById($v['pic']['picture'][0]->users_id);

        foreach ($v['pic']['comments'] as $com)
            $com->users_id = $this->UserModel->getById($com->users_id)[0];

        if (isset($_SESSION['loggedin']))
            $v['pic']['is_liked'] = $this->LikeModel->isLiked($id, $_SESSION['id']);

        if (!empty($errors))
            $v['pic']['errors'] = $errors;
        $this->set($v);
        $this->render('pic.php');
    }

    public function postComment()
    {
        if (!isset($_SESSION['username']))
        {
            header('Location: '.WEBROOT);
            return;
        }

        if (!empty($_POST)) {
            $this->loadModel('CommentModel');
            $this->loadModel('ImageModel');

            if (empty($_POST['content']) || !is_string($_POST['content']))
                $errors['content'] = true;

            if (empty($this->ImageModel->getImageById($_POST['images_id'])))
                $errors['img_not_found'] = true;

            if (empty($errors)) {
                $comment = new Comment();

                $comment->setContent($_POST['content']);
                $comment->setImagesId($_POST['images_id']);
                $comment->setUsersId($_POST['users_id']);
                $this->CommentModel->save($comment);

                $comment = $this->CommentModel->getById($this->CommentModel->getDB()->lastInsertId());

                $date = new \DateTime($comment[0]->created_at);
                $json['date'] = date('l jS \of F Y H:i:s', $date->getTimestamp());
                $date = null;

                $this->loadModel('UserModel');

                $author = $this->UserModel->getById($comment[0]->users_id);
                $json['author'] = $author[0]->username;
                $json['authorId'] = $comment[0]->users_id;
                $json['status'] = true;

                $this->loadModel('ImageModel');
                $img = $this->ImageModel->getImageById($_POST['images_id']);

                $imgAuthor = $this->UserModel->getById($img[0]->users_id);

                $email = new EMail();

                $email->setTo($imgAuthor[0]->email);
                $email->setSubject('Camagru - Somone comment one of your pics');
                $email->setMessage(
                    '<h1>Hello, someone posted a comment on one of your pictures:</h1>'.
                    '<p>'.htmlspecialchars($comment[0]->content).'</p>'
                );
                $email->send();
            }
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            if (!empty($json))
                echo json_encode($json);
            elseif (!empty($errors))
                echo json_encode($errors);
        }
        else
        {
            if (!empty($json))
                header('Location: '.WEBROOT.'gallery/pic/'.$_POST['images_id']);
            elseif (!empty($errors))
                $this->pic($_POST['images_id'], $errors);
            else
                header('Location: '.WEBROOT);
        }
    }

    public function like($image_id = null)
    {
        if ($image_id == null || $image_id < 0 || !is_numeric($image_id))
        {
            header('Location: '.WEBROOT);
            return;
        }

        $this->loadModel('ImageModel');
        if (empty($this->ImageModel->getImageById($image_id)))
            $errors['img_not_found'] = true;

        if (!isset($_SESSION['username']))
            $errors['not_connected'] = true;


        if (empty($errors))
        {
            $this->loadModel('LikeModel');
            if ($this->LikeModel->isLiked($image_id, $_SESSION['id'])[0]->isLiked)
            {
                $this->LikeModel->deleteLike($this->LikeModel->findLikeId($image_id, $_SESSION['id'])[0]->id);
                $json['state'] = false;
            }
            else
            {
                $like = new Like();

                $like->setImagesId($image_id);
                $like->setUsersId($_SESSION['id']);
                $this->LikeModel->save($like);
                $json['state'] = true;
            }
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            if (empty($errors))
                echo json_encode($json);
            else
                echo json_encode($errors);
        }
        else
        {
            if (empty($errors))
                header('Location: '.WEBROOT.'gallery/pic/'.$image_id);
            else
                $this->pic($image_id, $errors);
        }
    }
}