<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = hash('sha256', $_POST['password']);

        require_once 'db.php';

        if (!$db) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        $stmt = mysqli_prepare($db, "SELECT id, password FROM usuarios WHERE email = ?");
        if (!$stmt) {
            die("Error en la consulta");
        }
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $usuario = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            if ($usuario['password'] === $password) {
                session_start();
                $_SESSION['usuario_id'] = $usuario['id'];
                header("Location: cuenta.php");
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
    <title>Registro</title>
</head>
<body>
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
            <button type="submit">Registrarse</button>
        </div>
    </form>
</body>
</html>