<?php
include('AMetodosPHP/conexion.php'); // Asegúrate de que la conexión esté incluida

if (isset($_GET['id'])) {
    $idTarea = $_GET['id'];
    
    // Obtener los estados disponibles de la base de datos
    $conexion = (new Cconexion())->ConexionBD();
    $sql = "SELECT * FROM Estado";
    $result = $conexion->query($sql);
    $estados = $result->fetchAll(PDO::FETCH_ASSOC);
    
    // Verificar si el formulario fue enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nuevoEstado = $_POST['estado'];
        
        // Actualizar el estado de la tarea en la base de datos
        $updateSql = "UPDATE Tarea SET CodigoEstado = :nuevoEstado WHERE IDTarea = :idTarea";
        $stmt = $conexion->prepare($updateSql);
        $stmt->bindParam(':nuevoEstado', $nuevoEstado, PDO::PARAM_INT);
        $stmt->bindParam(':idTarea', $idTarea, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            /*echo "Estado actualizado correctamente.";*/
        } else {
            /*echo "Error al actualizar el estado.";*/
        }
    }
} else {
    echo "No se ha especificado la tarea.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestor de Tareas para organizar y gestionar tus tareas diarias.">
    <title>Cambiar Estado</title>
    
    <!-- Preconexiones y estilos CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href='https://fonts.googleapis.com/css?family=DM+Serif+Display' rel='stylesheet'>
    <link rel="stylesheet" href="Css/Estilo_gen.css">
</head>

<body class="fondo-especifico">
    
    <div class="container tipografia-parrafos">
        <div class="card-crear p-4">
            <h2 class="tipografia-titulos text-center mb-4">Cambiar Estado de la Tarea</h2>
            
            <form action="cambiar_estado.php?id=<?php echo $idTarea; ?>" method="POST" class="tipografia-parrafo">
                <div class="row">
                    <div class="col-md-12">
                        <label for="estado" class="form-label tipografia-titulos"><strong>Seleccionar nuevo estado</strong></label>
                        <select name="estado" id="estado" class="form-control" required>
                            <?php
                            foreach ($estados as $estado) {
                                echo "<option value='" . $estado['CodigoEstado'] . "'>" . $estado['NombreEstado'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                    <button type="submit" class="btn btn-primary">Actualizar Estado</button>
                    <a href="indexUsuario.php" class="btn btn-secondary">Volver a Tareas</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
