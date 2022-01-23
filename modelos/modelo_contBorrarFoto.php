<?php
    $consulta = "update usuarios set foto='".IMAGEN_DEFECTO."' where id_usuario=".$_POST["id_usuario"];
    $resultado = mysqli_query($conexion, $consulta);
    if($resultado){
        unlink("img/".$_POST["foto_ant"]);
        $_POST["foto_ant"] = IMAGEN_DEFECTO;
    }else{
        $body="<h1>Práctica 8</h1><p>Error en la consulta Nº: ".mysqli_errno($conexion). " : ".mysqli_error($conexion)."</p>";
        mysqli_close($conexion);
        session_destroy();
        die(error_page("Práctica 8 - Index",$body));
    }
?>