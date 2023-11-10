<?php
session_start();

$compraRealizada = "";

// Nuevo cliente 
if (isset($_GET['cliente'])) {
    $_SESSION['cliente'] = $_GET['cliente'];
    $_SESSION['pedidos'] = [];
}

//PRIMERA ENTRADA
if (!isset($_SESSION['cliente'])) {
    require_once('bienvenida.php');
    exit(); //Para que solo se muestre beinvenida, y con el
            //el $_SERVER['PHP_SELF'] de bienvenida se vuelve a hacer este código.
}

// SE USA $_SERVER['PHP_SELF'] PARA LLEGAR ACA
    //SI TINE VALOR EL $POST
if (isset($_POST["accion"])) {
    
    //SI ESTE VALOR ES ANOTAR
    if ($_POST["accion"] == " Anotar ") {
        if (isset($_SESSION['pedidos'][$_POST['fruta']])) //SI YA HABIA ALGO ANOTADO DE ES FRUTA, AÑADE CANTIDAD
            $_SESSION['pedidos'][$_POST['fruta']] += $_POST['cantidad'];
        else {
            $_SESSION['pedidos'][$_POST['fruta']] = $_POST['cantidad']; // SINO, INICIALIZA CON LA CANTIDAD SEÑALADA
        }
    }
    
    //SI ESTE VALOR ES TERMINAR
    if ($_POST["accion"] == " Terminar ") {
        $compraRealizada = htmlTablaPedidos();
        require_once("despedida.php");
        session_destroy();
        exit;
    }
}

$compraRealizada = htmlTablaPedidos();
require_once('compra.php');


function htmlTablaPedidos(): string
{
    $msg = "";
    if (count($_SESSION['pedidos']) > 0) {
        $msg .= "Este es su pedido :";
        $msg .= "<table style='border: 1px solid black;'>";
        foreach ($_SESSION['pedidos'] as $key => $value) {
            $msg .= "<tr><td><b>" . $key . "</b><td></td><td>" . $value . "</td></tr>";
        }
        $msg .= "</table>";
    }
    return $msg;
}