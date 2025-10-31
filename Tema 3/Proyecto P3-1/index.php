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

            <label for="nombreUsuario">Nombre: <input type="text" name="nombreUsuario" id="nombreUsuario" value="<?php echo !empty($_POST['nombreUsuario']) ? htmlspecialchars($_POST['nombreUsuario']) : ""; ?>"></label><br> 
            <label for="apellidoUsuario">Apellidos: <input type="text" name="apellidoUsuario" id="apellidoUsuario" value="<?php echo !empty($_POST['apellidoUsuario']) ? htmlspecialchars($_POST['apellidoUsuario']) : ""; ?>"></label><br>
            <label for="direccionUsuario">Direccion de Usuario: <input type="text" name="direccionUsuario" id="direccionUsuario" value="<?php echo !empty($_POST['direccionUsuario']) ? htmlspecialchars($_POST['direccionUsuario']) : ""; ?>"></label><br>

            <label for="eleccionCalleOAvenida">Selecciona tu Calle/Avenida: 
                <select name="eleccionCalleOAvenida" id="eleccionCalleOAvenida" onchange="updateAddressOptions()">
                    <option value="" disabled selected>-- Seleccione una opción --</option>
                    <option value="calle" >Calle</option>
                    <option value="avenida">Avenida</option>
                </select>
            </label>
            <br>
            
            <div id="opcionesDinamicas" style="display: none;">
                <label for="tipoViaSecundario">Elige el Tipo de Vía específico: 
                    <select name="tipoViaSecundario" id="tipoViaSecundario">
                    </select>
                </label>
            </div>

        </fieldset>
        <button type="submit">Enviar</button>
    </form>

    <script>
        const opcionesCalle = ["Calle1", "Calle2", "Calle3"];
        const opcionesAvenida = ["Avenida1", "Avenida2", "Avenida3"];

        function updateAddressOptions() {
            const selectPrincipal = document.getElementById('eleccionCalleOAvenida');
            const opcionesDinamicas = document.getElementById('opcionesDinamicas');
            const selectSecundario = document.getElementById('tipoViaSecundario');
            const valorSeleccionado = selectPrincipal.value;

            selectSecundario.innerHTML = '';
            opcionesDinamicas.style.display = 'none';

            let opcionesAMostrar = [];

            if (valorSeleccionado === 'calle') {
                opcionesAMostrar = opcionesCalle;
            } else if (valorSeleccionado === 'avenida') {
                opcionesAMostrar = opcionesAvenida;
            }

            if (opcionesAMostrar.length > 0) {
                opcionesAMostrar.forEach(opcion => {
                    const nuevaOpcion = document.createElement('option');
                    nuevaOpcion.value = opcion.toLowerCase().replace(/\s/g, ''); 
                    nuevaOpcion.textContent = opcion; 
                    selectSecundario.appendChild(nuevaOpcion);
                });
                
                opcionesDinamicas.style.display = 'block';
            }
        }
        window.onload = updateAddressOptions;
    </script>
    <?php
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            // Vamos a guardar ahora todos los valores con sus validaciones
            $infoUsr = [];
            $errores = [];
            if(!empty($_POST['nombreUsuario'])){
            $expresionNombre = "/^[A-Z][a-zA-ZáéíóúÁÉÍÓÚñÑ\s'-]+$/"; 
            
            if(preg_match($expresionNombre, $_POST['nombreUsuario'])){ // Validamos antes de guardar la informacion para no guardar nada erroneo
                $nombreUsuario = htmlspecialchars(trim($_POST['nombreUsuario']));
                $infoUsr["nombreUsuario"] = $nombreUsuario;
            } else { // Por si el usuario lo deja vacio todo 
                $errores["nombreUsuario"] = "El nombre debe empezar con mayúscula y contener solo letras y espacios.";
            }
            } else {
                $errores["nombreUsuario"] = "El nombre de usuario es obligatorio.";
            }
            
            if(!empty($_POST['apellidoUsuario'])){
                $expresionApellido = "/^[A-Z][a-zA-ZáéíóúÁÉÍÓÚñÑ\s'-]+$/"; 
                
                if(preg_match($expresionApellido, $_POST['apellidoUsuario'])){
                    $apellidoUsuario = htmlspecialchars(trim($_POST['apellidoUsuario']));
                    $infoUsr["apellidoUsuario"] = $apellidoUsuario;
                } else {
                    $errores["apellidoUsuario"] = "El apellido debe empezar con mayúscula y contener solo letras y espacios.";
                }
            } else {
                $errores["apellidoUsuario"] = "El apellido de usuario es obligatorio.";
            }

            if(!empty($_POST['direccionUsuario'])){
                $expresionDireccion = "/^[a-zA-Z0-9\s#,\.-]{5,}$/"; 
                
                if(preg_match($expresionDireccion, $_POST['direccionUsuario'])){
                    $direccionUsuario = htmlspecialchars(trim($_POST['direccionUsuario']));
                    $infoUsr["direccionUsuario"] = $direccionUsuario;
                } else {
                    $errores["direccionUsuario"] = "La dirección no tiene un formato válido.";
                }
            } else {
                $errores["direccionUsuario"] = "La dirección es obligatoria.";
            }

            if(!empty($_POST['eleccionCalleOAvenida']) && in_array($_POST['eleccionCalleOAvenida'], ['calle', 'avenida'])){
                $infoUsr["eleccionCalleOAvenida"] = $_POST['eleccionCalleOAvenida'];
            } else {
                $errores["eleccionCalleOAvenida"] = "Debe seleccionar si es Calle o Avenida.";
            }

            if(!empty($_POST['tipoViaSecundario'])){
                $infoUsr["tipoViaSecundario"] = htmlspecialchars(trim($_POST['tipoViaSecundario']));
            } else {
                $errores["tipoViaSecundario"] = "Debe seleccionar el tipo de vía específica.";
            }
            
            if(empty($errores)){
                
            } else {
                echo "<h2> Los errores han sido: </h2>";
                foreach($errores as $error){
                    echo "- <strong>$error</strong> <br>";
                }
            }
        }
    ?>
</body>
</html>