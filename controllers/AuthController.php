<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';

function getDB() {
    $config = require __DIR__ . '/../config/database.php';
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
    return new PDO($dsn, $config['user'], $config['password']);
}

$db = getDB();
$usuarioModel = new Usuario($db);

function crearCuenta($nombre, $correo, $contrasena, $rol) {
    global $usuarioModel;
    return $usuarioModel->crear($nombre, $correo, $contrasena, $rol);
}

function login($correo, $contrasena) {
    global $usuarioModel;
    return $usuarioModel->autenticar($correo, $contrasena);
}

function obtenerRoles() {
    global $usuarioModel;
    return $usuarioModel->obtenerRoles();
} 