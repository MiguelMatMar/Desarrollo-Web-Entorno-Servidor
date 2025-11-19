<?php
    session_start();

    function eliminarDelCarrito($id_producto) { // Para eliminar un producto del carrito segun el id del producto en el array asociativo de la cookie
        $carrito = isset($_COOKIE['carrito']) ? json_decode($_COOKIE['carrito'], true) : [];
        if (isset($carrito[$id_producto])) {
            unset($carrito[$id_producto]);
            setcookie('carrito', json_encode($carrito), time() + 86400, "/");
        }
    }

    $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : null;
    if ($id !== null) {
        eliminarDelCarrito($id); // Llamamos a la funcion 
    }

    header("Location: carrito.php");
    exit;
?>