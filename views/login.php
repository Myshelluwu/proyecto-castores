<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Castores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/proyecto-castores/public/styles.css" rel="stylesheet">
</head>
<body>
<div class="login-container">
    <div class="card p-4" style="min-width: 350px;">
        <div class="text-center mb-3">
            <img src="/proyecto-castores/public/img/castor.png" alt="Logo" class="logo">
            <h4 class="mb-0">Sistema de Inventario</h4>
            <small class="text-muted">Castores</small>
        </div>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        session_start();
        $mensaje = "";
        try {
            require_once __DIR__ . '/../controllers/AuthController.php';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $correo = trim($_POST['correo'] ?? '');
                $password = $_POST['password'] ?? '';
                if ($correo && $password) {
                    $usuario = login($correo, $password);
                    if ($usuario) {
                        $_SESSION['usuario'] = $usuario;
                        header('Location: inventario.php');
                        exit;
                    } else {
                        $mensaje = '<div class="alert alert-danger">Correo o contraseña incorrectos.</div>';
                    }
                } else {
                    $mensaje = '<div class="alert alert-danger">Todos los campos son obligatorios.</div>';
                }
            }
        } catch (Throwable $e) {
            $mensaje = '<div class="alert alert-danger">Error de conexión a la base de datos.</div>';
        }
        echo $mensaje;
        ?>
        <div class="mt-3 text-center">
            <a href="crear_cuenta.php" class="text-decoration-none">¿No tienes cuenta? Crea una aquí</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>