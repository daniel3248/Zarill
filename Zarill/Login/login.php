<?php
require '../Database/conexion.php'; // Conexión a la base de datos
session_start(); // Inicia la sesión

// Validar si los campos están definidos en $_POST
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    die("Por favor, completa todos los campos. <a href='login.html'>Volver</a>");
}

// Obtener datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Validar que no estén vacíos
if (empty($email) || empty($password)) {
    die("Por favor, completa todos los campos. <a href='login.html'>Volver</a>");
}

// Verificar si el usuario existe
$sql = "SELECT * FROM usuario WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Comparar la contraseña
    if ($password === $user['password']) {

        // Guardar la información del usuario en la sesión
        $_SESSION['user_id'] = $user['idUsuario'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['role'] = $user['role'];


        header("Location: ../Main/main.php"); // ENVIA EL USUARIO A LA PAGINA PRINCIPAL


    } else {
      header("Location: ../Login/loginfailed.html");
    }
} else {
    header("Location: ../Login/loginfailed.html");
}

$stmt->close();
$conn->close();
?>