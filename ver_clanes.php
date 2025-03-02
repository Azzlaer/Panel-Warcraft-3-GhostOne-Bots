<?php
include 'config.php'; // Incluir el archivo de configuración de la base de datos

// Consulta para obtener los datos de los clanes
$sql = "SELECT cid, name, motd FROM pvpgn_clan ORDER BY name DESC";
$result = $conn->query($sql);
?>
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
</style>

<div class="container">
    <h1>Lista de Clanes</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre del Clan</th>
                <th>Mensaje del Clan</th>
                <th>Cantidad de Miembros</th>
                <th>Miembros</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cid = $row['cid'];

                // Obtener la cantidad de miembros
                $memberSql = "SELECT COUNT(*) AS member_count FROM pvpgn_clanmember WHERE cid = ?";
                $stmt = $conn->prepare($memberSql);
                $stmt->bind_param('i', $cid);
                $stmt->execute();
                $stmt->bind_result($memberCount);
                $stmt->fetch();
                $stmt->close();

                // Obtener los nombres de los miembros
                $memberNames = [];
                $membersSql = "SELECT uid FROM pvpgn_clanmember WHERE cid = ?";
                $stmt = $conn->prepare($membersSql);
                $stmt->bind_param('i', $cid);
                $stmt->execute();
                $resultMembers = $stmt->get_result();
                while ($memberRow = $resultMembers->fetch_assoc()) {
                    $uid = $memberRow['uid'];
                    $uidSql = "SELECT acct_username FROM pvpgn_bnet WHERE uid = ?";
                    $stmtUid = $conn->prepare($uidSql);
                    $stmtUid->bind_param('i', $uid);
                    $stmtUid->execute();
                    $stmtUid->bind_result($acctUsername);
                    $stmtUid->fetch();
                    $stmtUid->close();
                    $memberNames[] = $acctUsername;
                }
                $stmt->close();
                $members = implode(", ", $memberNames);

                echo "<tr>
                        <td>" . htmlspecialchars($row['name'], ENT_QUOTES) . "</td>
                        <td>" . htmlspecialchars($row['motd'], ENT_QUOTES) . "</td>
                        <td>" . htmlspecialchars($memberCount, ENT_QUOTES) . "</td>
                        <td>" . htmlspecialchars($members, ENT_QUOTES) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='no-results'>No hay resultados</td></tr>";
        }

        // Cerrar conexión
        $conn->close();
        ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>