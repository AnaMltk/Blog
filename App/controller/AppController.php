<?php

namespace App\controller;


class AppController
{
    protected $view;
    public function __construct()
    {
        $this->view = new ViewController();
        
    }

    /**
     * @return string
     */
    protected function getToken(): string
    {
        return bin2hex(random_bytes(32));
    }
}
