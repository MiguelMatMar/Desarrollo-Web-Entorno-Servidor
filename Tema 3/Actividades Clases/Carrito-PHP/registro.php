<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim(htmlspecialchars($_POST['nombre']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password_raw = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email no válido";
        exit;
    }

    if (strlen($password_raw) < 6) { // Validacion de la longitud de la contraseña, por si se introduce una muy facil de robar
        echo "La contraseña debe tener al menos 6 caracteres";
        exit;
    }

    $password_hash = hash('sha256', $password_raw);

    require_once 'db.php';
    $conn = $db;

    if (!isset($conn) || !$conn) { // Si la conexion no existe o nos ha devuelto falso entonces mostramos error
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Comprobar si ya existe el id del usuario filtrando por email para no insertar usuarios duplicados 
    $stmt = mysqli_prepare($conn, "SELECT id FROM usuarios WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        echo "El email ya está registrado";
        exit;
    }
    mysqli_stmt_close($stmt);

    // Insertar usuario nuevo si no existe
    $stmt = mysqli_prepare($conn, "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Error en la preparación: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "sss", $nombre, $email, $password_hash);
    if (mysqli_stmt_execute($stmt)) {
        $nuevo_id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);
        session_start();
        $_SESSION['usuario_id'] = $nuevo_id; // Si se inserta entonces guardamos el id del usuario
        header("Location: cuenta.php");
        exit;
    } else { // Sino pues devolvemos el error
        $err = mysqli_stmt_error($stmt);
        mysqli_stmt_close($stmt);
        echo "Error al registrar el usuario: " . $err;
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registro</title>
</head>
<body>
    <h1>Registro</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div>
            <label for="nombre">Nombre</label><br>
            <input type="text" id="nombre" name="nombre" required maxlength="100" autocomplete="name">
        </div>

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