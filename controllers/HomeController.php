<?php
namespace controller;

class HomeController extends Controller
{
//    public function index($name = 'World')

    public function index()
    {
        $this->loadModel('UserModel');
        $this->loadModel('ImageModel');

        $v['home'] = array(
            'images' => $this->ImageModel->getLast(12),
        );

        $this->set($v);
        $this->render('home.php');
    }

//    public function getLastImages()
//    {
//        $this->loadModel('ImageModel');
//    }
}
