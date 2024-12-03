<?php
// updatepassword.php
session_start();

// Verificar que el token esté presente
if (!isset($_SESSION['token'])) {
    die("Sesión expirada o no autorizado.");
}

// Obtener email y contraseñas del formulario
$email = $_POST['email'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Verificar que las contraseñas coincidan
if ($new_password !== $confirm_password) {
    die("Las contraseñas no coinciden.");
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zarill";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Actualizar la contraseña en la base de datos (sin hash)
$sql = "UPDATE usuario SET password = ? WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $new_password, $email);

if ($stmt->execute()) {
    echo "Contraseña cambiada exitosamente.";
    // Redirigir al usuario al login o página principal
    header("Location:../Login/login.html");
    exit;
} else {
    echo "Error al cambiar la contraseña.";
}

$stmt->close();
$conn->close();
?>