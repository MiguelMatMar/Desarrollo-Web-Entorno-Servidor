<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "mi_base";
    try {

        // Conexión a la base de datos
        $conexion = mysqli_connect($host, $user, $password, $db);

        // Verificar si se creo la conexión a la BD
        if (!$conexion) {
            throw new Exception("Error en la conexión a la base de datos: " .
            mysqli_connect_error());
        }

        // Consulta SQL
        $consulta = "SELECT * FROM usuarios";
        $resultado = mysqli_query($conexion, $consulta);

        // Verificar si la consulta se ejecutó correctamente
        if (!$resultado) {
            throw new Exception("Error en la consulta SQL: " . mysqli_error($conexion));
        }

        // Comprobar si hay resultados
        if (mysqli_num_rows($resultado) > 0) {
            echo "<h1>Hay resultados</h1>";
            echo "<style>  body{ height: 100vh; display:flex; flex-direction:column;  align-items:center;} tr, td{ border: 1px solid black; padding: 15px; text-align:center; font-size: 1.3em;} </style>";
            echo "<table>";
            for($i = 0;$i< mysqli_num_rows($resultado);$i++){
                $iterar = mysqli_fetch_assoc($resultado);
                if($i == 0){
                    echo "<tr>";
                    foreach($iterar as $a => $b){
                        echo "<td> $a </td>";
                    }
                    echo "</tr>";
                }
                echo "<tr>";
                foreach($iterar as $b){
                    echo "<td> $b </td>";
                }
                echo "</tr>";
                
            }    
            echo "</table>";
        } else {
            echo "<h1>No hay resultados</h1>";
        }

        } catch (Exception $e) {

            // Manejo de la excepción, mostrar mensaje de error
            echo "Excepción capturada: " . $e->getMessage();

        } finally {

            // Cerrar la conexión si fue creada
            if (isset($conexion) && $conexion) {
                mysqli_close($conexion);
            }
            
        }
?>