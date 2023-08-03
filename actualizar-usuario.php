<?php
if(isset($_POST)){
    // Conexión a la base de datos
    require_once 'includes/conexion.php';
    
    // Agarrar los valores del formulario de actualización
    // mysqli_real_escape_string hace que lo que le pases sea interpretado como un string
    $nombre = isset($_POST['name']) ? mysqli_real_escape_string($db, $_POST['name']) : false;
    $apellidos = isset($_POST['lastnames']) ? mysqli_real_escape_string($db, $_POST['lastnames']) : false;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, $_POST['email']) : false;
    
    // Array de errores
    $errores = [];
    
    // Validar los datos antes de guardarlos en la base de datos
    // Validar nombre
    if(!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)) {
        $nombre_validate = true;
    } else {
        $nombre_validate = false;
        $errores['nombre'] = "El nombre no es válido";
    }
    // Validar apellidos
    if(!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)) {
        $apellidos_validate = true;
    } else {
        $apellidos_validate = false;
        $errores['apellidos'] = "Los apellidos no son válidos";
    }
    // Validar email
    if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_validate = true;
    } else {
        $email_validate = false;
        $errores['email'] = "El email no es válido";
    }
    
    
    $guardar_usuario = false;
    
    if(count($errores) == 0){
        $usuario = $_SESSION['usuario'];
        $guardar_usuario = true;
        
        // Comprobar si el email ya existe
        $sql = "SELECT id, email FROM usuarios WHERE email='$email'";
        $isset_email = mysqli_query($db, $sql);
        $isset_user = mysqli_fetch_assoc($isset_email);
        
        if($isset_user['id'] == $usuario['id'] || empty($isset_user)){   
            // Actualizar usuario en la base de datos (en la tabla usuarios)
            $sql = "UPDATE usuarios SET ".
                   "nombre='$nombre', ".
                   "apellidos='$apellidos', ".
                   "email='$email' ".
                   "WHERE id= ".$usuario['id'];
            $guardar = mysqli_query($db, $sql);

            if($guardar) {
                $_SESSION['usuario']['nombre'] = $nombre;
                $_SESSION['usuario']['apellidos'] = $apellidos;
                $_SESSION['usuario']['email'] = $email;

                $_SESSION['completado'] = 'Tus datos se han actualizado con éxito';
            } else {
                $_SESSION['errores']['general'] = "Fallo al actualizar tus datos";
            }
        }else{
            $_SESSION['errores']['general'] = "El usuario ya existe";
        }
        
    } else {
        $_SESSION['errores'] = $errores;
        header('location: index.php');
    }
}

header('location: mis-datos.php');