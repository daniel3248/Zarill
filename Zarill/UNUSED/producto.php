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

</head>
<body>
    
    <!-- SI SE HA INICIADO SESION MOSTRAR HEADER NORMAL -->

    <?php if ($isLoggedIn): ?>      

    <!-- INICIO DEL HEADER -->

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

                <nav>
                    <button class="nav-button" onclick="window.location.href='#modal-enviado'">
                        <i class="fas fa-truck"></i> Envios
                    </button>
                    <button class="nav-button" onclick="window.location.href='#modal-rembolso'">
                        <i class="fas fa-sync-alt"></i> Rembolso
                    </button>
                    <button class="nav-button" onclick="window.location.href='#modal-pagos'">
                        <i class="fas fa-credit-card"></i> Pagos
                    </button>
                    <button class="nav-button" onclick="window.location.href='#modal-resenas'">
                        <i class="fas fa-comments"></i> Reseñas
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

</aside>
    
        <!-- Modal Template (repeated for each modal) -->
        <div id="modal-enviado" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">envios</h2>
                    <a href="#" class="close" aria-label="Cerrar">&times;</a>
                </div>
                <div class="modal-body">
                    <div class="tabs">
                        <button class="tab-button active" data-tab="enviados">enviados</button>
                        <button class="tab-button" data-tab="recividos">recividos</button>
                    </div>
                    <div class="tab-content" id="enviados">
                        <div class="product-entry">
                            <div class="product-image">
                                <img src="/placeholder.svg?height=100&width=100" alt="Imagen del producto">
                            </div>
                            <div class="product-info">
                                <p class="product-name">Informacion del producto</p>
                                <p class="product-quantity">cantidas comprada</p>
                            </div>
                        </div>
                        <div class="product-entry">
                            <div class="product-image">
                                <img src="/placeholder.svg?height=100&width=100" alt="Imagen del producto">
                            </div>
                            <div class="product-info">
                                <p class="product-name">Informacion del producto</p>
                                <p class="product-quantity">cantidas comprada</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="recividos" style="display: none;">
                        <p>No hay envíos recibidos.</p>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Repeat the modal structure for other modals (rembolso, pagos, resenas) -->
        <div id="modal-rembolso" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Rembolsos</h2>
                    <a href="#" class="close" aria-label="Cerrar">&times;</a>
                </div>
                <div class="modal-body">
                    <div class="tabs">
                        <button class="tab-button active" data-tab="en-espera">Rembolsos en espera</button>
                        <button class="tab-button" data-tab="realizados">Rembolsos realizados</button>
                    </div>
                    <div class="tab-content" id="en-espera">
                        <div class="product-entry">
                            <div class="product-image">
                                <img src="/placeholder.svg?height=100&width=100" alt="Imagen del producto">
                            </div>
                            <div class="product-info">
                                <p class="product-name">Informacion del producto</p>
                                <p class="product-quantity">cantidas comprada</p>
                            </div>
                        </div>
                        <div class="refund-reason">
                            <label for="motivo-rembolso">Motivo del rembolso</label>
                            <textarea id="motivo-rembolso" rows="4" placeholder="Escribe el motivo del rembolso"></textarea>
                        </div>
                    </div>
                    <div class="tab-content" id="realizados" style="display: none;">
                        <p>No hay rembolsos realizados.</p>
                    </div>
                </div>
            </div>
        </div>
        
    
        <div id="modal-pagos" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">pagos</h2>
                    <a href="#" class="close" aria-label="Cerrar">&times;</a>
                </div>
                <div class="modal-body">
                    <div class="tabs">
                        <button class="tab-button active" data-tab="en-espera">pago en espera</button>
                        <button class="tab-button" data-tab="realizado">Pago realizado</button>
                    </div>
                    <div class="tab-content" id="en-espera">
                        <div class="product-entry">
                            <div class="product-image">
                                <img src="/placeholder.svg?height=100&width=100" alt="Imagen del producto">
                            </div>
                            <div class="product-info">
                                <p class="product-name">Informacion del producto</p>
                                <p class="product-quantity">cantidas comprada</p>
                                <div class="price-details">
                                    <div class="price-row">
                                        <span>Precio subtotal</span>
                                        <span>$$$</span>
                                    </div>
                                    <div class="price-row">
                                        <span>Precio envío</span>
                                        <span>$$$</span>
                                    </div>
                                    <div class="price-row total">
                                        <span>Precio total</span>
                                        <span>$$$</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-entry">
                            <div class="product-image">
                                <img src="/placeholder.svg?height=100&width=100" alt="Imagen del producto">
                            </div>
                            <div class="product-info">
                                <p class="product-name">Informacion del producto</p>
                                <p class="product-quantity">cantidas comprada</p>
                                <div class="price-details">
                                    <div class="price-row">
                                        <span>Precio subtotal</span>
                                        <span>$$$</span>
                                    </div>
                                    <div class="price-row">
                                        <span>Precio envío</span>
                                        <span>$$$</span>
                                    </div>
                                    <div class="price-row total">
                                        <span>Precio total</span>
                                        <span>$$$</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="realizado" style="display: none;">
                        <p>No hay pagos realizados.</p>
                    </div>
                </div>
            </div>
        </div>
        
    
        <div id="modal-resenas" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">RESEÑAS</h2>
                    <a href="#" class="close" aria-label="Cerrar">&times;</a>
                </div>

                
                <!-- Add content specific to resenas modal here -->
                <p>Aquí puedes ver y gestionar tus reseñas.</p>
            </div>
        </div>
    </body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
    
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabName = button.getAttribute('data-tab');
    
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.style.display = 'none');
    
                    button.classList.add('active');
                    document.getElementById(tabName).style.display = 'block';
                });
            });
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
    
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabName = button.getAttribute('data-tab');
    
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.style.display = 'none');
    
                    button.classList.add('active');
                    document.getElementById(tabName).style.display = 'block';
                });
            });
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
    
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabName = button.getAttribute('data-tab');
    
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.style.display = 'none');
    
                    button.classList.add('active');
                    document.getElementById(tabName).style.display = 'block';
                });
            });
        });
    </script>     

    <!-- INICIO DEL BODY -->

    <section class="product-section">
    <div class="product-container">
        <div class="product-image">
            <img src="../Img/pij1.jpg" alt="Pijama Stitch">
        </div>

        <div class="product-details">
            <div class="product-form">
                <h1>Pijama Stitch</h1>
                <p class="price">42.000</p>

                <div class="product-options">
                    <label for="color">Color</label>
                    <select id="color" name="color">
                        <option value="lila">Lila</option>
                    </select>

                    <!-- Tallas con checkboxes -->
                    <fieldset>
                        <legend>Talla:</legend>
                        <label>
                            <input type="radio" name="talla" value="S" required> S
                        </label>
                        <label>
                            <input type="radio" name="talla" value="M" required> M
                        </label>
                        <label>
                            <input type="radio" name="talla" value="L" required> L
                        </label>
                        <label>
                            <input type="radio" name="talla" value="XL" required> XL
                        </label>
                    </fieldset>
                </div>

                <label for="cantidad">Cantidad</label>
                <div class="quantity-cart">
                    <input type="number" id="cantidad" name="cantidad" value="1" min="1" required>
                    <form action="checkout.php" method="GET">
                        <input type="hidden" name="producto" value="Pijama Stitch">
                        <input type="hidden" name="precio" value="42000">
                        <input type="hidden" name="color" value="lila">
                        <input type="hidden" name="imagen" value="../Img/pij1.jpg"> <!-- URL de la imagen -->
                        <input type="hidden" name="talla" value="L">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" id="cantidad" name="cantidad" value="1" min="1">
                        <button type="submit" class="add-to-cart">Comprar</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
</section>


</body>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>