<?php
    session_start();
    setcookie('carrito', '', time() - 3600, "/"); // Elimina la cookie del carrito estableciendo una fecha de expiración pasada
    header("Location: carrito.php");
    exit;
?>