<?php
    session_start();
    require_once 'db.php';

    $carrito_cookie = isset($_COOKIE['carrito']) ? json_decode($_COOKIE['carrito'], true) : []; // Obtener carrito desde cookie, si no existe iniciar array vacío
    $total = 0;
?>

    <h1>Tu Carrito</h1>

    <?php if (empty($carrito_cookie)){ ?>
        <p>El carrito está vacío.</p>
    <?php } else { ?>
        <ul>
            <?php foreach ($carrito_cookie as $id => $item){ // Si el carrito no esta vacío iteramos y mostramos
                $producto = obtenerProductoPorId($db, intval($id)); // 
                if ($producto) { // Si el producto existe calculamos subtotal y total
                    $subtotal = $producto['precio'] * $item['cantidad'];
                    $total += $subtotal;
                }
                
            ?>
                <li> 
                    <?php // Mostramos detalles del producto en el carrito
                        echo htmlspecialchars($producto['nombre'])." - " 
                    ?>  
                    <?php echo $producto['precio']. " x ". $item['cantidad']. " = ". $subtotal. "€" ?>
                    <a href="eliminar.php?id=<?php echo $id ?>"> Eliminar </a>
                </li>
            <?php } ?>
        </ul>

        <?php echo "<strong> Total: $total € </strong>" ?>
        <p><a href="vaciar.php"> Vaciar carrito</a> <a href="comprar.php"> Comprar</a></p>
    <?php } ?>

    <br><a href="index.php"> Volver a la tienda</a>