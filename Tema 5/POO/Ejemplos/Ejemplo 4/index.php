<?php

    // INTERFAZ: define qué debe hacer un arma o luchador que use espada
    interface Espada {
        public function atacar($objetivo);
        public function getDamage();
    }

    // CLASE ABSTRACTA: plantilla para todos los guerreros
    abstract class Guerrero implements Espada {

        protected $vida;
        protected $fuerza;

        // Constructor
        public function __construct($vida, $fuerza){
            $this->vida = $vida;
            $this->fuerza = $fuerza;
        }

        // La clase abstracta implementa parte del comportamiento,
        // pero sigue siendo pública porque la interfaz lo exige.
        public function atacar($objetivo){
            echo "$objetivo sufrió {$this->getDamage()} de daño<br>";
        }

        // Forzamos a que cada guerrero calcule su daño de forma distinta
        abstract public function getDamage();
    }
    class GuerreroLigero extends Guerrero {
        public function getDamage(){
            return $this->fuerza * 1.2;
        }
    }

    class GuerreroPesado extends Guerrero {
        public function getDamage(){
            return $this->fuerza * 2;
        }
    }

    

    // Probamos el polimorfismo:
    $g1 = new GuerreroLigero(100, 10);
    $g2 = new GuerreroPesado(150, 10);

    $g1->atacar("Orco");  // Usa daño 1.2x
    $g2->atacar("Orco");  // Usa daño 2x

?>
