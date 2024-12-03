<?php
// Conexión a la base de datos (ajusta los valores a tu configuración)
$servername = "localhost"; // El servidor donde está la base de datos
$username = "root"; // Tu usuario de base de datos
$password = ""; // Tu contraseña de base de datos
$dbname = "zarill"; // El nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recoger los datos del formulario
$producto = $_POST['producto'];
$precio_total = $_POST['precio_total'];
$cantidad = $_POST['cantidad'];
$imagen = $_POST['imagen'];
$tarjeta_numero = $_POST['tarjeta_numero'];
$tarjeta_nombre = $_POST['tarjeta_nombre'];
$tarjeta_cvc = $_POST['tarjeta_cvc'];
$paypal_email = $_POST['paypal_email'];

// Insertar los datos en la tabla 'pedidos'
$sql = "INSERT INTO pedidos (producto, precio, cantidad, total, imagen, tarjeta_numero, tarjeta_nombre, tarjeta_cvc, paypal_email)
        VALUES ('$producto', '$precio_total', '$cantidad', '$precio_total', '$imagen', '$tarjeta_numero', '$tarjeta_nombre', '$tarjeta_cvc', '$paypal_email')";

if ($conn->query($sql) === TRUE) {
    // Redirigir a la página de éxito si la inserción es exitosa
    header("Location: compra_exitosa.html");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
