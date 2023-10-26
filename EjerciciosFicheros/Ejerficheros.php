<html>

<head>
    <title>Formulario de subida de archivos múltiple</title>
    <meta charset="UTF-8">
</head>

<body>
    <?php
    // se incluyen esta tabla de  códigos de error que produce la subida de archivos en PHPP
    // Posibles errores de subida segun el manual de PHP

    define('TAMANIO_MAXIMO_TOTAL', 300); // 300KB
    define('TAMANIO_MAXIMO_IMAGEN', 200000); // 200KB


    define('ERROR_NO_JPG_PNG', 9);
    define('ERROR_TAMANIO_IMAGEN', 10);
    define('ERROR_TAMANIO_TOTAL', 11);
    define('ERROR_IMG_EXISTENTE', 12);

    $codigosErrorSubida = [
        UPLOAD_ERR_OK         => 'Subida correcta',  // Valor 0
        UPLOAD_ERR_INI_SIZE   => 'El tamaño del archivo excede el admitido por el servidor',  // directiva upload_max_filesize en php.ini
        UPLOAD_ERR_FORM_SIZE  => 'El tamaño del archivo excede el admitido por el cliente',  // directiva MAX_FILE_SIZE en el formulario HTML
        UPLOAD_ERR_PARTIAL    => 'El archivo no se pudo subir completamente',
        UPLOAD_ERR_NO_FILE    => 'No se seleccionó ningún archivo para ser subido',
        UPLOAD_ERR_NO_TMP_DIR => 'No existe un directorio temporal donde subir el archivo',
        UPLOAD_ERR_CANT_WRITE => 'No se pudo guardar el archivo en disco',  // permisos
        UPLOAD_ERR_EXTENSION  => 'Una extensión PHP evito la subida del archivo',  // extensión PHP
        ERROR_NO_JPG_PNG      => 'El archivo no es una imagen JPG o PNG',
        ERROR_TAMANIO_IMAGEN  => 'El tamaño de la imagen excede el permitido',
        ERROR_IMG_EXISTENTE => 'Ya existe un archivo con el mismo nombre',

    ];



    $mensaje = '';
    $directorioSubida = 'C:/imgusers';
    $tamanioTotal = 0;
    $errorFicheros = 0;


    // No se recibe nada, error al enviar el POST, se supera post_max_size
    if (count($_POST) == 0) {
        $mensaje = "  Error: se supera el tamaño máximo de un petición POST ";
    }
    // si no se recibe el el archivo, se descarta el proceso
    else if (sizeOf($_FILES) == 0) {
        $mensaje = "  Error: no se reciben archivos ";
        echo $mensaje;
    } else {
        /*  PARA VER EL CONTENIDO DE $FILES Y ERRORES*/
        echo "<pre>";
        var_dump($_FILES);

        echo "<pre>";
        var_dump($codigosErrorSubida);
        echo " ** Se reciben archivos **";

        $numeroImagenes = sizeof($_FILES['archivos']['name']);

        $mensaje .= "<h3>Comprobando si cumplen las condiciones los archivos recibidos...</h3>";

        //Comprobamos si los datos cumplen las condiciones

        for ($i = 0; $i < $numeroImagenes; $i++) {
            $mensaje .= '<strong>ESTADO</strong><br />';
            // Información sobre el archivo subido
            $nombreFichero   =   $_FILES['archivos']['name'][$i];
            $tipoFichero     =   $_FILES['archivos']['type'][$i];
            $tamanioFichero  =   $_FILES['archivos']['size'][$i];
            $temporalFichero =   $_FILES['archivos']['tmp_name'][$i];
            $errorFichero    =   $_FILES['archivos']['error'][$i];

            //COMPROBAR EL TIPO DE ARCHIVO
            if ($tipoFichero != "image/jpeg" && $tipoFichero != "image/png") {
                $mensaje .= "El tipo de archivo de $nombreFichero -[$tipoFichero]- no es válido <br />";
                $errorFicheros = 9;
                $mensaje .= "<br>***Se ha producido el error nº $errorFicheros: <em>" . $codigosErrorSubida[$errorFicheros] . '***</em> <br />';
                //COMPROBAR EL TAMAÑO DE LA IMAGEN
            } else if ($tamanioFichero > TAMANIO_MAXIMO_IMAGEN) {
                $mensaje .= "El tamaño del archivo $nombreFichero -[" . number_format(($tamanioFichero / 1000), 1, ',', '.') . " KB]- es superior a 200Kb <br />";
                $errorFicheros = 10;
                $mensaje .= "<br>***Se ha producido el error nº $errorFicheros: <em>" . $codigosErrorSubida[$errorFicheros] . '***</em> <br />';
                //COMPROBAR EL TAMAÑO TOTAL DE LAS IMAGENES
            } else if ($tamanioTotal > TAMANIO_MAXIMO_TOTAL) {
                $tamanioTotal = $tamanioTotal + number_format(($tamanioFichero / 1000), 0, ',', '.');
                $mensaje .= "El tamaño de los archivos -[$tamanioTotal KB]- es superior a los 300Kb permitidos <br />";
                $errorFicheros = 11;
                $mensaje .= "<br>***Se ha producido el error nº $errorFicheros: <em>" . $codigosErrorSubida[$errorFicheros] . '***</em> <br />';
                //COMPROBAR SI EXISTE YA ES IMAGEN EN LA CARPETA
            } else if (is_file($directorioSubida . "/" . $nombreFichero)) {
                $mensaje .= "El archivo $nombreFichero ya existe en el servidor <br />";
                $errorFicheros = 12;
                $mensaje .= "<br>***Se ha producido el error nº $errorFicheros: <em>" . $codigosErrorSubida[$errorFicheros] . '***</em> <br />';
            } else {
                // SI NO HAY ERRORES, SE SUBE EL ARCHIVO
                $mensaje .= "El archivo $nombreFichero cumple las condiciones<br />";
                if ($errorFicheros > 0) {
                    $mensaje .= "<br>***Se ha producido el error nº $errorFicheros: <em>" . $codigosErrorSubida[$errorFicheros] . '***</em> <br />';
                } else {
                    $mensaje .= '<br><br><strong>Intentando subir el archivo</strong>: ' . ' <br />';
                    $mensaje .= "- Nombre: $nombreFichero" . ' <br />';
                    $mensaje .= '- Tamaño: ' . number_format(($tamanioFichero / 1000), 1, ',', '.') . ' KB <br />';
                    $mensaje .= "- Tipo: $tipoFichero" . ' <br />';
                    $mensaje .= "- Nombre archivo temporal: $temporalFichero" . ' <br />';
                    $mensaje .= "- Código de estado: $errorFichero" . ' <br />';
                    $tamanioTotal = $tamanioTotal + number_format(($tamanioFichero / 1000), 0, ',', '.');


                    $mensaje .= '<br /><strong>RESULTADO</strong><br />';

                    // Obtengo el código de error de la operación, 0 si todo ha ido bien
                    if ($errorFichero > 0) {
                        $mensaje .= "Se ha producido el error nº $errorFichero: <em>" . $codigosErrorSubida[$errorFichero] . '</em> <br />';
                    } else {
                        // subida correcta del temporal
                        // si es un directorio y tengo permisos     
                        if (is_dir($directorioSubida) && is_writable($directorioSubida)) {
                            //Intento mover el archivo temporal al directorio indicado
                            if (move_uploaded_file($temporalFichero,  $directorioSubida . '/' . $nombreFichero) == true) {
                                $mensaje .= 'Archivos guardado en: ' . $directorioSubida . ' correctamente <br /><hr>';
                            } else {
                                $mensaje .= 'ERROR: Archivo no guardado correctamente <br />';
                            }
                        } else {
                            $mensaje .= 'ERROR: No es un directorio correcto o no se tiene permiso de escritura <br />';
                        }
                    }
                }
            }
        }
    }

    ?>

    <body>
        <h2>Bienvenido Usuario
            <h2>
                <?= $mensaje; ?>
                <br />
                <a href="selectmultiple.html">Volver a la página de subida</a>
                </form>
    </body>

</html>