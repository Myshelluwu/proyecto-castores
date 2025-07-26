<?php
// Funciones auxiliares 
if (!function_exists('getDB')) {
    function getDB() {
        $config = require __DIR__ . '/config/database.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
        return new PDO($dsn, $config['user'], $config['password']);
    }
} 