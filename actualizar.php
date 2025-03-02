<?php
$conexion = new mysqli("localhost", "latinbattle", "H8opgZWQrs0dgt7a", "latinbat_peru");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "
    UPDATE gameplayers SET spoofedrealm='LatinBattle.com' WHERE spoofedrealm='156.244.39.172';
    UPDATE gameplayers SET spoofedrealm='Radmin-VPN' WHERE spoofedrealm='';
    UPDATE downloads SET map = REPLACE(map, 'Maps\\\\Download\\\\', '');
    UPDATE games SET map = REPLACE(map, 'Maps\\\\Download\\\\', '');
    UPDATE gameplayers SET spoofedrealm='Rubattle.net' WHERE spoofedrealm='212.42.38.174';
    UPDATE admins SET server='156.244.39.172' WHERE server='LatinBattle.com';
";

if ($conexion->multi_query($sql)) {
    echo "Consultas ejecutadas correctamente";
} else {
    echo "Error: " . $conexion->error;
}

$conexion->close();
?>
