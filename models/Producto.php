<?php

class Producto {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function obtenerTodos($soloActivos = null) {
        $sql = "SELECT * FROM productos";
        if ($soloActivos === true) {
            $sql .= " WHERE activo = 1";
        } elseif ($soloActivos === false) {
            $sql .= " WHERE activo = 0";
        }
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar($nombre, $descripcion, $cantidad) {
        $sql = "INSERT INTO productos (nombre, descripcion, cantidad) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $cantidad]);
    }

    public function actualizar($id, $nombre, $descripcion, $cantidad) {
        $sql = "UPDATE productos SET nombre=?, descripcion=?, cantidad=? WHERE idProducto=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $cantidad, $id]);
    }

    public function cambiarEstado($id, $activo) {
        $sql = "UPDATE productos SET activo=? WHERE idProducto=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$activo, $id]);
    }

    public function sacar($id, $cantidad) {
        $sql = "UPDATE productos SET cantidad = cantidad - ? WHERE idProducto=? AND cantidad >= ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$cantidad, $id, $cantidad]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM productos WHERE idProducto=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 