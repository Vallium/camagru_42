<?php
namespace controller;

abstract class Controller
{
    private $vars = array();
    private $layout = 'default';

    abstract public function index();

    public function set(array $var)
    {
        $this->vars = array_merge($this->vars, $var);
    }

    public function render($view)
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

    public function loadModel($model)
    {
        echo ROOT.'models'.DS.$model.'.php'.PHP_EOL;
        require_once(ROOT.'models'.DS.$model.'.php');
        $this->$model = '\model\\'.$model;
        echo '\model\\'.$model;
        $this->$model = new $model();
    }

}