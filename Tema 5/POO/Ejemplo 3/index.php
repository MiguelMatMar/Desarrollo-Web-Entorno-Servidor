<?php

    // Clase abstracta
    abstract class Vehiculo {

        public $peso;
        public $caballos;
        public $tipoCombustible;
        public $nombreVehiculo;

        public function __construct($peso, $caballos, $tipoCombustible, $nombreVehiculo){
            $this->peso = $peso;
            $this->caballos = $caballos;
            $this->tipoCombustible = $tipoCombustible;
            $this->nombreVehiculo = $nombreVehiculo;
        }

        /* Setters */
        public function setPeso($peso){
            $this->peso = $peso;
        }
        public function setCaballos($caballos){
            $this->caballos = $caballos;
        }
        public function setTipoCombustible($tipoCombustible){
            $this->tipoCombustible = $tipoCombustible;
        }
        public function setNombreVehiculo($nombreVehiculo){
            $this->nombreVehiculo = $nombreVehiculo;
        }

        /* Getters */
        public function getPeso(){
            return $this->peso;
        }
        public function getCaballos(){
            return $this->caballos;
        }
        public function getTipoCombustible(){
            return $this->tipoCombustible;
        }
        public function getNombreVehiculo(){
            return $this->nombreVehiculo;
        }

        // Método abstracto obligatorio para las clases hijas
        abstract protected function mostrarCaracteristicas();
    }


    class Coche extends Vehiculo {
        public function mostrarCaracteristicas(){
            return [
                'peso' => $this->peso,
                'caballos' => $this->caballos,
                'tipoCombustible' => $this->tipoCombustible,
                'nombreVehiculo' => $this->nombreVehiculo
            ];
        }
    }


    $coche1 = new Coche(200, 100, "Diesel", "Aorus");

    echo "<h2> Las caracteristicas del coche son: </h2>";

    foreach($coche1->mostrarCaracteristicas() as $caracteristica => $valor){
        echo "<p> $caracteristica -> $valor </p>";
    }

?>
