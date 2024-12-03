<?php
session_start(); // Iniciar sesión
$isLoggedIn = isset($_SESSION['user_id']); // Verificar si el usuario ha iniciado sesión

// Verificar si el usuario tiene rol de admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Si el usuario no es admin, redirigir a main.php
    header("Location: ../Main/main.php");
    exit;
}

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

// Obtener el ID del producto desde la URL
$idProducto = $_GET['id'] ?? null;

if ($idProducto) {
    // Consultar la información del producto
    $sql = "SELECT * FROM producto WHERE idProducto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    if (!$producto) {
        die("Producto no encontrado.");
    }
} else {
    die("ID de producto no especificado.");
}

// Actualizar el producto (si se envió el formulario)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $talla = $_POST['talla'];
    $descripcion = $_POST['descripcion'];
    $infoAdd = $_POST['infoAdd'];

    // Inicializar la ruta de la imagen con la actual en la base de datos
    $imagen = $producto['imagen']; // Mantener la imagen actual

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Leer el archivo de imagen y convertirlo a BLOB
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
    }

    // Actualizar el producto en la base de datos
    $updateSql = "UPDATE producto SET nombre = ?, precio = ?, talla = ?, descripcion = ?, infoAdd = ?, imagen = ? WHERE idProducto = ?";
    $updateStmt = $conn->prepare($updateSql);

    // "b" indica que estamos vinculando un parámetro binario para la imagen
    $updateStmt->bind_param("sdssssi", $nombre, $precio, $talla, $descripcion, $infoAdd, $imagen, $idProducto);

    if ($updateStmt->execute()) {
        header("Location: ../Main/main.php");
    } else {
        echo "Error al actualizar el producto: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="mainstyles.css"> <!-- Asegúrate de que la hoja de estilo esté disponible -->
</head>
<body>

    <!-- INICIO DEL HEADER Y SIDEBAR -->
    <header class="header">
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">             
                <a id="title" class="navbar-brand" href="mainadmin.php">
                    <div class="logo">
                        <i class="fa-solid fa-moon fa-rotate-by" style="--fa-rotate-angle: 330deg;"></i>&nbsp;Zarill
                    </div>
                </a>
            </div>
        </nav>
        <label for="sidebar-toggle" class="menu-button" aria-label="Abrir panel de usuario">
            <img src="../Img/user.png" id="usuario" alt="User" width="35" height="35" class="d-inline-block align-text-top">
        </label>
    </header>
    
    <input type="checkbox" id="sidebar-toggle" aria-hidden="true">

    <aside class="sidebar">
        <div class="sidebar-content">
            <label for="sidebar-toggle" class="close-button" aria-label="Cerrar panel de usuario">
                <i class="fas fa-times"></i>
            </label>
            <div class="user-info">
                <div class="avatar" aria-hidden="true">
                    <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
                </div>
                <div class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
            </div>
            <nav class="container-btn">
                <button class="nav-button" onclick="window.location.href='../Inventory/inventory.php'">
                    <i class="fa-solid fa-box"></i> Inventario
                </button>
                <button class="nav-button" onclick="window.location.href=''">
                    <i class="fa-solid fa-pen"></i> Modificar publicacion
                </button>
                <button class="nav-button" onclick="window.location.href='../Publicacion/publicacion.html'">
                    <i class="fa-solid fa-plus"></i> Crear publicacion
                </button>
            </nav>
            <form class="logout-class" action="../Logout/logout.php" method="POST">
                <button type="submit" class="logout-button">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- FORMULARIO DE EDICIÓN -->
    <main class="container mt-5">
        <h1>Editar Producto</h1>
        <div class="row">
            <!-- Imagen del Producto a la izquierda -->
            <div class="col-md-4">
                <div class="product-image">
                    <?php 
                    if ($producto['imagen']) {
                        // Convertir BLOB a base64 y mostrar la imagen
                        $imagenBase64 = base64_encode($producto['imagen']);
                        echo "<img src='data:image/jpeg;base64,{$imagenBase64}' alt='Imagen del Producto' class='img-thumbnail'>";
                    } else {
                        // Si no hay imagen, mostrar una predeterminada
                        echo "<img src='default-image.jpg' alt='Imagen del Producto' class='img-thumbnail'>";
                    }
                    ?>
                </div>
            </div>

            <!-- Formulario de edición a la derecha -->
            <div class="col-md-8">
                <form method="POST" enctype="multipart/form-data">
                    <!-- Nombre del Producto -->
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                    </div>

                    <!-- Precio -->
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
                    </div>

                    <!-- Talla -->
                    <div class="form-group">
                        <label for="talla">Talla</label>
                        <input type="text" class="form-control" id="talla" name="talla" value="<?php echo htmlspecialchars($producto['talla']); ?>" required>
                    </div>

                    <!-- Descripción -->
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($producto['descripcion']); ?>" required>
                    </div>

                    <!-- Información Adicional -->
                    <div class="form-group">
                        <label for="infoAdd">Información Adicional</label>
                        <input type="text" class="form-control" id="infoAdd" name="infoAdd" value="<?php echo htmlspecialchars($producto['infoAdd']); ?>" required>
                    </div>

                    <!-- Imagen (opcional) -->
                    <div class="form-group">
                        <label for="imagen">Imagen</label>
                        <input type="file" class="form-control-file" id="imagen" name="imagen">
                    </div>

                    <!-- Botón de Guardar -->
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </main>

</body>
</html>

<?php
$conn->close();