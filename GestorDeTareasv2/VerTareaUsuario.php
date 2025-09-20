<?php
    // Incluir el archivo de conexión y/o ObtenerTareas si ahí tienes la lógica de conexión
    include_once("AMetodosPHP/VerTarea.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestor de Tareas para organizar y gestionar tus tareas diarias.">
    <title>Gestor de Tareas</title>
    
    <!-- Preconexiones para mejorar el rendimiento -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- CDN Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- CDN Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=DM+Serif+Display' rel='stylesheet'>
    
    <!-- Estilos Personalizados -->
    <link rel="stylesheet" href="Css/Estilo_gen.css">
</head>

<body class="fondo-especifico">
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg tipografia-titulos">
        <div class="container-fluid">
            <!-- Botón de menú desplegable para dispositivos móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#Mostrar-Navbar" aria-controls="Mostrar-Navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Marca de la aplicación y perfil del usuario -->
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <div class="text-center ms-2">
                    <h1 class="usuario">Nombre de Usuario</h1>
                    <h2 class="rol">Rol del Usuario</h2>
                </div>
            </a>
            
            <!-- Menú de navegación -->
            <div class="collapse navbar-collapse" id="Mostrar-Navbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link help-button" href="Documentacion.html">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <!-- Cambiar el enlace de logout a 'logout.php' -->
                        <a class="nav-link logout-button" href="logout.php">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenedor para la tarea -->
    <div class="container mt-5">
        <div class="card-crear p-4">
            <h3 class="tipografia-titulos"><?= htmlspecialchars($tarea['NombreTarea']) ?></h3>
            <p class="tipografia-parrafos bold"><strong>Asignado a:</strong> <?= htmlspecialchars($tarea['AsignadoA']) ?></p>
            <p class="tipografia-parrafos bold"><strong>Descripción:</strong> <?= htmlspecialchars($tarea['Descripcion']) ?></p>
            <p class="tipografia-parrafos bold"><strong>Categoría:</strong> <?= htmlspecialchars($tarea['Categoria']) ?></p>
            <p class="tipografia-parrafos bold"><strong>Fecha de Inicio:</strong> <?= htmlspecialchars($tarea['FechaInicio']) ?></p>
            <p class="tipografia-parrafos bold"><strong>Fecha de Finalización:</strong> <?= htmlspecialchars($tarea['FechaFinal']) ?></p>
        </div>

        <!-- Botón de regreso -->
        <div class="mt-4 text-center">
            <a href="indexUsuario.php" class="btn btn-secondary tipografia-titulos">Volver a la página principal</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
