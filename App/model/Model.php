<?php

namespace App\model;


abstract class Model
{
    use Hydrator;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }
}
