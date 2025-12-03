<?php
// ACTIVIDAD 3: VEHÍCULOS (HERENCIA)
// =================================
//
// OBJETIVO:
// Entender cómo funciona la herencia y la sobreescritura de métodos.
//
// INSTRUCCIONES:
// 1. Define una clase base 'Vehiculo'.
//    - Propiedades: marca, modelo.
//    - Constructor: recibe marca y modelo.
//    - Método 'mover()': imprime "El vehículo se está moviendo".
//
// 2. Define una clase 'Coche' que extienda de 'Vehiculo'.
//    - Sobreescribe 'mover()': imprime "El coche conduce por la carretera".
//
// 3. Define una clase 'Moto' que extienda de 'Vehiculo'.
//    - Sobreescribe 'mover()': imprime "La moto acelera rápidamente".
//
// 4. Instancia un Coche y una Moto y llama a sus métodos 'mover()'.

class Vehiculo {
    // --- TU CÓDIGO AQUÍ ---
}

class Coche extends Vehiculo {
    // --- TU CÓDIGO AQUÍ ---
}

class Moto extends Vehiculo {
    // --- TU CÓDIGO AQUÍ ---
}

// --- ZONA DE PRUEBAS ---
echo "<h3>Prueba Actividad 3</h3>";
if (class_exists('Coche') && class_exists('Moto')) {
    $coche = new Coche("Toyota", "Corolla");
    echo "Coche: " . (isset($coche->marca) ? $coche->marca : '') . "<br>";
    $coche->mover(); // Debería decir algo específico de coche
    echo "<br>";

    $moto = new Moto("Yamaha", "R1");
    echo "Moto: " . (isset($moto->marca) ? $moto->marca : '') . "<br>";
    $moto->mover(); // Debería decir algo específico de moto
} else {
    echo "Las clases Coche y Moto aún no han sido creadas correctamente.";
}
?>