<?php

namespace App\Utils;

/**
 * Clase de ejemplo para demostrar namespaces y autoloading.
 */
class Calculadora
{
    /**
     * Suma dos números.
     *
     * @param int|float $a
     * @param int|float $b
     * @return int|float
     */
    public function sumar($a, $b)
    {
        return $a + $b;
    }

    /**
     * Muestra el namespace completo de la clase.
     *
     * @return string
     */
    public function getClase()
    {
        // La constante mágica __NAMESPACE__ devuelve el nombre del namespace
        return __NAMESPACE__ . '\\' . (new \ReflectionClass($this))->getShortName();
    }
}