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

    /**
     * @param mixed $page
     * @param mixed $option
     * 
     * @return void
     */
    public function display($page, $option):void
    {
        echo $this->twig->render($page, $option);
    }

    /**
     * @param mixed $location
     * 
     * @return void
     */
    public function redirect($location):void
    {
        header('Location: ' . $location);
        exit;
    }
}
