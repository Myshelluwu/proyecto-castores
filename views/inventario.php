<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - Castores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/proyecto-castores/public/styles.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <?php
    if (!empty($_SESSION['mensaje'])) {
        echo $_SESSION['mensaje'];
        unset($_SESSION['mensaje']);
    }
    ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <?php if ($_SESSION['usuario']['idRol'] == 1): ?>
          <h2>Inventario Administrador</h2>
        <?php endif; ?>
        <?php if ($_SESSION['usuario']['idRol'] == 2): ?>
          <h2>Inventario Almacenista</h2>
        <?php endif; ?>
        <div>
        <?php if ($_SESSION['usuario']['idRol'] != 2): ?>
            <a href="agregar_producto.php" class="btn btn-success">Agregar Producto a inventario</a>
            <a href="movimientos.php" class="btn btn-secondary">Ver Historial de Movimientos</a>
        <?php endif; ?>
        <a href="logout.php" class="btn btn-outline-danger ms-2">Cerrar sesión</a>
        </div>
    </div>
    <?php if ($_SESSION['usuario']['idRol'] != 2): ?>
      <div class="mb-3">
          <form method="GET" class="d-inline">
              <input type="hidden" name="estado" value="activos">
              <button type="submit" class="btn btn-outline-primary btn-sm">Activos</button>
          </form>
          <form method="GET" class="d-inline">
              <input type="hidden" name="estado" value="inactivos">
              <button type="submit" class="btn btn-outline-secondary btn-sm">Inactivos</button>
          </form>
          <form method="GET" class="d-inline">
              <input type="hidden" name="estado" value="todos">
              <button type="submit" class="btn btn-outline-dark btn-sm">Todos</button>
          </form>
      </div>
    <?php endif; ?>
    <?php
    require_once __DIR__ . '/../controllers/ProductoController.php';
    $estado = $_GET['estado'] ?? 'activos';
    if ($estado === 'activos') {
        $productos = listarProductos(true);
    } elseif ($estado === 'inactivos') {
        $productos = listarProductos(false);
    } else {
        $productos = listarProductos();
    }
    ?>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?= $producto['idProducto'] ?></td>
                <td><?= htmlspecialchars($producto['nombre']) ?></td>
                <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                <td><?= $producto['cantidad'] ?></td>
                <td>
                    <?php if ($producto['activo']): ?>
                        <span class="badge bg-success">Activo</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Inactivo</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($producto['activo']): ?>
                        <?php if ($_SESSION['usuario']['idRol'] != 1): ?>
                        <!-- Botón Sacar producto -->
                        <button type="button" class="btn btn-warning btn-sm d-inline" data-bs-toggle="modal" data-bs-target="#sacarModal<?= $producto['idProducto'] ?>">Sacar</button>
                        <!-- Modal Sacar producto -->
                        <div class="modal fade" id="sacarModal<?= $producto['idProducto'] ?>" tabindex="-1" aria-labelledby="sacarModalLabel<?= $producto['idProducto'] ?>" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form method="POST" action="../routes.php?accion=sacar_producto" onsubmit="return validarSacar<?= $producto['idProducto'] ?>();">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="sacarModalLabel<?= $producto['idProducto'] ?>">Sacar producto</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                  <input type="hidden" name="id" value="<?= $producto['idProducto'] ?>">
                                  <div class="mb-3">
                                    <label for="cantidad_sacar<?= $producto['idProducto'] ?>" class="form-label">Cantidad a sacar</label>
                                    <input type="number" class="form-control" id="cantidad_sacar<?= $producto['idProducto'] ?>" name="cantidad" min="1" max="<?= $producto['cantidad'] ?>" required>
                                    <div class="invalid-feedback">Ingrese una cantidad válida (mayor a 0 y menor o igual al inventario).</div>
                                  </div>
                                  <div class="alert alert-warning" role="alert">
                                    ¿Está seguro? El movimiento quedará registrado.
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                  <button type="submit" class="btn btn-warning">Confirmar salida</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <script>
                        function validarSacar<?= $producto['idProducto'] ?>() {
                          var input = document.getElementById('cantidad_sacar<?= $producto['idProducto'] ?>');
                          var max = parseInt(input.getAttribute('max'));
                          if (input.value === '' || isNaN(input.value) || parseInt(input.value) <= 0 || parseInt(input.value) > max) {
                            input.classList.add('is-invalid');
                            return false;
                          } else {
                            input.classList.remove('is-invalid');
                            return true;
                          }
                        }
                        </script>
                        <?php endif; ?>
                        <?php if ($_SESSION['usuario']['idRol'] != 2): ?>
                        <!-- Botón Entrada de producto -->
                        <button type="button" class="btn btn-primary btn-sm d-inline" data-bs-toggle="modal" data-bs-target="#entradaModal<?= $producto['idProducto'] ?>">Entrada de producto</button>
                        <form action="cambiar_estado.php" method="POST" class="d-inline">
                            <input type="hidden" name="idProducto" value="<?= $producto['idProducto'] ?>">
                            <input type="hidden" name="activo" value="0">
                            <button type="submit" class="btn btn-outline-secondary btn-sm">Desactivar</button>
                        </form>
                        <?php endif; ?>
                        <!-- Modal Entrada de producto -->
                        <div class="modal fade" id="entradaModal<?= $producto['idProducto'] ?>" tabindex="-1" aria-labelledby="entradaModalLabel<?= $producto['idProducto'] ?>" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form method="POST" action="../routes.php?accion=entrada_producto" onsubmit="return validarEntrada<?= $producto['idProducto'] ?>();">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="entradaModalLabel<?= $producto['idProducto'] ?>">Entrada de producto</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                  <input type="hidden" name="id" value="<?= $producto['idProducto'] ?>">
                                  <div class="mb-3">
                                    <label for="cantidad_entrada<?= $producto['idProducto'] ?>" class="form-label">Cantidad a agregar</label>
                                    <input type="number" class="form-control" id="cantidad_entrada<?= $producto['idProducto'] ?>" name="cantidad" min="1" required>
                                    <div class="invalid-feedback">Ingrese una cantidad válida (mayor a 0).</div>
                                  </div>
                                  <div class="alert alert-warning" role="alert">
                                    ¿Está seguro? El movimiento quedará registrado.
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                  <button type="submit" class="btn btn-primary">Confirmar entrada</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <script>
                        function validarEntrada<?= $producto['idProducto'] ?>() {
                          var input = document.getElementById('cantidad_entrada<?= $producto['idProducto'] ?>');
                          if (input.value === '' || isNaN(input.value) || parseInt(input.value) <= 0) {
                            input.classList.add('is-invalid');
                            return false;
                          } else {
                            input.classList.remove('is-invalid');
                            return true;
                          }
                        }
                        </script>
                    <?php else: ?>
                        <?php if ($_SESSION['usuario']['idRol'] != 2): ?>
                        <form action="cambiar_estado.php" method="POST" class="d-inline">
                            <input type="hidden" name="idProducto" value="<?= $producto['idProducto'] ?>">
                            <input type="hidden" name="activo" value="1">
                            <button type="submit" class="btn btn-outline-success btn-sm">Activar</button>
                        </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 