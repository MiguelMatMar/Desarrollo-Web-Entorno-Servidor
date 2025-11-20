<?php
session_start();
require_once __DIR__ . '/../src/functions.php';

// Intentar encontrar "action" en las variables de cadena de consulta
$action = filter_input(INPUT_GET, 'action');
switch ($action){
    case 'cart':
        displayCart();
        break;
    
    case 'addToCart':
        $id = filter_input(INPUT_GET, 'id');
        addItemToCart($id);
        displayCart();
        break;
    
    case 'removeFromCart':
        $id = filter_input(INPUT_GET, 'id');
        removeItemFromCart($id);
        displayCart();
        break;
    
    case 'changeCartQuantity':
        $id = filter_input(INPUT_GET, 'id');
        $changeDirection = filter_input(INPUT_POST, 'changeDirection');
        if ($changeDirection == 'increase') {
            increaseCartQuantity($id);
        } else {
            reduceCartQuantity($id);
        }
        displayCart();
        break;
    case 'checkout':
        // Create order from session cart
        $cartItems = getShoppingCart();
        $products = getAllProducts();
        if (empty($cartItems)) {
            displayCart();
            break;
        }
        // Si el usuario no está logueado, redirigir al inicio
        $user_id = isset($_SESSION['user_id']) ?  header('Location: /') : 1;
        $total = 0.0;
        foreach ($cartItems as $pid => $qty) {
            if (!isset($products[$pid])) continue;
            $total += $products[$pid]['price'] * $qty;
        }
        $pedido_id = crearPedido($user_id, $total);
        if ($pedido_id === false) {
            // failure creating order — show cart with message
            $_SESSION['flash'] = 'Unable to create order. Please try again.';
            displayCart();
            break;
        }
        // insert order details
        foreach ($cartItems as $pid => $qty) {
            if (!isset($products[$pid])) continue;
            $precio = $products[$pid]['price'];
            insertarDetallePedido($pedido_id, (int)$pid, (int)$qty, (float)$precio);
        }
        // clear cart
        unset($_SESSION['cart']);
        $_SESSION['flash'] = "Order #$pedido_id created successfully.";
        header('Location: /');
        exit;
    
    default:
        displayProducts();
}
?>