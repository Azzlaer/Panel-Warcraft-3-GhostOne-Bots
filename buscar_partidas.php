<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Partidas</title>
	<?php include 'header.php'; ?>
    <style>
   body {
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.main-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px; /* Espaciado entre los contenedores */
    max-width: 1200px; /* Para que no se expanda demasiado en pantallas grandes */
    width: 100%;
}

.container {
    flex: 1 1 45%; /* Hace que los contenedores ocupen el 45% del ancho */
    max-width: 600px;
    text-align: center;
    padding: 20px;
    border-radius: 10px;
    background: rgba(0, 0, 0, 0.8);
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.5);
}

@media (max-width: 768px) {
    .container {
        flex: 1 1 90%; /* En pantallas más pequeñas, cada contenedor ocupa más espacio */
    }
}


h1 {
    color: #d4af37; /* Dorado inspirado en Valheim */
    margin-bottom: 20px;
    text-shadow: 2px 2px 5px #000;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 0 auto;
}

thead {
    background-color: #333;
    color: #d4af37; /* Dorado */
}

th, td {
    padding: 10px;
    text-align: center;
    border: 1px solid #444;
}

th {
    font-weight: bold;
    cursor: pointer;
    text-transform: uppercase;
}

th a {
    color: inherit;
    text-decoration: none;
}

th a:hover {
    text-decoration: underline;
}

tbody tr:nth-child(even) {
    background-color: #2a2a2a;
}

tbody tr:nth-child(odd) {
    background-color: #1e1e1e;
}

tbody tr:hover {
    background-color: #444;
}

td {
    color: #f2f2f2;
}
</style>
</head>
<body>
<div class="container">
    <img src="https://latinbattle.com/wp-content/uploads/2023/03/logo-small.png" alt="Logo">
    <h1>Información del BOT de PERU</h1>
    <h2>Ingrese el nombre del usuario que desea buscar</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="creatorname">Usuario:</label>
            <p>
              <input type="text" name="creatorname" id="creatorname" required>
            </p>
            <p>&nbsp;                  </p>
      </div>
		<button type="submit">Buscar</button>
		

    </form>
<p><img src="https://conurbanes.org/wp-content/uploads/2020/02/barra-separadora.png" width="514" height="60"></p>
    <?php
    // Conectar a la base de datos MySQL (MariaDB)
    $host = 'localhost';
    $db = 'latinbat_peru';
    $user = 'latinbattle';
    $pass = 'H8opgZWQrs0dgt7a';

    // Crear la conexión
    $conn = new mysqli($host, $user, $pass, $db);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Inicializar variables para el nombre del creador y el estado del baneo
    $creatorname = "";
    $isBanned = "NO"; // Valor predeterminado

    // Manejar la entrada del formulario
    if (isset($_POST['creatorname'])) {
        $creatorname = $_POST['creatorname'];

        // Convertir el nombre a minúsculas
        $creatorname = strtolower($creatorname);

        // Consultar si el nombre está baneado
        $banQuery = "SELECT name FROM bans WHERE LOWER(name) = ?";
        $stmt = $conn->prepare($banQuery);
        $stmt->bind_param('s', $creatorname);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $isBanned = "SI";
        }
        
        // Consultar la base de datos para contar las partidas creadas por el "creatorname"
        $query = "SELECT COUNT(*) AS cantidad FROM games WHERE LOWER(creatorname) = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $creatorname);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $row = $result->fetch_assoc();
        $cantidadPartidas = $row['cantidad'];

        // Consultar la suma total de la duración en minutos
        $sumQuery = "SELECT SUM(duration) AS total_duration FROM games WHERE LOWER(creatorname) = ?";
        $stmt = $conn->prepare($sumQuery);
        $stmt->bind_param('s', $creatorname);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $totalDurationMinutes = $row['total_duration'];

        // Convertir los minutos totales a meses, días, horas y minutos
        $months = floor($totalDurationMinutes / 43200); // 43200 minutos en un mes (asumiendo 30 días por mes)
        $remainingMinutes = $totalDurationMinutes % 43200;
        $days = floor($remainingMinutes / 1440); // 1440 minutos en un día
        $remainingMinutes = $remainingMinutes % 1440;
        $hours = floor($remainingMinutes / 60);
        $minutes = $remainingMinutes % 60;

        // Mostrar el resultado
        echo "<div class='result'>";        
        echo "Cantidad de partidas creadas: $cantidadPartidas<br>";
        echo "Usuario Baneado: $isBanned <br>";
        echo "Cantidad de Horas: $months meses, $days días, $hours horas y $minutes minutos<br>";
        echo "</div>";
        
        // Mostrar la tabla de partidas si no es un administrador
        if ($isBanned == "NO") {
            echo "<h2 align='center'>Partidas Creadas por " . htmlspecialchars($creatorname, ENT_QUOTES) . "</h2>";
            echo "<table>";
            echo "<tr><th>Usuario</th><<th>Mapa</th><th>Duración (minutos)</th><th>Fecha y Hora</th></tr>";

            // Consultar las partidas creadas por el usuario
            $gameQuery = "SELECT gamename, map, duration, datetime FROM games WHERE LOWER(creatorname) = ?";
            $stmt = $conn->prepare($gameQuery);
            $stmt->bind_param('s', $creatorname);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                // Eliminar el texto "Maps/Download/" de la columna "Map"
                $row['map'] = str_replace("Maps/Download/", "", $row['map']);
                
                // Convertir la duración de segundos a minutos
                $row['duration'] = gmdate("i:s", $row['duration']);
                
                echo "<tr>";                
                echo "<td>" . htmlspecialchars($row['gamename'], ENT_QUOTES) . "</td>";
                echo "<td>" . htmlspecialchars($row['map'], ENT_QUOTES) . "</td>";
                echo "<td>" . htmlspecialchars($row['duration'], ENT_QUOTES) . "</td>";
                echo "<td>" . htmlspecialchars($row['datetime'], ENT_QUOTES) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>
    <img src="https://i.imgur.com/RMfAb8W.png" alt="Footer Image" class="footer-img">
</div>

<?php include 'footer.php'; ?>

