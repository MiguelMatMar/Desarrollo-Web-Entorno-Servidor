<?php
    $pageTitle = 'Mis Pedidos';
        // Cabeceras y funciones
        if (session_status() === PHP_SESSION_NONE) session_start();
        require_once __DIR__ . '/../templates/_headers.php';
        require_once __DIR__ . '/../src/functions.php';

        // Si no hay usuario logueado, forzamos login
        if (!isset($_SESSION['user']['id'])) {
                header('Location: /login.php');
                exit;
        }

        $usuario_id = (int)$_SESSION['user']['id'];
        $pedidos = obtenerPedidosPorUsuario($usuario_id);
?>

<?php if ($pedidos === false): ?>
    <div class="alert alert-warning">No se han podido cargar los pedidos. Inténtalo de nuevo más tarde.</div>
<?php elseif (empty($pedidos)): ?>
    <div class="alert alert-info">No tienes pedidos todavía. <a href="/">Ver productos</a></div>
<?php else: ?>
    <?php foreach ($pedidos as $pedido):
        $pid = $pedido['id'] ?? null;
        $fecha = isset($pedido['fecha']) ? date('d/m/Y H:i', strtotime($pedido['fecha'])) : '';
        $total = isset($pedido['total']) ? number_format((float)$pedido['total'], 2) : '0.00';
        $detalles = $pid ? obtenerDetallePedido($pid) : false;
    ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Pedido #<?= htmlspecialchars($pid) ?></strong>
                <span class="pull-right"><?= htmlspecialchars($fecha) ?> &nbsp; - &nbsp; <strong>€ <?= $total ?></strong></span>
            </div>
            <div class="panel-body">
                <?php if ($detalles === false): ?>
                    <div class="alert alert-warning">No se pudieron cargar los detalles de este pedido.</div>
                <?php elseif (empty($detalles)): ?>
                    <div class="text-muted">Este pedido no contiene líneas.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-right">Precio</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $subTotalCalc = 0; foreach ($detalles as $d):
                                    $nombre = $d['nombre'] ?? 'Producto';
                                    $cantidad = isset($d['cantidad']) ? (int)$d['cantidad'] : 0;
                                    $precio = isset($d['precio']) ? (float)$d['precio'] : 0.0;
                                    $sub = $cantidad * $precio;
                                    $subTotalCalc += $sub;
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($nombre) ?></td>
                                        <td class="text-center"><?= $cantidad ?></td>
                                        <td class="text-right">€ <?= number_format($precio, 2) ?></td>
                                        <td class="text-right">€ <?= number_format($sub, 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right"><strong>Subtotal calculado: € <?= number_format($subTotalCalc, 2) ?></strong></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</div>
</body>
</html>