<?php
namespace controller;

$nb_img_on_gallery_load = 12;

class HomeController extends Controller
{
    public function index()
    {
        $this->loadModel('ImageModel');

        $v['home'] = array(
            'images' => $this->ImageModel->getLast($GLOBALS['nb_img_on_gallery_load']),
            'nb_photos' => $this->ImageModel->countAll()
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
