<?php
// Configuración de la base de datos
$host = 'localhost';
$user = 'root'; // Cambia si usas otro usuario
$password = ''; // Cambia si tienes una contraseña configurada
$database = 'zarill';

// Crear la conexión
$conn = new mysqli('localhost', 'root', '', 'zarill');

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>