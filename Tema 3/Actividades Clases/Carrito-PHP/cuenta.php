<?php
session_start();
require_once 'db.php';

$logged = isset($_SESSION['usuario_id']);

// Si se solicita ver detalles de un pedido
$ver_pedido = isset($_GET['pedido']) ? intval($_GET['pedido']) : null;

if ($logged) {
    $user_id = $_SESSION['usuario_id'];
    $pedidos = obtenerPedidosPorUsuario($db, $user_id);
} else {
    $pedidos = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Mi cuenta</title>
</head>
<body>
    <h1>Mi cuenta</h1>
    <p><a href="index.php">Tienda</a> | <a href="carrito.php">Ver carrito</a>
    <?php // Si el usuario esta logueado que le muestre para cerrar sesion
    if ($logged) { ?> | <a href="logout.php">Cerrar sesión</a><?php } ?>
    </p>

    <?php if (!$logged)  {  // Si no esta logueado que le muestre los formularios de inicio o registro?>
        <h2>Acceder</h2>
        <form method="post" action="login.php">
            <label>Email</label><br>
            <input type="email" name="email" required><br>
            <label>Contraseña</label><br>
            <input type="password" name="password" required><br>
            <button type="submit">Iniciar sesión</button>
        </form>

        <h2>Registro</h2>
        <form method="post" action="registro.php">
            <label>Nombre</label><br>
            <input type="text" name="nombre" required><br>
            <label>Email</label><br>
            <input type="email" name="email" required><br>
            <label>Contraseña</label><br>
            <input type="password" name="password" required minlength="6"><br>
            <button type="submit">Registrarse</button>
        </form>
    <?php } else { // Si esta logueado entoncemos comprobamos si ha hecho pedidos ?>
        <h2>Tus pedidos</h2>
        <?php if (empty($pedidos)) {   // Si hacemos la consulta y los pedidos estan vacios entonces le devolvemos que no se ha realizado pedidos todavia?> 
            <p>No has realizado pedidos todavía.</p>
        <?php } else { // Si si existen los pedidos entonces se lo mostramos ?>
            <ul>
                <?php foreach ($pedidos as $p) { ?>
                    <li>
                        Pedido #<?php echo intval($p['id']); ?> - Total: <?php echo $p['total']; ?> € - Fecha: <?php echo $p['fecha']; ?>
                        - <a href="cuenta.php?pedido=<?php echo intval($p['id']); ?>">Ver detalles</a> 
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>

            <?php if ($ver_pedido) { // Si el usuario le da a un enlace para mostrar los detalles de un pedido entonces, se obtiene el id de un pedido y llamamos a la funcion  para obtener un array asociativo y mostrar los pedidos  
            $detalles = obtenerDetallePedido($db, $ver_pedido);
            if ($detalles) { // Si hay detalles del pedido entonces mostramos
                echo '<h3>Detalles del pedido #' . intval($ver_pedido) . '</h3>';
                echo '<ul>';
                foreach ($detalles as $d) {
                    echo '<li>' . htmlspecialchars($d['nombre']) . ' - ' . intval($d['cantidad']) . ' × ' . $d['precio'] . ' €</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>No se encontraron detalles para ese pedido.</p>';
            }
        }
        ?>
    <?php } ?>

</body>
</html>
