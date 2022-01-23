<?php
    if(!isset($_SESSION["registros"])){
        $_SESSION["registros"] = 2;
        $_SESSION["buscar"] = "";
    }

    if(isset($_POST["reg"])){
        $_SESSION["registros"] = $_POST["reg"];
        $_SESSION["buscar"] = $_POST["buscar"];
        $_SESSION["pagina"] = 1;
    }

    if(!isset($_SESSION["pagina"])){
        $_SESSION["pagina"] = 1;
    }
    if(isset($_POST["pagina"])){
        $_SESSION["pagina"] = $_POST["pagina"];
    }
?>