<?php
    echo "<div>";
    //Mostramos todos los datos del usuario
    echo "<h2>Detalles del usuario " . $_POST["btnListar"] . "</h2>";
    $consulta = "select usuario, nombre, dni, sexo, foto from usuarios where id_usuario=" . $_POST["btnListar"];
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        if ($datos = mysqli_fetch_assoc($resultado)) {
            echo "<p><strong>Usuario : </strong>" . $datos["usuario"] . "</p>";
            echo "<p><strong>Nombre : </strong>" . $datos["nombre"] . "</p>";
            echo "<p><strong>DNI : </strong>" . $datos["dni"] . "</p>";
            echo "<p><strong>Sexo : </strong>" . $datos["sexo"] . "</p>";
            echo "<p><strong>foto : </strong><img src='img/" . $datos["foto"] . "'/></p>";
        } else {
            echo "<p>El usuario seleccionado ya no se encuentra en la BD</p>";
        }
        mysqli_free_result($resultado);
        echo "<form action='index.php' method='post'><input type='submit' value='Volver'/></form>";
        echo "</div>";
    } else {
        $error = "<p>Error en la consulta Nº: " . mysqli_errno($conexion) . " : " . mysqli_error($conexion) . "</p></div></body></html>";
        mysqli_close($conexion);
        session_destroy();
        die($error);
    }
    $_SESSION["accion"] = "El usuario mostrado";
?>