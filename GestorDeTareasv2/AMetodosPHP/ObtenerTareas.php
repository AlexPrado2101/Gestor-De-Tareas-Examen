<?php
// Incluir la conexión
include_once("conexion.php");

// Crear una instancia de la clase de conexión
$conexion = new Cconexion();
$conn = $conexion->ConexionBD();

// Consulta SQL para obtener las tareas
$sql = "SELECT T.IDTarea, C.NombreCategoria, T.NombreTarea, U.Usuario, T.FechaInicio, T.FechaFinal, E.NombreEstado, I.NivelImportancia
        FROM Tarea T
        JOIN Categoria C ON T.CodigoCategoria = C.CodigoCategoria
        JOIN Estado E ON T.CodigoEstado = E.CodigoEstado
        JOIN Importancia I ON T.CodigoImportancia = I.CodigoImportancia
        JOIN Usuario U ON T.UsuarioAsignado = U.IDUsuario";

try {
    // Ejecutar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Guardar los resultados en un array
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Verificar si $tareas está vacío
    if (!$tareas) {
        $tareas = []; // Definir $tareas como un array vacío si no hay resultados
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
    $tareas = []; // Definir $tareas como un array vacío si ocurre un error
}
?>
