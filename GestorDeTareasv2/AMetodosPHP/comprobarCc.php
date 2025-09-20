<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conexion de PHP con SQL Server</title>
</head>
<body>
    <?php
        include_once("conexion.php");
        
        // Crear una instancia de la clase
        $conexion = new Cconexion();
        
        // Llamar al método de la instancia
        $conexion->ConexionBD();
    ?>
</body>
</html>
