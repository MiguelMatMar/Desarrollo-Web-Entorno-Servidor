<?php 
    // Apartado seleccion calleAvenida select options desplegable
        function mostrarCalleAvenida(){
            if(!empty($_REQUEST["seleccionCalleAvenida"])){
                $seleccionCalleAvenida = $_POST["seleccionCalleAvenida"];
                $calles = ['calle1','calle2','calle3'];
                $avenidas = ['avenida1','avenida2','avenida3'];
                if($seleccionCalleAvenida == "calle"){
                    echo "<select name='calle' id='calle'>";
                    foreach($calles as $calle){
                        echo "<option value='$calle'> $calle </option>";
                    }
                    echo "</select>";
                }elseif($seleccionCalleAvenida == "avenida"){
                    echo "<select name='avenida' id='avenida'>";
                    foreach($avenidas as $avenida){
                        echo "<option value='$avenida'> $avenida </option>";
                    }
                    echo '</select>';
                }
            }
        }
    // Valida campos del formulario
        $erroresValidacion = [];
        
        if(isset($infoUsr)){ // Si ya esta seteada y hay cosas dentro no la vuelve a setear
            $infoUsr = [];
        }
        var_dump($infoUsr);
        if(!empty($_REQUEST["nombreUsuario"])){
            $nombreUsuario = $_POST["nombreUsuario"];
            $comprobacion = "/^[a-zA-Z]+$/";
            if(!preg_match($comprobacion,$nombreUsuario)){
                $erroresValidacion[] = "<br> Error de nombre usuario, solo puede tener MAYUS y minus <br>";
            }else{
                $infoUsr[] = $nombreUsuario;
            }
        }
        if(!empty($_REQUEST["apellidoUsuario"])){
            $apellidoUsuario = $_POST["apellidoUsuario"];
            $comprobacion = "/^([a-zA-Z]+\s){2,}$/";
            if(!preg_match($comprobacion, $apellidoUsuario)){
                $erroresValidacion[] = "<br> Error de Apellidos, solo puede tener MAYUS y minus, y cada apellido separado por un espacio <br>";
            }else{
                $infoUsr[] = $apellidoUsuario;
            }
        }
        if(!empty($_REQUEST["direccionUsuario"])){
            $direccionUsuario = $_POST["direccionUsuario"];
            $comprobacion = "/^[a-zA-Z0-9]+$/";
            if(!preg_match($comprobacion,$direccionUsuario)){
                $erroresValidacion[] = "<br> Error de direccion, la direccion solo puede tener MAYUS, minus y numeros <br>";
            }else{
                $infoUsr[] = $direccionUsuario;
            }
        }
        
?>