<?php
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {
        $error_usuario = repetido($conexion, "usuarios", "usuario",  $_POST["usuario"]);
        if (is_array($error_usuario)) {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Práctica 8 - Index", "<h1>Nuevo Usuario</h1><p>".$error_usuario["error"]."</p>"));
        }
    }

    $error_clave = $_POST["clave"] == "";
    $error_nombre = $_POST["nombre"] == "";
    
    $error_dni = $_POST["dni"] == "" || comprobarDNI($_POST["dni"]);
    if (!$error_dni) {
        $error_dni = repetido($conexion, "usuarios", "dni", strtoupper($_POST["dni"]));
        if (is_array($error_dni)) {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Práctica 8 - Index", "<h1>Nuevo Usuario</h1><p>".$error_dni["error"]."</p>"));
        }
    }
    
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000);
    
    $error_form_nuevo = $error_nombre || $error_usuario || $error_clave || $error_dni || $error_foto;

    if (!$error_form_nuevo) {
        $consulta = "insert into usuarios (usuario, nombre, clave, dni, sexo) values ('".$_POST["usuario"]."','".$_POST["nombre"] . "','" . md5($_POST["clave"]) . "','" . strtoupper($_POST["dni"]) . "', '".$_POST["sexo"]."')";
        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
            $_SESSION["accion"] = "El usuario ha sido insertado con éxito";
            if($_FILES["foto"]["name"] != ""){
                $ult_id = mysqli_insert_id($conexion);
                $array_aux = explode(".", $_FILES["foto"]["name"]);
                if(count($array_aux) == 1){
                    $extension = "";
                }else{
                    $extension = ".".end($array_aux);
                }
                $nombre_img = "img".$ult_id.$extension;
                @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "img/".$nombre_img);
                if($var){
                    $consulta = "update usuarios set foto='".$nombre_img."' where id_usuario=".$ult_id;
                    $resultado = mysqli_query($conexion, $consulta);
                    if(!$resultado){
                        $body="<h1>Práctica 8</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
                        mysqli_close($conexion);
                        session_destroy();
                        die(error_page("Práctica 8 - Index",$body));
                    }
                }else{
                    $_SESSION["accion"]="Usuario insertado con la foto por defecto";
                }
            }
        } else {
            $body = "<h1>Nuevo Usuario</h1><p>Imposible realizar la consulta. Nº".mysqli_errno($conexion)." : ".mysqli_error($conexion) . "</p>";
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Práctica 8 - Index", $body));
        }
    }
?>