<?php
session_start(); // Inicia sesión
session_destroy(); // Destruye todas las variables de sesión
header("Location: ../Main/main.php"); // Redirige al formulario de login
exit;
?>