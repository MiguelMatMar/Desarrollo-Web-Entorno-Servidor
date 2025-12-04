<?php

namespace App\Utils;

class Calculadora{

    private $a;
    private $b;

    public function sumar($a, $b){
        return $a + $b;
    }
    
    public function getClase(){
        return __NAMESPACE__ . '\\' . (new \ReflectionClass($this))->getShortName();
    }
}