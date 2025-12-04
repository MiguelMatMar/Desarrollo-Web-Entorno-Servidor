<?php

/**
 * Autoloader Básico basado en PSR-4
 *
 * Registra una función de autoload que busca la clase en la carpeta 'src'.
 */

spl_autoload_register(function ($claseCompleta) {
    // Definimos el prefijo del namespace de nuestro proyecto
    $prefijo = 'App\\';
    
    // Definimos la carpeta base donde se encuentran nuestros archivos de clases
    $carpetaBase = __DIR__ . '/src/';

    // Si la clase no usa nuestro prefijo, la ignoramos.
    $longitudPrefijo = strlen($prefijo);
    if (strncmp($prefijo, $claseCompleta, $longitudPrefijo) !== 0) {
        return;
    }

    // Obtenemos el nombre de la clase relativo (sin el prefijo 'App\')
    $claseRelativa = substr($claseCompleta, $longitudPrefijo);

    // Creamos la ruta del archivo:
    // 1. Reemplazamos el separador de namespace (\) por el separador de directorio (/)
    // 2. Añadimos la carpeta base ('src/')
    // 3. Añadimos la extensión '.php'
    $archivo = $carpetaBase. str_replace('\\', '/', $claseRelativa). '.php';

    // Si el archivo existe, lo incluimos.
    if (file_exists($archivo)) {
        require_once $archivo;
    }
});

//
