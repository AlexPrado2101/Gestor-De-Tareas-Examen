<?php
    // Incluir la conexión
    include_once("AMetodosPHP/conexion.php");
 
    // Crear una instancia de la clase de conexión
    $conexion = new Cconexion();
    $conn = $conexion->ConexionBD();
 
    // Obtener el año y el mes desde la URL o usar los valores por defecto
    $year = isset($_GET['year']) ? intval($_GET['year']) : date("Y");
    $month = isset($_GET['month']) ? intval($_GET['month']) : date("m");
 
    if ($month < 1) {
        $month = 12;
        $year--;
    } elseif ($month > 12) {
        $month = 1;
        $year++;
    }
 
    // Consulta SQL para obtener las tareas de un mes específico
    $sql = "SELECT T.IDTarea, C.NombreCategoria, T.NombreTarea, U.Usuario, T.FechaInicio, T.FechaFinal, E.NombreEstado, I.NivelImportancia
            FROM Tarea T
            JOIN Categoria C ON T.CodigoCategoria = C.CodigoCategoria
            JOIN Estado E ON T.CodigoEstado = E.CodigoEstado
            JOIN Importancia I ON T.CodigoImportancia = I.CodigoImportancia
            JOIN Usuario U ON T.UsuarioAsignado = U.IDUsuario
            WHERE (T.FechaInicio <= :end_date) AND (T.FechaFinal >= :start_date)";
 
    // Calcular las fechas de inicio y fin del mes
    $start_date = "$year-$month-01";
    $end_date = date("Y-m-t", strtotime($start_date));
 
    try {
        // Ejecutar la consulta
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
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
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestor de Tareas para organizar y gestionar tus tareas diarias.">
    <title>Gestor de Tareas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
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
 
    <div class="main-content">
        <h2 class="d-flex justify-content-center align-items-center tipografia-titulos">Calendario de Tareas</h2>
        <div class="mt-4">
            <div class="d-flex justify-content-between mb-3">
                <a href="?month=<?php echo $month - 1; ?>&year=<?php echo $year; ?>" class="btn btn-secondary tipografia-titulos">Mes Anterior</a>
                <h3><?php echo date("F Y", strtotime("$year-$month-01")); ?></h3>
                <a href="?month=<?php echo $month + 1; ?>&year=<?php echo $year; ?>" class="btn btn-secondary tipografia-titulos">Mes Siguiente</a>
            </div>
 
            <table class="table">
                <thead>
                    <tr class="tipografia-parrafos text-center">
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miércoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sábado</th>
                        <th>Domingo</th>
                    </tr>
                </thead>
                <tbody>
 
                <?php
                    $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year); // Número de días en el mes
                    $first_day_of_month = date("N", strtotime("$year-$month-01")); // Día de la semana del primer día del mes (1=lunes, 7=domingo)
 
                    $day_counter = 1;
                    for ($i = 0; $i < 6; $i++) { // Max 6 filas (una por semana)
                        echo "<tr>";
                        for ($j = 1; $j <= 7; $j++) { // 7 días a la semana
                            if (($i === 0 && $j < $first_day_of_month) || $day_counter > $days_in_month) {
                                echo "<td></td>"; // Si el día no corresponde, deja la celda vacía
                            } else {
                                $date = "$year-$month-" . str_pad($day_counter, 2, '0', STR_PAD_LEFT); // Generar la fecha completa (YYYY-MM-DD)
                               
                                echo "<td><strong>$day_counter</strong><div class='task-list'>";
 
                                // Mostrar las tareas correspondientes a esta fecha
                                foreach ($tareas as $tarea) {
                                    $fechaInicio = strtotime($tarea['FechaInicio']);  // Convertir fecha de inicio a timestamp
                                    $fechaFinal = $tarea['FechaFinal'] ? strtotime($tarea['FechaFinal']) : null; // Si no hay fecha final, asignar null
                                   
                                    // Verificar si la tarea está activa en el día actual
                                    if ($fechaInicio <= strtotime($date) && ($fechaFinal == null || $fechaFinal >= strtotime($date))) {
                                        echo "<div class='task-name'>{$tarea['NombreTarea']}</div>"; // Imprimir el nombre de la tarea
                                    }
                                }
 
                                echo "</div></td>";
                                $day_counter++;
                            }
                        }
                        echo "</tr>";
                        if ($day_counter > $days_in_month) break;
                    }
                    ?>
 
                </tbody>
            </table>
        </div>
        <div>
            <a href="indexUsuario.php" class="btn btn-secondary mt-3 tipografia-parrafos">Volver a la Página Inicial</a>
        </div>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>