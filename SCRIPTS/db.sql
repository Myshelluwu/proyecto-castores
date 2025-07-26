CREATE DATABASE castores;
USE castores;

-- Tabla de roles
CREATE TABLE roles (
    idRol INT(2) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- Insertar roles
INSERT INTO roles (idRol, nombre) VALUES
(1, 'Administrador'),
(2, 'Almacenista');


-- Tabla de usuarios
CREATE TABLE usuarios (
    idUsuario INT(6) PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(25) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    idRol INT(2) NOT NULL,
    estatus INT(1) NOT NULL,
    FOREIGN KEY (idRol) REFERENCES roles(idRol)
);

-- Tabla de productos
CREATE TABLE productos (
    idProducto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    cantidad INT NOT NULL DEFAULT 0,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de movimientos
CREATE TABLE movimientos (
    idMovimiento INT AUTO_INCREMENT PRIMARY KEY,
    idProducto INT NOT NULL,
    idUsuario INT(6) NOT NULL,
    tipo ENUM('entrada', 'salida') NOT NULL,
    cantidad INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idProducto) REFERENCES productos(idProducto),
    FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario)
);