<?php
    // Incluir el archivo de conexión y/o ObtenerTareas si ahí tienes la lógica de conexión
    include_once("conexion.php");

    // Obtener el ID de la tarea desde la URL
    $idTarea = isset($_GET['id']) ? $_GET['id'] : 0;

    // Crear la conexión
    $conexion = new Cconexion();
    $conn = $conexion->ConexionBD();

    // Consulta para obtener los datos específicos de la tarea por su ID
    $sql = "SELECT T.NombreTarea, U.Usuario AS AsignadoA, T.Descripcion, C.NombreCategoria AS Categoria, 
                   T.FechaInicio, T.FechaFinal
            FROM Tarea T
            JOIN Usuario U ON T.UsuarioAsignado = U.IDUsuario
            JOIN Categoria C ON T.CodigoCategoria = C.CodigoCategoria
            WHERE T.IDTarea = :id";

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $idTarea, PDO::PARAM_INT);
    $stmt->execute();

    // Obtener los datos de la tarea
    $tarea = $stmt->fetch(PDO::FETCH_ASSOC);
?>