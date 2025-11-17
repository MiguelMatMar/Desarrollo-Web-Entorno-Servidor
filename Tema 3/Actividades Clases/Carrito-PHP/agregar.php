<?php
    session_start();

    $productos = [
        1 => ['id' => 1, 'nombre' => 'Espada Élfica', 'precio' => 120],
        2 => ['id' => 2, 'nombre' => 'Armadura de Acero', 'precio' => 300],
        3 => ['id' => 3, 'nombre' => 'Poción de Salud', 'precio' => 50]
    ];

    $id = $_GET['id'] ?? null;

    if ($id && isset($productos[$id])) {
        $producto = $productos[$id];

        // Si no existe el carrito, se crea
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Buscar si el producto ya existe en el carrito
        $encontrado = false;
        foreach ($_SESSION['carrito'] as &$item) { // Paso por valor para modificarlo
            if ($item['id'] == $id) {
                $item['cantidad']++;
                $encontrado = true;
                break;
            }
        }

        // Si no estaba en el carrito, se añade
        if (!$encontrado) {
            $producto['cantidad'] = 1;
            $_SESSION['carrito'][] = $producto;
        }
    }

    header("Location: carrito.php");
    exit;
?>