<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
$usuario = $_SESSION['usuario'];
if ($usuario['idRol'] == 2) {
    echo '<div class="container py-4"><div class="alert alert-danger">Acceso denegado. No tienes permisos para ver el historial de movimientos.</div></div>';
    exit;
}
require_once __DIR__ . '/../controllers/MovimientoController.php';
$tipo = $_GET['tipo'] ?? 'todos';
if ($tipo === 'entrada') {
    $movimientos = array_filter(obtenerHistorial(), fn($m) => $m['tipo'] === 'entrada');
} elseif ($tipo === 'salida') {
    $movimientos = array_filter(obtenerHistorial(), fn($m) => $m['tipo'] === 'salida');
} else {
    $movimientos = obtenerHistorial();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Movimientos - Castores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/proyecto-castores/public/styles.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Historial de Movimientos</h2>
        <div> 
            <a href="inventario.php" class="btn btn-secondary">&larr; Regresar</a>
        </div>
    </div>
    <div class="d-flex align-items-left mb-3">
        <a href="movimientos.php?tipo=todos" class="btn btn-outline-success btn-sm me-2">Todos</a>
        <a href="movimientos.php?tipo=entrada" class="btn btn-outline-primary btn-sm me-2">Entradas</a>
        <a href="movimientos.php?tipo=salida" class="btn btn-outline-warning btn-sm me-2">Salidas</a>
    </div>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($movimientos)): ?>
            <tr><td colspan="7" class="text-center">No hay movimientos registrados.</td></tr>
        <?php else: ?>
            <?php foreach ($movimientos as $mov): ?>
                <tr>
                    <td><?= $mov['idMovimiento'] ?></td>
                    <td><?= htmlspecialchars($mov['nombre']) ?></td>
                    <td>
                        <?php if ($mov['tipo'] === 'entrada'): ?>
                            <span class="badge bg-primary">Entrada</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Salida</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $mov['cantidad'] ?></td>
                    <td><?= $mov['fecha'] ?></td>
                    <td><?= htmlspecialchars($mov['usuario_nombre']) ?></td>
                    <td><?= htmlspecialchars($mov['usuario_correo']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 