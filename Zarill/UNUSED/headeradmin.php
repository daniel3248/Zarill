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
                <img src="../Img/user.png" id="usuario" alt="User" width="35" height="35" class="d-inline-block align-text-top">
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