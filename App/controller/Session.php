<?php

namespace App\controller;

class Session
{

    /**
     * @param mixed $key
     * @param mixed $value
     * 
     * @return void
     */
    public function write($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param mixed $key
     * 
     * @return array|null
     */
    public function read($key)
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * @return array
     */
    public function delete(): array
    {
        return $_SESSION = array();
    }
}
