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
                <button onclick="window.location.href='CrearTarea.php'" class="btn btn-secondary">Crear Tarea</button>
                <button class="btn btn-secondary" onclick="window.location.href='Calendario.php'">
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
                        // Verificar si hay tareas para mostrar
                        if (!empty($tareas)) {
                            // Ciclo para mostrar cada tarea en una fila de la tabla
                            foreach ($tareas as $tarea) {
                                echo "<tr class='tipografia-parrafos text-center'>";
                                echo "<td>" . $tarea['NombreCategoria'] . "</td>";
                                echo "<td>" . $tarea['NombreTarea'] . "</td>";
                                echo "<td>" . $tarea['Usuario'] . "</td>";
                                echo "<td>" . $tarea['FechaInicio'] . "</td>";
                                echo "<td>" . $tarea['FechaFinal'] . "</td>";
                                echo "<td class='estado-cell'>" . $tarea['NombreEstado'] . "</td>";
                                echo "<td class='important-cell'>" . $tarea['NivelImportancia'] . "</td>";
                                echo "<td>
                                        <a href='VerTarea.php?id=" . $tarea['IDTarea'] . "' class='btn btn-info btn-sm'>Ver</a>
                                        <a href='Editar.php?id=" . $tarea['IDTarea'] . "' class='btn btn-warning btn-sm'>Editar</a>
                                        <button class='btn btn-danger btn-sm eliminar-btn' onclick='confirmarEliminacion(" . $tarea['IDTarea'] . ")'>Eliminar</button>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            // Mensaje cuando no hay tareas para mostrar
                            echo "<tr><td colspan='8' class='text-center'>No hay tareas para mostrar</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <!---------------------------------Eliminar ---------------------------->    
        
        <a href="TareasCompletadas.html" class="btn btn-secondary tipografia-titulos">Ver Tareas Completadas</a>
    </div>
    
    <div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar esta tarea?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let idTareaAEliminar;

        function confirmarEliminacion(idTarea) {
            idTareaAEliminar = idTarea;
            var modalConfirmacion = new bootstrap.Modal(document.getElementById('modalConfirmacion'));
            modalConfirmacion.show();
        }

        document.getElementById("btnConfirmarEliminar").addEventListener("click", function() {
            window.location.href = "AMetodosPHP/delete.php?id=" + idTareaAEliminar;
        });
    </script>


        <!-- Enlace para ver tareas completadas -->
        <a href="TareasCompletadas.html" class="btn btn-secondary tipografia-titulos">Ver Tareas Completadas</a>
    </div>

    <!-- Scripts necesarios para Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>