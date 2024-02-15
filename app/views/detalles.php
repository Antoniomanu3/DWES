<hr>
<button onclick="location.href='./'"> Volver </button>
<br><br>
<table>
    <tr>
        <td>Id:</td>
        <td><input type="number" name="id" value="<?= $cli->id ?>" readonly> </td>
        <td rowspan="7">
            <img src='<?= $ruta ?>' />
        </td>
        <td rowspan="7">
            <img src="<?= $bandera ?>" width="20px" height="20px" />
        </td>

        <td rowspan="7">
            <iframe src="<?= $localizacion ?>" width="200px"  frameborder="0" style='border:0' allowfullscreen ></iframe>
        </td>
    </tr>
    <tr>
        <td>First_name:</td>
        <td><input type="text" name="first_name" value="<?= $cli->first_name ?>" readonly> </td>
    </tr>
    <tr>
        <td>Last_name:</td>
        <td><input type="text" name="last_name" value="<?= $cli->last_name ?>" readonly></td>
    </tr>
    <tr>
        <td>E-mail:</td>
        <td><input type="email" name="email" value="<?= $cli->email ?>" readonly></td>
    </tr>
    <tr>
        <td>Gender</td>
        <td><input type="text" name="gender" value="<?= $cli->gender ?>" readonly></td>
    </tr>
    <tr>
        <td>Ip_address:</td>
        <td><input type="text" name="ip_address" value="<?= $cli->ip_address ?>" readonly></td>
    </tr>
    <tr>
        <td>Telefono:</td>
        <td><input type="tel" name="telefono" value="<?= $cli->telefono ?>" readonly></td>
    </tr>
</table>
<br>
<form>
    <input type="hidden" name="id" value="<?= $cli->id ?>">
    <button type="submit" name="nav-detalles" value="Anterior"> Anterior << </button>
            <button type="submit" name="nav-detalles" value="Siguiente"> >> Siguiente </button>
            <button type="submit" name="nav-detalles" value="Imprimir"> Imprimir </button>
</form>