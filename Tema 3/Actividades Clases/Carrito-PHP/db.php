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



?>  