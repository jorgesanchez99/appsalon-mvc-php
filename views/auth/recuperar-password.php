<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Ingresa tu nuevo password a continuacion</p>
<?php include_once __DIR__ . '/../template/alertas.php'; ?>


<?php if($error)  return;?>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu nuevo Password" required>
    </div>
    <input type="submit" value="Guardar Nuevo Password" class="boton">
</form>


<div class="acciones">
    <a href="/">Ya tienes cuenta? Iniciar Sesión</a>
    <a href="/crear-cuenta">Aun no tienes cuenta? Obtener una</a>
</div>