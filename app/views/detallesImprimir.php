<?php 

$id= $cli->id;
$nombre= $cli->first_name;
$apellido= $cli->last_name;
$email= $cli->email;
$genero=$cli->gender;
$ip=$cli->ip_address;
$tel=$cli->telefono;


require_once 'vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<h1>'.$nombre.' '.$apellido.' [#'.$id.']</h1>');
$mpdf->WriteHTML('<p>E-mail:  '.$email.'</p>');
$mpdf->WriteHTML('<p>Genero:  '.$genero.'</p>');
$mpdf->WriteHTML('<p>Ip:  '.$ip.'</p>');
$mpdf->WriteHTML('<p>Telefono:  '.$tel.'</p>');
$mpdf->WriteHTML('<iframe src="'.$localizacion.'></iframe>');
$mpdf->Output();
?>