<?php
namespace controller;

abstract class Controller
{
    private $var = array();

    public function set(array $var)
    {
        $this->var = array_merge($this->var, $var);
    }

    public function render($view)
    {
        extract($this->var);
        ob_start();
        require ROOT.DS.'views'.DS.$view;
        $content_for_layout = ob_get_clean();
        require ROOT.DS.'views'.DS.'layout.php';
    }

    abstract public function index();
}