<form id="form_buscar" name="form_buscar" action="index.php" method="post">
    <div>
        <label for="reg">Registros a mostrar</label>
        <select name="reg" id="reg" onchange="document.form_buscar.submit();">
            <option <?php if($_SESSION["registros"] == 2) echo "selected";?> value="2">2</option>
            <option <?php if($_SESSION["registros"] == 4) echo "selected";?> value="4">4</option>
            <option <?php if($_SESSION["registros"] == -1) echo "selected";?> value="-1">Todos</option>
        </select>
    </div>
    <div>
        <input type="text" name="buscar" id="buscar" value="<?php echo $_SESSION["buscar"];?>"/>
        <input type="submit" value="Buscar"/>
    </div>
</form>