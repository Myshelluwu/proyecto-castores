<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: views/login.php');
    exit();
}
// Aquí iría el contenido principal si hay sesión activa 