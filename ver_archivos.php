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
</style>
<script>
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("filesTable");
        switching = true;
        dir = "asc"; 
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>
<?php include 'header.php'; ?>


<div class="container">
<img src="https://latinbattle.com/wp-content/uploads/2023/03/logo-small.png" alt="Logo">
    <h1>Lista de Archivos Subidos</h1>

    <div class="filter-container">
        <form method="GET" action="">
            <label for="categoria">Filtrar por categoría:</label>
            <select id="categoria" name="categoria" onchange="this.form.submit()">
                <option value="">Todas</option>
                <option value="Otros">Otros</option>
				<option value="Otros">Anime</option>
                <option value="Melee">Melee</option>
                <option value="Heroe Defense">Heroe Defense</option>
                <option value="Hero Arena">Hero Arena</option>
                <option value="Tower Defense (Cooperative)">Tower Defense (Cooperative)</option>
                <option value="Tower Defense (Survivor)">Tower Defense (Survivor)</option>
                <option value="Tower Wars">Tower Wars</option>
                <option value="Role Playing (RPG)">Role Playing (RPG)</option>
                <option value="Minigame-Sports">Minigame-Sports</option>
                <option value="Cinematics">Cinematics</option>
                <option value="Campaigne">Campaigne</option>
                <option value="Castle Defense">Castle Defense</option>
                <option value="Tutorial Jass">Tutorial Jass</option>
                <option value="Tutorial GUI">Tutorial GUI</option>
            </select>
        </form>
    </div>

    <table id="filesTable">
        <thead>
            <tr>
                <th onclick="sortTable(0)">ID</th>
                <th onclick="sortTable(1)">Usuario</th>
                <th onclick="sortTable(2)">Nombre del Archivo</th>
                <th onclick="sortTable(3)">Tamaño (MB)</th>
            </tr>
        </thead>
        <tbody>
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

            // Obtener la categoría seleccionada
            $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

            // Construir la consulta
            if ($categoria && $categoria != '') {
                $sql = "SELECT id, usuario, nombre_archivo, tamano, categoria FROM Maps WHERE categoria = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $categoria);
            } else {
                $sql = "SELECT id, usuario, nombre_archivo, tamano, categoria FROM Maps";
                $stmt = $conn->prepare($sql);
            }

            // Ejecutar la consulta y mostrar los resultados
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td data-label='ID'>" . $row['id'] . "</td>";
                    echo "<td data-label='Usuario'>" . $row['usuario'] . "</td>";
                    echo "<td data-label='Nombre del Archivo'>" . $row['nombre_archivo'] . "</td>";
                    echo "<td data-label='Tamaño (MB)'>" . number_format($row['tamano'] / (1024 * 1024), 2) . "</td>";                    
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay archivos en esta categoría.</td></tr>";
            }

            // Cerrar la conexión a la base de datos
            $stmt->close();
            $conn->close();
            ?>
        </tbody>
    </table>

    <div class="pagination">
        <a href="#">&laquo;</a>
        <a href="#" class="active">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#">&raquo;</a>
    </div>
</div>











<?php include 'footer.php'; ?>