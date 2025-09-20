<?php
include_once("AMetodosPHP/CrearTarea.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Tarea</title>
    <!-- Importación de estilos externos (Bootstrap y Google Fonts) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="Css/Estilo_gen.css">
</head>

<body class="fondo-especifico tipografia-parrafos">

    <div class="container tipografia-parrafos">
        <div class="card-crear p-4">

            <!-- Título del formulario -->
            <h2 class="tipografia-titulos text-center mb-4">Crear Tarea</h2>

            <form method="POST" class="tipografia-parrafo">
                <div class="row">
                    <!-- Columna izquierda con campos principales -->
                    <div class="col-md-6">
                        <!-- Campo de nombre de la tarea -->
                        <div class="mb-4">
                            <label for="nombreTarea" class="form-label tipografia-titulos"><strong>Título de la Tarea</strong></label>
                            <input type="text" id="nombreTarea" name="nombreTarea" class="form-control" required>
                        </div>

                        <!-- Campo de usuario asignado -->
                        <div class="mb-4">
                            <label for="asignadoA" class="form-label tipografia-titulos"><strong>Asignado a</strong></label>
                            <select id="asignadoA" name="asignadoA" class="form-control" required>
                                <?php
                                // Obtener usuarios
                                $usuariosQuery = "SELECT IDUsuario, Usuario FROM Usuario";
                                $stmtUsuarios = $conn->prepare($usuariosQuery);
                                $stmtUsuarios->execute();
                                $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($usuarios as $usuario) {
                                    echo "<option value='" . $usuario['IDUsuario'] . "'>" . $usuario['Usuario'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Campo de fecha de inicio -->
                        <div class="mb-4">
                            <label for="fechaInicio" class="form-label tipografia-titulos"><strong>Fecha de Inicio</strong></label>
                            <input type="date" id="fechaInicio" name="fechaInicio" class="form-control" required>
                        </div>

                        <!-- Campo de fecha final -->
                        <div class="mb-4">
                            <label for="fechaFinal" class="form-label tipografia-titulos"><strong>Fecha de Finalización</strong></label>
                            <input type="date" id="fechaFinal" name="fechaFinal" class="form-control" required>
                        </div>
                    </div>

                    <!-- Columna derecha con campos adicionales -->
                    <div class="col-md-6">
                        <!-- Campo de importancia de la tarea -->
                        <div class="mb-4">
                            <label for="importancia" class="form-label tipografia-titulos"><strong>Nivel de Importancia</strong></label>
                            <select id="importancia" name="importancia" class="form-control" required>
                                <?php
                                // Obtener importancia
                                $importanciaQuery = "SELECT CodigoImportancia, NivelImportancia FROM Importancia";
                                $stmtImportancia = $conn->prepare($importanciaQuery);
                                $stmtImportancia->execute();
                                $importancias = $stmtImportancia->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($importancias as $nivel) {
                                    echo "<option value='" . $nivel['CodigoImportancia'] . "'>" . $nivel['NivelImportancia'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Campo de categoría de la tarea -->
                        <div class="mb-4">
                            <label for="categoria" class="form-label tipografia-titulos"><strong>Categoría</strong></label>
                            <select id="categoria" name="categoria" class="form-control" required>
                                <?php
                                // Obtener categorías
                                $categoriasQuery = "SELECT CodigoCategoria, NombreCategoria FROM Categoria";
                                $stmtCategorias = $conn->prepare($categoriasQuery);
                                $stmtCategorias->execute();
                                $categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($categorias as $categoria) {
                                    echo "<option value='" . $categoria['CodigoCategoria'] . "'>" . $categoria['NombreCategoria'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Campo de descripción -->
                        <div class="form-group mb-6">
                            <label for="descripcion" class="form-label tipografia-titulos"><strong>Descripción</strong></label>
                            <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                </div>
                <!-- Contenedor para los botones, centrado y fuera de las columnas -->
                <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                    <button type="submit" class="btn btn-secondary">Crear Tarea</button>
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Importación de scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
