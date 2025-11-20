<?php
        $pageTitle = 'Iniciar sesión';
        // Necesitamos la sesión para login/registro
        if (session_status() === PHP_SESSION_NONE) session_start();
        require_once  __DIR__ . '/../src/functions.php';
        require_once  __DIR__ . '/../templates/_headers.php';

        $form = filter_input(INPUT_GET, 'form') ?: 'login';

        $message = '';
        // Manejar envío de formularios
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($form === 'login') {
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                if ($email === '' || $password === '') {
                    $message = 'Por favor rellena usuario y contraseña.';
                } else {
                    if (function_exists('loginUsr')) {
                        $res = loginUsr($email, hash('sha512', $password));
                        if ($res) {
                            $_SESSION['user'] = $res;
                            header('Location: /'); 
                            exit;
                        } else {
                            $message = 'Usuario o contraseña incorrectos.';
                        }
                    } else {
                        $message = 'Función de login no disponible.';
                    }
                }
            } else {
                // register
                $username = trim($_POST['username'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                $password2 = $_POST['password2'] ?? '';
                if ($username === '' || $email === '' || $password === '' || $password2 === '') {
                    $message = 'Rellena todos los campos del registro.';
                } elseif ($password !== $password2) {
                    $message = 'Las contraseñas no coinciden.';
                } else {
                    if (function_exists('registerUsr')) {
                        $ok = registerUsr($username, $email, hash('sha512', $password));
                        if ($ok) {
                            $message = 'Registro correcto. Ya puedes iniciar sesión.';
                            header('Location: ?form=login');
                            exit;
                        } else {
                            $message = 'No se pudo registrar el usuario.';
                        }
                    } else {
                        $message = 'Función de registro no disponible.';
                    }
                }
            }
        }
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="btn-group btn-group-justified" role="group" aria-label="Forms toggle">
            <a href="?form=login" class="btn btn-default <?= $form === 'login' ? 'active' : '' ?>">Login</a>
            <a href="?form=register" class="btn btn-default <?= $form === 'register' ? 'active' : '' ?>">Register</a>
        </div>

                <?php if ($form === 'login'): ?>
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
                        <?php endif; ?>
                        <form action="" method="post" class="mt-3">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
                <?php else: ?>
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
                        <?php endif; ?>
                        <form action="" method="post" class="mt-3">
                <div class="form-group">
                    <label for="reg_username">Username</label>
                    <input type="text" class="form-control" id="reg_username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="reg_email">Email</label>
                    <input type="email" class="form-control" id="reg_email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="reg_password">Password</label>
                    <input type="password" class="form-control" id="reg_password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="reg_password2">Confirm Password</label>
                    <input type="password" class="form-control" id="reg_password2" name="password2" required>
                </div>
                <button type="submit" class="btn btn-success">Register</button>
            </form>
        <?php endif; ?>
    </div>
</div>