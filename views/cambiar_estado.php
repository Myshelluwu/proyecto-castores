<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../controllers/ProductoController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['idProducto'] ?? null;
    $activo = $_POST['activo'] ?? null;
    if ($id !== null && $activo !== null) {
        cambiarEstadoProducto($id, $activo);
    }
}
header('Location: inventario.php');
exit;
