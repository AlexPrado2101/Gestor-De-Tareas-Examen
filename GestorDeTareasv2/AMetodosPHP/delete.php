<?php
    include_once("conexion.php");

    if (isset($_GET['id'])) {
        $idTarea = $_GET['id'];
        
        $conexion = new Cconexion();
        $conn = $conexion->ConexionBD();

        $query = "DELETE FROM Tarea WHERE IDTarea = :idTarea";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idTarea', $idTarea);

        if ($stmt->execute()) {
            header("Location: ../index.php?mensaje=Tarea eliminada exitosamente");
            exit();
        } else {
            echo "Error al eliminar la tarea.";
        }
    }
?>
