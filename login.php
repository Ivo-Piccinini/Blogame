<?php
// Iniciar la sesión y la conexión a la base de datos
require_once 'includes/conexion.php';

// Agarrar los datos del formulario
if(isset($_POST)){
    
    // Borrar error antiguo
    if(isset($_SESSION['error_login'])) {
        unset($_SESSION['error_login']);
        
    }
    
    // Agarrar datos del formulario
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Consulta para comprobar las credenciales del usuario
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $login = mysqli_query($db, $sql);
    
    if($login && mysqli_num_rows($login) == 1){
        $usuario = mysqli_fetch_assoc($login);
        // Comprobar la contraseña
        $verify = password_verify($password, $usuario['password']);
        
        if($verify){
            // Utilizar una sesión para guardar los datos del usuario logueado
            $_SESSION['usuario'] = $usuario;
            
        } else {
            // Si algo falla, enviar una sesión con el fallo
            $_SESSION['error_login'] = "Fallo en el login";
        }
    } else {
        // Mensaje de error
        $_SESSION['error_login'] = "Fallo en el login";
    }
    
}

// Redirigir al index.php
header("location: index.php");