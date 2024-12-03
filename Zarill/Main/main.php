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
        .product-image {
    width: 100%; /* Ocupa el 100% del ancho del card */
    height: auto; /* Mantiene la relación de aspecto */
    max-height: 200px; /* Define una altura máxima para las imágenes */
    object-fit: contain; /* Asegura que la imagen se ajuste al área sin recortarse */
}

    </style>
</head>

    <!-- SI LA PERSONA QUE HA INICIADO SESION ES UN ADMIN, SERA REDIRIGIDO A LA PAGINA DE ADMINISTRACION -->

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {

        header("Location: ../Mainadmin/mainadmin.php");
        exit;
    }
    ?>
    
    <!-- SI SE HA INICIADO SESION MOSTRAR HEADER NORMAL -->

    <?php if ($isLoggedIn): ?>      

    <!-- INICIO DEL HEADER -->

    <header class="header">
        
        <!-- LOS 2 DIV SON LA NUBE -->
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
    
        <nav class="navbar">
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
            <button id="btnEnvios" class="btn-open">
                <i class="fas fa-sync-alt"></i>  Envíos
            </button>
            <button id="btnReembolso" class="btn-open">
                <i class="fas fa-truck"></i> Reembolsos
            </button>
            <button id="btnPagos" class="btn-open">
                <i class="fas fa-credit-card"></i> Pagos
            </button>
            <button id="btnConfiguracion" class="btn-open">
                <i class="fas fa-comments"></i> Configuración
            </button>
            </nav>

            <form class="logout-class" action="../Logout/logout.php" method="POST">
                <button type="submit" class="logout-button">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </button>
            </form>
        </div>
        </aside>

    <!-- SI NO SE HA INICIADO SESION MOSTRAR BOTON DE INICIAR SESION -->
    
    <?php else: ?>          
            
    <header class="header">
        
        <!-- LOS 2 DIV SON LA NUBE -->
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
    
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">             
                <a id="title" class="navbar-brand" href="main.php">
                    <div class="logo">
                        <i class="fa-solid fa-moon fa-rotate-by" style="--fa-rotate-angle: 330deg;"></i>&nbsp;Zarill
                    </div>
                </a>
        </nav>
        
        <div class="login-area">
            <button onclick="window.location.href='../Login/login.html'" class="login-button">
                &nbsp;<i id="login-icon" class="fas fa-user"></i>&nbsp;Iniciar Sesión&nbsp;
            </button>
        </div>

    </header>
    
    <input type="checkbox" id="sidebar-toggle" aria-hidden="true">

    <?php endif; ?>

            <!-- Modal Envios -->
        <div id="modalEnvios" class="modal">
            <div class="modal-content">
                <span id="closeModalEnvios" class="close">&times;</span>
                <h2>Envíos</h2>
                <div id="toggleEnvios">
                    <button id="btnEnviado" class="btn">Enviado</button>
                    <button id="btnRecibido" class="btn">Recibido</button>
                </div>
                <div id="enviosEnviado" class="toggle-section active">
                    <h3>Estado: Enviado</h3>
                    <p>Información sobre envíos realizados.</p>
                </div>
                <div id="enviosRecibido" class="toggle-section">
                    <h3>Estado: Recibido</h3>
                    <p>Información sobre envíos recibidos.</p>
                </div>
            </div>
        </div>

        <!-- Modal Reembolso -->
        <div id="modalReembolso" class="modal">
            <div class="modal-content">
                <span id="closeModalReembolso" class="close">&times;</span>
                <h2>Reembolso</h2>
                <div id="toggleReembolso">
                    <button id="btnEspera" class="btn">Reembolso en Espera</button>
                    <button id="btnRealizado" class="btn">Reembolso Realizado</button>
                </div>
                <div id="reembolsoEspera" class="toggle-section active">
                    <h3>Estado: En Espera</h3>
                    <p>Información sobre reembolsos en espera.</p>
                </div>
                <div id="reembolsoRealizado" class="toggle-section">
                    <h3>Estado: Realizado</h3>
                    <p>Información sobre reembolsos realizados.</p>
                </div>
            </div>
        </div>

        <!-- Modal Pagos -->
        <div id="modalPagos" class="modal">
            <div class="modal-content">
                <span id="closeModalPagos" class="close">&times;</span>
                <h2>Pagos</h2>
                <div id="togglePagos">
                    <button id="btnPagoEspera" class="btn">Pagos en Espera</button>
                    <button id="btnPagoRealizado" class="btn">Pago Realizado</button>
                </div>
                <div id="pagosEspera" class="toggle-section active">
                    <h3>Estado: En Espera</h3>
                    <p>Información sobre pagos en espera.</p>
                </div>
                <div id="pagosRealizado" class="toggle-section">
                    <h3>Estado: Realizado</h3>
                    <p>Información sobre pagos realizados.</p>
                </div>
            </div>
        </div>


        <div id="modalConfiguracion" class="modal">
            <div class="modal-content">
                <span id="closeModalConfiguracion" class="close">&times;</span>
                <h2>Configuración de Perfil</h2>

                <!-- Botones de navegación entre apartados -->
                <div id="toggleButtons">
                    <button id="toggleUsuario" class="btn">Usuario</button>
                    <button id="toggleDatos" class="btn">Datos</button>
                </div>

                <!-- Apartado Usuario -->
                <div id="seccionUsuario" class="toggle-section">
                    <h3>Usuario</h3>
                    <form id="formUsuario">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Nuevo email">
                        <label for="emailDatos">Email:</label>
                        <input type="email" id="emailDatos" name="emailDatos" placeholder="Email">
                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" placeholder="Nueva contraseña">
                        <button type="submit" class="btn">Actualizar Usuario</button>
                    </form>
                </div>

                <!-- Apartado Datos -->
                <div id="seccionDatos" class="toggle-section" style="display: none;">
                    <h3>Datos Personales</h3>
                    <div class="user-info">
                        <div class="avatar" aria-hidden="true">
                            <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
                        </div>
                        <div class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
                    </div>

                    <form id="formDatos">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Nombre completo">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" id="telefono" name="telefono" placeholder="Número de teléfono">
                        <label for="direccion">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" placeholder="Dirección">
                        <label for="ciudad">Ciudad:</label>
                        <input type="text" id="ciudad" name="ciudad" placeholder="Ciudad">
                        <button type="submit" class="btn">Actualizar Datos</button>
                    </form>
                </div>
            </div>
        </div>

    <script>
        // Función para cerrar todos los modales
        function cerrarTodosLosModales() {
            const modales = document.querySelectorAll(".modal"); // Selecciona todos los modales
            modales.forEach(modal => {
                modal.style.display = "none"; // Cierra cada modal
            });
        }

        // Función para configurar modales
        function configurarModal(botonId, modalId, cerrarId) {
            const boton = document.getElementById(botonId);
            const modal = document.getElementById(modalId);
            const cerrar = document.getElementById(cerrarId);

            // Abrir modal
            boton.onclick = function () {
                cerrarTodosLosModales(); // Cierra los demás modales
                modal.style.display = "block"; // Muestra el modal actual
            };

            // Cerrar modal con la "X"
            cerrar.onclick = function () {
                modal.style.display = "none";
            };
        }

        // Evento global para cerrar modal al hacer clic fuera del contenido
        window.addEventListener("click", function (event) {
            const modales = document.querySelectorAll(".modal");
            modales.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        });

        // Configuración de los modales
        configurarModal("btnEnvios", "modalEnvios", "closeModalEnvios");
        configurarModal("btnReembolso", "modalReembolso", "closeModalReembolso");
        configurarModal("btnPagos", "modalPagos", "closeModalPagos");
        configurarModal("btnConfiguracion", "modalConfiguracion", "closeModalConfiguracion");

        // Función genérica para gestionar toggles dentro de un modal
        function configurarToggle(toggleBtns, sections) {
            toggleBtns.forEach((btn, index) => {
                btn.addEventListener("click", () => {
                    // Ocultar todas las secciones
                    sections.forEach(section => section.style.display = "none");
                    // Mostrar la sección correspondiente
                    sections[index].style.display = "block";
                });
            });
        }

        // Configuración de los toggles por modal

        // Modal Configuración
        const toggleUsuarioBtn = document.getElementById("toggleUsuario");
        const toggleDatosBtn = document.getElementById("toggleDatos");
        const seccionUsuario = document.getElementById("seccionUsuario");
        const seccionDatos = document.getElementById("seccionDatos");

        // Mostrar solo la sección seleccionada en Configuración
        toggleUsuarioBtn.addEventListener("click", () => mostrarSeccion(seccionUsuario));
        toggleDatosBtn.addEventListener("click", () => mostrarSeccion(seccionDatos));
        function mostrarSeccion(seccion) {
            seccionUsuario.style.display = "none";
            seccionDatos.style.display = "none";
            seccion.style.display = "block";
        }
        // Mostrar la sección inicial (Usuario)
        mostrarSeccion(seccionUsuario);

        // Modal Envios
        const enviosBtns = [document.getElementById("btnEnviado"), document.getElementById("btnRecibido")];
        const enviosSections = [document.getElementById("enviosEnviado"), document.getElementById("enviosRecibido")];
        configurarToggle(enviosBtns, enviosSections);

        // Modal Reembolso
        const reembolsoBtns = [document.getElementById("btnEspera"), document.getElementById("btnRealizado")];
        const reembolsoSections = [document.getElementById("reembolsoEspera"), document.getElementById("reembolsoRealizado")];
        configurarToggle(reembolsoBtns, reembolsoSections);

        // Modal Pagos
        const pagosBtns = [document.getElementById("btnPagoEspera"), document.getElementById("btnPagoRealizado")];
        const pagosSections = [document.getElementById("pagosEspera"), document.getElementById("pagosRealizado")];
        configurarToggle(pagosBtns, pagosSections);


    </script>
    
    
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


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>