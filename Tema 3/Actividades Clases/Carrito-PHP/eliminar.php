<?php
    session_start();

    function eliminarDelCarrito($id_producto) {
        $carrito = isset($_COOKIE['carrito']) ? json_decode($_COOKIE['carrito'], true) : [];
        if (isset($carrito[$id_producto])) {
            unset($carrito[$id_producto]);
            setcookie('carrito', json_encode($carrito), time() + 86400, "/");
        }
    }

    $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : null;
    if ($id !== null) {
        eliminarDelCarrito($id);
    }

    header("Location: carrito.php");
    exit;
?>