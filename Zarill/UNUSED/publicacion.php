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
$imagen_ruta = "";

// Manejo de la imagen
if (isset($_FILES['imagen_prenda']) && $_FILES['imagen_prenda']['error'] === UPLOAD_ERR_OK) {
    // Crear directorio si no existe
    $directorio_subida = 'uploads/';
    if (!is_dir($directorio_subida)) {
        mkdir($directorio_subida, 0777, true);
    }

    // Generar un nombre único para la imagen
    $nombre_imagen = uniqid() . "-" . basename($_FILES['imagen_prenda']['name']);
    $imagen_ruta = $directorio_subida . $nombre_imagen;

    // Mover el archivo subido al directorio
    if (!move_uploaded_file($_FILES['imagen_prenda']['tmp_name'], $imagen_ruta)) {
        echo "Error al subir la imagen.";
        exit;
    }
}

// Preparar y ejecutar la consulta SQL
$sql = "INSERT INTO producto (nombre, talla, descripcion, infoAdd, precio, imagen_ruta)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssdss", $nombre, $talla, $descripcion, $infoAdd, $precio, $imagen_ruta);

    if ($stmt->execute()) {
        echo "Producto agregado exitosamente.";
        
        // **Actualizar el archivo HTML**
        $html_file = 'productos.html'; // Archivo HTML que contiene la lista de productos
        $nuevo_producto = "
        <div class='producto'>
            <img src='$imagen_ruta' alt='$nombre' style='width:150px;height:auto;'>
            <h3>$nombre</h3>
            <p>Precio: $$precio</p>
        </div>";

        // Si el archivo existe, agregar al final
        if (file_exists($html_file)) {
            $contenido = file_get_contents($html_file);

            // Insertar antes del cierre de la etiqueta body
            $contenido = str_replace('</body>', $nuevo_producto . "\n</body>", $contenido);

            file_put_contents($html_file, $contenido);
        } else {
            // Crear un nuevo archivo HTML si no existe
            $contenido = "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Productos</title>
                <style>
                    .producto { margin: 20px; padding: 10px; border: 1px solid #ddd; text-align: center; }
                    img { max-width: 100%; height: auto; }
                </style>
            </head>
            <body>
                <h1>Lista de Productos</h1>
                $nuevo_producto
            </body>
            </html>";

            file_put_contents($html_file, $contenido);
        }
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
