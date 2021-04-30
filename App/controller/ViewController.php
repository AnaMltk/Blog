<?php

namespace App\controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ViewController
{
    private $twig;
    public function __construct()
    {

        $loader = new FilesystemLoader('App/view');
        $this->twig = new Environment($loader);
    }
    public function display($page, $option){
        echo $this->twig->render($page, $option);
    }
}