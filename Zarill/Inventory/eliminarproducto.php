<?php
// Configuración de conexión a la base de datos
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

// Verificar si se envió el ID del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idProducto'])) {
    $idProducto = $_POST['idProducto'];

    // Eliminar el producto
    $sql = "DELETE FROM producto WHERE idProducto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idProducto);

    if ($stmt->execute()) {
        echo "Producto eliminado con éxito.";
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "ID de producto no válido.";
}

// Cerrar conexión
$conn->close();

// Redirigir de vuelta al inventario
header("Location: inventory.php");
exit;
?>