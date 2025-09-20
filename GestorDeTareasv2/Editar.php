<?php
    // Incluir el archivo de conexión y/o lógica de conexión
    include_once("AMetodosPHP/EditarTarea.php");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestor de Tareas para organizar y gestionar tus tareas diarias.">
    <title>Editar Tarea</title>
    
    <!-- Preconexiones y estilos CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href='https://fonts.googleapis.com/css?family=DM+Serif+Display' rel='stylesheet'>
    <link rel="stylesheet" href="Css/Estilo_gen.css">
</head>

<body class="fondo-especifico">
    
    <!-- Contenedor para la edición de tarea -->
    <div class="container tipografia-parrafos">
        <div class="card-crear p-4">
            <!-- Título del formulario -->
            <h2 class="tipografia-titulos text-center mb-4">Editar Tarea</h2>
            
            <form method="POST" class="tipografia-parrafo">
                <div class="row">
                    <!-- Columna izquierda con campos principales -->
                    <div class="col-md-6">
                        <!-- Campo de nombre de la tarea -->
                        <div class="mb-4">
                            <label for="nombreTarea" class="form-label tipografia-titulos"><strong>Título de la Tarea</strong></label>
                            <input type="text" id="nombreTarea" name="nombreTarea" class="form-control" value="<?= htmlspecialchars($tarea['NombreTarea']) ?>" required>
                        </div>

                        <!-- Campo de usuario asignado -->
                        <div class="mb-4">
                            <label for="asignadoA" class="form-label tipografia-titulos"><strong>Asignado a</strong></label>
                            <select id="asignadoA" name="asignadoA" class="form-control" required>
                                <?php
                                // Consulta para obtener todos los usuarios
                                $usuariosQuery = "SELECT IDUsuario, Usuario FROM Usuario";
                                $stmtUsuarios = $conn->prepare($usuariosQuery);
                                $stmtUsuarios->execute();
                                $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

                                // Mostrar la lista de usuarios
                                foreach ($usuarios as $usuario) {
                                    // Comprobar si el usuario está asignado a la tarea
                                    $selected = ($usuario['IDUsuario'] == $tarea['UsuarioAsignado']) ? 'selected' : '';
                                    echo "<option value='" . $usuario['IDUsuario'] . "' $selected>" . $usuario['Usuario'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Campo de fecha de inicio -->
                        <div class="mb-4">
                            <label for="fechaInicio" class="form-label tipografia-titulos"><strong>Fecha de Inicio</strong></label>
                            <input type="date" id="fechaInicio" name="fechaInicio" class="form-control" value="<?= htmlspecialchars($tarea['FechaInicio']) ?>" required>
                        </div>

                        <!-- Campo de fecha final -->
                        <div class="mb-4">
                            <label for="fechaFinal" class="form-label tipografia-titulos"><strong>Fecha de Finalización</strong></label>
                            <input type="date" id="fechaFinal" name="fechaFinal" class="form-control" value="<?= htmlspecialchars($tarea['FechaFinal']) ?>" required>
                        </div>
                    </div>

                    <!-- Columna derecha con campos adicionales -->
                    <div class="col-md-6">
                        <!-- Campo de importancia de la tarea -->
                        <div class="mb-4">
                            <label for="importancia" class="form-label tipografia-titulos"><strong>Nivel de Importancia</strong></label>
                            <select id="importancia" name="importancia" class="form-control" required>
                                <?php
                                // Consulta para obtener todos los niveles de importancia
                                $importanciaQuery = "SELECT CodigoImportancia, NivelImportancia FROM Importancia";
                                $stmtImportancia = $conn->prepare($importanciaQuery);
                                $stmtImportancia->execute();
                                $importancias = $stmtImportancia->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($importancias as $nivel) {
                                    $selected = ($nivel['CodigoImportancia'] == $tarea['CodigoImportancia']) ? 'selected' : '';
                                    echo "<option value='" . $nivel['CodigoImportancia'] . "' $selected>" . $nivel['NivelImportancia'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Campo de Estado -->




                        <!-- Campo de categoría de la tarea -->
                        <div class="mb-4">
                            <label for="categoria" class="form-label tipografia-titulos"><strong>Categoría</strong></label>
                            <select id="categoria" name="categoria" class="form-control" required>
                                <?php
                                // Consulta para obtener todas las categorías
                                $categoriasQuery = "SELECT CodigoCategoria, NombreCategoria FROM Categoria";
                                $stmtCategorias = $conn->prepare($categoriasQuery);
                                $stmtCategorias->execute();
                                $categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);

                                // Mostrar la lista de categorías
                                foreach ($categorias as $categoria) {
                                    // Comprobar si la categoría está asignada a la tarea
                                    $selected = ($categoria['CodigoCategoria'] == $tarea['CodigoCategoria']) ? 'selected' : '';
                                    echo "<option value='" . $categoria['CodigoCategoria'] . "' $selected>" . $categoria['NombreCategoria'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Campo de descripción -->
                        <div class="form-group mb-6">
                            <label for="descripcion" class="form-label tipografia-titulos"><strong>Descripción</strong></label>
                            <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required><?= htmlspecialchars($tarea['Descripcion']) ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Contenedor para los botones, centrado y fuera de las columnas -->
                <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                    <button type="submit" class="btn btn-secondary">Guardar Cambios</button>
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
