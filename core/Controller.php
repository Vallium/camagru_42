<?php
namespace controller;

abstract class Controller
{
    private $vars = array();
    private $layout = 'default';

    public function index()
    {
        $this->render('404.php');
    }

    public function notFound()
    {
        $this->render('404.php');
    }

    public function set(array $var)
    {
        $this->vars = array_merge($this->vars, $var);
    }

    protected function render($view)
    {
        extract($this->vars);

        ob_start();
        require (ROOT.'views'.DS.$view);
        $content_for_layout = ob_get_clean();

        if ($this->layout == false)
            echo $content_for_layout;
        else
            require ROOT.'views'.DS.'layout'.DS.$this->layout.'.php';
    }

    protected function loadModel($model)
    {
        require_once(ROOT.'models'.DS.$model.'.php');
        $modelname = '\model\\'.$model;

        $this->$model= new $modelname();
    }
}