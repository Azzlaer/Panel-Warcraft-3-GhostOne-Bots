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

<div class="main-container">
    <div class="container">
	<p><img src="https://latinbattle.com/wp-content/uploads/2023/03/aa.png" width="335" height="255"></p>
        <h1>Información del Servidor</h1>
        <div class="info">
            <h2>Nuestro servidor se inauguró el <strong>5 de marzo de 2022</strong>.</h2>
            <p>
                <script>
                    var montharray = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
                    function countup(yr, m, d) {
                        var today = new Date();
                        var pastDate = new Date(yr, m - 1, d);
                        var difference = Math.floor((today - pastDate) / (24 * 60 * 60 * 1000));
                        document.write("El servidor está online hace " + difference + " días.");
                    }
                    countup(2022, 3, 5);
                </script>
            </p>
        </div>
    </div>

    <div class="container">
	<img src="rexxar.png" width="300" height="250">
        <div class="info">
            <?php
            $xml = simplexml_load_file('C:/Games/pvpgnem/var/status/server.xml');
            if ($xml && isset($xml->Uptime)) {
                echo "<p>El servidor a veces se debe reiniciar o apagar por motivos del proveedor,<br>";
                echo "pero hasta el momento está online desde hace:<br>";
                echo "<span class='highlight'>{$xml->Uptime}</span></p>";
            }
            ?>
        </div>
  </div>

    <div class="container">
        <h2>Partidas creadas actualmente</h2>
        <table width="100%" align="center">
            <thead>
                <tr>
                    <th>Nombre del Juego</th>
                    <th>Clienttag</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($xml && isset($xml->Games->game)) {
                foreach ($xml->Games->game as $game) {
                    echo "<tr><td>" . htmlspecialchars($game->name, ENT_QUOTES) . "</td>";
                    echo "<td>" . (isset($game->clienttag) ? htmlspecialchars($game->clienttag, ENT_QUOTES) : "N/A") . "</td></tr>";
                }
            }
            ?>
            </tbody>
      </table>
    </div>

    <div class="container">
        <h2>Usuarios Online</h2>
        <table width="100%">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Versión</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($xml && isset($xml->Users->user)) {
                foreach ($xml->Users->user as $user) {
                    echo "<tr><td>" . htmlspecialchars($user->name, ENT_QUOTES) . "</td>";
                    echo "<td>" . htmlspecialchars($user->version, ENT_QUOTES) . "</td></tr>";
                }
            }
            ?>
            </tbody>
      </table>
    </div>
</div>


<footer>
    &copy; 2024 LatinBattle. Todos los derechos reservados.
</footer>

</body>
</html>
