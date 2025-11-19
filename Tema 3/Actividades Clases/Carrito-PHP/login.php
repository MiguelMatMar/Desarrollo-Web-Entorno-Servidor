<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Verificamos el email
        $password = hash('sha256', $_POST['password']); // Hasheamos la contraseña nada mas la envie

        require_once 'db.php';

        if (!$db) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        $stmt = mysqli_prepare($db, "SELECT id, password FROM usuarios WHERE email = ?"); // Preparamos la consulta para obtener los datos del usuario filtrando por el email
        if (!$stmt) {
            die("Error en la consulta");
        }
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt); // Guardamos lo que ha devuelto en un array asociativo 

        if ($result && mysqli_num_rows($result) > 0) { // Si nos ha devuelto algo, es decir, el usuario existe
            $usuario = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            if ($usuario['password'] === $password) { // Y la contraseña hasheada de la base de datos que hemos obtenido es la misma que nos ha mandado el usuario por el formulario
                session_start(); // Iniciamos sesion
                $_SESSION['usuario_id'] = $usuario['id']; // Guardamos el id en una variable de sesion
                header("Location: cuenta.php"); // Redirigimos a la cuenta para, por si el usuario quiere ver los pedidos que ha hecho
                exit;
            }
        }

        echo "Usuario o contraseña incorrectos";
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>
<body>
    <h1>Iniciar Sesion</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <div>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" required maxlength="255" autocomplete="email">
        </div>

        <div>
            <label for="password">Contraseña</label><br>
            <input type="password" id="password" name="password" required minlength="6" autocomplete="new-password">
        </div>

        <div>
            <button type="submit">Iniciar Sesion</button>
        </div>
    </form>
</body>
</html>