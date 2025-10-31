<?php  require_once("./php.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="./php.php" method="post">
        <fieldset>

            <legend>Informacion Personal</legend>

            <label for="nombreUsuario">Nombre: <input type="text" name="nombreUsuario" id="nombreUsuario" value=<?php /* Valor por defecto enviado */ echo !empty($_POST["nombreUsuario"]) ? $_POST['nombreUsuario'] : ""; ?>></label><br> 
            <label for="apellidoUsuario">Apellidos: <input type="text" name="apellidoUsuario" id="apellidoUsuario" value=<?php echo !empty($_POST["apellidoUsuario"]) ? $_POST["apellidoUsuario"] : ""?>></label><br>
            <label for="direccionUsuario">Direccion de Usuario: <input type="text" name="direccionUsuario" id="direccionUsuario" value=<?php echo !empty($_POST["direccionUsuario"]) ? $_POST["direccionUsuario"] : ""?>></label><br>

            <label for="eleccionCalleOAvenida">Selecciona tu Calle/Avenida: 
                <select name="eleccionCalleOAvenida" id="eleccionCalleOAvenida" onchange="updateAddressOptions()">
                    <option value="" disabled selected>-- Seleccione una opción --</option>
                    <option value="calle" <?php echo (isset($_POST["eleccionCalleOAvenida"]) && $_POST["eleccionCalleOAvenida"] == "calle") ? "selected" : ""; ?>>Calle</option>
                    <option value="avenida" <?php echo (isset($_POST["eleccionCalleOAvenida"]) && $_POST["eleccionCalleOAvenida"] == "avenida") ? "selected" : ""; ?>>Avenida</option>
                </select>
            </label>
            <br>
            <div id="opcionesDinamicas" style="display: none;">
                <label for="tipoViaSecundario">Elige el Tipo de Vía específico: 
                    <select name="tipoViaSecundario" id="tipoViaSecundario">
                        <option value="principal">Principal</option>
                        <option value="secundaria">Secundaria</option>
                        <option value="peatonal">Peatonal</option>
                    </select>
                </label>
            </div>
            
            </label>
        </fieldset>
        
    </form>
   <script>
        function updateAddressOptions() {
            const selectPrincipal = document.getElementById('eleccionCalleOAvenida');
            const opcionesDinamicas = document.getElementById('opcionesDinamicas');
            const valorSeleccionado = selectPrincipal.value;

            opcionesDinamicas.style.display = 'none';
            if (valorSeleccionado === 'calle' || valorSeleccionado === 'avenida') {
                opcionesDinamicas.style.display = 'block';
            }
        }

        window.onload = updateAddressOptions;
    </script>

</body>
</html>