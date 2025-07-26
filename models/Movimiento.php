<?php

class Movimiento {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function registrar($idProducto, $idUsuario, $tipo, $cantidad) {
        $sql = "INSERT INTO movimientos (idProducto, idUsuario, tipo, cantidad) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idProducto, $idUsuario, $tipo, $cantidad]);
    }

    public function obtenerHistorial($idProducto = null) {
        $sql = "SELECT m.*, p.nombre, u.nombre AS usuario_nombre, u.correo AS usuario_correo FROM movimientos m JOIN productos p ON m.idProducto = p.idProducto JOIN usuarios u ON m.idUsuario = u.idUsuario";
        if ($idProducto) {
            $sql .= " WHERE m.idProducto = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$idProducto]);
        } else {
            $stmt = $this->db->query($sql);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 