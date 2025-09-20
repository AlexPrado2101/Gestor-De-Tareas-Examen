<?php
    // Incluir archivos necesarios para obtener tareas y aplicar filtros
    include_once("AMetodosPHP/ObtenerTareas.php");
    include_once("AMetodosPHP/Filtro.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración básica de la página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestor de Tareas para organizar y gestionar tus tareas diarias.">
    <title>Gestor de Tareas</title>
    
    <!-- Preconexiones para mejorar el rendimiento -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- CDN Bootstrap CSS para estilos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- CDN Bootstrap Icons para íconos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts para tipografía personalizada -->
    <link href='https://fonts.googleapis.com/css?family=DM+Serif+Display' rel='stylesheet'>
    
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="Css/Estilo_gen.css">
</head>

<body>
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

    <!-- Contenedor principal de la aplicación -->
    <div class="main-content">
        <!-- Barra de filtros y botones -->
        <div class="d-flex justify-content-between align-items-center mb-3 tipografia-titulos">
            <!-- Formulario de filtros -->
            <form method="GET" action="index.php">
                <!-- Filtro de categoría -->
                <select id="cateFilter" name="categoria" class="form-select btn-secondary d-inline w-auto">
                    <option value="">Categoria</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['CodigoCategoria'] ?>" <?= ($categoria['CodigoCategoria'] == $categoriaFiltro) ? 'selected' : '' ?>>
                            <?= $categoria['NombreCategoria'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Filtro de estado -->
                <select id="estadoFilter" name="estado" class="form-select btn-secondary d-inline w-auto">
                    <option value="">Estado</option>
                    <?php foreach ($estados as $estado): ?>
                        <option value="<?= $estado['CodigoEstado'] ?>" <?= ($estado['CodigoEstado'] == $estadoFiltro) ? 'selected' : '' ?>>
                            <?= $estado['NombreEstado'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Filtro de importancia -->
                <select id="importanciaFilter" name="importancia" class="form-select btn-secondary d-inline w-auto">
                    <option value="">Importancia</option>
                    <?php foreach ($importancias as $importancia): ?>
                        <option value="<?= $importancia['CodigoImportancia'] ?>" <?= ($importancia['CodigoImportancia'] == $importanciaFiltro) ? 'selected' : '' ?>>
                            <?= $importancia['NivelImportancia'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Botón para aplicar los filtros -->
                <button id="filterButton" class="btn btn-secondary ms-2" type="submit">Filtrar</button>
            </form>

            <!-- Botones adicionales para crear tarea y calendario -->
            <div>
                <button class="btn btn-secondary" onclick="window.location.href='CalendarioUsuario.php'">
                    <i class="bi-calendar"></i>
                </button>
            </div>
        </div>

        <!-- Tabla de tareas -->
        <div class="mt-4">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr class="tipografia-parrafos text-center">
                        <th>Categoria</th>
                        <th>Tarea</th>
                        <th>Usuario Asignado</th>
                        <th>Inicio de la Tarea</th>
                        <th>Finalización de la Tarea</th>
                        <th>Estado de la Tarea</th>
                        <th>Importancia</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if (!empty($tareas)) {
                        foreach ($tareas as $tarea) {
                            echo "<tr class='tipografia-parrafos text-center'>";
                            echo "<td>" . htmlspecialchars($tarea['NombreCategoria']) . "</td>";
                            echo "<td>" . htmlspecialchars($tarea['NombreTarea']) . "</td>";
                            echo "<td>" . htmlspecialchars($tarea['Usuario']) . "</td>";
                            echo "<td>" . htmlspecialchars($tarea['FechaInicio']) . "</td>";
                            echo "<td>" . htmlspecialchars($tarea['FechaFinal']) . "</td>";
                            echo "<td class='estado-cell'>" . htmlspecialchars($tarea['NombreEstado']) . "</td>";
                            echo "<td class='important-cell'>" . htmlspecialchars($tarea['NivelImportancia']) . "</td>";
                            echo "<td>
                                    <a href='VerTareaUsuario.php?id=" . $tarea['IDTarea'] . "' class='btn btn-info btn-sm'>Ver</a>
                                    <a href='cambiar_estado.php?id=" . $tarea['IDTarea'] . "' class='btn btn-warning btn-sm'>Cambiar Estado</a>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No hay tareas para mostrar</td></tr>";
                    }
                ?>
            </tbody>

            </table>
        </div>

        <!-- Enlace para ver tareas completadas -->
        <a href="TareasCompletadas.html" class="btn btn-secondary tipografia-titulos">Ver Tareas Completadas</a>
    </div>

    <!-- Scripts necesarios para Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>