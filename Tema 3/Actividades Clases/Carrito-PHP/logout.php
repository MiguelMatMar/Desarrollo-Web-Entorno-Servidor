<?php
    session_start();
    // Solo destruir si está logueado
    if (isset($_SESSION['usuario_id'])) {
        // Vaciar session y cookie si se usa
        $_SESSION = [];
        if (ini_get("session.use_cookies")) { // Si las cookies se han creado 
            $params = session_get_cookie_params(); // Guardamos los parametros creados
            setcookie(session_name(), '', time() - 42000, // Borramos los parametros, para quitar abosultamente todas las cookies del usuario
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy(); // Tambien destruimos la sesion 
    }
    header('Location: index.php');
    exit;
?>
