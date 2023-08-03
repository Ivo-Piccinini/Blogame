<?php require_once 'includes/redirexion.php'; ?>
<?php require_once 'includes/header.php';?>
<?php require_once 'includes/sidebar.php';?>

<!--CONTENIDO PRINCIPAL-->
<div id="principal">
    <h1>Crear categorías</h1>
    <p>
        Añade nuevas categorías al blog para que los usuarios puedan usarlas al
        crear sus entradas.
    </p>
    <br>
    <form action="guardar_categoria" method="POST">
        <label for="nombre">Nombre de la categoría</label>
        <input type="text" name="nombre"/>
        
        <input type="submit" value="Guardar"/>
    </form>
</div><!--Fin principal-->

<?php require_once 'includes/footer.php';?>