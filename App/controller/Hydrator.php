<?php

namespace App\controller;

trait Hydrator
{
    /**
     * @param mixed $data
     * 
     * @return void
     */
    public function hydrate($data): void
    {
        foreach ($data as $key=>$value){
            $key = str_replace('_', '', $key);
            $method = 'set'.ucfirst($key);
            
            if(method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }
}
