<?php
  require_once __DIR__ . '/db.php';

  // MIS FUNCIONES PARA LA BASE DE DATOS // 
  function getAllProducts(): array {
    // Usa la conexión definida en src/db.php
    global $db;
    $products = [];
    if (!isset($db) || !$db) {
      return $products;
    }
    $result = mysqli_query($db, "SELECT * FROM productos");
    if (!$result){ 
        return $products;
    }
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC); // Obtener todos los productos como un array asociativo
    mysqli_free_result($result);
    
    foreach ($rows as $row) {
      $p = [];
      // nombre / name
      $p['name'] = $row['nombre'];
      
      // description /
      $p['description'] = $row['description']; 

      // precio
      $p['price'] = (float)$row['precio'];
      
      // stars 
      $p['stars'] = (int)$row['stars'];
      
      // image
      $p['image'] = $row['image'];
      
      $products[$row['id']] = $p;
      
    }
    return $products;
  }

  function crearPedido($usuario_id, $total) { // Inserta en los pedidos el ID del usuario y el total del pedido
    global $db;
    $stmt = mysqli_prepare($db, "INSERT INTO pedidos (usuario_id, total) VALUES (?, ?)");
    if (!$stmt){ 
        return false;
    }
    mysqli_stmt_bind_param($stmt, "id", $usuario_id, $total);
    $ok = mysqli_stmt_execute($stmt);
    if (!$ok) {
        mysqli_stmt_close($stmt);
        return false;
    }
    $pedido_id = mysqli_insert_id($db);
    mysqli_stmt_close($stmt);
    return $pedido_id;
}

function insertarDetallePedido($pedido_id, $producto_id, $cantidad, $precio) { // Inserta los pedidos de los productos que ha hecho el usuario y el id del pedido en concreto
    global $db;
    $stmt = mysqli_prepare($db, "INSERT INTO pedido_detalle (pedido_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
    if (!$stmt){ 
        return false;
    }
    mysqli_stmt_bind_param($stmt, "iiid", $pedido_id, $producto_id, $cantidad, $precio);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function obtenerPedidosPorUsuario($usuario_id) { // Obtiene los pedidos que ha hecho el usuario, solamente el pedido no los detalles
    global $db;
    $stmt = mysqli_prepare($db, "SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY fecha DESC");
    if (!$stmt){ 
        return false;
    }
    mysqli_stmt_bind_param($stmt, "i", $usuario_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        mysqli_stmt_close($stmt);
        return false;
    }
    $pedidos = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $pedidos;
}

function obtenerDetallePedido($pedido_id) { // Obtenemos los detalles de cada pedido que ha hecho el cliente
    global $db;
    $stmt = mysqli_prepare($db, "SELECT pd.*, p.nombre FROM pedido_detalle pd LEFT JOIN productos p ON pd.producto_id = p.id WHERE pd.pedido_id = ?");
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "i", $pedido_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        mysqli_stmt_close($stmt);
        return false;
    }
    $detalles = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $detalles;
}

function loginUsr($email, $password) { // Función para loguear al usuario
    global $db;
    $stmt = mysqli_prepare($db, "SELECT * FROM usuarios WHERE email = ?");
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        mysqli_stmt_close($stmt);
        return false;
    }
    $user = mysqli_fetch_assoc($result); // Devuelve el usuario como un array asociativo
    mysqli_stmt_close($stmt);
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

function registerUsr($username, $email, $password) { // Función para registrar al usuario
    global $db;
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($db, "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password_hash);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

// FUNCIONES DEL PROFESOR // 
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
function displayProducts(): void{
  
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