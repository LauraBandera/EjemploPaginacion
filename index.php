<?php

require "src/ctes_funciones.php";

session_name("Practica_8");
session_start();

@$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
if (!$conexion) {
    session_destroy();
    die(error_page("Práctica 8 - Index", "<h1>Listado de Usuarios</h1><p>Error en la conexión Nº: ".mysqli_connect_errno()." : ".mysqli_connect_error()."</p>"));
}
mysqli_set_charset($conexion, "utf8");

/*----------------------------------- Modelos Editar ---------------------------------- */
if(isset($_POST["btnContEditar"])){
    require "modelos/modelo_contEditar.php";
}

if(isset($_POST["btnContBorrarFoto"])){
    require "modelos/modelo_contBorrarFoto.php";
}

/*----------------------------------- Modelos Borrar ---------------------------------- */
if (isset($_POST["btnContBorrar"])) {
    require "modelos/modelo_contBorrar.php";
}

/*----------------------------------- Modelos Nuevo ---------------------------------- */
if (isset($_POST["btnContNuevo"])) {
    require "modelos/modelo_contNuevo.php";
}

/*------------------------------------ Modelo Paginación ------------------------------ */
require "modelos/modelo_paginacion.php";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 8 - Index</title>
    <style>
        .centrar {
            text-align: center;
        }
        .form_nuevo {
            width: 60%;
            margin: 1.5em auto;
        }
        img {
            width: 75px;
            height: auto;
        }
        table,
        th,
        td {
            border: 1px solid black;
        }
        table {
            border-collapse: collapse;
            width: 60%;
            margin: 0 auto;
        }
        .enlinea {
            display: inline;
        }
        .enlace {
            background: none;
            border: none;
            text-decoration: underline;
            color: blue;
        }
        .error{
            color: red;
        }
        #form_editar{
            display:flex;
            justify-content: space-evenly;
        }
        #form_editar div{
            width:50%
        }
        #form_editar div img{
            height:250px;
            width: auto;
        }
        #form_buscar{
            width: 60%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            margin-bottom: .5rem;
        }
        #form_pags{
            width: 60%;
            margin: 0 auto;
            text-align: center;
            margin-top: .5rem;
        }
    </style>
</head>

<body>
    <h1>Práctica 8</h1>

    <?php
        //----------------------------------- Vista Listar -----------------------------
        if (isset($_POST["btnListar"])) {
            require "vistas/vista_listar.php";
        }

        //--------------------------------------- Vista Editar ------------------------------------
        if (isset($_POST["btnEditar"]) || (isset($_POST["btnContEditar"]) && $errores_form_editar) || isset($_POST["btnBorrarFoto"]) || isset($_POST["btnNoContBorrarFoto"])) {
            require "vistas/vista_editar.php";
        }

        //---------------------------------------- Vista Borrar ---------------------------------------
        if (isset($_POST["btnBorrar"])) {
            require "vistas/vista_borrar.php";
        }

        //------------------------------------------ Vista Nuevo ------------------------------------
        if(isset($_POST["btnNuevo"]) || (isset($_POST["btnContNuevo"]) && $error_form_nuevo)){
            require "vistas/vista_nuevo.php";
        }

        //------------------------------------------ TABLA PRINCIPAL + ACCIÓN -----------------------------------------
        //Ponemos la acción realizada
        if (isset($_SESSION["accion"])) {
            echo "<p class='mensaje'>".$_SESSION["accion"]."</p>";
            unset($_SESSION["accion"]);
        }
        
        echo "<h2>Listado de los usuarios</h2>";
        //Formulario buscar y número registro por página
        require "vistas/vista_buscar.php";

        require "vistas/vista_principal.php";

        //Formulario paginación
        require "vistas/vista_paginacion.php";
        mysqli_close($conexion);
    ?>

</body>

</html>