<?php
// ACTIVIDAD 1: CLASE PRODUCTO
// ===========================
//
// OBJETIVO:
// Crear una clase 'Producto' que represente un artículo en una tienda.
//
// INSTRUCCIONES:
// 1. Define la clase 'Producto'.
// 2. Define las propiedades PÚBLICAS: nombre (string), precio (float), stock (int).
// 3. Crea un CONSTRUCTOR que reciba nombre, precio y stock inicial.
// 4. Crea un método 'actualizarStock($cantidad)' que sume (o reste si es negativo) al stock actual.
// 5. Crea un método 'calcularValorTotal()' que devuelva el precio multiplicado por el stock.
//
// PISTA:
// $this->propiedad se usa para acceder a las propiedades de la clase.

class Producto {
    // --- TU CÓDIGO AQUÍ ---

    // Propiedades
    public $nombre;
    public $stock;
    public $precio;
    // Constructor
    public function __construct($nombre,$precio,$stock){
        $this -> nombre = $nombre;
        $this -> stock = $stock;
        $this -> precio = $precio;
    }
    // Métodos
    public function actualizarStock($cantidad){
        if($cantidad> 0){
            $this -> stock -= $cantidad;
        }else if($cantidad < 0){
            $this -> stock += $cantidad;
        }else{
            return "Error";
        }
    }
    public function calcularValorTotal(){
        return $this->stock * $this->precio;
    }
    // ----------------------
}

// --- ZONA DE PRUEBAS (NO MODIFICAR, SOLO EJECUTAR) ---
echo "<h3>Prueba Actividad 1</h3>";
if (class_exists('Producto')) {
    $p = new Producto("Laptop", 800.00, 10);
    echo "Producto creado: " . (isset($p->nombre) ? $p->nombre : 'Sin nombre') . "<br>";
    
    if (method_exists($p, 'actualizarStock')) {
        $p->actualizarStock(-2); // Vendemos 2
        echo "Stock actualizado (esperado 8): " . (isset($p->stock) ? $p->stock : 'N/A') . "<br>";
    }
    
    if (method_exists($p, 'calcularValorTotal')) {
        echo "Valor total inventario (esperado 6400): " . $p->calcularValorTotal() . "<br>";
    }
} else {
    echo "La clase Producto aún no ha sido creada.";
}
?>