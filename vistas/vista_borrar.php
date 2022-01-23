<?php
    echo "<div>";
    echo "<h2>Borrado del usuario ".$_POST["btnBorrar"]."</h2>";
    echo "<form action='index.php' method='post'>";
    echo "<p class='centrar'>Se dispone ha borrar al usuario con nombre: <strong>".$_POST["nombreBorrar"]."</strong></p>";
    echo "<p class='centrar'>
            <button type='submit' name='btnContBorrar' value='".$_POST["btnBorrar"]."'>Continuar</button> 
            <input type='submit' value='Cancelar'/>
            <input type='hidden' name='img_borra' value='" . $_POST["imgBorrar"] . "'/>
        </p>";
    echo "</form>";
    echo "</div>";
?>