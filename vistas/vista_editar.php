<?php
    if(isset($_POST["btnEditar"])){
        $id_usuario = $_POST["btnEditar"];
        $consulta = "select * from usuarios where id_usuario = ".$id_usuario;
        $resultado = mysqli_query($conexion, $consulta);
        if($resultado){
            if($datos = mysqli_fetch_assoc($resultado)){
                $usuario = $datos["usuario"];
                $nombre = $datos["nombre"];
                $dni = $datos["dni"];
                $sexo = $datos["sexo"];
                $foto = $datos["foto"];
            }else{
                $error_currencia = "<p>El usuario seleccionado ya no se encuentra en la BBDD</p>";
            }
            mysqli_free_result($resultado);
        }else{
            $error = "<p>Error en la consulta Nº: ".mysqli_errno($conexion)." : ".mysqli_error($conexion)."</p></div></body></html>";
            mysqli_close($conexion);
            session_destroy();
            die($error);
        }
    }else{
        $id_usuario = $_POST["id_usuario"];
        $nombre = $_POST["nombre"];
        $usuario = $_POST["usuario"];
        $dni = $_POST["dni"];
        $sexo = $_POST["sexo"];
        $foto = $_POST["foto_ant"];
    }
    echo "<h2>Editando el Usuario con ID ".$id_usuario."</h2>";
    if(isset($error_concurrencia)){
        echo $error_concurrencia;
        echo "<form action='index.php' method='post'><input type='submit' value='Volver'/></form>";
    }else{
        ?>
            <form id="form_editar" action="index.php" method="post" enctype="multipart/form-data">
                <div>
                    <p>
                        <label for="nombre">Nombre:</label>
                        <br/>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>"/>
                        <?php
                            if(isset($_POST["btnContEditar"]) && $error_nombre){
                                echo "<span class='error>** Campo Obligatorio **</span>";
                            }
                        ?>
                    </p>
                    <p>
                        <label for="usuario">Usuario:</label>
                        <br/>
                        <input type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?php  echo $usuario; ?>">
                        <?php
                            if(isset($_POST["btnContEditar"]) && $error_usuario){
                                if($_POST["usuario"] == ""){
                                    echo "<span class='error'>** Campo Obligatorio**</span>";
                                }else{
                                    echo "<span class='error'>** Usuario repetido **</span>";
                                }
                            }
                        ?>
                    </p>
                    <p>
                        <label for="clave">Contraeña:</label>
                        <br/>
                        <input type="password" name="clave" id="clave" placeholder="Contraseña"/>
                    </p>
                    <p>
                        <label for="dni">DNI:</label>
                        <br/>
                        <input type="text" placeholder="DNI: 11223344A" name="dni" id="dni" value="<?php echo $dni; ?>"/>
                        <?php
                            if(isset($_POST["btnContEditar"]) && $error_dni){
                                if ($_POST["dni"] == "") {
                                    echo "<span class='error'> * Campo Obligatorio *</span>";
                                } elseif (comprobarDNI($_POST["dni"])) { 
                                    echo "<span class='error'> * DNI incorrecto *</span>";
                                } else {
                                    echo "<span class='error'> * DNI repetido *</span>";
                                }
                            }
                        ?>
                    </p>
                    <p>Sexo:</p>
                    <p>
                        <input type="radio" name="sexo" id="hombre" value="Hombre" <?php if($sexo=="Hombre") echo "checked";?>/>
                        <label for="hombre">Hombre</label>
                        <br/>
                        <input type="radio" name="sexo" id="mujer" value="Mujer" <?php if($sexo=="Mujer") echo "checked";?>/>
                        <label for="mujer">Mujer</label>
                    </p>
                    <p>
                        <label for="foto">Incluir mi foto (Máx 500Kb de imagen): </label>
                        <input type="file" name="foto" id="foto" accept="image/*"/>
                        <br/>
                        <?php
                            if(isset($_POST["btnContEditar"]) && $error_foto){
                                if($_FILES["foto"]["error"]){
                                    echo "<span class='error'>Error en la subida del archivo al servidor</span>";
                                }elseif(!getimagesize($_FILES["foto"]["tmp_name"])){
                                    echo "<span class='error'>No has seleccionado un archivo imagen</span>";
                                }else{
                                    echo "<span class='error'>Tamaño de la imagen demasiado grande</span>";
                                }
                            }
                        ?>
                    </p>
                    <p>
                        <input type="hidden" name="id_usuario" value="<?php echo $id_usuario;?>"/>
                        <input type="hidden" name="foto_ant" value="<?php echo $foto;?>"/>
                        <input type="submit" name="btnContEditar" value="Guardar Cambios"/>
                        <input type="submit" value="Atrás"/>
                    </p>
                </div>
                <div>
                    <img src="img/<?php echo $foto;?>" alt="Imagen del usuario" title="Imagen del usuario"/>
                    <br/>
                    <?php
                        if($foto != IMAGEN_DEFECTO && !isset($_POST["btnBorrarFoto"])){
                            echo "<input type='submit' name='btnBorrarFoto' value='Borrar'/>";
                        }
                        if(isset($_POST["btnBorrarFoto"])){
                            ?>
                                <p>¿Estás seguro?</p>
                                <input type="submit" value="Continuar" name="btnContBorrarFoto"/>
                                <input type="submit" value="Volver" name="btnNoContBorrarFoto"/>
                            <?php
                        }
                    ?>
                </div>
            </form>
        <?php
    }
?>