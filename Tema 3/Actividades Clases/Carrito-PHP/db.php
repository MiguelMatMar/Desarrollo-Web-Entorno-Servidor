<?php

    $host = "localhost";
    $username = "root";
    $passwd = "";
    $dbName = "mi_base";

    $db = mysqli_connect($host,$username,$passwd,$dbName);

    if(!$db){
        mysqli_close();
        header("Location: index.html");
    }

    function obtenerProductos($db){
        $consulta = "SELECT * FROM productos";
        $stmt = mysqli_prepare($db, $consulta);

        if(!$stmt){
            return false;
        }

        mysqli_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if($result){
            $resultados = mysqli_fetch_assoc($result);
            $resultados = json_encode($resultados);
            $resultados = json_decode($resultados);
            
            return $resultados;
        } else {
            return false;
        }
    }
    echo obtenerProductos($db);
?>