<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LatinBattle</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            text-align: center;
        }
        .navbar {
            display: flex;
            justify-content: center;
            background: rgba(0, 0, 0, 0.8);
            padding: 15px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .navbar a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 18px;
        }
        .navbar a:hover {
            background-color: #ff9800;
            border-radius: 5px;
        }
        .container {
            margin-top: 80px;
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="https://latinbattle.com">Inicio</a>
		<a href="ver_status.php">Estado</a>
		<a href="add_owner.php">Permiso</a>		
        <a href="directo.php">Subir Mapa</a>
		<a href="ver_listado.php">Listado</a>
        <a href="ver_partidas.php">Partidas</a>
        <a href="ver_clanes.php">Clanes</a>
        <a href="ver_archivos.php">Mapas Cargados</a>
        <a href="buscar_partidas.php">Buscar Partidas</a>
        <a href="https://discord.gg/mvczduBBVP">Discord</a>
    </div>
