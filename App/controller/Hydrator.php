<?php

namespace App\controller;

trait Hydrator
{
    public function hydrate($data)
    {
        foreach ($data as $key=>$value){
            $key = str_replace('_', '', $key);
            $method = 'set'.ucfirst($key);
            
            echo $method.'<br>';
            if(method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }
}
