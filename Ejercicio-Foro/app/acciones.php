<?php

function accionDetalles($id){
    $usuario = $_SESSION['tuser'][$id];
    $nombre  = $usuario[0];
    $login   = $usuario[1];
    $clave   = $usuario[2];
    $comentario=$usuario[3];
    $orden = "Detalles";
    include_once "layout/formulario.php";
    exit();
}

function accionAlta(){
    $nombre  = "";
    $login   = "";
    $clave   = "";
    $comentario = "";
    $orden= "Nuevo";
    include_once "layout/formulario.php";
    exit();
}

function accionPostAlta(){
   /*Comprueba si esxite un login igual,si lo hay lo redirige al form , sino se guarda el nuevo usuario*/  
    for ($i=0; $i < sizeof($_SESSION['tuser']); $i++) { 
        if ($_SESSION['tuser'][$i][1]==$_POST['login']) {
            $_SESSION['msg']='El login '.$_POST['login'] .' ya existe, introduzca otro';
            $nombre  = $_POST['nombre'];
            $login   = $_POST['login'];
            $clave   = $_POST['clave'];
            $comentario = $_POST['comentario'];
             $orden= "Nuevo";
            include_once "layout/formulario.php";
            exit();
        }
    }

    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $nuevo = [ $_POST['nombre'],$_POST['login'],$_POST['clave'],$_POST['comentario']];
    $_SESSION['tuser'][]= $nuevo;  
    $_SESSION['msg']='Se ha añadido el usuario '. $_POST['nombre'];
        
}

function accionBorrar($id){
array_splice($_SESSION['tuser'],$id,1,null);
$_SESSION['msg']='Se ha borrado el usuario con id:'. $id;
}

function accionTerminar(){
volcarDatos(($_SESSION['tuser']));
session_destroy();
$_SESSION['msg'] = 'Se han guardado todos los datos';
}



function accionModificar($id){
    $usuario = $_SESSION['tuser'][$id];
    $nombre  = $usuario[0];
    $login   = $usuario[1];
    $clave   = $usuario[2];
    $comentario=$usuario[3];
    $orden = "Modificar";
    include_once "layout/formulario.php";
    exit();

}



function accionPostModificar(){

    limpiarArrayEntrada($_POST);
    $modificacion = [ $_POST['nombre'],$_POST['login'],$_POST['clave'],$_POST['comentario']];
    for ($i=0; $i < sizeof($_SESSION['tuser']); $i++) { 
        $_SESSION['tuser'][$i];
        if ($_SESSION['tuser'][$i][1]==$_POST['login']) {
            $_SESSION['tuser'][$i]= $modificacion;
            break;
        }
        
    }
    $_SESSION['msg']='Se ha modificado el usuario '. $_POST['nombre'];
    
}