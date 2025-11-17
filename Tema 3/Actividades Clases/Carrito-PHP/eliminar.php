<?php
    session_start();

    $id = $_GET['id'] ?? null;

    if ($id && isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array_filter($_SESSION['carrito'], function($item) use ($id) {
            return $item['id'] != $id;
        });
    }

    header("Location: carrito.php");
    exit;
?>