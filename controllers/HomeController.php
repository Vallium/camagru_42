<?php
namespace controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->loadModel('ImageModel');

        $v['home'] = array(
            'images' => $this->ImageModel->getLast(12),
        );

        foreach($v['home']['images'] as $img)
        {
            if (file_exists(ROOT.'web'.DS.'img/uploads/'.$img->id.'.jpg'))
                $img->ext = '.jpg';
            elseif (file_exists(ROOT.'web'.DS.'img/uploads/'.$img->id.'.png'))
                $img->ext = '.png';
        }
        $this->set($v);
        $this->render('home.php');
    }
}
