<?php

function crudBorrar ($id){    
    $db = AccesoDatos::getModelo();
    $tuser = $db->borrarCliente($id);
}

function crudTerminar(){
    AccesoDatos::closeModelo();
    session_destroy();
    header("Location: index.php");
}
 
function crudAlta(){
    $cli = new Cliente();
    $orden= "Nuevo";
    $ruta="";
    include_once "app/views/formulario.php";
}

function crudDetalles($id){
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    $ruta=getFoto($id);
    $bandera=getBandera($cli->ip_address);
    $localizacion=getLoca($cli->ip_address);
    include_once "app/views/detalles.php";
}

function crudDetallesImprimir($id){
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    $ruta=getFoto($id);
    $bandera=getBandera($cli->ip_address);
    $localizacion=getLoca($cli->ip_address);
    include_once "app/views/detallesImprimir.php";
}

function crudDetallesSiguiente($id){
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteSiguiente($id);;
    if ($cli){
    $ruta=getFoto($cli->id);
    $bandera=getBandera($cli->ip_address);
    $localizacion=getLoca($cli->ip_address);
    include_once "app/views/detalles.php";
    }else {
        cruddetalles($id);
    }
}

function crudDetallesAnterior($id){
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnterior($id);
    if ($cli){
        $ruta=getFoto($cli->id);
        $bandera=getBandera($cli->ip_address);
        $localizacion=getLoca($cli->ip_address);
    include_once "app/views/detalles.php";
    }else {
        cruddetalles($id);
    }
}


function crudModificar($id){
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    $orden="Modificar";
    $ruta=getFoto($cli->id);
    include_once "app/views/formulario.php";
}

function crudPostAlta(){
    $db = AccesoDatos::getModelo();
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $error="";
    
    $cli = new Cliente();
    $cli->id=$_POST['id'];
    $cli->first_name=$_POST['first_name'];
    $cli->last_name=$_POST['last_name'];
    $cli->gender=$_POST['gender'];
    //Si el email pasa el filtrado y no existe en la base de datos lo guardo, sino muestro el error correspondiente
    if ((filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) && ($db->noexisteEmail($_POST['email']))) { $cli->email=$_POST['email'];}else{ $error=1; include_once "app/views/todo.php";} 	
    if (filter_var($_POST['ip_address'], FILTER_VALIDATE_IP)) { $cli->ip_address=$_POST['ip_address']; }else{ $error=2; include_once "app/views/todo.php"; }
    if (preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $_POST['telefono'])){ $cli->telefono=$_POST['telefono']; }else{ $error=3; include_once "app/views/todo.php";}

    //Si se ha enviado una imagen 
    if(isset($_FILES['imagen']['name'])){
        $error="";
        //Si la imagen pasa las condiciones y no hay ningún error 
        echo $error;
        if (imagenok($_FILES['imagen'])&&($error=="")){
          //Añado el cliente
            $db->addCliente($cli);
          //Subo la imagen mediante la id de usuario subido(autoincremento) y muestro el msg correspondiente
            $msg= up_img($_FILES['imagen'],$db->ultimoId());
            include_once "app/views/todo.php";
         //Sino muestro el error que ha tenido la imagen
        }else{
            echo "no entre";
            $error=0;
            echo $error;
            $msg=get_errorimg($_FILES['imagen']);
            include_once "app/views/todo.php";
        }
    }
    
}

function crudPostModificar(){
    $db = AccesoDatos::getModelo();
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $cli = new Cliente();
    $cli->id            =$_POST['id'];
    $cli->first_name    =$_POST['first_name'];
    $cli->last_name     =$_POST['last_name'];
    if ((filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) && ($db->noexisteEmail($_POST['email']))) { $cli->email=$_POST['email'];}else{ $error=1; include_once "app/views/todo.php";} 	
    $cli->gender=$_POST['gender'];
    if (filter_var($_POST['ip_address'], FILTER_VALIDATE_IP)) { $cli->ip_address=$_POST['ip_address']; }else{ $error=2; include_once "app/views/todo.php"; }
    if (preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $_POST['telefono'])) { $cli->telefono=$_POST['telefono']; }else{ $error=3; include_once "app/views/todo.php";}

    //Modifico el cliente
    $db->modCliente($cli);
    //Si se ha enviado una imagen 
    if(isset($_FILES['imagen']['name'])&&($_FILES['imagen']['name']!="")){
        print_r($_FILES['imagen']);
        $error="";
        //Si la imagen pasa las condiciones y no hay ningún error 
        if (imagenok($_FILES['imagen'])&&($error=="")){
          //Subo la imagen mediante la id de usuario subido(autoincremento) y muestro el msg correspondiente
            $msg= up_img($_FILES['imagen'],$cli->id);
            include_once "app/views/todo.php";
         //Sino muestro el error que ha tenido la imagen
        }else{
            echo "no entre";
            $error=0;
            echo $error;
            $msg=get_errorimg($_FILES['imagen']);
            include_once "app/views/todo.php";
        }
    }
    
}
