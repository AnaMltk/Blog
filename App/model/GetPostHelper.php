<?php

namespace App\model;

class GetPostHelper
{

    /**
     * @param string|null $key
     * 
     * @return mixed
     */
    public function getPost($key = null)
    {
        if ($key) {
            return $_POST[$key] ?? null;
        }
        return $_POST;
    }
}
