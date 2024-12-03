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

// Consultar los productos en la base de datos
$sql = "SELECT idProducto, nombre, talla, descripcion, infoAdd, precio, imagen FROM producto";
$result = $conn->query($sql);

// Manejar errores en la consulta SQL
if (!$result) {
    die("Error en la consulta SQL: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Productos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="mainstyles.css">
    <link rel="icon" href="../Img/logo.png" type="image/png">
</head>
<body>

    <!-- INICIO DEL HEADER (NO MODIFICADO) -->
    <header class="header">
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">             
                <a id="title" class="navbar-brand" href="../Mainadmin/mainadmin.php">
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

    <!-- SIDEBAR (NO MODIFICADO) -->
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

    <!-- INVENTARIO -->

    <div class="inventory-title">
        <h1>Inventario de Productos</h1>
    </div>

    <main class="inventory-container">
        <div class="table-responsive">
            <table class="table inventory-table">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Talla</th>
                        <th>Descripción</th>
                        <th>Información Adicional</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mostrar productos
                    while ($row = $result->fetch_assoc()) {
                        $imagen = base64_encode($row['imagen']); // Convertir la imagen en base64
                        echo "
                        <tr class='inventory-table'>
                            <td><img src='data:image/jpeg;base64,$imagen' alt='Producto' class='product-image'></td>
                            <td>" . $row["nombre"] . "</td>
                            <td>" . $row["talla"] . "</td>
                            <td>" . $row["descripcion"] . "</td>
                            <td>" . $row["infoAdd"] . "</td>
                            <td>$" . number_format($row["precio"], 2, ',', '.') . "</td>
                            <td>
                                <a href='editarproducto.php?id=" . $row['idProducto'] . "' class='btn btn-edit'>
                                    <i class='fas fa-pencil-alt'></i>
                                </a>
                                <a href='eliminarproducto.php?id=" . $row['idProducto'] . "' class='btn btn-delete'>
                                    <i class='fas fa-trash'></i>
                                </a>
                            </td>
                        </tr>
                        ";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>