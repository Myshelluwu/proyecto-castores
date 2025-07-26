<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Castores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/proyecto-castores/public/styles.css" rel="stylesheet">
</head>
<body>
<div class="register-container">
    <div class="card p-4" style="min-width: 350px;">
        <div class="text-center mb-3">
            <img src="/proyecto-castores/public/img/castor.png" alt="Logo" class="logo">
            <h4 class="mb-0">Crear Cuenta</h4>
            <small class="text-muted">Sistema de Inventario Castores</small>
        </div>
        <?php
        require_once __DIR__ . '/../controllers/AuthController.php';
        $mensaje = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $correo = trim($_POST['correo'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmar = $_POST['confirmar_password'] ?? '';
            $rol = $_POST['rol'] ?? '';
            if ($usuario && $correo && $password && $confirmar && $rol) {
                if ($password !== $confirmar) {
                    $mensaje = '<div class="alert alert-danger">Las contraseñas no coinciden.</div>';
                } else {
                    $ok = crearCuenta($usuario, $correo, $password, $rol);
                    if ($ok) {
                        $mensaje = '<div class="alert alert-success">Cuenta creada correctamente. Serás redirigido al inicio de sesión...</div>';
                        header("refresh:2;url=login.php");
                        // exit;  // No uses exit aquí, así se muestra el mensaje antes de redirigir
                    } else {
                        $mensaje = '<div class="alert alert-danger">Error al crear la cuenta. El correo ya existe.</div>';
                    }
                }
            } else {
                $mensaje = '<div class="alert alert-danger">Todos los campos son obligatorios.</div>';
            }
        }
        echo $mensaje;
        ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required autofocus>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirmar_password" class="form-label">Confirmar Contraseña</label>
                <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" required>
            </div>
            <div class="mb-3">
                <label for="rol" class="form-label">Tipo de usuario</label>
                <select class="form-select" id="rol" name="rol" required>
                    <option value="">Selecciona un rol</option>
                    <option value="1">Administrador</option>
                    <option value="2">Almacenista</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Crear Cuenta</button>
            <div class="mt-3 text-center">
                <a href="login.php" class="text-decoration-none">¿Ya tienes cuenta? Inicia sesión</a>
            </div>
        </form>
        
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>