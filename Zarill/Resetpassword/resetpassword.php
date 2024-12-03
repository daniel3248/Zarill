<?php
// resetpassword.php
session_start();

// Verificar que el token esté presente
if (!isset($_SESSION['token'])) {
    die("Sesión expirada o no autorizado.");
}

// Obtener el email desde la URL (pasado desde verifyemail.php)
$email = $_GET['email'];

// Mostrar el formulario de cambio de contraseña
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="resetpassword.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Cambiar Contraseña</h1>
        <br>
        <form action="updatepassword.php" method="POST">
            <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
            <label for="new_password">Nueva Contraseña</label>
            <input type="password" name="new_password" id="new_password" placeholder="Escribe tu nueva contraseña" required>
            <br>
            <label for="confirm_password">Confirmar Contraseña</label>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirma tu nueva contraseña" required>
            <br>
            <button type="submit">Cambiar Contraseña</button>
        </form>
    </div>
</body>
</html>