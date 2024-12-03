<?php
// verifyemail.php
session_start();

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

// Obtener el email del formulario
$email = $_POST['email'];

// Verificar si el email existe en la base de datos
$sql = "SELECT idUsuario FROM usuario WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Si el email existe, generar un token y redirigir al formulario para cambiar la contraseña
    $token = bin2hex(random_bytes(16)); // Genera un token aleatorio
    $_SESSION['token'] = $token; // Guardar token en sesión (para validarlo más tarde)

    // Redirigir al formulario de cambio de contraseña
    header("Location: resetpassword.php?email=" . urlencode($email));
    exit;
} else {
    echo "Este correo no está registrado.";
}

$stmt->close();
$conn->close();
?>