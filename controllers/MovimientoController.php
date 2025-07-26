<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Movimiento.php';

$db = getDB();
$movimientoModel = new Movimiento($db);

// Registrar movimiento
function registrarMovimiento($idProducto, $idUsuario, $tipo, $cantidad) {
    global $movimientoModel;
    return $movimientoModel->registrar($idProducto, $idUsuario, $tipo, $cantidad);
}

// Obtener historial de movimientos
function obtenerHistorial($idProducto = null) {
    global $movimientoModel;
    return $movimientoModel->obtenerHistorial($idProducto);
} 