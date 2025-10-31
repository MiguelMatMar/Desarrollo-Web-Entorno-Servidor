<?php
    $infoUsr = [];
    $errores = [];
    $form_step = 1;

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        
        if(!empty($_POST['nombreUsuario'])){
            $expresionNombre = "/^[A-Z][a-zA-ZáéíóúÁÉÍÓÚñÑ\s'-]+$/"; 
            if(preg_match($expresionNombre, $_POST['nombreUsuario'])){
                $infoUsr["nombreUsuario"] = htmlspecialchars(trim($_POST['nombreUsuario']));
            } else {
                $errores["nombreUsuario"] = "El nombre debe empezar con mayúscula y contener solo letras y espacios.";
            }
        } else {
            $errores["nombreUsuario"] = "El nombre de usuario es obligatorio.";
        }
        
        if(!empty($_POST['apellidoUsuario'])){
            $expresionApellido = "/^[A-Z][a-zA-ZáéíóúÁÉÍÓÚñÑ\s'-]+$/"; 
            if(preg_match($expresionApellido, $_POST['apellidoUsuario'])){
                $infoUsr["apellidoUsuario"] = htmlspecialchars(trim($_POST['apellidoUsuario']));
            } else {
                $errores["apellidoUsuario"] = "El apellido debe empezar con mayúscula y contener solo letras y espacios.";
            }
        } else {
            $errores["apellidoUsuario"] = "El apellido de usuario es obligatorio.";
        }

        if(!empty($_POST['direccionUsuario'])){
            $expresionDireccion = "/^[a-zA-Z0-9\s#,\.-]{5,}$/"; 
            if(preg_match($expresionDireccion, $_POST['direccionUsuario'])){
                $infoUsr["direccionUsuario"] = htmlspecialchars(trim($_POST['direccionUsuario']));
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
            $form_step = 2; 
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Completo</title>
    <style>
        .contenedor-datos {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            max-width: 600px;
            margin-bottom: 20px;
        }
        .columna-unica {
            grid-column: 1 / -1;
        }
        .formulario-dni {
            border: 1px solid #ccc;
            padding: 15px;
            max-width: 600px;
        }
        .oculto {
            display: none;
        }
        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>
<body>
    <?php
        if(!empty($errores) && $form_step == 1): // Muestra si han habido errores al enviarse el cuestionario.
            echo "<h2>Errores de validación:</h2>";
            foreach($errores as $error){
                echo "<p class='error'>- $error</p>";
            }
        endif;
    ?>

    <div id="paso1" class="<?php echo ($form_step == 2) ? 'oculto' : ''; ?>">
        <h2>Formulario de Datos</h2>
        <form action="./index.php" method="post">
            <div class="contenedor-datos">
                
                <div>
                    <label for="nombreUsuario">Nombre:</label>
                    <input type="text" name="nombreUsuario" id="nombreUsuario" value="<?php echo !empty($_POST['nombreUsuario']) ? htmlspecialchars($_POST['nombreUsuario']) : ""; ?>">
                    <?php if (isset($errores['nombreUsuario'])) echo "<span class='error'>".$errores['nombreUsuario']."</span>"; ?>
                </div>

                <div>
                    <label for="apellidoUsuario">Apellidos:</label>
                    <input type="text" name="apellidoUsuario" id="apellidoUsuario" value="<?php echo !empty($_POST['apellidoUsuario']) ? htmlspecialchars($_POST['apellidoUsuario']) : ""; ?>">
                    <?php if (isset($errores['apellidoUsuario'])) echo "<span class='error'>".$errores['apellidoUsuario']."</span>"; ?>
                </div>
                
                <div>
                    <label for="eleccionCalleOAvenida">Tipo de dirección:</label>
                    <select name="eleccionCalleOAvenida" id="eleccionCalleOAvenida" onchange="updateAddressOptions()">
                        <option value="" disabled selected>Seleccione...</option>
                        <option value="calle" <?php echo (isset($_POST["eleccionCalleOAvenida"]) && $_POST["eleccionCalleOAvenida"] == "calle") ? "selected" : ""; ?>>Calle</option>
                        <option value="avenida" <?php echo (isset($_POST["eleccionCalleOAvenida"]) && $_POST["eleccionCalleOAvenida"] == "avenida") ? "selected" : ""; ?>>Avenida</option>
                    </select>
                    <?php if (isset($errores['eleccionCalleOAvenida'])) echo "<span class='error'>".$errores['eleccionCalleOAvenida']."</span>"; ?>
                </div>
                
                <div id="opcionesDinamicas" class="oculto">
                    <label for="tipoViaSecundario">Vía:</label>
                    <select name="tipoViaSecundario" id="tipoViaSecundario">
                    </select>
                    <?php if (isset($errores['tipoViaSecundario'])) echo "<span class='error'>".$errores['tipoViaSecundario']."</span>"; ?>
                </div>
                
                <div class="columna-unica">
                    <label for="direccionUsuario">Dirección:</label>
                    <input type="text" name="direccionUsuario" id="direccionUsuario" value="<?php echo !empty($_POST['direccionUsuario']) ? htmlspecialchars($_POST['direccionUsuario']) : ""; ?>">
                    <?php if (isset($errores['direccionUsuario'])) echo "<span class='error'>".$errores['direccionUsuario']."</span>"; ?>
                </div>

            </div>
            <button type="submit">Enviar Datos</button>
        </form>
    </div>

    <div id="paso2" class="formulario-dni <?php echo ($form_step == 1) ? 'oculto' : ''; ?>">
        <h2>Subir Imagen del DNI</h2>
        <form action="./procesar_dni.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Documento de Identidad</legend>
                
                <?php foreach ($infoUsr as $key => $value): ?>
                    <input type="hidden" name="<?php echo $key; ?>" value="<?php echo htmlspecialchars($value); ?>">
                <?php endforeach; ?>
                
                <label for="dni">DNI (Imagen): <input type="file" name="dni" id="dni" required></label><br><br>
                <input type="submit" value="Finalizar Registro">
            </fieldset>
        </form>
    </div>

    <script>
        const opcionesCalle = ["Calle1", "Calle2", "Calle3"];
        const opcionesAvenida = ["Avenida1", "Avenida2", "Avenida3"];

        function updateAddressOptions() {
            const selectPrincipal = document.getElementById('eleccionCalleOAvenida');
            const opcionesDinamicas = document.getElementById('opcionesDinamicas');
            const selectSecundario = document.getElementById('tipoViaSecundario');
            const valorSeleccionado = selectPrincipal.value;
            const valorSecundarioGuardado = "<?php echo isset($_POST['tipoViaSecundario']) ? $_POST['tipoViaSecundario'] : ''; ?>";

            selectSecundario.innerHTML = '';
            opcionesDinamicas.classList.add('oculto'); 

            let opcionesAMostrar = [];

            if (valorSeleccionado === 'calle') {
                opcionesAMostrar = opcionesCalle;
            } else if (valorSeleccionado === 'avenida') {
                opcionesAMostrar = opcionesAvenida;
            }

            if (opcionesAMostrar.length > 0) {
                opcionesAMostrar.forEach(opcion => {
                    const nuevaOpcion = document.createElement('option');
                    const valorLimpio = opcion.toLowerCase().replace(/\s/g, ''); 
                    nuevaOpcion.value = valorLimpio;
                    nuevaOpcion.textContent = opcion;
                    
                    if (valorLimpio === valorSecundarioGuardado) {
                        nuevaOpcion.selected = true;
                    }

                    selectSecundario.appendChild(nuevaOpcion);
                });
                
                opcionesDinamicas.classList.remove('oculto');
            }
        }
        window.onload = updateAddressOptions;
    </script>
</body>
</html>