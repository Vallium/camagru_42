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
            {
                foreach ($images as $img)
                {
                    if (file_exists(ROOT.'img/uploads/'.$img->id.'.jpg'))
                        $img->ext = '.jpg';
                    elseif (file_exists(ROOT.'img/uploads/'.$img->id.'.png'))
                        $img->ext = '.png';
                }
                echo json_encode($images);
            }
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
            'comments' => $this->CommentModel->getLastComments($id),
            'likes' => $this->LikeModel->countLikesByImageId($id)
        );
//        echo '<pre>';
//        print_r($v['pic']['picture'][0]->users_id);
//        die;

        $v['pic']['author'] = $this->UserModel->getById($v['pic']['picture'][0]->users_id);


        foreach ($v['pic']['comments'] as $com)
            $com->users_id = $this->UserModel->getById($com->users_id)[0];

        if (isset($_SESSION['loggedin']))
            $v['pic']['is_liked'] = $this->LikeModel->isLiked($id, $_SESSION['id']);

        $this->set($v);
        $this->render('pic.php');
    }

    protected function sendCommentMail($mail, $content)
    {
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
            $endl = "\r\n";
        else
            $endl = "\n";

        $message_txt = "Hello, someone posted a comment on one of your pictures:".$endl.$content;

        $message_html = "
                <html>
                    <head>
                    </head>
                    <body style='background-color: rgba(50, 50, 50, 0.8); color: #ff6800; width: 960px; height: auto; margin: 0 auto;'>
                        <h1>Hello, someone posted a comment on one of your pictures:</h1>
                        <div style='border: 1px solid black; width: 850px; height: auto; margin: 0 auto; padding: 5px;'>".$content."</div>
                    </body>
                </html>
                ";

        $boundary = "-----=".md5(rand());

        $subject = "Camagru - Someone posted a comment!";

        $header = "From: \"www-data\" www-data@antoine.doussaud.org".$endl;
        $header.= "Reply-to: \"www-data\" www-data@antoine.doussaud.org".$endl;
        $header.= "MIME-Version: 1.0".$endl;
        $header.= "Content-Type: multipart/alternative;".$endl." boundary=\"$boundary\"".$endl;

        //=====Création du message.
        $message = $endl."--".$boundary.$endl;
        //=====Ajout du message au format texte.
        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$endl;
        $message.= "Content-Transfer-Encoding: 8bit".$endl;
        $message.= $endl.$message_txt.$endl;
        //==========

        $message.= $endl."--".$boundary.$endl;
        //=====Ajout du message au format HTML
        $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$endl;
        $message.= "Content-Transfer-Encoding: 8bit".$endl;
        $message.= $endl.$message_html.$endl;

        $message.= $endl."--".$boundary."--".$endl;
        $message.= $endl."--".$boundary."--".$endl;

        mail($mail, $subject, $message, $header);
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
//                    $json['mailtest'] = $imgAuthor[0]->email;
                    $this->sendCommentMail($imgAuthor[0]->email, $comment[0]->content);
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