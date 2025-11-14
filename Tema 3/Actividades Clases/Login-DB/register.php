<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $nombreUsr = $_POST['nombreUsr'];
        $passwdUsr = md5($_POST['passwdUsr']);

        require_once("./db.php");

        // Preparar consulta
        $sql = "INSERT INTO usuarios(nombreUsuario, passwdUsuario) VALUES (?, ?)";
        $stmt = mysqli_prepare($db, $sql);

        // Asociar parámetros
        mysqli_stmt_bind_param($stmt, "ss", $nombreUsr, $passwdUsr);

        // Ejecutar
        $ok = mysqli_stmt_execute($stmt);

        if ($ok) {
            // Registro correcto
            $_SESSION['nombreUsuario'] = $nombreUsr;
            header('Location: acc.php');
            exit;
        } else {
            // Error en el registro
            header('Location: ./index.html');
            exit;
        }
    }
?>
