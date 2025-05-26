<?php
require_once __DIR__ . '/setup.php';

try {
    $db = Database::connect();
    echo " Conexión exitosa a la base de datos.";
} catch (Exception $e) {
    echo " Error: " . $e->getMessage();
}