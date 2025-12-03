<?php

    trait mensaje1{
        public function msg1(){
            echo "Bienvenidoooo";
        }
    }
    class Bienvenido{
        use mensaje1;
    }

    $obj1 = new Bienvenido();
    $obj1 ->msg1();

?>