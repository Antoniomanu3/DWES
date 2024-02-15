<?php
switch ($error) {
    case 0:
        echo '<h1>'.$msg.'</h1>';
        echo '<button onclick="history.back()"> Volver </button>';
        break;
    case 1:
        echo '<h1> El correo no es válido (ej. example@text.es) o ya en uso </h1>';
        echo '<button onclick="history.back()"> Volver </button>';
        break;

    case 2:
        echo '<h1> La IP no es válida (ej. xxx.xxx.xxx.xxx) </h1>';
        echo '<button onclick="history.back()"> Volver </button>';
        break;

    case 3:
        echo '<h1> El teléfono no es válido (ej. 555-555-5555) </h1>';
        echo '<button onclick="history.back()"> Volver </button>';
        break;

    default : 
        echo '<h1>'.$msg.'</h1>';
        echo '<button onclick='.'location.href="http://localhost/Taller_php/2%c2%baTrimestre/ProyectoWeb%5bMokaroo%5d/"'.'> Principal </button>';
        break;
    
}

?>