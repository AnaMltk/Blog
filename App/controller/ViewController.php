<?php

namespace App\controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ViewController
{
    private $twig;
    public function __construct()
    {

        $loader = new FilesystemLoader('../view');
        $this->twig = new Environment($loader);
    }
    public function display($page, $option){
        echo $this->twig->render($page, $option);
    }

    public function redirect($location)
    {
        header('Location: '.$location);
        exit;
    }
}