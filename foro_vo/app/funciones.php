<?php
function usuarioOk($usuario, $contraseña) :bool {
   return (strrev(trim(strip_tags($usuario)))==$contraseña);
}

function palabraMasRepetida($array){
      $palabraMasRepetida = "";
      $maxRepeticiones = 1;
      
      foreach ($array as $palabra) {
         $repeticiones = 0;
         foreach ($array as $palabra2) {
               if ($palabra == $palabra2) {
                  $repeticiones++;
               }
         }
         if ($repeticiones > $maxRepeticiones) {
               $palabraMasRepetida = $palabra;
               $maxRepeticiones = $repeticiones;
         }
      }
      // Si el String a devolver está vacío devolvemos un mensaje, sino devolvemos la palabra
      if ($palabraMasRepetida=="") {
         return "No hay palabras repetidas";
      } else {
         return $palabraMasRepetida;
      }
   }

   function letraMasRepetida($string){
      $letraMasRepetida = "";
      $maxRepeticiones = 1;
      
      foreach (count_chars($string, 1) as $i => $val) {
         if ($val > $maxRepeticiones) {
               $letraMasRepetida = chr($i);
               $maxRepeticiones = $val;
         }
      }
      // Si el String a devolver está vacío devolvemos un mensaje, sino devolvemos la letra
      if ($letraMasRepetida=="") {
         return "No hay letras repetidas";
      } else {
         return $letraMasRepetida;
      }
   }