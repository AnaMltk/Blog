<?php

namespace App\controller;

class Session
{
    /* static $instance;

    static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Session();
        }
        return self::$instance;
    }*/

    /*public function __construct()
    {
        session_start();
    }*/

    public function write($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function read($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function delete()
    {
        return $_SESSION = array();
    }
}
