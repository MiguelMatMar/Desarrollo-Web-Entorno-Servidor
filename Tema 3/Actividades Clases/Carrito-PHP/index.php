<?php
require_once 'db.php';

$productos = obtenerProductos($db);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Tienda - Demo Carrito</title>
</head>
<body>
	<h1>Tienda</h1>
	<p><a href="carrito.php">Ver carrito</a> | <a href="registro.php">Registro</a> | <a href="login.php">Login</a> | <a href="cuenta.php">Mi Cuenta</a> </p>

	<?php if (!$productos) { ?>
		<p>No hay productos disponibles.</p>
	<?php } else { ?> <!-- Si hay productos en la base de datos los muestra del array asociativo que nos ha devuelto la funcion -->
		<ul>
		<?php foreach ($productos as $p) { ?>
			<li>
				<strong><?php echo htmlspecialchars($p['nombre']); ?></strong>
				- <?php echo $p['precio']; ?> €
				<a href="agregar.php?id=<?php echo intval($p['id']); ?>">Agregar</a> <!-- Esto lo hacemos para cuando vayamos a agregar un producto en concreto, mandamos el id del producto del array asociativo que hemos mostrado -->
			</li>
		<?php } ?>
		</ul>
	<?php } ?>

</body>
</html>
