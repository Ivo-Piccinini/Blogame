<?php
    require_once 'conexion.php';
    require_once 'helpers.php';
?>

<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Blogame</title>
        <link rel="stylesheet" type="text/css" href="./assets/css/styles.css"/>
        
        <!--FUENTES-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@600&display=swap" rel="stylesheet">
    </head>
    <body>
        <!--CABECERA-->
        <header id="cabecera">
            <!--LOGO-->
            <div id="logo">
                <a href="index.php">
                    Blogame
                </a>
            </div>
            
        <!--MENÚ-->
            <nav id="menu">
                <ul>
                    <li>
                        <a href="index.php">Inicio</a>
                    </li>
                    <?php 
                        $categorias = conseguirCategorias($db);
                        if(!empty($categorias)):
                            while($categoria = mysqli_fetch_assoc($categorias)): 
                    ?>
                            <li>
                                <a href="categoria.php?id=<?=$categoria['id']?>"><?=$categoria['nombre'];?></a>
                            </li>
                    <?php
                            endwhile; 
                        endif;
                    ?>
                </ul>
            </nav>
        
            <div class="clearfix"></div>
        </header>
        <div id="contenedor">