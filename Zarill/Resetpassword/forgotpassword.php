<?php
// forgotpassword.php
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="resetpassword.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Recuperar Contraseña</h1>
        <br>
        <p>Introduce tu email para recibir un enlace de restablecimiento de contraseña.</p>
        <form action="verifyemail.php" method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Escribe tu correo" required>
            <br>
            <button type="submit">Enviar Enlace</button>
        </form>
    </div>
</body>
</html>