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

    
?>