<?php
include_once("conexion.php");

// Crear conexión a la base de datos
$conexion = new Cconexion();
$conn = $conexion->ConexionBD();

// Procesar el formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreTarea = $_POST['nombreTarea'];
    $asignadoA = $_POST['asignadoA'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFinal = $_POST['fechaFinal'];
    $importancia = $_POST['importancia'];

    // Insertar tarea en la base de datos
    $sql = "INSERT INTO Tarea (NombreTarea, UsuarioAsignado, Descripcion, CodigoCategoria, FechaInicio, FechaFinal, CodigoImportancia, CodigoEstado) 
            VALUES (:nombreTarea, :asignadoA, :descripcion, :categoria, :fechaInicio, :fechaFinal, :importancia, 1)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombreTarea', $nombreTarea);
    $stmt->bindParam(':asignadoA', $asignadoA);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':fechaInicio', $fechaInicio);
    $stmt->bindParam(':fechaFinal', $fechaFinal);
    $stmt->bindParam(':importancia', $importancia);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    }
}
?>