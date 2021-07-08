<?php

namespace App\controller;


class AppController
{
    protected $view;
    public function __construct()
    {
        $this->view = new ViewController();
        
    }

    protected function getToken()
    {
        return bin2hex(random_bytes(32));
    }
}
