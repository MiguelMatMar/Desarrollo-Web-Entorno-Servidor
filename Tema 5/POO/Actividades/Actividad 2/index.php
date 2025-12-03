<?php
// ACTIVIDAD 2: CUENTA BANCARIA (ENCAPSULAMIENTO)
// ==============================================
//
// OBJETIVO:
// Practicar el encapsulamiento protegiendo el saldo de una cuenta.
//
// INSTRUCCIONES:
// 1. Define la clase 'CuentaBancaria'.
// 2. Define una propiedad PRIVADA: saldo (float).
// 3. Crea un constructor que inicialice el saldo (puedes empezar en 0 o recibir un monto).
// 4. Crea un método PÚBLICO 'depositar($monto)' que sume al saldo. Valida que el monto sea positivo.
// 5. Crea un método PÚBLICO 'retirar($monto)' que reste al saldo. 
//    - Valida que el monto sea positivo.
//    - Valida que haya saldo suficiente. Si no, muestra un error.
// 6. Crea un método PÚBLICO 'getSaldo()' que devuelva el saldo actual.
//
// PISTA:
// private $saldo; significa que no puedes hacer $cuenta->saldo = 1000; desde fuera.

class CuentaBancaria {
    // --- TU CÓDIGO AQUÍ ---
    
    // ----------------------
}

// --- ZONA DE PRUEBAS ---
echo "<h3>Prueba Actividad 2</h3>";
if (class_exists('CuentaBancaria')) {
    $cuenta = new CuentaBancaria(100); // Saldo inicial 100
    
    if (method_exists($cuenta, 'getSaldo')) {
        echo "Saldo inicial: " . $cuenta->getSaldo() . "<br>";
    }
    
    if (method_exists($cuenta, 'depositar')) {
        $cuenta->depositar(50);
        echo "Depositados 50. Nuevo saldo (esperado 150): " . $cuenta->getSaldo() . "<br>";
    }
    
    if (method_exists($cuenta, 'retirar')) {
        $cuenta->retirar(200); // Debería fallar
        $cuenta->retirar(30);
        echo "Retirados 30. Nuevo saldo (esperado 120): " . $cuenta->getSaldo() . "<br>";
    }
} else {
    echo "La clase CuentaBancaria aún no ha sido creada.";
}
?>