<?php

    // Primer ejemplo de clases

    // 1. Define la CLASE (molde)
    
    class Producto {
        public $nombre;
        public $precio;
        
        // Constructor

        public function __construct($nombreRecibido,$precioRecibido){
            $this->nombre = $nombreRecibido;
            $this->precio = $precioRecibido;
        }

        // Setters
            public function setNombre($nombre){
                $this -> nombre = $nombre;
            }
            public function setPrecio($precio){
                $this -> precio = $precio;
            }
        // Getters
            public function getNombre(){
                return $this->nombre;
            }
            public function getPrecio(){
                return $this-> precio;
            }



    }

    class Tienda{

        private $carrito = [];

        // No tiene constructor

        public function insertarCarrito($producto){
            if (is_object($producto)) {
                array_push($this->carrito, $producto);
            }
        }
        public function mostrarCarrito(){
            foreach($this->carrito as $producto){
                echo "Nombre Producto: ".$producto-> nombre.", precio del producto: ". $producto-> precio. " € <br>";
            }
        }
        public function reiniciarCarrito(){
            $this -> $carrito = [];
        }

    }

    $producto1 = new Producto("Pasta dental",2);
    $producto2 = new Producto("Carne Vacuna 500g", 13.99);

    $tienda = new Tienda;

    $tienda -> insertarCarrito($producto1);
    $tienda -> insertarCarrito($producto2);
    $tienda -> mostrarCarrito();


?>