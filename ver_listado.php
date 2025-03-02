<!DOCTYPE html>
<html>
<head>
    <title>Agregar Admin a GHost++</title>
    <style>
        .container {
            max-width: 100%;
            width: 50%;
            margin: 50px auto;
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.8);
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.5);
        }
        h1 {
            font-size: 2em;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            display: block;
            font-size: 1.2em;
            color: #fff;
        }
        input, select {
            width: 25%;
            padding: 10px;
            font-size: 1.2em;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            font-size: 1.2em;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #d4af37;
            color: black;
            cursor: pointer;
        }
        button:hover {
            background-color: #b8972e;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>
	<p align="center"><img src="aa.png" width="335" height="255"></p>
<div class="container">
	  <?php
// Asume que esta es la ruta de la carpeta que quieres contar
$dir = 'C:\Games\Warcraft III\Maps\Download';

// Escaneamos la carpeta y obtenemos una lista de todos los archivos y carpetas
$archivos = scandir($dir);

// Contamos la cantidad de archivos en la lista
$cantidad = count($archivos);

print ("TOTAL DE MAPAS CARGADOS: $cantidad.");

?>

  <p align="center"><?php
// Asume que esta es la ruta de la carpeta que quieres listar
$dir = 'C:\Games\Warcraft III\Maps\Download';

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

// Abrimos la carpeta
$dir_handle = opendir($dir);

// Creamos la tabla
echo '<center>';
echo '<table>';
echo '<th width="20%">ARCHIVO</th>';
echo '<th width="15%">TAMAÑO</th>';

// Recorremos todos los archivos de la carpeta
while (($file = readdir($dir_handle)) !== false) {
    // Ignoramos los archivos ocultos (que comienzan con un punto)
    if (substr($file, 0, 1) != '.') {
        // Calculamos la fecha de creación del archivo
        $timestamp = filectime($dir . '/' . $file);
        $fecha = date('d/m/Y', $timestamp);

        // Calculamos el tamaño del archivo
        $tamano = filesize($dir . '/' . $file);
        $tamano_formateado = formatSizeUnits($tamano);

        // Mostramos el nombre del archivo, la fecha de creación y el tamaño en una fila de la tabla
        echo '<tr>';
        echo '<td style="text-align: center;">' . $file . '</td>';
        echo '<td style="text-align: center;">' . $tamano_formateado . '</td>';
        echo '</tr>';
    }
}

// Cerramos la tabla y la carpeta
echo '</table>';
echo '</center>';
closedir($dir_handle);
?></div>	

<?php include 'footer.php'; ?>
</body>
</html>