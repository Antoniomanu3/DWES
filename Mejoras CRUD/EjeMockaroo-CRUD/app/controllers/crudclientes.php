<?php

function crudBorrar($id)
{
    $db = AccesoDatos::getModelo();
    $tuser = $db->borrarCliente($id);
}

function crudTerminar()
{
    AccesoDatos::closeModelo();
    session_destroy();
}

function crudAlta()
{
    $db = AccesoDatos::getModelo();
    $cli = new Cliente();
    $orden = "Nuevo";
    include_once "app/views/formulario.php";
}

function crudDetalles($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    include_once "app/views/detalles.php";
}

function crudDetallesSiguiente($id)
{
    $db = AccesoDatos::getModelo();
    if ($cli = $db->getClienteSiguiente($id)) {
        include_once "app/views/detalles.php";
    } else {
        crudDetalles($id);
    }

    $cli = $db->getClienteSiguiente($id);
    include_once "app/views/detalles.php";
}

function crudDetallesAnterior($id)
{

    $db = AccesoDatos::getModelo();
    if ($cli = $db->getClienteAnterior($id)) {
        include_once "app/views/detalles.php";
    } else {
        crudDetalles($id);
    }
    $cli = $db->getClienteAnterior($id);
    include_once "app/views/detalles.php";
}

function crudModificarSiguiente($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteSiguiente($id);
    include_once "app/views/formulario.php";
}

function crudModificarAnterior($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnterior($id);
    include_once "app/views/formulario.php";
}

function crudModificar($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    $orden = "Modificar";
    include_once "app/views/formulario.php";
}

function crudPostAlta()
{
    $db = AccesoDatos::getModelo();

    limpiarArrayEntrada($_POST); //Evito la posible inyección de código


    $cli = new Cliente();
    $cli->id = $_POST['id'];
    $cli->first_name = $_POST['first_name'];
    $cli->last_name = $_POST['last_name'];
    $cli->email = $_POST['email'];
    $cli->gender = $_POST['gender'];
    $cli->ip_address = $_POST['ip_address'];
    $cli->telefono = $_POST['telefono'];

    $emailExiste = $db->existeEmail($_POST['email']);
    $ipOK = comprobarIP($_POST['ip_address']);
    $telefonoOK = comprobarTelefono($_POST['telefono']);


    if ($emailExiste || !$ipOK || !$telefonoOK) {
        $orden = 'Nuevo';
        $error = 'Error en el formulario. ';
        if ($emailExiste) {
            $error .= "El email ya existe. ";
        }
        if (!$ipOK) {
            $error .= "La IP no es correcta. ";
        }
        if (!$telefonoOK) {
            $error .= "El telefono no es correcto. ";
        };
        include_once "app/views/formulario.php";
    } else {
        $db->addCliente($cli);

    }

}

function crudPostModificar()
{
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $cli = new Cliente();

    $cli->id = $_POST['id'];
    $cli->first_name = $_POST['first_name'];
    $cli->last_name = $_POST['last_name'];
    $cli->email = $_POST['email'];
    $cli->gender = $_POST['gender'];
    $cli->ip_address = $_POST['ip_address'];
    $cli->telefono = $_POST['telefono'];
    $db = AccesoDatos::getModelo();
    $db->modCliente($cli);

    $correcto = true;

    if (emailRepetidoModificar($cli->email, $cli->id)) {
        print "<p style='color: red;'>El email ya existe en la base de datos.</p>";
        $cli->email = "";
        $correcto = false;
    }

    if (!ipCorrecta($cli->ip_address)) {
        print "<p style='color: red;'>La IP no tiene el formato correcto.</p>";
        $cli->ip_address = "";
        $correcto = false;
    }
    if (!telefonoCorrecto($cli->telefono)) {
        print "<p style='color: red;'>El teléfono no tiene el formato correcto.</p>";
        $cli->telefono = "";
        $correcto = false;
    }
    if ($_POST['first_name'] == "") {
        print "<p style='color: red;'>El nombre no puede estar vacío.</p>";
        $cli->first_name = "";
        $correcto = false;
    }
    if ($_POST['last_name'] == "") {
        print "<p style='color: red;'>El apellido no puede estar vacío.</p>";
        $cli->last_name = "";
        $correcto = false;
    }
}

function conseguirRol($login):bool
{
    $rolConseguido = false;

    $db = AccesoDatos::getModelo();
    $resu = $db->getRol($login);

    if($resu !== false) {
        // si se encontró una coincidencia, devuelve true y se asigna a la variable de sesion el rol
        $rolConseguido = true;
        $_SESSION['rol'] = $resu;
    }

    return $rolConseguido;
}

//Funcion para ver si la ip tiene el formato correcto (999.999.999.999)

function ipCorrecta($ip)
{
    $formato = true;
    $patron = "/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/";

    if (preg_match($patron, $ip)) {
        $formato = true;
    } else {
        $formato = false;
    }

    return $formato;
}

//Funcion para ver si el email esta repetido en el alta

function emailRepetido($email)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteEmail($email);
    if ($cli) {
        return true;
    } else {
        return false;
    }
}

//Funcion para ver si el email esta repetido en modificar salvo en el cliente que se está modificando actualmente

function emailRepetidoModificar($email, $id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteEmail($email);
    if ($cli) {
        if ($cli->id == $id) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

//Funcion para ver si el telefono tiene el formato correcto (999-999-999)

function telefonoCorrecto($telefono)
{
    $formato = true;
    $patron = "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/";

    if (preg_match($patron, $telefono)) {
        $formato = true;
    } else {
        $formato = false;
    }

    return $formato;
}
