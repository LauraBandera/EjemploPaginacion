<?php
    $error_nombre = $_POST["nombre"] == "";

    $error_usuario = $_POST["usuario"] == "";
    if(!$error_usuario){
        $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"], "id_usuario", $_POST["id_usuario"]);
        if(is_array($error_usuario)){
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Práctica 8 - Index", "<p>".$error_usuario["error"]."</p>"));
        }
    }

    $error_dni = $_POST["dni"] == "" || comprobarDNI($_POST["dni"]);
    if(!$error_dni){
        $error_dni = repetido($conexion, "usuarios", "dni", strtoupper($_POST["dni"]), "id_usuario", $_POST["id_usuario"]);
        if(is_array($error_dni)){
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Práctica 8 - Index","<p>".$error_dni["error"]."</p>"));
        }
    }

    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000);

    $errores_form_editar = $error_nombre || $error_usuario || $error_dni || $error_foto;
    if(!$errores_form_editar){
        if($_POST["clave"] == ""){
            $consulta = "update usuarios set usuario='".$_POST["usuario"]."', nombre='".$_POST["nombre"]."', dni='".strtoupper($_POST["dni"])."', sexo='".$_POST["sexo"]."' where id_usuario=".$_POST["id_usuario"];
        }else{
            $consulta = "update usuarios set usuario='".$_POST["usuario"]."', nombre='".$_POST["nombre"]."', clave='".md5($_POST["clave"])."', dni='".strtoupper($_POST["dni"])."', sexo='".$_POST["sexo"]."' where id_usuario=".$_POST["id_usuario"];
        }
        $resultado = mysqli_query($conexion, $consulta);
        if($resultado){
            $_SESSION["accion"] = "Usuario editado con éxito";
            if($_FILES["foto"]["name"] != ""){
                $array_aux = explode(".", $_FILES["foto"]["name"]);
                if(count($array_aux) == 1){
                    $extension = "";
                }else{
                    $extension = ".".end($array_aux);
                }
                $nombre_img_nuevo = "img".$_POST["id_usuario"].$extension;
                @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "img/".$nombre_img_nuevo);
                if($var){
                    if($_POST["foto_ant"] != $nombre_img_nuevo){
                        $consulta = "update usuarios set foto='".$nombre_img_nuevo."' where id_usuario=".$_POST["id_usuario"];
                        $resultado = mysqli_query($conexion, $consulta);
                        if(!$resultado){
                            $body="<h1>Práctica 8</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
                            mysqli_close($conexion);
                            session_destroy();
                            die(error_page("Práctica 8 - Index",$body));
                        }
                        if($_POST["foto_ant"] != IMAGEN_DEFECTO){
                            unlink("img/".$_POST["foto_ant"]);
                        }
                    }
                }else{
                    $_SESSION["accion"] = "Actualizado el usuario sin foto por problemas al moverla a la carpeta del servidor";
                }
            }
        }else{
            $body="<h1>Práctica 8</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Práctica 8 - Index",$body));
        }
    }
?>