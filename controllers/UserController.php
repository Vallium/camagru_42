<?php
namespace controller;

use item\User;

/**
 * Class UserController
 * @package controller
 */

class UserController extends Controller
{
    public function index()
    {
        // TODO: Implement index() method.
    }

    public function signup()
    {
        if (isset($_SESSION['username']))
        {
            $this->render('home.php');
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
                $user->setUsername($_POST['username']);
                $user->setEmail($_POST['email']);
                $user->setPassword(sha1($_POST['password']));
                $this->UserModel->save($user);
                if (!$this->UserModel->getDB()->lastInsertId())
                    $errors['exist'] = true;
            }
//            else
//                print_r($errors);
        }
        $this->render('signup.php');
    }

    public function signin()
    {
        if (isset($_SESSION['username']))
        {
            $this->render('home.php');
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
                $user = $this->UserModel->find($_POST['username']);
                if ($user) {
                    if (sha1($_POST['password']) == $user['password'])
                    {
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['username'] = $_POST['username'];
                    }
                    else
                        echo 'bad pass';
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
        $this->render('home.php');
    }

    public function profile($user_id) {
        $this->loadModel('UserModel');

        $user['profile'] = array('user' => $this->UserModel->findById($user_id));
        $this->set($user);

        $this->render('profile.php');
    }
}