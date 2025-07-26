<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto - Castores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/proyecto-castores/public/styles.css" rel="stylesheet">
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
if ($_SESSION['usuario']['idRol'] == 2) {
    echo '<div class="container py-4"><div class="alert alert-danger">Acceso denegado. No tienes permisos para agregar productos al catálogo.</div></div>';
    exit;
}
?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h3 class="mb-3">Agregar Producto</h3>
                <?php
                require_once __DIR__ . '/../controllers/ProductoController.php';
                $mensaje = "";
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nombre = trim($_POST['nombre'] ?? '');
                    $descripcion = trim($_POST['descripcion'] ?? '');
                    if ($nombre && $descripcion) {
                        $ok = agregarProducto($nombre, $descripcion, 0); // cantidad inicial 0
                        if ($ok) {
                            $mensaje = '<div class="alert alert-success">Producto agregado correctamente.</div>';
                        } else {
                            $mensaje = '<div class="alert alert-danger">Error al agregar el producto.</div>';
                        }
                    } else {
                        $mensaje = '<div class="alert alert-danger">Todos los campos son obligatorios.</div>';
                    }
                }
                echo $mensaje;
                ?>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Agregar Producto</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="inventario.php" class="text-decoration-none">&larr; Volver al inventario</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 