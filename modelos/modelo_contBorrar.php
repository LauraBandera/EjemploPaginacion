<?php
    $consulta = "delete from usuarios where id_usuario=".$_POST["btnContBorrar"];
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        $_SESSION["accion"] = "El usuario seleccionado ha sido borrado con éxito";
        $_SESSION["pagina"] = 1;
        if($_POST["img_borra"] != IMAGEN_DEFECTO){
            unlink("img/".$_POST["img_borra"]);
        }
    } else {
        $body = "<h1>Práctica 8</h1><p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p>";
        mysqli_close($conexion);
        session_destroy();
        die(error_page("Práctica 8 - Index", $body));
    }
?>