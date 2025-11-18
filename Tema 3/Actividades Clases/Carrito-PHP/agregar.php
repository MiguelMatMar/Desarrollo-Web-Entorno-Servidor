<?php
    session_start();

    function agregarAlCarrito($id_producto, $cantidad = 1) { // Función para agregar al carrito usando cookies
        $carrito = isset($_COOKIE['carrito']) ? json_decode($_COOKIE['carrito'], true) : []; // Decodificar cookie existente o iniciar array vacío si no existe

        if (isset($carrito[$id_producto])) {
            $carrito[$id_producto]['cantidad'] += $cantidad;
        } else {
            $carrito[$id_producto] = ['cantidad' => $cantidad];
        }

        setcookie('carrito', json_encode($carrito), time() + 86400, "/"); // Guardar cookie actualizada
    }

    // Obtener parámetros (por GET o POST)
    $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : null; // ID del producto a agregar
    $cantidad = isset($_REQUEST['cantidad']) ? intval($_REQUEST['cantidad']) : 1; // Cantidad a agregar (por defecto 1)

    if ($id !== null) { // Si la ID es válida, agregar al carrito
        agregarAlCarrito($id, $cantidad);
    }

    header("Location: carrito.php");
    exit;
?>