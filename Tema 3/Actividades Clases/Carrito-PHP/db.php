<?php
 // Conexión a la base de datos y funciones de acceso a datos, para tenerlo todo en un solo archivo centralizado
    $host = "localhost";
    $username = "root";
    $passwd = "";
    $dbName = "carrito_php";

    $db = mysqli_connect($host,$username,$passwd,$dbName);

    if(mysqli_connect_errno()){
        mysqli_close($db);
        header("Location: index.html");
        exit();
    }

    function obtenerProductos($db) { // Función para obtener todos los productos en un array asociativo
        $result = mysqli_query($db, "SELECT * FROM productos");
        if (!$result){ 
            return false;
        }
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC); // Obtener todos los productos como un array asociativo
        mysqli_free_result($result);
        return $rows;
    }

    function obtenerProductoPorId($db, $id) { // Función para obtener un producto por su ID, devuelve false si no existe
        $stmt = mysqli_prepare($db, "SELECT * FROM productos WHERE id = ?");
        if (!$stmt){
            return false;
        } 
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt); // Array asociativo del producto
        if (!$result) {
            mysqli_stmt_close($stmt);
            return false;
        }
        $producto = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $producto;
    }

    function crearPedido($db, $usuario_id, $total) {
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

    function insertarDetallePedido($db, $pedido_id, $producto_id, $cantidad, $precio) {
        $stmt = mysqli_prepare($db, "INSERT INTO pedido_detalle (pedido_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
        if (!$stmt){ 
            return false;
        }
        mysqli_stmt_bind_param($stmt, "iiid", $pedido_id, $producto_id, $cantidad, $precio);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $ok;
    }

    function obtenerPedidosPorUsuario($db, $usuario_id) {
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

    function obtenerDetallePedido($db, $pedido_id) {
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

?>  