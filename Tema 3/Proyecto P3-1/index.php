<?php  require_once("./php.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="./#" method="post">
        <fieldset>

            <legend>Informacion Personal</legend>

            <label for="nombreUsuario">Nombre: <input type="text" name="nombreUsuario" id="nombreUsuario" value=<?php /* Valor por defecto enviado */ echo !empty($_POST["nombreUsuario"]) ? $_POST['nombreUsuario'] : ""; ?>></label><br> 
            <label for="apellidoUsuario">Apellidos: <input type="text" name="apellidoUsuario" id="apellidoUsuario" value=<?php echo !empty($_POST["apellidoUsuario"]) ? $_POST["apellidoUsuario"] : ""?>></label><br>
            <label for="direccionUsuario">Direccion de Usuario: <input type="text" name="direccionUsuario" id="direccionUsuario" value=<?php echo !empty($_POST["direccionUsuario"]) ? $_POST["direccionUsuario"] : ""?>></label><br>

            <label for="calleUsuario">Selecciona tu Calle: 
            <?php // Apartado para seleccionar calle o avenida
                if(!empty($_POST["selecciondeCalle"])){ // Si el usuario ha seleccionado alguna, se carga la pagina php.php para coger la funcion
                    
                    mostrarCalleAvenida(); // Muestra
                }else{ // Sino vuelve a mostrar por defecto la seleccion de avenida
                    echo 
                    '
                        <select name="seleccionCalleAvenida" id="seleccionCalleAvenida">
                            <option value="calle">Calle</option>
                            <option value="avenida">Avenida</option>
                        </select>
                    ';
                    echo '<input type="submit" name="selecciondeCalle" value="selecciondeCalle">';
                }
            ?>
            </label>
        </fieldset>
        
    </form>
    <form action="./php.php" method="post">
        <input type="submit" value="Enviar Datos">
    </form>
</body>
</html>