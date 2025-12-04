<?php

// Incluimos el autoloader para que se registre la función de carga de clases
require_once 'autoloader.php';

// Importamos la clase usando su namespace completo para poder referirnos a ella
// simplemente como 'Calculadora' en el código.
use App\Utils\Calculadora;
use App\Views\TablaGenerator;

echo "<h1>Proyecto de Autoloading y Namespaces en PHP</h1>";
echo "<hr>";

// 1. Instanciamos la clase. El autoloader se encarga de encontrar y cargar
// el archivo 'src/Utils/Calculadora.php' automáticamente.
$calc = new Calculadora();
$numeroA = 15;
$numeroB = 7;

// 2. Usamos las tablas
$tabla1 = new TablaGenerator();

echo "<h2>1. Prueba de Namespace y Autoloading</h2>";
echo "<p>Clase instanciada: <strong>" . $calc->getClase() . "</strong></p>";

// 2. Usamos el método de la clase
$resultado = $calc->sumar($numeroA, $numeroB);

echo "<h2>2. Ejecución del Método</h2>";
echo "<p>Operación: {$numeroA} + {$numeroB}</p>";
echo "<p>Resultado: <strong>{$resultado}</strong></p>";

echo "<h1> Generamos una tabla </h1>";
echo $tabla1->generateTable();

echo "<hr>";
echo "<p>¡El autoloader y el namespace están funcionando correctamente!</p>";