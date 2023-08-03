<?php require_once 'includes/redirexion.php'; ?>
<?php require_once 'includes/header.php';?>
<?php require_once 'includes/sidebar.php';?>

<!--CONTENIDO PRINCIPAL-->
<div id="principal">
    <h1>Mis datos</h1>
    <?php if(isset($_SESSION['completado'])) : ?>
        <div class="alerta alerta-exito">
            <?= $_SESSION['completado']; ?>
        </div>
    <?php elseif(isset($_SESSION['errores']['general'])): ?>
        <div class="alerta alerta-error">
            <?= $_SESSION['errores']['general']; ?>
        </div>
    <?php endif; ?>

        <form action="actualizar-usuario.php" method="POST">
            <label for="name">Nombre</label>
            <input type="text" name="name" value="<?=$_SESSION['usuario']['nombre'];?>"/>
            <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'nombre') : ''; ?>

            <label for="lastnames">Apellidos</label>
            <input type="text" name="lastnames" value="<?=$_SESSION['usuario']['apellidos'];?>"/>
            <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'apellidos') : ''; ?>

            <label for="email">Email</label>
            <input type="email" name="email" value="<?=$_SESSION['usuario']['email']?>"/>
            <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'email') : ''; ?>
            
            <input type="submit" name="submit" value="Actualizar" />
        </form>
        <?php borrarErrores(); ?>
    
</div><!--Fin principal-->

<?php require_once 'includes/footer.php';?>