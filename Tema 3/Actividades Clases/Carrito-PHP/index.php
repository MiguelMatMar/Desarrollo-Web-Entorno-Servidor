<?php
    session_start();

    
    $productos = 
?>

<h1>Tienda</h1>

<?php foreach ($productos as $p): ?>
    <div>
        <h3><?= $p['nombre'] ?></h3>
        <p>Precio: <?= $p['precio'] ?> €</p>
        <a href="agregar.php?id=<?= $p['id'] ?>">🛒 Añadir al carrito</a>
    </div>
    <hr>
<?php endforeach; ?>

<a href="carrito.php">Ver carrito</a>
