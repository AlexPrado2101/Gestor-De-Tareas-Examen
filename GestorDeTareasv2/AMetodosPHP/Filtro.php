<?php
// Incluir la clase de conexión
include_once("conexion.php");

// Crear una instancia de la clase de conexión
$conexion = new Cconexion();
$conn = $conexion->ConexionBD();

// Definir variables de filtro con valores predeterminados
$categoriaFiltro = '';
$estadoFiltro = '';
$importanciaFiltro = '';

// Obtener los filtros de la URL si están establecidos
if (isset($_GET['categoria'])) {
    $categoriaFiltro = $_GET['categoria'];
}
if (isset($_GET['estado'])) {
    $estadoFiltro = $_GET['estado'];
}
if (isset($_GET['importancia'])) {
    $importanciaFiltro = $_GET['importancia'];
}

// Consulta SQL base para obtener las categorías, estados e importancias
$sqlCategorias = "SELECT CodigoCategoria, NombreCategoria FROM Categoria";
$sqlEstados = "SELECT CodigoEstado, NombreEstado FROM Estado";
$sqlImportancias = "SELECT CodigoImportancia, NivelImportancia FROM Importancia";

// Filtrar las tareas basadas en los parámetros seleccionados
$whereConditions = [];

if ($categoriaFiltro != '') {
    $whereConditions[] = "T.CodigoCategoria = :categoriaFiltro";
}

if ($estadoFiltro != '') {
    $whereConditions[] = "T.CodigoEstado = :estadoFiltro";
}

if ($importanciaFiltro != '') {
    $whereConditions[] = "T.CodigoImportancia = :importanciaFiltro";
}

$whereSql = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';

// Consulta SQL para obtener las tareas filtradas
$sqlTareas = "SELECT T.IDTarea, C.NombreCategoria, T.NombreTarea, U.Usuario, T.FechaInicio, T.FechaFinal, E.NombreEstado, I.NivelImportancia
              FROM Tarea T
              JOIN Categoria C ON T.CodigoCategoria = C.CodigoCategoria
              JOIN Estado E ON T.CodigoEstado = E.CodigoEstado
              JOIN Importancia I ON T.CodigoImportancia = I.CodigoImportancia
              JOIN Usuario U ON T.UsuarioAsignado = U.IDUsuario
              $whereSql";

try {
    // Preparar y ejecutar la consulta para categorías, estados e importancias
    $categorias = $conn->query($sqlCategorias)->fetchAll(PDO::FETCH_ASSOC);
    $estados = $conn->query($sqlEstados)->fetchAll(PDO::FETCH_ASSOC);
    $importancias = $conn->query($sqlImportancias)->fetchAll(PDO::FETCH_ASSOC);

    // Preparar la consulta para obtener las tareas filtradas
    $stmt = $conn->prepare($sqlTareas);

    // Enlazar parámetros de filtro si es necesario
    if ($categoriaFiltro != '') {
        $stmt->bindParam(':categoriaFiltro', $categoriaFiltro);
    }
    if ($estadoFiltro != '') {
        $stmt->bindParam(':estadoFiltro', $estadoFiltro);
    }
    if ($importanciaFiltro != '') {
        $stmt->bindParam(':importanciaFiltro', $importanciaFiltro);
    }

    // Ejecutar la consulta de tareas
    $stmt->execute();
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error al obtener los datos: " . $e->getMessage();
    exit();
}

?>
