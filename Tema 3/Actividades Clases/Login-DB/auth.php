<?php
    session_start();

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $nombreUsr = $_POST['nombreUsr'];
        $passwdUsr = md5($_POST['passwdUsr']);

        require_once("./db.php");
  
        function consultarUsr($database, $usr, $passwd) {
            $consulta = "SELECT * FROM usuarios WHERE nombreUsuario = ? AND passwdUsuario = ?";
            
            // Preparar
            $stmt = mysqli_prepare($database, $consulta);
            
            // Asociar 
            mysqli_stmt_bind_param($stmt, "ss", $usr, $passwd);
            
            // Ejecutar
            mysqli_stmt_execute($stmt);
            
            // Obtener resultados
            $resultado = mysqli_stmt_get_result($stmt);

            // Devolver la fila si existe
            if(mysqli_num_rows($resultado) > 0){
                return true;
            }else{
                return false;
            }
        }

        if(consultarUsr($db,$nombreUsr,$passwdUsr)){
            $_SESSION['nombreUsuario'] = $nombreUsr;
            header('Location: acc.php');
        }else{
            header('Location: ./index.html');
        }

    }

?>