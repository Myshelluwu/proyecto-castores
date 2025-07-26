<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Producto.php';

$db = getDB();
$productoModel = new Producto($db);

// Listar productos
function listarProductos($soloActivos = null) {
    global $productoModel;
    return $productoModel->obtenerTodos($soloActivos);
}

// Agregar producto
function agregarProducto($nombre, $descripcion, $cantidad) {
    global $productoModel;
    return $productoModel->agregar($nombre, $descripcion, $cantidad);
}

// Actualizar producto
function actualizarProducto($id, $nombre, $descripcion, $cantidad) {
    global $productoModel;
    return $productoModel->actualizar($id, $nombre, $descripcion, $cantidad);
}

// Cambiar estado (borrado lógico)
function cambiarEstadoProducto($id, $activo) {
    global $productoModel;
    return $productoModel->cambiarEstado($id, $activo);
}

// Sacar producto
function sacarProducto($id, $cantidad) {
    global $productoModel;
    return $productoModel->sacar($id, $cantidad);
}

// Sumar cantidad (entrada de producto)
function entradaProducto($id, $cantidad) {
    global $productoModel;
    $producto = $productoModel->obtenerPorId($id);
    if ($producto) {
        $nuevaCantidad = $producto['cantidad'] + $cantidad;
        return $productoModel->actualizar($id, $producto['nombre'], $producto['descripcion'], $nuevaCantidad);
    }
    return false;
} 