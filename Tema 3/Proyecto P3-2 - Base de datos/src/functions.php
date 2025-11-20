<?php
    function starsHtml($stars): string {
        $s = '';
        $noEstrella = 5 - $stars;
        for($estrella = 0; $estrella < $stars; $estrella++){
            $s .= '<span class="glyphicon glyphicon-star"></span>';
        }
        for($a = 0; $a < $noEstrella; $a++){
            $s .= '<span class="glyphicon glyphicon-star-empty"></span>';
        }
        return $s;
    }
    // --- DATOS DE PRODUCTOS (Listado 15-8) ---
function getAllProducts(): array
{
  $products = [];
  $products['010'] = ['name' => 'Sandwich', 'description' => '...', 'price' => 1.00, 'stars' => 4, 'image' => 'peanut_butter.png'];
  $products['025'] = ['name' => 'Slice of cheesecake', 'description' => '...', 'price' => 2.00, 'stars' => 5, 'image' => 'chocolate_cheese_cake.png'];
  $products['005'] = ['name' => 'Pineapple', 'description' => '...', 'price' => 3.00, 'stars' => 2, 'image' => 'pineapple.png'];
  $products['021'] = ['name' => 'Jelly donut', 'description' => '...', 'price' => 4.50, 'stars' => 3, 'image' => 'jellydonut.png'];
  $products['002'] = ['name' => 'Banana', 'description' => '...', 'price' => 0.50, 'stars' => 5, 'image' => 'banana.png'];
  return $products;
}

// --- OBTENER CARRITO (Listado 15-16) ---
function getShoppingCart(): array
{
  // El valor por defecto es un array de carrito de compras vacío
  $cartItems = [];
  if (isset($_SESSION['cart'])) {
    $cartItems = $_SESSION['cart'];
  }
  return $cartItems;
}

// --- MANIPULACIÓN DEL CARRITO (Listados 15-17 a 15-21) ---
function addItemToCart($id): void
{
  $cartItems = getShoppingCart();
  $cartItems[$id] = 1;
  $_SESSION['cart'] = $cartItems;
}

function removeItemFromCart($id): void
{
  $cartItems = getShoppingCart();
  unset($cartItems[$id]);
  $_SESSION['cart'] = $cartItems;
}

function getQuantity($id, $cart): int
{
  if (isset($cart[$id])) {
    return $cart[$id];
  }
  return 0;
}

function increaseCartQuantity($id): void
{
  $cartItems = getShoppingCart();
  $quantity = getQuantity($id, $cartItems);
  $newQuantity = $quantity + 1;
  $cartItems[$id] = $newQuantity;
  $_SESSION['cart'] = $cartItems;
}

function reduceCartQuantity($id): void
{
  $cartItems = getShoppingCart();
  $quantity = getQuantity($id, $cartItems);
  $newQuantity = $quantity - 1;
  if ($newQuantity < 1) {
    unset($cartItems[$id]);
  } else {
    $cartItems[$id] = $newQuantity;
  }
  $_SESSION['cart'] = $cartItems;
}

// --- FUNCIONES DE VISUALIZACIÓN (Listado 15-23) ---
function displayProducts(): void
{
  $products = getAllProducts();
  require_once __DIR__ . '/../templates/list.php';
}

function displayCart(): void
{
  $products = getAllProducts();
  $cartItems = getShoppingCart();
  if (!empty($cartItems)) {
    require_once __DIR__ . '/../templates/cart.php';
  } else {
    require_once __DIR__ . '/../templates/emptyCart.php';
  }
}
?>