<?php
    if($_SESSION["buscar"] == ""){
        $consulta = "select * from usuarios";
    }else{
        $consulta = "select * from usuarios where nombre LIKE '%".$_SESSION["buscar"]."%'";
    }
    $resultado = mysqli_query($conexion, $consulta);
    if($resultado){
        $total_registros = mysqli_num_rows($resultado);
        mysqli_free_result($resultado);

        $paginas = ceil($total_registros/$_SESSION["registros"]);
        if($paginas > 1){
            echo "<form id='form_pags' action='index.php' method='post'>";
            if($_SESSION["pagina"] > 1){
                //Boton para ir a la primera página
                echo "<button name='pagina' value='1'>|<</button>";
                //Boton para ir a la página anterior
                echo "<button name='pagina' value='".($_SESSION["pagina"] - 1)."'><</button>";
            }
            //Botones con las páginas
            for($i=1; $i<=$paginas; $i++){
                if($_SESSION["pagina"] == $i){
                    echo "<button disabled name='pagina' value='".$i."'>".$i."</button>";
                }else{
                    echo "<button name='pagina' value='".$i."'>".$i."</button>";
                }
            }
            if($_SESSION["pagina"] < $paginas){
                //Boton para ir a la página anterior
                echo "<button name='pagina' value='".($_SESSION["pagina"] + 1)."' >></button>";
                //Boton para ir a la últia página
                echo "<button name='pagina' value='".$paginas."' >>|</button>";
            }            
            echo "</form>";
        }
    }
?>