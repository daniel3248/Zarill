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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Producto</title>
    <link rel="stylesheet" href="publicacionstyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="../Img/logo.png" type="image/png">
    <style>
        /* Centrar imagen dentro de la tarjeta */
        .card-body img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
            transition: transform 0.3s ease-in-out; /* Animación suave */
        }

        /* Animación de la imagen al pasar el mouse */
        .card-body:hover img {
            transform: scale(1.1); /* Aumenta el tamaño de la imagen al pasar el mouse */
        }

        /* Animación para la tarjeta completa */
        .card:hover {
            transform: translateY(-10px); /* La tarjeta se mueve ligeramente hacia arriba */
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1); /* Sombra más pronunciada */
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Transición suave en la tarjeta */
        }
    </style>
</head>
<body>
    <!-- INICIO DEL HEADER -->
    <div id="rounded_1" class="rounded-section"></div>
    <div id="rounded_2" class="rounded-section"></div>
    
    <header class="header">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img  src="../img/logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top">
            </a>
            <h1 id="title">Zarill</h1>
        </div>
    </header>

    <main>
        <form action="publicacion.php" method="post" enctype="multipart/form-data">
            <div class="container-fluid">
                <div class="row">
                    <!-- Imagen del Producto -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <label for="imagen_prenda" style="cursor: pointer;">
                                    <img id="preview" src="../img/mas.jpg" alt="imagen-producto">
                                </label>
                                <input type="file" id="imagen_prenda" name="imagen_prenda" accept="image/*" style="display: none;" onchange="previewImage(event)">
                            </div>
                        </div>
                    </div>

                    <!-- Datos del Producto -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h3>Detalles del Producto</h3>
                                
                                <!-- Nombre -->
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" placeholder="Escoge el nombre de la prenda" required>
                                </div>

                                <!-- Precio -->
                                <div class="mb-3">
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="number" name="precio" class="form-control" placeholder="Digite el Precio" required>
                                </div>

                                <!-- Tallas -->
                                <div class="form-group mb-3">
                                    <label for="Talla" class="form-label">Tallas</label>
                                    <div>
                                        <label><input type="radio" name="talla" value="XL" required> XL</label>
                                        <label><input type="radio" name="talla" value="L"> L</label>
                                        <label><input type="radio" name="talla" value="M"> M</label>
                                        <label><input type="radio" name="talla" value="S"> S</label>
                                    </div>
                                </div>

                                <!-- Descripción -->
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <input type="text" name="descripcion" class="form-control" placeholder="Escriba una breve descripción de la prenda" required>
                                </div>

                                <!-- Información Adicional -->
                                <div class="mb-3">
                                    <label for="infoAdd" class="form-label">Información Adicional</label>
                                    <input type="text" name="infoAdd" class="form-control" placeholder="Agregar datos adicionales">
                                </div>

                                <button type="submit" class="btn btn-block" style="background-color: #9060e7; color: white; border: none;">
                                Agregar Prenda
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const preview = document.getElementById('preview');
                preview.src = reader.result; // Cambia la imagen mostrada
            };
            reader.readAsDataURL(event.target.files[0]); // Lee el archivo seleccionado
        }
    </script>

    <footer>
        <p></p>
    </footer>
    
    <script src="https://kit.fontawesome.com/6be8b4e2de.js" crossorigin="anonymous"></script>
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
