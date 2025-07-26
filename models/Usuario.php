<?php

class Usuario {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function crear($nombre, $correo, $contrasena, $rol) {
        $sql = "INSERT INTO usuarios (nombre, correo, contrasena, idRol, estatus) VALUES (?, ?, ?, ?, 1)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $correo, password_hash($contrasena, PASSWORD_DEFAULT), $rol]);
    }

    public function autenticar($correo, $contrasena) {
        $sql = "SELECT * FROM usuarios WHERE correo = ? AND estatus = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            return $usuario;
        }
        return false;
    }

    public function obtenerRoles() {
        // 1 = Administrador, 2 = Almacenista
        return [1 => 'Administrador', 2 => 'Almacenista'];
    }
} 