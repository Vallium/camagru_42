<?php
namespace controller;

use item\User;

/**
 * Class UserController
 * @package controller
 */

class UserController extends Controller
{
//    public function index()
//    {
//    }


    protected function sendConfirmationMail($id, $mail, $hash)
    {
//        mail('anton.alliot@gmail.com', 'test mail', 'Salut ceci est un test');
//        $mail = 'anton.alliot@gmail.com';

        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
        {
            $passage_ligne = "\r\n";
        }
        else
        {
            $passage_ligne = "\n";
        }

        $message_txt = "Salut à tous, voici un e-mail envoyé par un script PHP.";
        $message_html = "<html><head></head><body style='background-color: rgba(50, 50, 50, 0.8); color: #ff6800;'>".'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'user/confirmSignUp/'.$id.'/'.$hash."</body></html>";

        $boundary = "-----=".md5(rand());

        $sujet = "Hey mon ami !";

        $header = "From: \"www-data\" www-data@antoine.doussaud.org".$passage_ligne;
        $header.= "Reply-to: \"www-data\" www-data@antoine.doussaud.org".$passage_ligne;
        $header.= "MIME-Version: 1.0".$passage_ligne;
        $header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;

        //=====Création du message.
        $message = $passage_ligne."--".$boundary.$passage_ligne;
        //=====Ajout du message au format texte.
        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_txt.$passage_ligne;
        //==========

        $message.= $passage_ligne."--".$boundary.$passage_ligne;
        //=====Ajout du message au format HTML
        $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_html.$passage_ligne;

        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;

        mail($mail,$sujet,$message, $header);
    }

    public function confirmSignUp($id, $hash)
    {
        $errors = array();
        $this->loadModel('UserModel');

        $user = $this->UserModel->getById($id);

//        echo '<pre>';
//        print_r($user);
//        die();

        if (empty($user))
            $errors['userNotFound'] = true;

        if ($user[0]->is_activated == 1)
            $errors['active'] = true;

        if (isset($_SESSION['loggedin']))
            $errors['alreadyLogged'] = true;

        if (empty($errors))
        {
            if ($user[0]->security_hash == $hash) {
                $obj = new User();

                $obj->setId($user[0]->id);
                $obj->setIsActivated(1);
                $obj->setSecurityHash(null);

                $this->UserModel->save($obj);
                echo 'Account confirmed with success!';
            }
        }
        header('Location: '.WEBROOT);
    }

    public function retrievePassword($id, $hash)
    {

    }

    public function signup()
    {
        if (isset($_SESSION['username']))
        {
            header('Location: '.WEBROOT);
//            $this->render('home.php');
            return;
        }

        if (isset($_POST))
        {
            $this->loadModel('UserModel');

            $errors = array();

            if (empty($_POST['username']) || !is_string($_POST['username']) || strlen($_POST['username'] > 45))
                $errors['username'] = true;

            if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $errors['email'] = true;

            if (empty($_POST['password']) || $_POST['password'] != $_POST['passwordConf'] || strlen($_POST['password']) > 255 )
                $errors['password'] = true;

            if (empty($errors))
            {
                $user = new User();
                $security_hash = sha1($_POST['username'].rand());

                $user->setUsername($_POST['username']);
                $user->setEmail($_POST['email']);
                $user->setPassword(sha1($_POST['password']));
                $user->setSecurityHash($security_hash);
                $this->UserModel->save($user);
                if (!$this->UserModel->getDB()->lastInsertId())
                    $errors['exist'] = true;

                // send email with security hash
                $this->sendConfirmationMail($this->UserModel->getDB()->lastInsertId(), $_POST['email'], $security_hash);

                header('Location: '.WEBROOT);
            }
//            else
//                print_r($errors);
        }
        $this->render('signup.php');
    }

    public function signin()
    {
        if (isset($_SESSION['username']) && $_SESSION['loggedin'] == true)
        {
            header('Location: '.WEBROOT);
//            $this->render('home.php');
            return;
        }

        if (isset($_POST))
        {
            $this->loadModel('UserModel');

            $errors = array();

            if (empty($_POST['username']) || !is_string($_POST['username']) || strlen($_POST['username'] > 45))
                $errors['username'] = true;
            if (empty($_POST['password']) || strlen($_POST['password']) > 255 )
                $errors['password'] = true;

            if (empty($errors))
            {
                $user = $this->UserModel->getByUsername($_POST['username']);
                if ($user) {
//                    echo '<pre>';
//                    print_r($user);
//                    die();
                    if ($user[0]->is_activated)
                    {
                        if (sha1($_POST['password']) == $user[0]->password) {
                            //                        session_start();
                            $_SESSION['loggedin'] = true;
                            $_SESSION['id'] = $user[0]->id;
                            $_SESSION['username'] = $user[0]->username;

                            header('Location: ' . WEBROOT);
                        } else
                            echo 'bad pass';
                    }
                    else
                        echo 'user not activate';
                }
                else
                    echo 'no exist';
            }
        }
        $this->render('signin.php');
    }

    public function logout() {
        session_unset();
        session_destroy();
//        $this->render('home.php');
//        TODO : change url in header calling
        header('Location: '.WEBROOT);

    }

    public function profile($user_id) {
        $this->loadModel('UserModel');

        $v['profile'] = array(
            'user' => $this->UserModel->getById($user_id));
        $this->set($v);

        $this->render('profile.php');
    }
}