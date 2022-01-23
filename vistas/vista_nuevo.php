<?php
    echo "<div>";
    ?>
        <h2>Nuevo Usuario</h2>
        <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" placeholder="Usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>" />
            <?php
                if (isset($_POST["btnContNuevo"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'> * Campo Obligatorio *</span>";
                    } else {
                        echo "<span class='error'> * Usuario repetido *</span>";
                    }
                }
            ?>
                <br /><br/>
                <label for="clave">Clave: </label>
                <input type="password" placeholder="Clave" name="clave" id="clave">
            <?php
                if (isset($_POST["btnContNuevo"]) && $error_clave) {
                    echo "<span class='error'> * Campo Obligatorio *</span>";
                }
            ?>
                <br /><br/>
                <label for="nombre">Nombre: </label>
                <input type="text" placeholder="Nombre" name="nombre" id="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>" />
            <?php
                if (isset($_POST["btnContNuevo"]) && $error_nombre) {
                    echo "<span class='error'> * Campo Obligatorio *</span>";
                }
            ?>
                <br/><br/>
                <label for="dni">DNI: </label>
                <input type="text" placeholder="DNI: 11223344A" name="dni" id="dni" value="<?php if (isset($_POST["dni"])) echo $_POST["dni"]; ?>" />
            <?php
                if (isset($_POST["btnContNuevo"]) && $error_dni) {
                    if ($_POST["dni"] == "") {
                        echo "<span class='error'> * Campo Obligatorio *</span>";
                    } elseif (!comprobarDNI($_POST["dni"])) { 
                        echo "<span class='error'> * DNI incorrecto *</span>";
                    } else {
                        echo "<span class='error'> * DNI repetido *</span>";
                    }
                }
            ?>
                <br /><br/>
                Sexo:
                <label for="hombre">Hombre</label>
                <input type="radio" name="sexo" id="hombre" value="Hombre" <?php if((isset($_POST["sexo"]) && $_POST["sexo"]=="Hombre" || !isset($_POST["btnContNuevo"]))) echo "checked";?>/>
                <label for="mujer">Mujer</label>
                <input type="radio" name="sexo" id="mujer" value="Mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="Mujer") echo "checked";?>/>
                <br/><br/>
                <label for="foto">Incluir mi foto (Archivo de tipo imagen Máx. 500KB):</label>
                <input type="file" name="foto" id="foto" accept="image/*"/>
                <span id="error">
                    <?php
                    if (isset($_POST["btnSubmit"]) && $error_foto) {
                        if ($_FILES["foto"]["error"]) {
                            echo "Error en la subida del archivo";
                        } elseif (!getimagesize($_FILES["foto"]["tmp_name"])) {
                            echo "No ha seleccionado un archivo imagen";
                        } else {
                            echo "El archivo seleccionado es superior a 500KB";
                        }
                    }
                    ?>
                </span>
                <br/><br/>
                <input type="submit" name="btnContNuevo" value="Guardar Cambios" />
                <input type="submit"value="Volver"/>
            </p>
        </form>
    <?php
    echo "</div>";
?>