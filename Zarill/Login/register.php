<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'zarill');

// Verificar conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validar contraseñas
if ($password !== $confirm_password) {
  die("Las contraseñas no coinciden. <a href='login.html'>Volver</a>");
}

// Hashear la contraseña
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Insertar datos en la base
$sql = "INSERT INTO usuario (nombre, email, password, role) VALUES ('$nombre', '$email', '$password','user')";
if ($conn->query($sql) === TRUE) {
  // Redirigir a una página de bienvenida
  header("Location: registersuccess.html");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>