<?php
    //CALCULO INICIO
    $inicio=($_SESSION["pagina"]-1)*$_SESSION["registros"];

    //Depende de la paginación
    if($_SESSION["registros"] > 0){
        if($_SESSION["buscar"] == ""){
            $consulta = "select * from usuarios limit ".$inicio.",".$_SESSION["registros"];
        }else{
            $consulta = "select * from usuarios where nombre LIKE '%".$_SESSION["buscar"]."%' limit ".$inicio.",".$_SESSION["registros"];
        }
    }else{
        if($_SESSION["buscar"] == ""){
            $consulta = "select * from usuarios";
        }else{
            $consulta = "select * from usuarios where nombre LIKE '%".$_SESSION["buscar"]."%'";
        }
    }
    
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo "<table class='centrar'>
                    <tr>
                        <th>#</th>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>
                            <form class='form_nuevo enlinea' action='index.php' method='post'>
                                <input class='enlace' type='submit' name='btnNuevo' value='Usuario +'/>
                            </form>
                        </th>
                    </tr>";
        while ($datos = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>".$datos["id_usuario"]."</td>";
            echo "<td><img src='img/".$datos["foto"]."'/></td>";
            echo "<td>
                        <form class='form_nuevo' action='index.php' method='post'>
                            <button class='enlace' title='Detalles Usuario' name='btnListar' value='" . $datos["id_usuario"] . "'>" . $datos["nombre"] . "</button>
                        </form></td>";
            echo "<td>
                        <form class='form_nuevo enlinea' action='index.php' method='post'>
                            <button class='enlace' title='Borrar Usuario' name='btnBorrar' value='" . $datos["id_usuario"] . "'>Borrar</button>
                            <input type='hidden' name='nombreBorrar' value='" . $datos["nombre"] . "'/>
                            <input type='hidden' name='imgBorrar' value='" . $datos["foto"] . "'/>
                        </form>
                        - 
                        <form class='form_nuevo enlinea' action='index.php' method='post'>
                            <button class='enlace' title='Editar Usuario' name='btnEditar' value='" . $datos["id_usuario"] . "'>Editar</button>
                        </form>
                </td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_free_result($resultado);
    } else {
        $error = "<p>Error en la consulta Nº: ". mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p></body></html>";
        mysqli_close($conexion);
        session_destroy();
        die($error);
    }
?>