<?php
session_start(); // Iniciar sesión
$isLoggedIn = isset($_SESSION['user_id']); // Verificar si el usuario ha iniciado sesión
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
        /* Añadir un borde a las tarjetas */
        .card {
            border: 2px solid #ddd; /* Borde gris claro */
            border-radius: 10px; /* Bordes redondeados */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Animación de transformación y sombra */
        }

        /* Efecto al pasar el mouse */
        .card:hover {
            transform: translateY(-10px); /* Subir ligeramente la tarjeta */
            box-shadow: 0 4px 20px  /* Sombra suave */
            border-color: #007bff; /* Cambiar color del borde al azul */
        }
    </style>
</head>
<body>

<!-- Verificar si el usuario es admin -->
<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: ../Mainadmin/mainadmin.php");
    exit;
} ?>

<!-- Si el usuario ha iniciado sesión, se muestra el header normal -->
<?php if ($isLoggedIn): ?>      

<!-- INICIO DEL HEADER -->
<header class="header">
    <div class="circle circle1"></div>
    <div class="circle circle2"></div>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">             
            <a id="title" class="navbar-brand" href="main.php">
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
<?php else: ?>
<!-- Si no se ha iniciado sesión, mostrar el header con opción de login -->
<header class="header">
    <div class="circle circle1"></div>
    <div class="circle circle2"></div>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">             
            <a id="title" class="navbar-brand" href="main.php">
                <div class="logo">
                    <i class="fa-solid fa-moon fa-rotate-by" style="--fa-rotate-angle: 330deg;"></i>&nbsp;Zarill
                </div>
            </a>
        </div>
    </nav>
    
    <div class="login-area">
        <button onclick="window.location.href='../Login/login.html'" class="login-button">
            &nbsp;<i id="login-icon" class="fas fa-user"></i>&nbsp;Iniciar Sesión&nbsp;
        </button>
    </div>
</header>

<input type="checkbox" id="sidebar-toggle" aria-hidden="true">
<?php endif; ?>

<!-- Verificar si el usuario ha iniciado sesión -->
<?php
// Recoger los datos del formulario
$producto = isset($_POST['producto']) ? $_POST['producto'] : '';
$precio = isset($_POST['precio']) ? $_POST['precio'] : 0;
$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 1; // Valor por defecto 1
$imagen = isset($_POST['imagen']) ? $_POST['imagen'] : ''; // Recoger la imagen

// Calcular el precio total
$total = $precio * $cantidad;
?>

<!-- Contenido del Checkout -->

<h1 class="custom-title">Resumen de tu compra</h1>

<style>
    .custom-title {
        text-align: center;
        background-color: #f8f9fa; /* Gris claro */
        padding: 20px 0; /* Espaciado superior e inferior */
        margin-bottom: 30px; /* Espaciado debajo del título */
        border-radius: 8px; /* Opcional, para bordes redondeados */
        color: rgb(184, 155, 155):
    }
</style>


    <div class="row">
        <!-- Columna de la imagen dentro de una tarjeta -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3>Producto</h3>
                    <img src="<?php echo $imagen; ?>" alt="Imagen del producto" class="img-fluid" style="max-width: 100%; height: auto;">
                </div>
            </div>
        </div>

        <!-- Columna de los datos del producto dentro de una tarjeta -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3>Detalles </h3>
                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($producto); ?></p>
                    <p><strong>Precio unitario:</strong> $<?php echo number_format($precio, 2, ',', '.'); ?></p>
                    <p><strong>Cantidad:</strong> <?php echo $cantidad; ?></p>
                    <p><strong>Precio Total:</strong> $<?php echo number_format($total, 2, ',', '.'); ?></p>
                </div>
            </div>
        </div>

        <!-- Columna para el formulario de pago dentro de una tarjeta -->
        <div class="col-md-4">
    <div class="card" style="border: 1px solid #ccc; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <div class="card-body">
            <h3 class="text-center">Métodos de Pago</h3>
            
            
            <form action="procesar_pago.php" method="POST">
    <input type="hidden" name="producto" value="<?php echo htmlspecialchars($producto); ?>">
    <input type="hidden" name="precio_total" value="<?php echo $total; ?>">
    <input type="hidden" name="cantidad" value="<?php echo $cantidad; ?>">
    <input type="hidden" name="imagen" value="<?php echo $imagen; ?>">

    <!-- Método de Pago: Tarjeta de Crédito -->
    <div class="form-group">
        <label for="tarjeta_numero">Número de tarjeta</label>
        <input type="text" class="form-control" id="tarjeta_numero" name="tarjeta_numero" required placeholder="1234 5678 9101 1121">
    </div>

    <div class="form-group">
        <label for="tarjeta_nombre">Nombre del titular</label>
        <input type="text" class="form-control" id="tarjeta_nombre" name="tarjeta_nombre" required placeholder="Nombre del titular">
    </div>

    <div class="form-group">
        <label for="tarjeta_cvc">CVC</label>
        <input type="text" class="form-control" id="tarjeta_cvc" name="tarjeta_cvc" required placeholder="123">
    </div>

    <!-- Método de Pago: PayPal -->
    <div class="form-group">
        <label for="paypal_email">Correo electrónico de PayPal</label>
        <input type="email" class="form-control" id="paypal_email" name="paypal_email" placeholder="example@paypal.com">
    </div>

    <!-- Botón para realizar el pago -->
    <button type="submit" class="btn btn-block" style="background-color: #9060e7; color: white; border: none;">
        Realizar Pago
    </button>
</form>


            
        </div>
    </div>
</div>

    </div>
</div>

</body>
</html>

