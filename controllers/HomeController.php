<?php
namespace controller;

class HomeController extends Controller
{
//    public function index($name = 'World')

    public function index()
    {
//        echo 'plop';
        $v = array();
        $v['home'] = array(
            'username' => 'Vallium',
            'age' => '23',
        );

        $this->set($v);
        $this->render('home.index.php');
    }
}