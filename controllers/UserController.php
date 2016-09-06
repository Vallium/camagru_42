<?php
namespace controller;

use core\EMail;
use item\User;

/**
 * Class UserController
 * @package controller
 */

class UserController extends Controller
{
    protected function sendConfirmationMail($id, $mail, $hash)
    {
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
            $endl = "\r\n";
        else
            $endl = "\n";

        $message_txt = 'Hello, welcome on Camagru. Please click the following link to activate your account:'.$endl.'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'user/confirmSignUp/'.$id.'/'.$hash;

        $message_html = "
                <html>
                    <head>
                    </head>
                    <body style='background-color: rgba(50, 50, 50, 0.8); color: #ff6800; width: 960px; height: auto; margin: 0 auto;'>
                        <h1>Hello,</h1>
                        <p>Welcome on Camagru from Vallium @ 42, please click the link below to active your account:</p>
                        <div style='border: 1px solid black; width: 850px; height: auto; margin: 0 auto; padding: 5px;'>".'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'user/confirmSignUp/'.$id.'/'.$hash."</div>
                    </body>
                </html>
                ";

        $boundary = "-----=".md5(rand());

        $sujet = "Camagru - Welcome! Active your account";

        $header = "From: \"www-data\" www-data@antoine.doussaud.org".$endl;
        $header.= "Reply-to: \"www-data\" www-data@antoine.doussaud.org".$endl;
        $header.= "MIME-Version: 1.0".$endl;
        $header.= "Content-Type: multipart/alternative;".$endl." boundary=\"$boundary\"".$endl;

        //  Init mail.
        $message = $endl."--".$boundary.$endl;

        //  Add Text Format.
        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$endl;
        $message.= "Content-Transfer-Encoding: 8bit".$endl;
        $message.= $endl.$message_txt.$endl;

        $message.= $endl."--".$boundary.$endl;

        //  Add HTML Format.
        $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$endl;
        $message.= "Content-Transfer-Encoding: 8bit".$endl;
        $message.= $endl.$message_html.$endl;

        $message.= $endl."--".$boundary."--".$endl;
        $message.= $endl."--".$boundary."--".$endl;

        mail($mail,$sujet,$message, $header);
    }

    protected function sendRetrieveEmail($id, $mail, $hash)
    {
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
            $endl = "\r\n";
        else
            $endl = "\n";

        $message_txt = 'Hello, welcome on Camagru. You forgot your password? Please click the following link to reset it:'.$endl.'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'user/changPassword/'.$id.'/'.$hash;

        $message_html = "
                <html>
                    <head>
                    </head>
                    <body style='background-color: rgba(50, 50, 50, 0.8); color: #ff6800; width: 960px; height: auto; margin: 0 auto;'>
                        <h1>Hello,</h1>
                        <p>You forgot your password? Please click the link below to reset it:</p>
                        <div style='border: 1px solid black; width: 850px; height: auto; margin: 0 auto; padding: 5px;'>".'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'user/changePassword/'.$id.'/'.$hash."</div>
                    </body>
                </html>
                ";

        $boundary = "-----=".md5(rand());

        $sujet = "Camagru - Welcome! Active your account";

        $header = "From: \"www-data\" www-data@antoine.doussaud.org".$endl;
        $header.= "Reply-to: \"www-data\" www-data@antoine.doussaud.org".$endl;
        $header.= "MIME-Version: 1.0".$endl;
        $header.= "Content-Type: multipart/alternative;".$endl." boundary=\"$boundary\"".$endl;

        //  Init mail.
        $message = $endl."--".$boundary.$endl;

        //  Add Text Format.
        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$endl;
        $message.= "Content-Transfer-Encoding: 8bit".$endl;
        $message.= $endl.$message_txt.$endl;

        $message.= $endl."--".$boundary.$endl;

        //  Add HTML Format.
        $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$endl;
        $message.= "Content-Transfer-Encoding: 8bit".$endl;
        $message.= $endl.$message_html.$endl;

        $message.= $endl."--".$boundary."--".$endl;
        $message.= $endl."--".$boundary."--".$endl;

        mail($mail, $sujet, $message, $header);
    }


    // TODO: protect invalid args
    
    public function confirmSignUp($id = null, $hash = null)
    {
        if ($id == null || $hash == null || $id < 0)
        {
            $this->render('404.php');
            return;
        }

        $errors = array();
        $v = array();

        $this->loadModel('UserModel');

        $user = $this->UserModel->getById($id);

        if (empty($user))
            $errors['userNotFound'] = true;
        elseif ($user[0]->is_activated == 1)
            $errors['active'] = true;

        if (isset($_SESSION['loggedin']))
        {
            header('Location: ' . WEBROOT);
            return;
        }

        if (empty($errors))
        {
            if ($user[0]->security_hash == $hash) {
                $obj = new User();

                $obj->setId($user[0]->id);
                $obj->setPassword($user[0]->password);
                $obj->setIsActivated(1);
                $obj->setSecurityHash(null);

                $this->UserModel->save($obj);
                $v['confirm']['ok'] = true;
            }
            else
                $v['confirm']['errors']['error_occured'] = true;
        }
        else
            $v['confirm']['errors'] = $errors;

        $this->set($v);
        $this->render('signin.php');
    }

    public function forgotPassword()
    {
        if (isset($_SESSION['username']))
        {
            header('Location: '.WEBROOT);
            return;
        }

        if (!empty($_POST)) {
            if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $errors['invalid_email_format'] = true;
            else
            {
                $this->loadModel('UserModel');

                $stupidUser = $this->UserModel->getByEmail($_POST['email']);

                if (empty($stupidUser))
                    $errors['undefined_email'] = true;
            }

            if (empty($errors))
            {
                $user = new User();
                $security_hash = sha1($stupidUser[0]->username.rand());

                $user->setId($stupidUser[0]->id);
                $user->setPassword($stupidUser[0]->password);
                $user->setIsActivated(true);
                $user->setSecurityHash($security_hash);

                $this->UserModel->save($user);

                $this->sendRetrieveEmail($stupidUser[0]->email, $stupidUser[0]->id, $security_hash);
            }

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            {
                if (empty($errors))
                    echo json_encode(true);
                else
                    echo json_encode($errors);
                die();
            }
            else
            {
                if (empty($errors))
                    header('Location: '.WEBROOT);
                else
                {
                    $v['errors'] = $errors;
                    $this->set($v);
                }
            }
        }
        $this->render('forgotPassword.php');
    }

    public function changePassword($id = null, $hash = null)
    {
        if ($id == null || $hash == null || $id < 0 || !is_numeric($id))
        {
            $this->render('404.php');
            return;
        }

        $this->loadModel('UserModel');

        if (empty($_POST))
        {
            $stupidUser = $this->UserModel->getById($id);
            if (empty($stupidUser) || $stupidUser[0]->security_hash != $hash)
                $v['retrieve']['bad_link'] = true;
            else
                $v['retrieve'] = array(
                    'id' => $stupidUser[0]->id,
                    'hash' => $stupidUser[0]->security_hash
                );
        }
        else
        {
            if (empty($_POST['id']) || $_POST['id'] < 0 || !is_numeric($_POST['id']))
                $errors['bad_id'] = true;
            else
            {
                $user = $this->UserModel->getById($_POST['id']);

                if (empty($user))
                    $errors['user_not_found'] = true;
                elseif ($_POST['hash'] != $user[0]->security_hash)
                    $errors['incorrect_hash'] = true;
                else
                {
                    if (empty($_POST['password']) || strlen($_POST['password']) > 100 || !preg_match('`^([a-zA-Z0-9-_]{6,100})$`', $_POST['password']))
                        $errors['password'] = true;

                    if ($_POST['password'] != $_POST['passwordConf'])
                        $errors['password_match'] = true;
                    elseif (sha1($_POST['password']) == $user[0]->password)
                        $errors['password_same'] = true;
                }
            }
            if (empty($errors))
            {
                $v['retrieve'] = true;
            }
            else
                $v['retrieve']['errors'] = $errors;
        }
        if (isset($v))
            $this->set($v);
        $this->render('forgotPassword.php');
    }

    public function signup()
    {
        if (isset($_SESSION['username']))
        {
            header('Location: '.WEBROOT);
            return;
        }

        if (!empty($_POST))
        {
            $this->loadModel('UserModel');

            $errors = array();

            if (empty($_POST['username']) || !is_string($_POST['username']) || strlen($_POST['username'] > 36) || !preg_match('`^([a-zA-Z0-9-_]{2,36})$`', $_POST['username']))
                $errors['username'] = true;

            if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $errors['email'] = true;

            if (empty($_POST['password']) || strlen($_POST['password']) > 100 || !preg_match('`^([a-zA-Z0-9-_]{6,100})$`', $_POST['password']))
                $errors['password'] = true;

            if ($_POST['password'] != $_POST['passwordConf'])
                $errors['password_match'] = true;

            $loginExists = $this->UserModel->getByUsername($_POST['username']);

            if (!empty($loginExists))
               $errors['login_already_exists'] = true;

            $emailExists = $this->UserModel->getByEmail($_POST['email']);

            if (!empty($emailExists))
                $errors['email_already_exists'] = true;

            if (empty($errors))
            {
                $user = new User();
                $security_hash = sha1($_POST['username'].rand());

                $user->setUsername($_POST['username']);
                $user->setEmail($_POST['email']);
                $user->setPassword(sha1($_POST['password']));
                $user->setSecurityHash($security_hash);

                $this->UserModel->save($user);

                $last_insert = $this->UserModel->getDB()->lastInsertId();

                // send email with security hash
                if ($last_insert)
                {
                    $email = new EMail();

                    $email->setTo($user->getEmail());
                    $email->setSubject('Camagru - Activate your account');
                    $email->setMessage(
                        '<h1>Hello,</h1>'.
                        '<p>Welcome on Camagru from Vallium @ 42, please click the link below to active your account:</p>'.
                        'http://'.$_SERVER['HTTP_HOST'].WEBROOT.'user/confirmSignUp/'.$last_insert.'/'.$security_hash
                    );
                    $email->send();
                }
                else
                    $errors['db_error'] = true;
            }

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            {
                if (empty($errors))
                    echo json_encode(true);
                else
                    echo json_encode($errors);
                die();
            }
            else
            {
                if (!empty($errors))
                {
                    $v['errors'] = $errors;
                    $this->set($v);
                }
            }
        }
        $this->render('signup.php');
    }

    private function get_gravatar($email, $s = 360, $d = 'mm', $r = 'g') {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";

        return $url;
    }

    public function signin()
    {
        if (isset($_SESSION['username']) && $_SESSION['loggedin'] == true)
        {
            header('Location: '.WEBROOT);
            return;
        }

        if (!empty($_POST))
        {
            $this->loadModel('UserModel');

            if (empty($_POST['username']) || !is_string($_POST['username']) || strlen($_POST['username'] > 36) || !preg_match('`^([a-zA-Z0-9-_]{2,36})$`', $_POST['username']))
                $errors['username'] = true;

            if (empty($_POST['password']) || strlen($_POST['password']) > 100 || !preg_match('`^([a-zA-Z0-9-_]{6,100})$`', $_POST['password']))
                $errors['password'] = true;

            $user = $this->UserModel->getByUsername($_POST['username']);

            if (empty($user))
                $errors['user_not_found'] = true;
            else
            {
                if (sha1($_POST['password']) == $user[0]->password) {
                    if ($user[0]->is_activated == true)
                    {
                        if ($user[0]->security_hash != null)
                        {
                            $obj = new User();

                            $obj->setId($user[0]->id);
                            $obj->setPassword($user[0]->password);
                            $obj->setIsActivated($user[0]->is_activated);
                            $obj->setSecurityHash(null);

                            $this->UserModel->save($obj);
                        }
                        $_SESSION['loggedin'] = true;
                        $_SESSION['id'] = $user[0]->id;
                        $_SESSION['username'] = $user[0]->username;
                        $_SESSION['gravatar'] = $this->get_gravatar($user[0]->email, 360);
                    }
                    else
                        $errors['user_not_activated'] = true;
                }
                else
                    $errors['bad_pass'] = true;
            }

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            {
                if (!empty($errors))
                    echo json_encode($errors);
                else
                    echo json_encode(true);
                die();
            }
            else
            {
                if (!empty($errors))
                {
                    $v['errors'] = $errors;
                    $this->set($v);
                }
                else
                    header('Location: '.WEBROOT);
            }
        }
        $this->render('signin.php');
    }

    public function logout() {
        session_unset();
        session_destroy();

        header('Location: '.WEBROOT);
    }

    public function profile($user_id = null) {
        if ($user_id == null || $user_id < 0 || !is_numeric($user_id))
            header('Location: '.WEBROOT);

        $this->loadModel('UserModel');
        $this->loadModel('ImageModel');

        $user = $this->UserModel->getById($user_id);

        if (empty($user))
        {
            $this->render('404.php');
            return;
        }

        $v['profile'] = array(
            'user' => $user,
            'pictures' => $this->ImageModel->getLastByUserId($user_id)
        );

        foreach($v['profile']['pictures'] as $pic)
        {
            if (file_exists(ROOT.'web'.DS.'img/uploads/'.$pic->id.'.jpg'))
                $pic->ext = '.jpg';
            elseif (file_exists(ROOT.'web'.DS.'img/uploads/'.$pic->id.'.png'))
                $pic->ext = '.png';
        }
        $this->set($v);

        $this->render('profile.php');
    }
}
