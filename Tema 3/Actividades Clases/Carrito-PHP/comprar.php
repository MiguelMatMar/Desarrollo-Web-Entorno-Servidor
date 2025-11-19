<?php
    session_start();
    require_once 'db.php';

    if (!isset($_SESSION['usuario_id'])) { // Comprobar si está logueado
        die("Debes iniciar sesión para hacer un pedido.");
    }

    $carrito = isset($_COOKIE['carrito']) ? json_decode($_COOKIE['carrito'], true) : []; // Obtener carrito desde cookie 
    if (empty($carrito)) {
        die("El carrito está vacío.");
    }

    $total = 0;
    foreach ($carrito as $id => $item) { // recorrer carrito para calcular total
        $producto = obtenerProductoPorId($db, intval($id));
        $precio = $producto ? $producto['precio'] : 0;
        $total += $precio * $item['cantidad'];
    }

    // Crear pedido del usuario 
    $pedido_id = crearPedido($db, $_SESSION['usuario_id'], $total);
    if (!$pedido_id) {
        die("Error al crear el pedido.");
    }

    // Insertar detalles
    foreach ($carrito as $id => $item) {
        $producto = obtenerProductoPorId($db, intval($id)); 
        $precio = $producto ? $producto['precio'] : 0;
        insertarDetallePedido($db, $pedido_id, intval($id), $item['cantidad'], $precio);
    }

    // Si el pedido se creó correctamente, vaciar el carrito para no tener los datos duplicados 
    setcookie('carrito', '', time() - 3600, "/");

    echo "Pedido realizado con éxito";
?>