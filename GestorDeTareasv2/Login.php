<?php
session_start();
include 'AMetodosPHP/conexion.php';  // Ruta al archivo de conexión

// Variables para almacenar mensajes de error y otros datos
$usuarioError = "";
$contraseñaError = "";
$usuario = "";
$contraseña = "";
$mensaje = "";

// Verificar si se ha enviado el formulario
if (isset($_POST['login'])) {
    $usuario = trim($_POST['usuario']);
    $contraseña = trim($_POST['contraseña']);

    // Validar campos vacíos
    if (empty($usuario)) {
        $usuarioError = "El usuario es obligatorio.";
    }

    if (empty($contraseña)) {
        $contraseñaError = "La contraseña es obligatoria.";
    }

    // Si no hay errores de validación
    if ($usuarioError == "" && $contraseñaError == "") {
        // Crear una instancia de conexión
        $conexion = new Cconexion();
        $conn = $conexion->ConexionBD();

        // Preparar y ejecutar la consulta SQL
        $sql = "SELECT * FROM Usuario WHERE Usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe y la contraseña es correcta
        if ($user && $user['Contraseña'] === $contraseña) {
            // Iniciar sesión y redirigir al usuario
            $_SESSION['usuario'] = $user['Usuario'];
            $_SESSION['rol'] = $user['Rol'];
            
            // Redirigir según el rol
            if ($user['Rol'] === 'Administrador') {
                header("Location: index.php");
            } else {
                header("Location: indexUsuario.php");
            }
            exit();
        } else {
            // Mensaje de error si las credenciales no coinciden
            $mensaje = "Usuario o contraseña incorrectos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="Css/Login.css">
</head>
<body>
    <form action="login.php" method="POST">
        <h2>Login</h2>
        <label>Usuario:</label>
        <input type="text" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>">
        <span><?php echo $usuarioError; ?></span><br>

        <label>Contraseña:</label>
        <input type="password" name="contraseña">
        <span><?php echo $contraseñaError; ?></span><br>

        <input type="submit" name="login" value= "Iniciar Sesión">
    </form>
    <p><?php echo $mensaje; ?></p>
</body>
</html>