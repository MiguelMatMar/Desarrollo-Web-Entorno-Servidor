<?php
    session_start();
    $carrito = $_SESSION['carrito'] ?? [];
    $total = 0;
?>

    <h1>Tu Carrito</h1>

    <?php if (empty($carrito)){ ?>
        <p>El carrito está vacío.</p>
    <?php }else{ ?>
        <ul>
            <?php foreach ($carrito as $item){
                $subtotal = $item['precio'] * $item['cantidad'];
                $total += $subtotal;
            ?>
                <li>
                    <?php echo $item['nombre'] ?> - <?php echo $item['precio'] ?> × <?php echo $item['cantidad'] ?> =
                    <?php echo $subtotal ?> €
                    <a href="eliminar.php?id=<?php echo $item['id'] ?>"> Eliminar </a> <!-- Crea la url para eliminar el id de cada producto-->
                </li>
            <?php }; ?>
        </ul>

        <p><strong>Total:</strong> <?php echo $total ?> €</p>
        <a href="vaciar.php"> Vaciar carrito</a>
    <?php }; ?>

    <br><a href="index.php"> Volver a la tienda</a>