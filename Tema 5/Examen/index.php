<?php
    // Interfaces
    interface Vendible{
        public function vender():bool;
        public function getTotalConImpuestos():float; 
    }

    // Trait
    trait LoggerTrait{
        public static function log(string $mensaje){
            echo "<br>[LOG] $mensaje". PHP_EOL;
        }
    }

    // Clase base
    abstract class ProductoBase implements Vendible{
        public function __construct(
            protected int $idProducto,
            protected string $nombreProducto,
            protected float $precioProducto
        ){}

        public function setIdProducto($id){
            $this->idProducto = $id; 
        }
        public function setNombreProducto($nombre){
            $this->nombreProducto = $nombre; 
        }
        public function setPrecioProducto($precio){
            $this->precioProducto = $precio; 
        }

        public function getIdProducto(){ 
            return $this->idProducto; 
        }
        public function getNombreProducto(){ 
            return $this->nombreProducto; 
        }
        public function getPrecioProducto(){ 
            return $this->precioProducto; 
        }

        abstract function calcularImpuesto() : float;

        public function vender():bool{
            return true;
        }

        public function getTotalConImpuestos():float{
            return $this->precioProducto + $this->calcularImpuesto();
        }

    }

    // Productos
    class ProductoFisico extends ProductoBase{
        public function calcularImpuesto(): float {
            return $this->precioProducto * 0.21; 
        }

    }
    class ProductoDigital extends ProductoBase{
        public function calcularImpuesto():float{
            return $this->precioProducto * 0.10;
        }
    }

    // Carrito
    class Carrito{
        private array $productos = [];
        use LoggerTrait;

        public function addProducto(ProductoBase $producto){
            $this->productos[] = $producto;
            self::log("Producto Insertado");
        }

        public function totalCarrito(){
            if(count($this->productos) === 0){
                throw new Exception("CarritoVacio");
            }

            $total = 0;

            foreach($this->productos as $producto){
                if($producto->vender()){
                    $total += $producto->getTotalConImpuestos();
                }
                
            }

            self::log("Total del carrito:");

            return $total;
        }

    }
    class Categoria {
        private array $productos = []; 

        public function __construct(
            private int $idCategoria,
            private string $nombreCategoria
        ){}

        // Setters
        public function setIdCategoria(int $id){
            $this->idCategoria = $id;
        }

        public function setNombreCategoria(string $nombre){
            $this->nombreCategoria = $nombre;
        }

        // Getters
        public function getIdCategoria(){
            return $this->idCategoria;
        }

        public function getNombreCategoria(){
            return $this->nombreCategoria;
        }

        public function getProductos(){
            return $this->productos;
        }

        // Asociar productos a la categoría
        public function addProducto(ProductoBase $producto){
            $this->productos[] = $producto;
            echo "<br>Producto '{$producto->getNombreProducto()}' agregado a la categoría '{$this->nombreCategoria}'.";
        }

        // Eliminar productos por su ID
        public function removeProducto(int $idProducto){
            foreach($this->productos as $index => $producto){
                if($producto->getIdProducto() == $idProducto){
                    unset($this->productos[$index]);
                    echo "<br>Producto con ID $idProducto eliminado de '{$this->nombreCategoria}'.";
                    return;
                }
            }
            echo "<br>No se encontró producto con ID $idProducto en la categoría '{$this->nombreCategoria}'.";
        }

        // Mostrar todos los productos
        public function listarProductos(){
            echo "<br><strong>Productos en la categoría '{$this->nombreCategoria}':</strong><br>";

            if(empty($this->productos)){
                echo "No hay productos en esta categoría.<br>";
                return;
            }

            foreach($this->productos as $producto){
                echo "- {$producto->getNombreProducto()} (ID: {$producto->getIdProducto()})<br>";
            }
        }

        // Obtener total con impuestos de todos los productos de la categoría
        public function getTotalConImpuestos(){
            $total = 0;

            foreach($this->productos as $producto){
                $total += $producto->getTotalConImpuestos();
            }

            return $total;
        }
    }

?>
