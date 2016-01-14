<?php
namespace controller;

class HomeController extends Controller
{
    public function index($name = 'World')
    {
        $v['username'] = $name;
        $v['age'] = '23';

        $this->set($v);
        $this->render('home.index.php');
    }
}