<?=
$comentario=strip_tags($_REQUEST['comentario']);
$palabras=[];
$palabras=explode(" ",$comentario);
?>


<div>
<b> Detalles:</b><br>
<table>
<tr><td>Longitud:          </td><td><?= strlen($comentario) ?></td></tr>
<tr><td>Nº de palabras:    </td><td><?= str_word_count($comentario); ?></td></tr>
<tr><td>Letra + repetida:  </td><td><?= letraMasRepetida( str_replace(" ","",$comentario)) ?></td></tr>
<tr><td>Palabra + repetida:</td><td><?= palabraMasRepetida($palabras) ?></td></tr>
</table>
</div>