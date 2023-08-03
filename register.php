<?php
if(isset($_POST)){
    // Conexión a la base de datos
    require_once 'includes/conexion.php';
    if(!isset($_SESSION)){
        session_start();
    }
    
    // Agarrar los valores del formulario de registro
    // mysqli_real_escape_string hace que lo que le pases sea interpretado como un string
    $nombre = isset($_POST['name']) ? mysqli_real_escape_string($db, $_POST['name']) : false;
    $apellidos = isset($_POST['lastnames']) ? mysqli_real_escape_string($db, $_POST['lastnames']) : false;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;
    $password = isset($_POST['password']) ? mysqli_real_escape_string($db, $_POST['password']) : false;
    
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
    // Validar password
    if(!empty($password)) {
        $password_validate = true;
    } else {
        $password_validate = false;
        $errores['password'] = "La contraseña está vacía";
    }
    
    
    $guardar_usuario = false;
    
    if(count($errores) == 0){
        $guardar_usuario = true;
        
        // Cifrar la contraseña
        /* 
            password_hash sirve para cifrar la contraseña. Los parámetros son:
            1 - la variable en la que se almacena la password del usuario.
            2 - la constante del algoritmo de contraseñas
            3 - un array asociativo de opciones
            (['cost'=>4] sirve para que la contraseña se encripte 4 veces)
            
            password_verify devuelve true si la contraseña encriptada es la
            misma que la del usuario. Para esto, usa 2 parámetros:
            1 - la variable en la que se almacena la password del usuario.
            2 - la variable que almacena la password encriptada del usuario.
        */
        $password_safe = password_hash($password, PASSWORD_BCRYPT, ['cost'=>4]);
        
        // Insertar usuario en la base de datos (en la tabla usuarios)
        $sql = "INSERT INTO usuarios VALUES(null, '$nombre', '$apellidos', '$email', '$password_safe', CURDATE())";
        $guardar = mysqli_query($db, $sql);
        
        if($guardar) {
            $_SESSION['completado'] = 'El registro se ha completado con éxito';
        } else {
            $_SESSION['errores']['general'] = "Fallo al guardar el usuario";
        }
        
    } else {
        $_SESSION['errores'] = $errores;
        header('location: index.php');
    }
}

header('location: index.php');