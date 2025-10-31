<?php

// Vamos a declarar los valores para luego ir comprobando 
$errores = [];
$DNI_DIR = "DNI/";
$USUARIOS_DIR = "usuarios/";
$USUARIO_FILE = $USUARIOS_DIR . "usuario.json";
$MAX_SIZE = 2 * 1024 * 1024; // 2 MB en bytes

if (!is_dir($DNI_DIR)) {
    mkdir($DNI_DIR, 0777, true);
}
if (!is_dir($USUARIOS_DIR)) {
    mkdir($USUARIOS_DIR, 0777, true);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

    if (isset($_FILES['dni'])) {
        $archivo = $_FILES['dni']; 

        if ($archivo['error'] !== UPLOAD_ERR_OK) { // sino hay error entonces perfe
            $errores[] = "Error al subir la imagen. Código de error: " . $archivo['error'];
        }

        if ($archivo['size'] > $MAX_SIZE) {
            $errores[] = "La imagen no debe superar los 2 MB.";
        }

        $tipoArchivo = $archivo['type'];
        if ($tipoArchivo !== 'image/jpeg' && $tipoArchivo !== 'image/png') {
            $errores[] = "Formato de imagen no válido. Solo se permiten JPG y PNG.";
        }

    } else {
        $errores[] = "Debe subir una imagen de DNI."; // Si no se ha subido nada
    }


    if (empty($errores)) { // Si no hay errores de envio del dni entonces validamos y guardamos 
        
        $extension = ($tipoArchivo === 'image/jpeg') ? 'jpg' : 'png';
        $safe_name = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['nombreUsuario'] . $_POST['apellidoUsuario']); // Guardamos el nombre del archivo, pero antes lo editaremos para guardarlo en un nombre mas seguro quitando todo lo que no sea letras, numeros,etc
        $final_filename = $safe_name . "_" . time() . "." . $extension; // Para que 2 archivos no se suban con el mismo nombre, time devuelve numeros que no se van a repetir, se puede hacer con random tmb
        $target_path = $DNI_DIR . $final_filename; // El destino del archivo

        if (move_uploaded_file($archivo['tmp_name'], $target_path)) { // Si se ha movido correctamente
            $userData = $_POST; // Array que guarda todo lo que se envio en el 1 cuestionario
            $userData['ruta_dni'] = $target_path; // Guardamos en esta clave la ruta del dni
            $userData['fecha_registro'] = date('Y-m-d H:i:s'); // añadimos la fecha y hora actual
            // Todo lo anterior es lo que se introducira en el json junto a lo que se guardo del POST
            $current_data = []; // Lo que hay ahora mismo
            if (file_exists($USUARIO_FILE) && filesize($USUARIO_FILE) > 0) { // Si el archivo usuario.json existe y su tamaño es superiror a 0 significa que hay cosas dentro y no la podemos remplazar
                $json_content = file_get_contents($USUARIO_FILE); // Pasos para obtener lo que existe
                $current_data = json_decode($json_content, true);
                if ($current_data === null) { // Si devuelve null entonces reseteamos los datos que existe
                    $current_data = [];
                }
            }
            
            $current_data[] = $userData; // Metemos el array de datos nuevos;
            
            $introducirDatosJson = json_encode($current_data, JSON_PRETTY_PRINT); // Lo codificamos a string del json
            if (file_put_contents($USUARIO_FILE, $introducirDatosJson)) { // Guardamos el contenido y hacemos validaciones para mostrarlo
                $mensaje_final = "Los datos se han guardado con exito";
                
            } else {
                $mensaje_final = "No se han podido guardar los datos, pero se ha subido el dni"; 
            }

        } else {
            $mensaje_final = "Error al subir el dni";
        }

    } else {
        $mensaje_final = "Error al subir la imagen";
        $mensaje_final .= "<ul><li>" . implode("</li><li>", $errores) . "</li></ul>";
    }

} else {
    $mensaje_final = "Acceso no permitido.";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Procesamiento Final</title>
</head>
<body>
    <h1>Resultado del Registro</h1>
    <div style="border: 1px solid #ccc; padding: 20px;">
        <?php echo $mensaje_final; ?>
    </div>
    <p><a href="index.php">Volver al inicio</a></p>
</body>
</html>