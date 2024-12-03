<?php
// Configuración de conexión a la base de datos,
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

// Consultar los productos en la base de datos
$sql = "SELECT idProducto, nombre, talla, descripcion, infoAdd, precio, imagen FROM producto";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <main>
        <div class="container">
            <?php if ($result->num_rows > 0): ?>
                <div class="table-wrapper">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Talla</th>
                                <th>Descripción</th>
                                <th>Información Adicional</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <!-- Mostrar imagen -->
                                    <td>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['imagen']); ?>" alt="Producto" class="product-thumbnail">
                                    </td>
                                    <!-- Mostrar los demás campos -->
                                    <td><?php echo $row['idProducto']; ?></td>
                                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($row['talla']); ?></td>
                                    <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                                    <td><?php echo htmlspecialchars($row['infoAdd']); ?></td>
                                    <td>$<?php echo number_format($row['precio'], 2, ',', '.'); ?></td>
                                    <td class="actions">
                                        <!-- Botón de edición -->
                                        <a href="editarproducto.php?id=<?php echo $row['idProducto']; ?>" class="edit-button">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <!-- Botón de eliminación -->
                                        <form method="POST" action="eliminarproducto.php" class="delete-form">
                                            <input type="hidden" name="idProducto" value="<?php echo $row['idProducto']; ?>">
                                            <button type="submit" class="delete-button">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No hay productos registrados en el inventario.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
<?php
// Cerrar la conexión
$conn->close();
?>