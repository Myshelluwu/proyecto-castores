<?php
// Definición de rutas 

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_GET['accion']) &&
    $_GET['accion'] === 'entrada_producto'
) {
    session_start();
    require_once __DIR__ . '/controllers/ProductoController.php';
    require_once __DIR__ . '/controllers/MovimientoController.php';
    $id = intval($_POST['id'] ?? 0);
    $cantidad = intval($_POST['cantidad'] ?? 0);
    if ($id > 0 && $cantidad > 0) {
        $ok = entradaProducto($id, $cantidad);
        if ($ok) {
            $idUsuario = $_SESSION['usuario']['idUsuario'] ?? null;
            registrarMovimiento($id, $idUsuario, 'entrada', $cantidad);
            $_SESSION['mensaje'] = '<div class="alert alert-success">Entrada registrada correctamente.</div>';
        } else {
            $_SESSION['mensaje'] = '<div class="alert alert-danger">Error al registrar la entrada.</div>';
        }
    } else {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">Cantidad inválida.</div>';
    }
    header('Location: views/inventario.php');
    exit;
} 

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_GET['accion']) &&
    $_GET['accion'] === 'sacar_producto'
) {
    session_start();
    require_once __DIR__ . '/controllers/ProductoController.php';
    require_once __DIR__ . '/controllers/MovimientoController.php';
    $id = intval($_POST['id'] ?? 0);
    $cantidad = intval($_POST['cantidad'] ?? 0);
    $ok = false;
    if ($id > 0 && $cantidad > 0) {
        $ok = sacarProducto($id, $cantidad);
        if ($ok) {
            $idUsuario = $_SESSION['usuario']['idUsuario'] ?? null;
            registrarMovimiento($id, $idUsuario, 'salida', $cantidad);
            $_SESSION['mensaje'] = '<div class="alert alert-success">Salida registrada correctamente.</div>';
        } else {
            $_SESSION['mensaje'] = '<div class="alert alert-danger">No se pudo realizar la salida. Verifique la cantidad disponible.</div>';
        }
    } else {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">Cantidad inválida.</div>';
    }
    header('Location: views/inventario.php');
    exit;
} 