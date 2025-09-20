<?php
    // Incluir el archivo de conexión y/o lógica de conexión
    include_once("conexion.php");

    // Obtener el ID de la tarea desde la URL
    $idTarea = isset($_GET['id']) ? $_GET['id'] : 0;

    // Crear la conexión
    $conexion = new Cconexion();
    $conn = $conexion->ConexionBD();

    // Consulta para obtener los datos de la tarea
    $sql = "SELECT T.NombreTarea, U.Usuario AS AsignadoA, T.Descripcion, C.NombreCategoria AS Categoria, 
                   T.FechaInicio, T.FechaFinal, T.UsuarioAsignado, T.CodigoCategoria, T.CodigoImportancia
            FROM Tarea T
            JOIN Usuario U ON T.UsuarioAsignado = U.IDUsuario
            JOIN Categoria C ON T.CodigoCategoria = C.CodigoCategoria
            WHERE T.IDTarea = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $idTarea, PDO::PARAM_INT);
    $stmt->execute();
    $tarea = $stmt->fetch(PDO::FETCH_ASSOC);

    // Guardar cambios si se envía el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombreTarea = $_POST['nombreTarea'];
        $asignadoA = $_POST['asignadoA'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];
        $fechaInicio = $_POST['fechaInicio'];
        $fechaFinal = $_POST['fechaFinal'];
        $importancia = $_POST['importancia']; // Nuevo campo de importancia

        $sqlUpdate = "UPDATE Tarea 
                      SET NombreTarea = :nombreTarea, UsuarioAsignado = :asignadoA, Descripcion = :descripcion, 
                          CodigoCategoria = :categoria, FechaInicio = :fechaInicio, FechaFinal = :fechaFinal, 
                          CodigoImportancia = :importancia
                      WHERE IDTarea = :id";

        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':nombreTarea', $nombreTarea);
        $stmtUpdate->bindParam(':asignadoA', $asignadoA);
        $stmtUpdate->bindParam(':descripcion', $descripcion);
        $stmtUpdate->bindParam(':categoria', $categoria);
        $stmtUpdate->bindParam(':fechaInicio', $fechaInicio);
        $stmtUpdate->bindParam(':fechaFinal', $fechaFinal);
        $stmtUpdate->bindParam(':importancia', $importancia);
        $stmtUpdate->bindParam(':id', $idTarea, PDO::PARAM_INT);
        
        if ($stmtUpdate->execute()) {
            header("Location: index.php");
            exit;
        }
    }
?>