<?php

namespace App\controller;


class AppController
{
    protected $view;
    public function __construct()
    {
        $this->view = new ViewController();
        
    }
}
