<?php
session_start(); // Iniciar sesión
$isLoggedIn = isset($_SESSION['user_id']); // Verificar si el usuario ha iniciado sesión

// Verificar si el usuario tiene rol de admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Si el usuario no es admin, redirigir a main.php
    header("Location: ../Main/main.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarill</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="mainstyles.css">
    <link rel="icon" href="../Img/logo.png" type="image/png">
    <style>
        .product-image {
    width: 100%; /* Ocupa el 100% del ancho del card */
    height: auto; /* Mantiene la relación de aspecto */
    max-height: 200px; /* Define una altura máxima para las imágenes */
    object-fit: contain; /* Asegura que la imagen se ajuste al área sin recortarse */
}

    </style>
</head>
<body>

    <!-- INICIO DEL HEADER -->
    <header class="header">
        <!-- LOS 2 DIV SON LA NUBE -->
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
    
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">             
                <a id="title" class="navbar-brand" href="mainadmin.php">
                    <div class="logo">
                        <i class="fa-solid fa-moon fa-rotate-by" style="--fa-rotate-angle: 330deg;"></i>&nbsp;Zarill
                    </div>
                </a>
        </nav>
        <label for="sidebar-toggle" class="menu-button" aria-label="Abrir panel de usuario">
            <img src="../Img/user.png" id="usuario" alt="User" width="30" height="35" class="d-inline-block align-text-top">
        </label>
    </header>

    <input type="checkbox" id="sidebar-toggle" aria-hidden="true">

    <!-- Mostrar la sidebar con opciones -->
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
                <button class="nav-button" onclick="window.location.href='../Publicacion/publicacionn.php'">
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

    <!-- INICIO DEL BODY -->
    <main class="container mt-4">
        <div class="row">
            <!-- CATALOGO DE PRODUCTOS -->
            <div class="col-md-12">
                <div class="catalog">
                    <h5 id="categoria-catalogo">Catálogo</h5>
                    <div class="row">

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

                        // Consultar los productos en la base de datos
                        $sql = "SELECT idProducto, nombre, talla, descripcion, infoAdd, precio, imagen FROM producto";
                        $result = $conn->query($sql);

                        // Manejar errores en la consulta SQL
                        if (!$result) {
                            die("Error en la consulta SQL: " . $conn->error);
                        }

                        // Verificar si se obtuvieron productos
                        if ($result->num_rows > 0) {
                            // Mostrar productos en cards
                            while ($row = $result->fetch_assoc()) {
                                $imagen = base64_encode($row['imagen']); // Convertir la imagen en base64
                                ?>
                                <!-- Card de producto -->
                                <div id="card" class="col-md-4 mb-4">
                                    <a href="../Producto/producto.php?id=<?php echo $row['idProducto']; ?>" class="text-decoration-none">
                                        <div class="card border text-center p-3 animate-fade">
                                            <!-- Imagen del producto -->
                                            <img src="data:image/jpeg;base64,<?php echo $imagen; ?>" alt="Imagen del producto" class="product-image mb-3">
                                            <!-- Nombre del producto -->
                                            <p class="description"><?php echo $row["nombre"]; ?></p>
                                            <!-- Precio del producto -->
                                            <p class="price">$<?php echo number_format($row["precio"], 2, ',', '.'); ?></p>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>No se encontraron productos.</p>";
                        }

                        // Cerrar la conexión
                        $conn->close();
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </main>
    
</body>
<script>
    document.getElementById('inventario-btn').addEventListener('click', function() {
        // Hacer la solicitud AJAX para obtener los productos
        fetch('obtener_inventario.php')
            .then(response => response.text())
            .then(data => {
                // Mostrar la tabla en el contenedor
                document.getElementById('tabla-inventario').innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>
