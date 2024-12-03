<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia por tu usuario de base de datos
$password = "";     // Cambia por tu contraseña de base de datos
$dbname = "zarill"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'] ?? '';
$precio = $_POST['precio'] ?? 0;
$talla = $_POST['talla'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$infoAdd = $_POST['infoAdd'] ?? '';
$imagen = null;

// Manejo de la imagen
if (isset($_FILES['imagen_prenda']) && $_FILES['imagen_prenda']['error'] === UPLOAD_ERR_OK) {
    // Leer la imagen y convertirla a binario
    $imagen = file_get_contents($_FILES['imagen_prenda']['tmp_name']);
}

// Preparar y ejecutar la consulta SQL
$sql = "INSERT INTO producto (nombre, talla, descripcion, infoAdd, precio, imagen) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssdss", $nombre, $talla, $descripcion, $infoAdd, $precio, $imagen);

    if ($stmt->execute()) {
        // Redirigir a una página de éxito
        header("Location: registersuccess.html");
        exit; // Asegúrate de terminar la ejecución aquí
    } else {
        echo "Error al agregar producto: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error en la consulta: " . $conn->error;
}

// Cerrar conexión
$conn->close();
?>