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
        <h1>Estadísticas de Partidas</h1>
        <div class="stats">
            <?php
            // Conectar a la base de datos MariaDB
            $mysqli = new mysqli('127.0.0.1', 'latinbattle', 'H8opgZWQrs0dgt7a', 'latinbat_peru');

            // Verificar la conexión
            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }

            // Consulta SQL para contar los registros en la columna "spoofedrealm" de la tabla "gameplayers"
            $queries = [
                "LatinBattle.com" => "SELECT COUNT(*) as total FROM gameplayers WHERE spoofedrealm = 'LatinBattle.com'",
                "Rubattle.net" => "SELECT COUNT(*) as total FROM gameplayers WHERE spoofedrealm = 'rubattle.net'",
                "Radmin-VPN" => "SELECT COUNT(*) as total FROM gameplayers WHERE spoofedrealm = 'Radmin-VPN'",
                "Total de Partidas" => "SELECT COUNT(*) as total FROM games"
            ];

            foreach ($queries as $description => $query) {
                $result = $mysqli->query($query);
                if ($result) {
                    $row = $result->fetch_assoc();
                    echo "<p>$description: " . $row['total'] . "</p>";
                } else {
                    echo "<p>Error al ejecutar la consulta para $description.</p>";
                }
            }
            ?>
        </div>

        <!-- Formulario del combobox -->
        <form method="POST" action="">
            <select name="consulta">
                <?php
                // Consultas disponibles y sus respectivas consultas SQL
                $consultas = [
                    'Ver Últimas 5 Partidas creadas' => "SELECT creatorname, gamename, map  FROM games WHERE creatorname NOT IN ('w3latino','acc.d2rbot','d2tbot', 'd2zbot', 'ssjuegos','d2pbot','d2obot','d2dota','d2gbot','d2xbot','d2qbot','d2wbot','d2npbot','d2fbot','d2zbot','d2hbot','d2mbot','d2cbot','saintseiya','saintseiya2','d2ubot','d2rbot','d2bbot','d2ibot','acc.d2nbot','acc.d2qbot','dota4ever') ORDER BY datetime DESC LIMIT 5",
                    'Ver Últimas 10 Partidas creadas' => "SELECT creatorname, gamename, map FROM games WHERE creatorname NOT IN ('w3latino','acc.d2rbot','d2tbot', 'd2zbot', 'ssjuegos','d2pbot','d2obot','d2dota','d2gbot','d2xbot','d2qbot','d2wbot','d2npbot','d2fbot','d2zbot','d2hbot','d2mbot','d2cbot','saintseiya','saintseiya2','d2ubot','d2rbot','d2bbot','d2ibot','acc.d2nbot','acc.d2qbot','dota4ever') ORDER BY datetime DESC LIMIT 10",
                    'Ver Últimas 50 Partidas creadas' => "SELECT creatorname, gamename, map FROM games WHERE creatorname NOT IN ('w3latino','acc.d2rbot','d2tbot', 'd2zbot', 'ssjuegos','d2pbot','d2obot','d2dota','d2gbot','d2xbot','d2qbot','d2wbot','d2npbot','d2fbot','d2zbot','d2hbot','d2mbot','d2cbot','saintseiya','saintseiya2','d2ubot','d2rbot','d2bbot','d2ibot','acc.d2nbot','acc.d2qbot','dota4ever') ORDER BY datetime DESC LIMIT 50",
                    'Ver Todas las Partidas creadas' => "SELECT creatorname, gamename, map FROM games WHERE creatorname NOT IN ('w3latino','acc.d2rbot','d2tbot', 'd2zbot', 'ssjuegos','d2pbot','d2obot','d2dota','d2gbot','d2xbot','d2qbot','d2wbot','d2npbot','d2fbot','d2zbot','d2hbot','d2mbot','d2cbot','saintseiya','saintseiya2','d2ubot','d2rbot','d2bbot','d2ibot','acc.d2nbot','acc.d2qbot','dota4ever') ORDER BY datetime DESC",
                    'Ver Partidas de bots' => "SELECT creatorname, gamename, map FROM games WHERE creatorname IN ('w3latino','acc.d2rbot','d2tbot','d2zbot','ssjuegos','d2pbot','d2obot','d2dota','d2gbot','d2xbot','d2qbot','d2wbot','d2npbot','d2fbot','d2zbot','d2hbot','d2mbot','saintseiya','d2cbot','d2nbot','d2ubot','d2rbot','d2bbot','ssjuegos','d2ibot') ORDER BY datetime DESC",   
                    'Ver Partidas DotA' => 'SELECT gameid, winner, min, sec FROM dotagames ORDER BY id DESC',
                    'Ver Últimas 5 Partidas DotA' => 'SELECT gameid,colour,kills,deaths,assists,gold FROM dotaplayers ORDER BY id DESC LIMIT 5',
                    'Ver Últimas 10 Partidas DotA' => 'SELECT gameid,colour,kills,deaths,assists,gold FROM dotaplayers ORDER BY id DESC LIMIT 10',
                    'Ver Últimas 50 Partidas DotA' => 'SELECT gameid,colour,kills,deaths,assists,gold FROM dotaplayers ORDER BY id DESC LIMIT 50',
                    'Ver Todas las Partidas DotA' => 'SELECT gameid,colour,kills,deaths,assists,gold FROM dotaplayers ORDER BY id DESC',
                    'Ver Baneados' => 'SELECT name, server, date, expiredate, reason, gamename FROM bans ORDER BY date DESC',    
                    'Ver Historial' => 'SELECT name, team, colour, leftreason, spoofedrealm FROM gameplayers ORDER BY id DESC LIMIT 30',
                    'Ver Usuarios con permisos' => 'SELECT name FROM admins ORDER BY name ASC',
                    'Ver Descargados' => 'SELECT spoofedrealm, name, map FROM downloads ORDER BY datetime DESC LIMIT 30',
                    'Estadísticas W3 Arena' => 'SELECT name, SUM(CASE WHEN pid = 1 THEN 1 ELSE 0 END) AS WIN,  SUM(CASE WHEN pid = 0 THEN 1 ELSE 0 END) AS LOSE,  AVG(CASE WHEN pid = 1 THEN 1 ELSE 0 END) * 100 AS RATE,  1000+SUM(CASE WHEN pid = 1 THEN 25 ELSE -25 END) AS MMR  FROM w3mmdplayers GROUP BY name ORDER BY MMR DESC',
                ];

                $opcionSeleccionada = isset($_POST['consulta']) ? $_POST['consulta'] : array_key_first($consultas);
                $query = $consultas[$opcionSeleccionada];

                foreach ($consultas as $opcion => $consulta) {
                    echo "<option value='$opcion'" . ($opcion == $opcionSeleccionada ? " selected" : "") . ">$opcion</option>";
                }
	// Reemplazar "hero" con la imagen en caso de ser "Npbm"
						if ($row['hero'] === 'Npbm') {
            $row['hero'] = "<img src='https://i.imgur.com/DiwAwfQ.gif' alt='Npbm' width='50' height='50'>";
        }
						if ($row['hero'] === 'H00R') {
            $row['hero'] = "<img src='https://i.imgur.com/eQb6oFV.gif' alt='H00R' width='50' height='50'>";
        }
						if ($row['hero'] === 'H00U') {
            $row['hero'] = "<img src='https://i.imgur.com/JZrCNYi.gif' alt='H00U' width='50' height='50'>";
        }
						if ($row['hero'] === 'H00I') {
            $row['hero'] = "<img src='https://i.imgur.com/NIbjeo3.gif' alt='00I' width='50' height='50'>";
        }
						if ($row['hero'] === 'E01A') {
            $row['hero'] = "<img src='https://i.imgur.com/yqlq1oK.gif' alt='E01A' width='50' height='50'>";
        }
        if ($row['hero'] === 'UC60') {
            $row['hero'] = "<img src='https://i.imgur.com/xK1DC03.gif' alt='UC60' width='50' height='50'>";
        }		
						if ($row['hero'] === 'U008') {
            $row['hero'] = "<img src='https://i.imgur.com/qsOolGh.gif' alt='U008' width='50' height='50'>";
        }
						if ($row['hero'] === 'E002') {
            $row['hero'] = "<img src='https://i.imgur.com/paGq7pd.gif' alt='E002' width='50' height='50'>";
        }
						if ($row['hero'] === 'HC49') {
            $row['hero'] = "<img src='https://i.imgur.com/QHKww0b.gif' alt='C49' width='50' height='50'>";
        }
						if ($row['hero'] === 'Emoo') {
            $row['hero'] = "<img src='https://i.imgur.com/ENTRCDj.gif' alt='Emoo' width='50' height='50'>";
        }
						if ($row['hero'] === 'Ucrl') {
            $row['hero'] = "<img src='https://i.imgur.com/6Ej3v7O.gif' alt='Ucrl' width='50' height='50'>";
        }
						if ($row['hero'] === 'Ekee') {
            $row['hero'] = "<img src='https://i.imgur.com/kKRJsmp.gif' alt='Ekee' width='50' height='50'>";
        }			
						if ($row['hero'] === 'U00K') {
            $row['hero'] = "<img src='https://i.imgur.com/5yzyodc.gif' alt='U00K' width='50' height='50'>";
        }	
						if ($row['hero'] === 'Nbbc') {
            $row['hero'] = "<img src='https://i.imgur.com/V8TpG1z.gif' alt='Nbbc' width='50' height='50'>";
        }	
						if ($row['hero'] === 'Hmbr') {
            $row['hero'] = "<img src='https://i.imgur.com/0iVNW8u.gif' alt='Hmbr' width='50' height='50'>";
        }
						if ($row['hero'] === 'Harf') {
            $row['hero'] = "<img src='https://i.imgur.com/EYJzjsS.gif' alt='Harf' width='50' height='50'>";
        }		
						if ($row['hero'] === 'Ogrh') {
            $row['hero'] = "<img src='https://i.imgur.com/C0RTGW2.gif' alt='Ogrh' width='50' height='50'>";
        }
						if ($row['hero'] === 'UC11') {
            $row['hero'] = "<img src='https://i.imgur.com/SR4iZnd.gif' alt='UC11' width='50' height='50'>";
        }
						if ($row['hero'] === 'N016') {
            $row['hero'] = "<img src='https://i.imgur.com/Pg7OX5z.gif' alt='N016' width='50' height='50'>";
        }
						if ($row['hero'] === 'E01B') {
            $row['hero'] = "<img src='https://i.imgur.com/aRXzowD.gif' alt='E01B' width='50' height='50'>";
        }		
						if ($row['hero'] === 'Opgh') {
            $row['hero'] = "<img src='https://i.imgur.com/wbLI1HT.gif' alt='Opgh' width='50' height='50'>";
        }
						if ($row['hero'] === 'EC45') {
            $row['hero'] = "<img src='https://i.imgur.com/ZUIbAxf.gif' alt='EC45' width='50' height='50'>";
        }
						if ($row['hero'] === '') {
            $row['hero'] = "<img src='https://i.imgur.com/PEbdXIb.gif' alt='' width='50' height='50'>";
        }
						if ($row['hero'] === 'Hvsh') {
            $row['hero'] = "<img src='https://i.imgur.com/9UtXwvn.gif' alt='Hvsh' width='50' height='50'>";
        }
						if ($row['hero'] === 'O00J') {
            $row['hero'] = "<img src='https://i.imgur.com/dvgxdEK.gif' alt='O00J' width='50' height='50'>";
        }	
						if ($row['hero'] === 'H004') {
            $row['hero'] = "<img src='https://i.imgur.com/m9od9iL.gif' alt='H004' width='50' height='50'>";
        }			
						if ($row['hero'] === 'Ewar') {
            $row['hero'] = "<img src='https://i.imgur.com/Ed02mAR.gif' alt='Ewar' width='50' height='50'>";
        }
						if ($row['hero'] === 'UC91') {
            $row['hero'] = "<img src='https://i.imgur.com/EJWtbC6.gif' alt='UC91' width='50' height='50'>";
        }
						if ($row['hero'] === 'H00D') {
            $row['hero'] = "<img src='https://i.imgur.com/GEnw5h7.gif' alt='H00D' width='50' height='50'>";
        }
						if ($row['hero'] === 'N01I') {
            $row['hero'] = "<img src='https://i.imgur.com/65O0M8a.gif' alt='N01I' width='50' height='50'>";
        }
						if ($row['hero'] === 'Nfir') {
            $row['hero'] = "<img src='https://i.imgur.com/glDdzCl.gif' alt='Nfir' width='50' height='50'>";
        }
						if ($row['hero'] === 'Usyl') {
            $row['hero'] = "<img src='https://i.imgur.com/18ry6pf.gif' alt='Usyl' width='50' height='50'>";
        }
						if ($row['hero'] === 'Nbrn') {
            $row['hero'] = "<img src='https://i.imgur.com/wTpQuw9.gif' alt='Nbrn' width='50' height='50'>";
        }
						if ($row['hero'] === 'E01C') {
            $row['hero'] = "<img src='https://i.imgur.com/8AA5KE7.gif' alt='E01C' width='50' height='50'>";
        }
						if ($row['hero'] === 'Udea') {
            $row['hero'] = "<img src='https://i.imgur.com/awVQ4gW.gif' alt='Udea' width='50' height='50'>";
        }
						if ($row['hero'] === 'Edem') {
            $row['hero'] = "<img src='https://i.imgur.com/9lnDrrs.gif' alt='Edem' width='50' height='50'>";
        }
						if ($row['hero'] === 'Oshd') {
            $row['hero'] = "<img src='https://i.imgur.com/UnhDqbp.gif' alt='Oshd' width='50' height='50'>";        }

						if ($row['hero'] === 'Huth') {
            $row['hero'] = "<img src='https://i.imgur.com/9lnDrrs.gif' alt='Huth' width='50' height='50'>";
        }
						if ($row['hero'] === 'Huth') {
            $row['hero'] = "<img src='https://i.imgur.com/9lnDrrs.gif' alt='Huth' width='50' height='50'>";
        }
						if ($row['hero'] === 'UC76') {
            $row['hero'] = "<img src='https://i.imgur.com/zn7VFBL.gif' alt='UC76' width='50' height='50'>";
        }
						if ($row['hero'] === 'Hmkg') {
            $row['hero'] = "<img src='https://i.imgur.com/bLChjNY.gif' alt='Hmkg' width='50' height='50'>";
        }
						if ($row['hero'] === 'H00A') {
            $row['hero'] = "<img src='https://i.imgur.com/AayruKf.gif' alt='H00A' width='50' height='50'>";
        }
						if ($row['hero'] === 'H001') {
            $row['hero'] = "<img src='https://i.imgur.com/G5F1fTP.gif' alt='H001' width='50' height='50'>";
        }
						if ($row['hero'] === 'Orkn') {
            $row['hero'] = "<img src='https://i.imgur.com/q6i4STJ.gif' alt='Orkn' width='50' height='50'>";
        }
						if ($row['hero'] === 'H008') {
            $row['hero'] = "<img src='https://i.imgur.com/WGscnlh.gif' alt='H008' width='50' height='50'>";
        }
						if ($row['hero'] === 'Hlgr') {
            $row['hero'] = "<img src='https://i.imgur.com/WEqrtS0.gif' alt='Hlgr' width='50' height='50'>";
        }
						if ($row['hero'] === 'H00H') {
            $row['hero'] = "<img src='https://i.imgur.com/Q7TrKSn.gif' alt='H00H' width='50' height='50'>";
        }
						if ($row['hero'] === 'U00E') {
            $row['hero'] = "<img src='https://i.imgur.com/zpBraVM.gif' alt='U00E' width='50' height='50'>";
        }
						if ($row['hero'] === 'Eevi') {
            $row['hero'] = "<img src='https://i.imgur.com/g7rW8Ws.gif' alt='Eevi' width='50' height='50'>";
        }
						if ($row['hero'] === 'H00K') {
            $row['hero'] = "<img src='https://i.imgur.com/bTRwO3n.gif' alt='H00K' width='50' height='50'>";
        }
						if ($row['hero'] === 'Otch') {
            $row['hero'] = "<img src='https://i.imgur.com/dyfwxhS.gif' alt='Otch' width='50' height='50'>";
        }
						if ($row['hero'] === 'U00F') {
            $row['hero'] = "<img src='https://i.imgur.com/oMNqqiT.gif' alt='U00F' width='50' height='50'>";
        }
						if ($row['hero'] === 'E00P') {
            $row['hero'] = "<img src='https://i.imgur.com/GMVPDqf.gif' alt='E00P' width='50' height='50'>";
        }
						if ($row['hero'] === 'EC57') {
            $row['hero'] = "<img src='https://i.imgur.com/aZsZBh7.gif' alt='EC57' width='50' height='50'>";
        }
						if ($row['hero'] === 'UC42') {
            $row['hero'] = "<img src='https://i.imgur.com/uyBtQ1A.gif' alt='UC42' width='50' height='50'>";
        }
						if ($row['hero'] === 'H00V') {
            $row['hero'] = "<img src='https://i.imgur.com/HuSK5zY.gif' alt='H00V' width='50' height='50'>";
        }
						if ($row['hero'] === 'UC01') {
            $row['hero'] = "<img src='https://i.imgur.com/UBbathd.gif' alt='UC01' width='50' height='50'>";
        }
						if ($row['hero'] === 'U00A') {
            $row['hero'] = "<img src='https://i.imgur.com/jAK7iXS.gif' alt='U00A' width='50' height='50'>";
        }
						if ($row['hero'] === 'Udre') {
            $row['hero'] = "<img src='https://i.imgur.com/0dfNHCx.gif' alt='Udre' width='50' height='50'>";
        }
						if ($row['hero'] === 'Naka') {
            $row['hero'] = "<img src='https://i.imgur.com/HX6zyGp.gif' alt='Naka' width='50' height='50'>";
        }
						if ($row['hero'] === 'H06S') {
            $row['hero'] = "<img src='https://i.imgur.com/D61xTHk.gif' alt='H06S' width='50' height='50'>";
        }
						if ($row['hero'] === 'N0HP') {
            $row['hero'] = "<img src='https://i.imgur.com/oBPJZ5s.gif' alt='N0HP' width='50' height='50'>";
        }
						if ($row['hero'] === 'H071') {
            $row['hero'] = "<img src='https://i.imgur.com/3ymE2fT.gif' alt='H071' width='50' height='50'>";        }

						if ($row['hero'] === 'U00C') {
            $row['hero'] = "<img src='https://i.imgur.com/YjgLwME.gif' alt='U00C' width='50' height='50'>";
        }
						if ($row['hero'] === 'H00S') {
            $row['hero'] = "<img src='https://i.imgur.com/ormkT4v.gif' alt='H00S' width='50' height='50'>";
        }
						if ($row['hero'] === 'E01Y') {
            $row['hero'] = "<img src='https://i.imgur.com/EwtHZTi.gif' alt='E01Y' width='50' height='50'>";
        }		
						if ($row['hero'] === 'N0MU') {
            $row['hero'] = "<img src='https://i.imgur.com/4LyD6cn.gif' alt='N0MU' width='50' height='50'>";
        }
						if ($row['hero'] === 'O015') {
            $row['hero'] = "<img src='https://i.imgur.com/D9c96kz.gif' alt='O015' width='50' height='50'>";
        }
						if ($row['hero'] === 'E02N') {
            $row['hero'] = "<img src='https://i.imgur.com/WV6WHVx.gif' alt='E02N' width='50' height='50'>";
        }
						if ($row['hero'] === 'E02F') {
            $row['hero'] = "<img src='https://i.imgur.com/KkFmsDH.gif' alt='E02F' width='50' height='50'>";
        }
						if ($row['hero'] === 'E02I') {
            $row['hero'] = "<img src='https://i.imgur.com/DYrIXSN.gif' alt='E02I' width='50' height='50'>";        }		

						if ($row['hero'] === 'H00Q') {
            $row['hero'] = "<img src='https://i.imgur.com/WsKQPKw.gif' alt='H00Q' width='50' height='50'>";        }
		
						if ($row['hero'] === 'HC92') {
            $row['hero'] = "<img src='https://i.imgur.com/6HR1yx3.gif' alt='HC92' width='50' height='50'>";
        }
						if ($row['hero'] === 'N0EG') {
            $row['hero'] = "<img src='https://i.imgur.com/VzGmWoE.gif' alt='N0EG' width='50' height='50'>";
        }
						if ($row['hero'] === 'N01A') {
            $row['hero'] = "<img src='https://i.imgur.com/ClqSo9v.gif' alt='N01A' width='50' height='50'>";
        }
						if ($row['hero'] === 'U006') {
            $row['hero'] = "<img src='https://i.imgur.com/oJZ3tmP.gif' alt='U006' width='50' height='50'>";
        }
						if ($row['hero'] === 'E02X') {
            $row['hero'] = "<img src='https://i.imgur.com/d8mm1Cn.gif' alt='E02X' width='50' height='50'>";
        }	
						if ($row['hero'] === 'Ntin') {
            $row['hero'] = "<img src='https://i.imgur.com/bTRwO3n.gif' alt='Ntin' width='50' height='50'>";
        }		
						if ($row['hero'] === 'Ubal') {
            $row['hero'] = "<img src='https://i.imgur.com/G58yR1o.gif' alt='Ubal' width='50' height='50'>";
        }
						if ($row['hero'] === 'U00P') {
            $row['hero'] = "<img src='https://i.imgur.com/wmCctJR.gif' alt='U00P' width='50' height='50'>";
        }	
						if ($row['hero'] === 'E005') {
            $row['hero'] = "<img src='https://i.imgur.com/XqMrJDN.gif' alt='E005' width='50' height='50'>";
        }
						if ($row['hero'] === 'U000') {
            $row['hero'] = "<img src='https://i.imgur.com/grq4ZJP.gif' alt='U000' width='50' height='50'>";
        }
						if ($row['hero'] === 'N0M7') {
            $row['hero'] = "<img src='https://i.imgur.com/sghebDg.gif' alt='N0M7' width='50' height='50'>";
        }
						if ($row['hero'] === 'E032') {
            $row['hero'] = "<img src='https://i.imgur.com/Sfwcbuo.gif' alt='E032' width='50' height='50'>";
        }
						if ($row['hero'] === 'E02K') {
            $row['hero'] = "<img src='https://i.imgur.com/UiGtHVs.gif' alt='E02K' width='50' height='50'>";
        }		
						if ($row['hero'] === 'H07I') {
            $row['hero'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='H07I' width='50' height='50'>";
        }		
						if ($row['hero'] === 'H06W') {
            $row['hero'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='H06W' width='50' height='50'>";
        }		
						if ($row['hero'] === 'N02B') {
            $row['hero'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='N02B' width='50' height='50'>";
        }			
						if ($row['hero'] === 'H708') {
            $row['hero'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='H708' width='50' height='50'>";
        }		
						if ($row['hero'] === 'H733') {
            $row['hero'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='H733' width='50' height='50'>";
        }		
						if ($row['hero'] === 'Emns') {
            $row['hero'] = "<img src='https://i.imgur.com/GcOYwnS.gif' alt='Emns' width='50' height='50'>";
        }		
						if ($row['hero'] === 'N00R') {
            $row['hero'] = "<img src='https://i.imgur.com/kwu056T.gif' alt='N00R' width='50' height='50'>";
        }		
						if ($row['hero'] === 'E02J') {
            $row['hero'] = "<img src='https://i.imgur.com/og246wp.gif' alt='E02J' width='50' height='50'>";
        }	
						if ($row['hero'] === 'N01O') {
            $row['hero'] = "<img src='https://i.imgur.com/Vmd7XC8.gif' alt='N01O' width='50' height='50'>";
        }
						if ($row['hero'] === 'H08B') {
            $row['hero'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='H08B' width='50' height='50'>";
        }
						if ($row['hero'] === 'NC00') {
            $row['hero'] = "<img src='https://i.imgur.com/a31GUjF.gif' alt='NC00' width='50' height='50'>";
        }
						if ($row['hero'] === 'E02U') {
            $row['hero'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='E02U' width='50' height='50'>";
        }
						if ($row['hero'] === 'UC18') {
            $row['hero'] = "<img src='https://i.imgur.com/H99e1AC.gif' alt='UC18' width='50' height='50'>";
        }
						if ($row['hero'] === 'H00N') {
            $row['hero'] = "<img src='https://i.imgur.com/HX6zyGp.gif' alt='H00N' width='50' height='50'>";
        }
						if ($row['hero'] === 'Ulic') {
            $row['hero'] = "<img src='https://i.imgur.com/T8dMTff.gif' alt='Ulic' width='50' height='50'>";
        }
						if ($row['hero'] === 'N00B') {
            $row['hero'] = "<img src='https://i.imgur.com/09Zp79t.gif' alt='N00B' width='50' height='50'>";
        }
						if ($row['hero'] === 'EC77') {
            $row['hero'] = "<img src='https://i.imgur.com/5CraEfk.gif' alt='EC77' width='50' height='50'>";
        }		
						if ($row['hero'] === 'Hvwd') {
            $row['hero'] = "<img src='https://i.imgur.com/XqMrJDN.gif' alt='Hvwd' width='50' height='50'>";
        }			
		
		
	
//HEROES QUE NO TIENEN IMAGEN Y QUE HAY QUE BUSCAR QUIENES SON
						if ($row['hero'] === 'N015') {
            $row['hero'] = "<img src='https://i.imgur.com/uu1UVM6.png' alt='N015' width='50' height='50'>";
        }
						if ($row['hero'] === 'H500') {
            $row['hero'] = "<img src='https://i.imgur.com/uu1UVM6.png' alt='H500' width='50' height='50'>";
        }

	

// Reemplazar "Item1" con la imagen






        if ($row['item1'] === 'I0NR') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0NR' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0HI') {
            $row['item1'] = "<img src='https://i.imgur.com/kLhg0hv.gif' alt='I0HI' width='50' height='50'>";
        }
        if ($row['item1'] === 'I06B') {
            $row['item1'] = "<img src='https://i.imgur.com/fhZKKvs.gif' alt='I06B' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0BE') {
            $row['item1'] = "<img src='https://i.imgur.com/mVmYms9.gif' alt='I0BE' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0IM') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0IM' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0FY') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0FY' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0IP') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0IP' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0NX') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0NX' width='50' height='50'>";
        }
        if ($row['item1'] === 'I06V') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I06V' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0ME') {
            $row['item1'] = "<img src='https://i.imgur.com/xTd6S2K.gif' alt='I0ME' width='50' height='50'>";
        }
        if ($row['item1'] === 'I04E') {
            $row['item1'] = "<img src='https://i.imgur.com/xTd6S2K.gif' alt='I04E' width='50' height='50'>";
        }
        if ($row['item1'] === 'I045') {
            $row['item1'] = "<img src='https://i.imgur.com/MJ5ec2U.gif' alt='I045' width='50' height='50'>";
        }	
        if ($row['item1'] === 'I0KH') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0KH' width='50' height='50'>";
        }
        if ($row['item1'] === 'I09P') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I09P' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0OV') {
            $row['item1'] = "<img src='https://i.imgur.com/ig69ypo.gif' alt='I0OV' width='50' height='50'>";
        }
        if ($row['item1'] === 'I09T') {
            $row['item1'] = "<img src='https://i.imgur.com/fAjjoGj.gif' alt='I09T' width='50' height='50'>";
        }
        if ($row['item1'] === 'I00P') {
            $row['item1'] = "<img src='https://i.imgur.com/Vg4LgNW.gif' alt='I00P' width='50' height='50'>";
        }
        if ($row['item1'] === 'I05W') {
            $row['item1'] = "<img src='https://i.imgur.com/Vg4LgNW.gif' alt='I05W' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0KY') {
            $row['item1'] = "<img src='https://i.imgur.com/Vg4LgNW.gif' alt='I0KY' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0L5') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0L5' width='50' height='50'>";
        }
        if ($row['item1'] === 'I08Z') {
            $row['item1'] = "<img src='https://i.imgur.com/1yzcHME.gif' alt='I08Z' width='50' height='50'>";
        }		
        if ($row['item1'] === 'I0MU') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0MU' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0HP') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0HP' width='50' height='50'>";
        }
        if ($row['item1'] === 'I05Z') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05Z' width='50' height='50'>";
        }
        if ($row['item1'] === '') {
            $row['item1'] = "<img src='https://i.imgur.com/TxmuHuc.gif' alt='' width='50' height='50'>";
        }
        if ($row['item1'] === 'I047') {
            $row['item1'] = "<img src='https://i.imgur.com/Xdj53uF.gif' alt='I047' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0GJ') {
            $row['item1'] = "<img src='https://i.imgur.com/DtE7ccv.gif' alt='I0GJ' width='50' height='50'>";
        }
        if ($row['item1'] === 'I04S') {
            $row['item1'] = "<img src='https://i.imgur.com/dbLQsZw.gif' alt='I04S' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0HB') {
            $row['item1'] = "<img src='https://i.imgur.com/yg5xQxO.gif' alt='I0HB' width='50' height='50'>";
        }		
        if ($row['item1'] === 'I012') {
            $row['item1'] = "<img src='https://i.imgur.com/u896GVA.gif' alt='I012' width='50' height='50'>";
        }
        if ($row['item1'] === 'I02O') {
            $row['item1'] = "<img src='https://i.imgur.com/cjLEIkH.gif' alt='I02O' width='50' height='50'>";
        }
        if ($row['item1'] === 'I051') {
            $row['item1'] = "<img src='https://i.imgur.com/TUo49xk.gif' alt='I051' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0LL') {
            $row['item1'] = "<img src='https://i.imgur.com/3peiMR1.gif' alt='I0LL' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0MI') {
            $row['item1'] = "<img src='https://i.imgur.com/m29IjCH.gif' alt='I0MI' width='50' height='50'>";
        }
        if ($row['item1'] === 'I02T') {
            $row['item1'] = "<img src='https://i.imgur.com/4BvIZL6.gif' alt='I02T' width='50' height='50'>";
        }		
        if ($row['item1'] === 'I04H') {
            $row['item1'] = "<img src='https://i.imgur.com/cbq6iQ6.gif' alt='I04H' width='50' height='50'>";
        }
        if ($row['item1'] === 'I06J') {
            $row['item1'] = "<img src='https://i.imgur.com/WOiVNCK.gif' alt='I06J' width='50' height='50'>";
        }
        if ($row['item1'] === 'I06L') {
            $row['item1'] = "<img src='https://i.imgur.com/EJKe0Lw.gif' alt='I06L' width='50' height='50'>";
        }
        if ($row['item1'] === 'I06H') {
            $row['item1'] = "<img src='https://i.imgur.com/OqgjzgS.gif' alt='I06H' width='50' height='50'>";
        }
        if ($row['item1'] === 'I08O') {
            $row['item1'] = "<img src='https://i.imgur.com/cquIgN9.gif' alt='I08O' width='50' height='50'>";
        }
        if ($row['item1'] === 'I095') {
            $row['item1'] = "<img src='https://i.imgur.com/mJ7w6HT.gif' alt='I095' width='50' height='50'>";
        }
        if ($row['item1'] === 'I08K') {
            $row['item1'] = "<img src='https://i.imgur.com/Xg66kfK.gif' alt='I08K' width='50' height='50'>";
        }
        if ($row['item1'] === 'I09C') {
            $row['item1'] = "<img src='https://i.imgur.com/IF2yHhM.gif' alt='I09C' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0BG') {
            $row['item1'] = "<img src='https://i.imgur.com/8VCntOL.gif' alt='I0BG' width='50' height='50'>";
        }
        if ($row['item1'] === 'I05I') {
            $row['item1'] = "<img src='https://i.imgur.com/cRPRT6T.gif' alt='I05I' width='50' height='50'>";
        }
        if ($row['item1'] === 'I09F') {
            $row['item1'] = "<img src='https://i.imgur.com/gSBicQJ.gif' alt='I09F' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0A8') {
            $row['item1'] = "<img src='https://i.imgur.com/mSymIIP.gif' alt='I0A8' width='50' height='50'>";
        }		
        if ($row['item1'] === 'I04C') {
            $row['item1'] = "<img src='https://i.imgur.com/S0yXyvj.gif' alt='I04C' width='50' height='50'>";
        }
        if ($row['item1'] === 'I08Y') {
            $row['item1'] = "<img src='https://i.imgur.com/X8tCk0U.gif' alt='I08Y' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0K6') {
            $row['item1'] = "<img src='https://i.imgur.com/inYvfAY.gif' alt='I0K6' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0BA') {
            $row['item1'] = "<img src='https://i.imgur.com/Zg4OQtH.gif' alt='I0BA' width='50' height='50'>";
        }
        if ($row['item1'] === 'I00Z') {
            $row['item1'] = "<img src='https://i.imgur.com/pFeRqMa.gif' alt='I00Z' width='50' height='50'>";
        }
        if ($row['item1'] === 'I08T') {
            $row['item1'] = "<img src='https://i.imgur.com/pzRYTc0.gif' alt='I08T' width='50' height='50'>";
        }
        if ($row['item1'] === 'I09H') {
            $row['item1'] = "<img src='https://i.imgur.com/qJlVXha.gif' alt='I09H' width='50' height='50'>";
        }
        if ($row['item1'] === 'I08P') {
            $row['item1'] = "<img src='https://i.imgur.com/cvJQUAd.gif' alt='I08P' width='50' height='50'>";
        }	
        if ($row['item1'] === 'I09L') {
            $row['item1'] = "<img src='https://i.imgur.com/6MHCN2o.gif' alt='I09L' width='50' height='50'>";
        }	
        if ($row['item1'] === 'I0BJ') {
            $row['item1'] = "<img src='https://i.imgur.com/JYgADbN.gif' alt='I0BJ' width='50' height='50'>";
        }
        if ($row['item1'] === 'I08H') {
            $row['item1'] = "<img src='https://i.imgur.com/WmLyGwu.gif' alt='I08H' width='50' height='50'>";
        }		
        if ($row['item1'] === 'I093') {
            $row['item1'] = "<img src='https://i.imgur.com/1oM5Abl.gif' alt='I093' width='50' height='50'>";
        }
        if ($row['item1'] === 'I044') {
            $row['item1'] = "<img src='https://i.imgur.com/APEwKRQ.gif' alt='I044' width='50' height='50'>";
        }
        if ($row['item1'] === 'I067') {
            $row['item1'] = "<img src='https://i.imgur.com/iepxoMH.gif' alt='I067' width='50' height='50'>";
        }		
        if ($row['item1'] === 'I0HJ') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0HJ' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0HJ') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0HJ' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0FS') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0FS' width='50' height='50'>";
        }
        if ($row['item1'] === 'I04I') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04I' width='50' height='50'>";
        }
	    if ($row['item1'] === 'I0AP') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0AP' width='50' height='50'>";
        }
        if ($row['item1'] === 'I05Y') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05Y' width='50' height='50'>";
        }
        if ($row['item1'] === 'I04K') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04K' width='50' height='50'>";
        }
        if ($row['item1'] === 'I08G') {
            $row['item1'] = "<img src='https://i.imgur.com/1rXq4IZ.gif' alt='I08G' width='50' height='50'>";
        }
        if ($row['item1'] === 'I05V') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05V' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0GH') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0GH' width='50' height='50'>";
        }	
        if ($row['item1'] === 'I05G') {
            $row['item1'] = "<img src='https://i.imgur.com/ZDVRLKo.gif' alt='I05G' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0OG') {
            $row['item1'] = "<img src='https://i.imgur.com/h15W7Um.gif' alt='I0OG' width='50' height='50'>";
        }	
        if ($row['item1'] === 'I049') {
            $row['item1'] = "<img src='https://i.imgur.com/8OhLX71.gif' alt='I049' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0BK') {
            $row['item1'] = "<img src='https://i.imgur.com/ZQXWkHn.gif' alt='I0BK' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0A3') {
            $row['item1'] = "<img src='https://i.imgur.com/ZUnHzGl.gif' alt='I0A3' width='50' height='50'>";
        }
        if ($row['item1'] === 'I00I') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I00I' width='50' height='50'>";
        }
        if ($row['item1'] === 'I073') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I073' width='50' height='50'>";
        }
        if ($row['item1'] === 'I0LC') {
            $row['item1'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0LC' width='50' height='50'>";
        }

	

// Reemplazar "Item2" con la imagen



        if ($row['item2'] === 'I0HB') {
            $row['item2'] = "<img src='https://i.imgur.com/yg5xQxO.gif' alt='I0HB' width='50' height='50'>";
        }	
        if ($row['item2'] === 'I063') {
            $row['item2'] = "<img src='https://i.imgur.com/ntmDqDL.gif' alt='I063' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0LL') {
            $row['item2'] = "<img src='https://i.imgur.com/3peiMR1.gif' alt='I0LL' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0AO') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0AO' width='50' height='50'>";
        }
        if ($row['item2'] === 'I04Q') {
            $row['item2'] = "<img src='https://i.imgur.com/RTrKDRI.gif' alt='I04Q' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0BK') {
            $row['item2'] = "<img src='https://i.imgur.com/ZQXWkHn.gif' alt='I0BK' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0BM') {
            $row['item2'] = "<img src='https://i.imgur.com/8OhLX71.gif' alt='I0BM' width='50' height='50'>";
        }        
		if ($row['item2'] === 'I0AF') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0AF' width='50' height='50'>";
        }	
		if ($row['item2'] === 'I08G') {
            $row['item2'] = "<img src='https://i.imgur.com/1rXq4IZ.gif' alt='I08G' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0JF') {
            $row['item2'] = "<img src='https://i.imgur.com/bZ6Wbbc.gif' alt='I0JF' width='50' height='50'>";
        }
        if ($row['item2'] === 'I08T') {
            $row['item2'] = "<img src='https://i.imgur.com/pzRYTc0.gif' alt='I08T' width='50' height='50'>";
        }
        if ($row['item2'] === '') {
            $row['item2'] = "<img src='https://i.imgur.com/TxmuHuc.gif' alt='' width='50' height='50'>";
        }
        if ($row['item2'] === 'I09C') {
            $row['item2'] = "<img src='https://i.imgur.com/IF2yHhM.gif' alt='I09C' width='50' height='50'>";
        }
        if ($row['item2'] === 'I055') {
            $row['item2'] = "<img src='https://i.imgur.com/sNA20id.gif' alt='I055' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0AI') {
            $row['item2'] = "<img src='https://i.imgur.com/HalUhf0.gif' alt='I0AI' width='50' height='50'>";
        }			
        if ($row['item2'] === 'I0GJ') {
            $row['item2'] = "<img src='https://i.imgur.com/DtE7ccv.gif' alt='I0GJ' width='50' height='50'>";
        }
        if ($row['item2'] === 'I08K') {
            $row['item2'] = "<img src='https://i.imgur.com/Xg66kfK.gif' alt='I08K' width='50' height='50'>";
        }
        if ($row['item2'] === 'I067') {
            $row['item2'] = "<img src='https://i.imgur.com/iepxoMH.gif' alt='I067' width='50' height='50'>";
        }		
        if ($row['item2'] === 'I06L') {
            $row['item2'] = "<img src='https://i.imgur.com/EJKe0Lw.gif' alt='I06L' width='50' height='50'>";
        }		
        if ($row['item2'] === 'I0MI') {
            $row['item2'] = "<img src='https://i.imgur.com/m29IjCH.gif' alt='I0MI' width='50' height='50'>";
        }
        if ($row['item2'] === 'I05I') {
            $row['item2'] = "<img src='https://i.imgur.com/cRPRT6T.gif' alt='I05I' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0HB') {
            $row['item2'] = "<img src='https://i.imgur.com/yg5xQxO.gif' alt='I0HB' width='50' height='50'>";
        }	
        if ($row['item2'] === 'I0K6') {
            $row['item2'] = "<img src='https://i.imgur.com/inYvfAY.gif' alt='I0K6' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0HI') {
            $row['item2'] = "<img src='https://i.imgur.com/9AL9kLt.gif' alt='I0HI' width='50' height='50'>";
        }		
        if ($row['item2'] === 'I05H') {
            $row['item2'] = "<img src='https://i.imgur.com/ZDVRLKo.gif' alt='I05H' width='50' height='50'>";
        }
        if ($row['item2'] === 'I02T') {
            $row['item2'] = "<img src='https://i.imgur.com/4BvIZL6.gif' alt='I02T' width='50' height='50'>";
        }
        if ($row['item2'] === 'I099') {
            $row['item2'] = "<img src='https://i.imgur.com/Hinoizz.gif' alt='I099' width='50' height='50'>";
        }
        if ($row['item2'] === 'I09H') {
            $row['item2'] = "<img src='https://i.imgur.com/qJlVXha.gif' alt='I09H' width='50' height='50'>";
        }        
        if ($row['item2'] === 'I06B') {
            $row['item2'] = "<img src='https://i.imgur.com/fhZKKvs.gif' alt='I06B' width='50' height='50'>";
        }
        if ($row['item2'] === 'I06H') {
            $row['item2'] = "<img src='https://i.imgur.com/OqgjzgS.gif' alt='I06H' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0AM') {
            $row['item2'] = "<img src='https://i.imgur.com/T8OgeJQ.gif' alt='I0AM' width='50' height='50'>";
        }
        if ($row['item2'] === 'I05G') {
            $row['item2'] = "<img src='https://i.imgur.com/ZDVRLKo.gif' alt='I05G' width='50' height='50'>";
        }
        if ($row['item2'] === 'I09F') {
            $row['item2'] = "<img src='https://i.imgur.com/gSBicQJ.gif' alt='I09F' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0KY') {
            $row['item2'] = "<img src='https://i.imgur.com/Vg4LgNW.gif' alt='I0KY' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0OV') {
            $row['item2'] = "<img src='https://i.imgur.com/ig69ypo.gif' alt='I0OV' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0BG') {
            $row['item2'] = "<img src='https://i.imgur.com/8VCntOL.gif' alt='I0BG' width='50' height='50'>";
        }
        if ($row['item2'] === 'I02O') {
            $row['item2'] = "<img src='https://i.imgur.com/cjLEIkH.gif' alt='I02O' width='50' height='50'>";
        }
        if ($row['item2'] === 'I05C') {
            $row['item2'] = "<img src='https://i.imgur.com/8psZryG.gif' alt='I05C' width='50' height='50'>";
        }
        if ($row['item2'] === 'I051') {
            $row['item2'] = "<img src='https://i.imgur.com/TUo49xk.gif' alt='I051' width='50' height='50'>";
        }
        if ($row['item2'] === 'I06J') {
            $row['item2'] = "<img src='https://i.imgur.com/WOiVNCK.gif' alt='I06J' width='50' height='50'>";
        }
        if ($row['item2'] === 'I08Y') {
            $row['item2'] = "<img src='https://i.imgur.com/X8tCk0U.gif' alt='I08Y' width='50' height='50'>";
        }		
        if ($row['item2'] === 'I08O') {
            $row['item2'] = "<img src='https://i.imgur.com/cquIgN9.gif' alt='I08O' width='50' height='50'>";
        }		
        if ($row['item2'] === 'I04H') {
            $row['item2'] = "<img src='https://i.imgur.com/cbq6iQ6.gif' alt='I04H' width='50' height='50'>";
        }		
        if ($row['item2'] === 'I045') {
            $row['item2'] = "<img src='https://i.imgur.com/MJ5ec2U.gif' alt='I045' width='50' height='50'>";
        }			
        if ($row['item2'] === 'I02P') {
            $row['item2'] = "<img src='https://i.imgur.com/Gr4lca6.gif' alt='I02P' width='50' height='50'>";
        }
        if ($row['item2'] === 'I09Z') {
            $row['item2'] = "<img src='https://i.imgur.com/arYLlo9.gif' alt='I09Z' width='50' height='50'>";
        }			
        if ($row['item2'] === 'I0FZ') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0FZ' width='50' height='50'>";
        }
        if ($row['item2'] === 'I009') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I009' width='50' height='50'>";
        }	
        if ($row['item2'] === 'I093') {
            $row['item2'] = "<img src='https://i.imgur.com/1oM5Abl.gif' alt='I093' width='50' height='50'>";
        }
        if ($row['item2'] === 'I016') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I016' width='50' height='50'>";
        }
        if ($row['item2'] === 'I06V') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I06V' width='50' height='50'>";
        }		
        if ($row['item2'] === 'I04F') {
            $row['item2'] = "<img src='https://i.imgur.com/Lc4BA7j.gif' alt='I04F' width='50' height='50'>";
        }
        if ($row['item2'] === 'I09P') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I09P' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0HJ') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0HJ' width='50' height='50'>";
        }		
        if ($row['item2'] === 'I0JV') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0JV' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0GH') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0GH' width='50' height='50'>";
        }
        if ($row['item2'] === 'I05Y') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05Y' width='50' height='50'>";
        }
        if ($row['item2'] === 'I09N') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I09N' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0AP') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0AP' width='50' height='50'>";
        }
        if ($row['item2'] === 'I05Z') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05Z' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0BA') {
            $row['item2'] = "<img src='https://i.imgur.com/Zg4OQtH.gif' alt='I0BA' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0LC') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0LC' width='50' height='50'>";
        }
        if ($row['item2'] === 'I09D') {
            $row['item2'] = "<img src='https://i.imgur.com/3ula1se.gif' alt='I09D' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0G1') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0G1' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0EV') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0EV' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0KL') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0KL' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0HP') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0HP' width='50' height='50'>";
        }
        if ($row['item2'] === 'I00Q') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I00Q' width='50' height='50'>";
        }
        if ($row['item2'] === 'I04O') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04O' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0HR') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0HR' width='50' height='50'>";
        }
        if ($row['item2'] === 'I00I') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I00I' width='50' height='50'>";
        }
        if ($row['item2'] === 'I062') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I062' width='50' height='50'>";
        }
        if ($row['item2'] === 'I09O') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I09O' width='50' height='50'>";
        }
        if ($row['item2'] === 'I04K') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04K' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0KF') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0KF' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0GX') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0GX' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0BJ') {
            $row['item2'] = "<img src='https://i.imgur.com/JYgADbN.gif' alt='I0BJ' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0A3') {
            $row['item2'] = "<img src='https://i.imgur.com/ZUnHzGl.gif' alt='I0A3' width='50' height='50'>";
        }
        if ($row['item2'] === 'I08Z') {
            $row['item2'] = "<img src='https://i.imgur.com/1yzcHME.gif' alt='I08Z' width='50' height='50'>";
        }
        if ($row['item2'] === 'I05F') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05F' width='50' height='50'>";
        }		
        if ($row['item2'] === 'I095') {
            $row['item2'] = "<img src='https://i.imgur.com/mJ7w6HT.gif' alt='I095' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0QS') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0QS' width='50' height='50'>";
        }		
        if ($row['item2'] === 'I0LV') {
            $row['item2'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0LV' width='50' height='50'>";
        }		
        if ($row['item2'] === 'I054') {
            $row['item2'] = "<img src='https://i.imgur.com/IPrskpB.gif' alt='I054' width='50' height='50'>";
        }	
        if ($row['item2'] === 'I048') {
            $row['item2'] = "<img src='https://i.imgur.com/a5UDMef.gif' alt='I048' width='50' height='50'>";
        }
        if ($row['item2'] === 'I0A9') {
            $row['item2'] = "<img src='https://i.imgur.com/4Q70HGC.gif' alt='I0A9' width='50' height='50'>";
        }	


	
// Reemplazar "Item3" con la imagen


        if ($row['item3'] === 'I06L') {
            $row['item3'] = "<img src='https://i.imgur.com/EJKe0Lw.gif' alt='I06L' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0BM') {
            $row['item3'] = "<img src='https://i.imgur.com/8OhLX71.gif' alt='I0BM' width='50' height='50'>";
        }  
        if ($row['item3'] === 'I0HB') {
            $row['item3'] = "<img src='https://i.imgur.com/yg5xQxO.gif' alt='I0HB' width='50' height='50'>";
        }
        if ($row['item3'] === 'I052') {
            $row['item3'] = "<img src='https://i.imgur.com/b0uMes9.gif' alt='I052' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0LC') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0LC' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0KF') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0KF' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0G0') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0G0' width='50' height='50'>";
        }
        if ($row['item3'] === 'I05F') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05F' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0M4') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0M4' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0FS') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0FS' width='50' height='50'>";
        }
        if ($row['item3'] === 'I08R') {
            $row['item3'] = "<img src='https://i.imgur.com/AS97grQ.gif' alt='I08R' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0KA') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0KA' width='50' height='50'>";
        }
        if ($row['item3'] === 'I05Y') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05Y' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0P1') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0P1' width='50' height='50'>";
        }
        if ($row['item3'] === 'I04I') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04I' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0AP') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0AP' width='50' height='50'>";
        }
        if ($row['item3'] === 'I04K') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04K' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0GC') {
            $row['item3'] = "<img src='https://i.imgur.com/DRZ4iqy.gif' alt='I0GC' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0J6') {
            $row['item3'] = "<img src='https://i.imgur.com/R0dOBEd.gif' alt='I0J6' width='50' height='50'>";
        }
        if ($row['item3'] === 'I00G') {
            $row['item3'] = "<img src='https://i.imgur.com/T8OgeJQ.gif' alt='I00G' width='50' height='50'>";
        }
        if ($row['item3'] === 'I02P') {
            $row['item3'] = "<img src='https://i.imgur.com/Gr4lca6.gif' alt='I02P' width='50' height='50'>";
        }
        if ($row['item3'] === '') {
            $row['item3'] = "<img src='https://i.imgur.com/TxmuHuc.gif' alt='' width='50' height='50'>";
        }
        if ($row['item3'] === 'I099') {
            $row['item3'] = "<img src='https://i.imgur.com/Hinoizz.gif' alt='I099' width='50' height='50'>";
        }
        if ($row['item3'] === 'I08Z') {
            $row['item3'] = "<img src='https://i.imgur.com/1yzcHME.gif' alt='I08Z' width='50' height='50'>";
        }			
        if ($row['item3'] === 'I08T') {
            $row['item3'] = "<img src='https://i.imgur.com/pzRYTc0.gif' alt='I08T' width='50' height='50'>";
        }
        if ($row['item3'] === 'I045') {
            $row['item3'] = "<img src='https://i.imgur.com/MJ5ec2U.gif' alt='I045' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0GJ') {
            $row['item3'] = "<img src='https://i.imgur.com/DtE7ccv.gif' alt='I0GJ' width='50' height='50'>";
        }
        if ($row['item3'] === 'I08K') {
            $row['item3'] = "<img src='https://i.imgur.com/Xg66kfK.gif' alt='I08K' width='50' height='50'>";
        }
        if ($row['item3'] === 'I067') {
            $row['item3'] = "<img src='https://i.imgur.com/iepxoMH.gif' alt='I067' width='50' height='50'>";
        }
        if ($row['item3'] === 'I05I') {
            $row['item3'] = "<img src='https://i.imgur.com/cRPRT6T.gif' alt='I05I' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0HI') {
            $row['item3'] = "<img src='https://i.imgur.com/9AL9kLt.gif' alt='I0HI' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0BG') {
            $row['item3'] = "<img src='https://i.imgur.com/8VCntOL.gif' alt='I0BG' width='50' height='50'>";
        }
        if ($row['item3'] === 'I06H') {
            $row['item3'] = "<img src='https://i.imgur.com/OqgjzgS.gif' alt='I06H' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0AI') {
            $row['item3'] = "<img src='https://i.imgur.com/HalUhf0.gif' alt='I0AI' width='50' height='50'>";
        }	
        if ($row['item3'] === 'I08P') {
            $row['item3'] = "<img src='https://i.imgur.com/cvJQUAd.gif' alt='I08P' width='50' height='50'>";
        }	
        if ($row['item3'] === 'I095') {
            $row['item3'] = "<img src='https://i.imgur.com/mJ7w6HT.gif' alt='I095' width='50' height='50'>";
        }
        if ($row['item3'] === 'I05C') {
            $row['item3'] = "<img src='https://i.imgur.com/8psZryG.gif' alt='I05C' width='50' height='50'>";
        }
        if ($row['item3'] === 'I09C') {
            $row['item3'] = "<img src='https://i.imgur.com/IF2yHhM.gif' alt='I09C' width='50' height='50'>";
        }
        if ($row['item3'] === 'I09H') {
            $row['item3'] = "<img src='https://i.imgur.com/qJlVXha.gif' alt='I09H' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0BA') {
            $row['item3'] = "<img src='https://i.imgur.com/Zg4OQtH.gif' alt='I0BA' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0AW') {
            $row['item3'] = "<img src='https://i.imgur.com/DHhVhLq.gif' alt='I0AW' width='50' height='50'>";
        }
        if ($row['item3'] === 'I02O') {
            $row['item3'] = "<img src='https://i.imgur.com/cjLEIkH.gif' alt='I02O' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0MI') {
            $row['item3'] = "<img src='https://i.imgur.com/m29IjCH.gif' alt='I0MI' width='50' height='50'>";
        }
        if ($row['item3'] === 'I051') {
            $row['item3'] = "<img src='https://i.imgur.com/TUo49xk.gif' alt='I051' width='50' height='50'>";
        }
        if ($row['item3'] === 'I06B') {
            $row['item3'] = "<img src='https://i.imgur.com/fhZKKvs.gif' alt='I06B' width='50' height='50'>";
        }
        if ($row['item3'] === 'I04H') {
            $row['item3'] = "<img src='https://i.imgur.com/cbq6iQ6.gif' alt='I04H' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0NE') {
            $row['item3'] = "<img src='https://i.imgur.com/qgjOofo.gif' alt='I0NE' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0OV') {
            $row['item3'] = "<img src='https://i.imgur.com/ig69ypo.gif' alt='I0OV' width='50' height='50'>";
        }
        if ($row['item3'] === 'I04C') {
            $row['item3'] = "<img src='https://i.imgur.com/S0yXyvj.gif' alt='I04C' width='50' height='50'>";
        }
        if ($row['item3'] === 'I04G') {
            $row['item3'] = "<img src='https://i.imgur.com/SJMdzIa.gif' alt='I04G' width='50' height='50'>";
        }		
        if ($row['item3'] === 'I06J') {
            $row['item3'] = "<img src='https://i.imgur.com/WOiVNCK.gif' alt='I06J' width='50' height='50'>";
        }		
        if ($row['item3'] === 'I04T') {
            $row['item3'] = "<img src='https://i.imgur.com/HcQ9OTW.gif' alt='I04T' width='50' height='50'>";
        }
        if ($row['item3'] === 'I012') {
            $row['item3'] = "<img src='https://i.imgur.com/u896GVA.gif' alt='I012' width='50' height='50'>";
        }		
        if ($row['item3'] === 'I00Z') {
            $row['item3'] = "<img src='https://i.imgur.com/pFeRqMa.gif' alt='I00Z' width='50' height='50'>";
        }		
        if ($row['item3'] === 'I02T') {
            $row['item3'] = "<img src='https://i.imgur.com/4BvIZL6.gif' alt='I02T' width='50' height='50'>";
        }		
        if ($row['item3'] === 'I09Z') {
            $row['item3'] = "<img src='https://i.imgur.com/arYLlo9.gif' alt='I09Z' width='50' height='50'>";
        }		
        if ($row['item3'] === 'I0BK') {
            $row['item3'] = "<img src='https://i.imgur.com/ZQXWkHn.gif' alt='I0BK' width='50' height='50'>";
        }
        if ($row['item3'] === 'I08G') {
            $row['item3'] = "<img src='https://i.imgur.com/1rXq4IZ.gif' alt='I08G' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0MU') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0MU' width='50' height='50'>";
        }
        if ($row['item3'] === 'I002') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I002' width='50' height='50'>";
        }
        if ($row['item3'] === 'I05Z') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05Z' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0GH') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0GH' width='50' height='50'>";
        }
        if ($row['item3'] === 'I09M') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I09M' width='50' height='50'>";
        }
        if ($row['item3'] === 'I0OI') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0OI' width='50' height='50'>";
        }
        if ($row['item3'] === 'I05V') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05V' width='50' height='50'>";
        }	
        if ($row['item3'] === 'I0LL') {
            $row['item3'] = "<img src='https://i.imgur.com/3peiMR1.gif' alt='I0LL' width='50' height='50'>";
        }	
        if ($row['item3'] === 'I093') {
            $row['item3'] = "<img src='https://i.imgur.com/1oM5Abl.gif' alt='I093' width='50' height='50'>";
        }
        if ($row['item3'] === 'I062') {
            $row['item3'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I062' width='50' height='50'>";
        }
        if ($row['item3'] === 'I04Z') {
            $row['item3'] = "<img src='https://i.imgur.com/9VBlGX6.gif' alt='I04Z' width='50' height='50'>";
        }




		
// Reemplazar "Item4" con la imagen


        if ($row['item4'] === 'I05S') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05S' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0A9') {
            $row['item4'] = "<img src='https://i.imgur.com/4Q70HGC.gif' alt='I0A9' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0P1') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0P1' width='50' height='50'>";
        }
        if ($row['item4'] === 'I00D') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I00D' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0DR') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0DR' width='50' height='50'>";
        }
        if ($row['item4'] === 'I049') {
            $row['item4'] = "<img src='https://i.imgur.com/8OhLX71.gif' alt='I049' width='50' height='50'>";
        }
        if ($row['item4'] === 'I04Q') {
            $row['item4'] = "<img src='https://i.imgur.com/RTrKDRI.gif' alt='I04Q' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0QS') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0QS' width='50' height='50'>";
        }	
        if ($row['item4'] === 'I0LL') {
            $row['item4'] = "<img src='https://i.imgur.com/3peiMR1.gif' alt='I0LL' width='50' height='50'>";
        }
        if ($row['item4'] === 'I099') {
            $row['item4'] = "<img src='https://i.imgur.com/Hinoizz.gif' alt='I099' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0FZ') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0FZ' width='50' height='50'>";
        }
        if ($row['item4'] === 'I04K') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04K' width='50' height='50'>";
        }
        if ($row['item4'] === 'I05F') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05F' width='50' height='50'>";
        }
        if ($row['item4'] === 'I050') {
            $row['item4'] = "<img src='https://i.imgur.com/5EFOCVD.gif' alt='I050' width='50' height='50'>";
        }
        if ($row['item4'] === 'I044') {
            $row['item4'] = "<img src='https://i.imgur.com/APEwKRQ.gif' alt='I044' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0KF') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0KF' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0AW') {
            $row['item4'] = "<img src='https://i.imgur.com/DHhVhLq.gif' alt='I0AW' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0AE') {
            $row['item4'] = "<img src='https://i.imgur.com/w4wd8ZU.gif' alt='I0AE' width='50' height='50'>";
        }
        if ($row['item4'] === 'I114') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I114' width='50' height='50'>";
        }
        if ($row['item4'] === 'I09C') {
            $row['item4'] = "<img src='https://i.imgur.com/IF2yHhM.gif' alt='I09C' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0P4') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0P4' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0HB') {
            $row['item4'] = "<img src='https://i.imgur.com/yg5xQxO.gif' alt='I0HB' width='50' height='50'>";
        }	
        if ($row['item4'] === 'I04M') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04M' width='50' height='50'>";
        }
        if ($row['item4'] === 'I04L') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04L' width='50' height='50'>";
        }
        if ($row['item4'] === 'I02Y') {
            $row['item4'] = "<img src='https://i.imgur.com/2D5iLEL.gif' alt='I02Y' width='50' height='50'>";
        }
        if ($row['item4'] === 'I04Z') {
            $row['item4'] = "<img src='https://i.imgur.com/9VBlGX6.gif' alt='I04Z' width='50' height='50'>";
        }
        if ($row['item4'] === 'I05G') {
            $row['item4'] = "<img src='https://i.imgur.com/ZDVRLKo.gif' alt='I05G' width='50' height='50'>";
        }
        if ($row['item4'] === 'I06B') {
            $row['item4'] = "<img src='https://i.imgur.com/fhZKKvs.gif' alt='I06B' width='50' height='50'>";
        }
        if ($row['item4'] === 'I08G') {
            $row['item4'] = "<img src='https://i.imgur.com/1rXq4IZ.gif' alt='I08G' width='50' height='50'>";
        }
        if ($row['item4'] === 'I04R') {
            $row['item4'] = "<img src='https://i.imgur.com/f82W3ID.gif' alt='I04R' width='50' height='50'>";
        }
        if ($row['item4'] === 'I062') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I062' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0AI') {
            $row['item4'] = "<img src='https://i.imgur.com/HalUhf0.gif' alt='I0AI' width='50' height='50'>";
        }	
        if ($row['item4'] === 'I0AY') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0AY' width='50' height='50'>";
        }
        if ($row['item4'] === 'I04I') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04I' width='50' height='50'>";
        }
        if ($row['item4'] === 'I099') {
            $row['item4'] = "<img src='https://i.imgur.com/Hinoizz.gif' alt='I099' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0QY') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0QY' width='50' height='50'>";
        }	
        if ($row['item4'] === 'I09Z') {
            $row['item4'] = "<img src='https://i.imgur.com/arYLlo9.gif' alt='I09Z' width='50' height='50'>";
        }	
        if ($row['item4'] === 'I02T') {
            $row['item4'] = "<img src='https://i.imgur.com/4BvIZL6.gif' alt='I02T' width='50' height='50'>";
        }	
        if ($row['item4'] === 'I04V') {
            $row['item4'] = "<img src='https://i.imgur.com/PQ7A4Mu.gif' alt='I04V' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0JI') {
            $row['item4'] = "<img src='https://i.imgur.com/NKk3XXX.gif' alt='I0JI' width='50' height='50'>";
        }
        if ($row['item4'] === 'I00G') {
            $row['item4'] = "<img src='https://i.imgur.com/T8OgeJQ.gif' alt='I00G' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0BJ') {
            $row['item4'] = "<img src='https://i.imgur.com/JYgADbN.gif' alt='I0BJ' width='50' height='50'>";
        }
        if ($row['item4'] === 'I095') {
            $row['item4'] = "<img src='https://i.imgur.com/mJ7w6HT.gif' alt='I095' width='50' height='50'>";
        }
        if ($row['item4'] === 'I08O') {
            $row['item4'] = "<img src='https://i.imgur.com/cquIgN9.gif' alt='I08O' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0EV') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0EV' width='50' height='50'>";
        }
        if ($row['item4'] === 'I05C') {
            $row['item4'] = "<img src='https://i.imgur.com/8psZryG.gif' alt='I05C' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0MI') {
            $row['item4'] = "<img src='https://i.imgur.com/m29IjCH.gif' alt='I0MI' width='50' height='50'>";
        }
        if ($row['item4'] === 'I012') {
            $row['item4'] = "<img src='https://i.imgur.com/u896GVA.gif' alt='I012' width='50' height='50'>";
        }
        if ($row['item4'] === 'I09T') {
            $row['item4'] = "<img src='https://i.imgur.com/fAjjoGj.gif' alt='I09T' width='50' height='50'>";
        }
        if ($row['item4'] === 'I045') {
            $row['item4'] = "<img src='https://i.imgur.com/MJ5ec2U.gif' alt='I045' width='50' height='50'>";
        }	
        if ($row['item4'] === 'I051') {
            $row['item4'] = "<img src='https://i.imgur.com/TUo49xk.gif' alt='I051' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0NE') {
            $row['item4'] = "<img src='https://i.imgur.com/qgjOofo.gif' alt='I0NE' width='50' height='50'>";
        }
        if ($row['item4'] === 'I06L') {
            $row['item4'] = "<img src='https://i.imgur.com/EJKe0Lw.gif' alt='I06L' width='50' height='50'>";
        }
        if ($row['item4'] === 'I093') {
            $row['item4'] = "<img src='https://i.imgur.com/1oM5Abl.gif' alt='I093' width='50' height='50'>";
        }
        if ($row['item4'] === 'I048') {
            $row['item4'] = "<img src='https://i.imgur.com/a5UDMef.gif' alt='I048' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0KY') {
            $row['item4'] = "<img src='https://i.imgur.com/Vg4LgNW.gif' alt='I0KY' width='50' height='50'>";
        }
        if ($row['item4'] === 'I04E') {
            $row['item4'] = "<img src='https://i.imgur.com/xTd6S2K.gif' alt='I04E' width='50' height='50'>";
        }
        if ($row['item4'] === 'I08T') {
            $row['item4'] = "<img src='https://i.imgur.com/pzRYTc0.gif' alt='I08T' width='50' height='50'>";
        }		
        if ($row['item4'] === '') {
            $row['item4'] = "<img src='https://i.imgur.com/TxmuHuc.gif' alt='' width='50' height='50'>";
        }
        if ($row['item4'] === 'I08K') {
            $row['item4'] = "<img src='https://i.imgur.com/Xg66kfK.gif' alt='I08K' width='50' height='50'>";
        }
        if ($row['item4'] === 'I05I') {
            $row['item4'] = "<img src='https://i.imgur.com/cRPRT6T.gif' alt='I05I' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0HI') {
            $row['item4'] = "<img src='https://i.imgur.com/9AL9kLt.gif' alt='I0HI' width='50' height='50'>";
        }	
        if ($row['item4'] === 'I05I') {
            $row['item4'] = "<img src='https://i.imgur.com/cRPRT6T.gif' alt='I05I' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0BA') {
            $row['item4'] = "<img src='https://i.imgur.com/Zg4OQtH.gif' alt='I0BA' width='50' height='50'>";
        }
        if ($row['item4'] === 'I09H') {
            $row['item4'] = "<img src='https://i.imgur.com/qJlVXha.gif' alt='I09H' width='50' height='50'>";
        }
        if ($row['item4'] === 'I08Z') {
            $row['item4'] = "<img src='https://i.imgur.com/1yzcHME.gif' alt='I08Z' width='50' height='50'>";
        }	
        if ($row['item4'] === 'I02O') {
            $row['item4'] = "<img src='https://i.imgur.com/cjLEIkH.gif' alt='I02O' width='50' height='50'>";
        }
        if ($row['item4'] === 'I0A8') {
            $row['item4'] = "<img src='https://i.imgur.com/mSymIIP.gif' alt='I0A8' width='50' height='50'>";
        }		
        if ($row['item4'] === 'I08P') {
            $row['item4'] = "<img src='https://i.imgur.com/cvJQUAd.gif' alt='I08P' width='50' height='50'>";
        }			
        if ($row['item4'] === 'I05Y') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05Y' width='50' height='50'>";
        }		
        if ($row['item4'] === 'I04T') {
            $row['item4'] = "<img src='https://i.imgur.com/HcQ9OTW.gif' alt='I04T' width='50' height='50'>";
        }	
        if ($row['item4'] === 'I0L0') {
            $row['item4'] = "<img src='https://i.imgur.com/HcQ9OTW.gif' alt='I0L0' width='50' height='50'>";
        }		
        if ($row['item4'] === 'I0GH') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0GH' width='50' height='50'>";
        }	
        if ($row['item4'] === 'I07Y') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I07Y' width='50' height='50'>";
        }			
        if ($row['item4'] === 'I0GH') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0GH' width='50' height='50'>";
        }
        if ($row['item4'] === 'I06H') {
            $row['item4'] = "<img src='https://i.imgur.com/OqgjzgS.gif' alt='I06H' width='50' height='50'>";
        }
        if ($row['item4'] === 'I097') {
            $row['item4'] = "<img src='https://i.imgur.com/4V1A9oz.gif' alt='I097' width='50' height='50'>";
        }		
        if ($row['item4'] === 'I0HR') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0HR' width='50' height='50'>";
        }
        if ($row['item4'] === 'I04N') {
            $row['item4'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04N' width='50' height='50'>";
        }

		
// Reemplazar "Item5" con la imagen 


        if ($row['item5'] === 'I0J6') {
            $row['item5'] = "<img src='https://i.imgur.com/R0dOBEd.gif' alt='I0J6' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0NE') {
            $row['item5'] = "<img src='https://i.imgur.com/qgjOofo.gif' alt='I0NE' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0HB') {
            $row['item5'] = "<img src='https://i.imgur.com/yg5xQxO.gif' alt='I0HB' width='50' height='50'>";
        }	
        if ($row['item5'] === 'I0KY') {
            $row['item5'] = "<img src='https://i.imgur.com/Vg4LgNW.gif' alt='I0KY' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0AY') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0AY' width='50' height='50'>";
        }
        if ($row['item5'] === 'I05C') {
            $row['item5'] = "<img src='https://i.imgur.com/8psZryG.gif' alt='I05C' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0S7') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0S7' width='50' height='50'>";
        }
        if ($row['item5'] === 'I044') {
            $row['item5'] = "<img src='https://i.imgur.com/APEwKRQ.gif' alt='I044' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0L7') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0L7' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0AE') {
            $row['item5'] = "<img src='https://i.imgur.com/w4wd8ZU.gif' alt='I0AE' width='50' height='50'>";
        }
        if ($row['item5'] === 'I04F') {
            $row['item5'] = "<img src='https://i.imgur.com/Lc4BA7j.gif' alt='I04F' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0PB') {
            $row['item5'] = "<img src='https://i.imgur.com/B0mT9XV.gif' alt='I0PB' width='50' height='50'>";
        }
        if ($row['item5'] === 'I06B') {
            $row['item5'] = "<img src='https://i.imgur.com/fhZKKvs.gif' alt='I06B' width='50' height='50'>";
        }
        if ($row['item5'] === 'I08T') {
            $row['item5'] = "<img src='https://i.imgur.com/pzRYTc0.gif' alt='I08T' width='50' height='50'>";
        }
        if ($row['item5'] === 'I04G') {
            $row['item5'] = "<img src='https://i.imgur.com/SJMdzIa.gif' alt='I04G' width='50' height='50'>";
        }	
        if ($row['item5'] === 'I04I') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04I' width='50' height='50'>";
        }
        if ($row['item5'] === 'I062') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I062' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0KL') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0KL' width='50' height='50'>";
        }
        if ($row['item5'] === 'I04K') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04K' width='50' height='50'>";
        }
        if ($row['item5'] === 'I04M') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04M' width='50' height='50'>";
        }
        if ($row['item5'] === 'I04L') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04L' width='50' height='50'>";
        }
        if ($row['item5'] === 'I04O') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04O' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0LC') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0LC' width='50' height='50'>";
        }
        if ($row['item5'] === 'I05Y') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05Y' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0GH') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0GH' width='50' height='50'>";
        }
        if ($row['item5'] === 'I04N') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04N' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0HR') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0HR' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0FZ') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0FZ' width='50' height='50'>";
        }
        if ($row['item5'] === 'I099') {
            $row['item5'] = "<img src='https://i.imgur.com/Hinoizz.gif' alt='I099' width='50' height='50'>";
        }	
        if ($row['item5'] === 'I08K') {
            $row['item5'] = "<img src='https://i.imgur.com/Xg66kfK.gif' alt='I08K' width='50' height='50'>";
        }
        if ($row['item5'] === 'I055') {
            $row['item5'] = "<img src='https://i.imgur.com/sNA20id.gif' alt='I055' width='50' height='50'>";
        }
        if ($row['item5'] === 'I045') {
            $row['item5'] = "<img src='https://i.imgur.com/MJ5ec2U.gif' alt='I045' width='50' height='50'>";
        }	
        if ($row['item5'] === 'I0HI') {
            $row['item5'] = "<img src='https://i.imgur.com/9AL9kLt.gif' alt='I0HI' width='50' height='50'>";
        }	
        if ($row['item5'] === '') {
            $row['item5'] = "<img src='https://i.imgur.com/TxmuHuc.gif' alt='' width='50' height='50'>";
        }
        if ($row['item5'] === 'I05H') {
            $row['item5'] = "<img src='https://i.imgur.com/ZDVRLKo.gif' alt='I05H' width='50' height='50'>";
        }
        if ($row['item5'] === 'I06J') {
            $row['item5'] = "<img src='https://i.imgur.com/WOiVNCK.gif' alt='I06J' width='50' height='50'>";
        }
        if ($row['item5'] === 'I05I') {
            $row['item5'] = "<img src='https://i.imgur.com/cRPRT6T.gif' alt='I05I' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0HI') {
            $row['item5'] = "<img src='https://i.imgur.com/9AL9kLt.gif' alt='I0HI' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0AM') {
            $row['item5'] = "<img src='https://i.imgur.com/T8OgeJQ.gif' alt='I0AM' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0HI') {
            $row['item5'] = "<img src='https://i.imgur.com/9AL9kLt.gif' alt='I0HI' width='50' height='50'>";
        }	
        if ($row['item5'] === 'I08O') {
            $row['item5'] = "<img src='https://i.imgur.com/cquIgN9.gif' alt='I08O' width='50' height='50'>";
        }
        if ($row['item5'] === 'I09T') {
            $row['item5'] = "<img src='https://i.imgur.com/fAjjoGj.gif' alt='I09T' width='50' height='50'>";
        }
        if ($row['item5'] === 'I08P') {
            $row['item5'] = "<img src='https://i.imgur.com/cvJQUAd.gif' alt='I08P' width='50' height='50'>";
        }	
        if ($row['item5'] === 'I09Z') {
            $row['item5'] = "<img src='https://i.imgur.com/arYLlo9.gif' alt='I09Z' width='50' height='50'>";
        }
        if ($row['item5'] === 'I054') {
            $row['item5'] = "<img src='https://i.imgur.com/IPrskpB.gif' alt='I054' width='50' height='50'>";
        }		
        if ($row['item5'] === 'I091') {
            $row['item5'] = "<img src='https://i.imgur.com/I9jgcgc.gif' alt='I091' width='50' height='50'>";
        }		
        if ($row['item5'] === 'I0BG') {
            $row['item5'] = "<img src='https://i.imgur.com/8VCntOL.gif' alt='I0BG' width='50' height='50'>";
        }
        if ($row['item5'] === 'I04H') {
            $row['item5'] = "<img src='https://i.imgur.com/cbq6iQ6.gif' alt='I04H' width='50' height='50'>";
        }
        if ($row['item5'] === 'I02T') {
            $row['item5'] = "<img src='https://i.imgur.com/4BvIZL6.gif' alt='I02T' width='50' height='50'>";
        }	
        if ($row['item5'] === 'I09H') {
            $row['item5'] = "<img src='https://i.imgur.com/qJlVXha.gif' alt='I09H' width='50' height='50'>";
        }
        if ($row['item5'] === 'I05I') {
            $row['item5'] = "<img src='https://i.imgur.com/cRPRT6T.gif' alt='I05I' width='50' height='50'>";
        }
        if ($row['item5'] === 'I051') {
            $row['item5'] = "<img src='https://i.imgur.com/TUo49xk.gif' alt='I051' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0A8') {
            $row['item5'] = "<img src='https://i.imgur.com/mSymIIP.gif' alt='I0A8' width='50' height='50'>";
        }	
        if ($row['item5'] === 'I09C') {
            $row['item5'] = "<img src='https://i.imgur.com/IF2yHhM.gif' alt='I09C' width='50' height='50'>";
        }
        if ($row['item5'] === 'I08G') {
            $row['item5'] = "<img src='https://i.imgur.com/1rXq4IZ.gif' alt='I08G' width='50' height='50'>";
        }
        if ($row['item5'] === 'I095') {
            $row['item5'] = "<img src='https://i.imgur.com/mJ7w6HT.gif' alt='I095' width='50' height='50'>";
        }
        if ($row['item5'] === 'I02O') {
            $row['item5'] = "<img src='https://i.imgur.com/cjLEIkH.gif' alt='I02O' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0NG') {
            $row['item5'] = "<img src='https://i.imgur.com/NzQP1BW.gif' alt='I0NG' width='50' height='50'>";
        }		
        if ($row['item5'] === 'I0OV') {
            $row['item5'] = "<img src='https://i.imgur.com/ig69ypo.gif' alt='I0OV' width='50' height='50'>";
        }
        if ($row['item5'] === 'I06H') {
            $row['item5'] = "<img src='https://i.imgur.com/OqgjzgS.gif' alt='I06H' width='50' height='50'>";
        }
        if ($row['item5'] === 'I06L') {
            $row['item5'] = "<img src='https://i.imgur.com/EJKe0Lw.gif' alt='I06L' width='50' height='50'>";
        }
        if ($row['item5'] === 'I097') {
            $row['item5'] = "<img src='https://i.imgur.com/4V1A9oz.gif' alt='I097' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0BA') {
            $row['item5'] = "<img src='https://i.imgur.com/Zg4OQtH.gif' alt='I0BA' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0AI') {
            $row['item5'] = "<img src='https://i.imgur.com/HalUhf0.gif' alt='I0AI' width='50' height='50'>";
        }	
        if ($row['item5'] === 'I00Z') {
            $row['item5'] = "<img src='https://i.imgur.com/pFeRqMa.gif' alt='I00Z' width='50' height='50'>";
        }
        if ($row['item5'] === 'I04R') {
            $row['item5'] = "<img src='https://i.imgur.com/f82W3ID.gif' alt='I04R' width='50' height='50'>";
        }		
        if ($row['item5'] === 'I0MI') {
            $row['item5'] = "<img src='https://i.imgur.com/m29IjCH.gif' alt='I0MI' width='50' height='50'>";
        }

        if ($row['item5'] === 'I0A3') {
            $row['item5'] = "<img src='https://i.imgur.com/ZUnHzGl.gif' alt='I0A3' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0P1') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0P1' width='50' height='50'>";
        }
        if ($row['item5'] === 'I0A9') {
            $row['item5'] = "<img src='https://i.imgur.com/4Q70HGC.gif' alt='I0A9' width='50' height='50'>";
        }	
        if ($row['item5'] === 'I0SJ') {
            $row['item5'] = "<img src='https://i.imgur.com/DtE7ccv.gif' alt='I0SJ' width='50' height='50'>";
        }
        if ($row['item5'] === 'I052') {
            $row['item5'] = "<img src='https://i.imgur.com/b0uMes9.gif' alt='I052' width='50' height='50'>";
        }
		if ($row['item5'] === 'I0AP') {
            $row['item5'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0AP' width='50' height='50'>";
        }
	
// Reemplazar "Item6" con la imagen 	


        if ($row['item6'] === 'I04V') {
            $row['item6'] = "<img src='https://i.imgur.com/PQ7A4Mu.gif' alt='I04V' width='50' height='50'>";
        }
        if ($row['item6'] === 'I00M') {
            $row['item6'] = "<img src='https://i.imgur.com/xrDFdTe.gif' alt='I00M' width='50' height='50'>";
        }
        if ($row['item6'] === 'I04K') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04K' width='50' height='50'>";
        }
        if ($row['item6'] === 'I04I') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04I' width='50' height='50'>";
        }
        if ($row['item6'] === 'I005') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I005' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0JS') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0JS' width='50' height='50'>";
        }
        if ($row['item6'] === 'I00Z') {
            $row['item6'] = "<img src='https://i.imgur.com/pFeRqMa.gif' alt='I00Z' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0SD') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0SD' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0GJ') {
            $row['item6'] = "<img src='https://i.imgur.com/DtE7ccv.gif' alt='I0GJ' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0S7') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0S7' width='50' height='50'>";
        }

        if ($row['item6'] === 'I047') {
            $row['item6'] = "<img src='https://i.imgur.com/Xdj53uF.gif' alt='I047' width='50' height='50'>";
        }
        if ($row['item6'] === 'I062') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I062' width='50' height='50'>";
        }
		if ($row['item6'] === 'I02R') {
            $row['item6'] = "<img src='https://i.imgur.com/xn6h2sb.gif' alt='I02R' width='50' height='50'>";
        }
		if ($row['item6'] === 'I0AF') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0AF' width='50' height='50'>";
        }	
        if ($row['item6'] === 'I09T') {
            $row['item6'] = "<img src='https://i.imgur.com/fAjjoGj.gif' alt='I09T' width='50' height='50'>";
        }
		if ($row['item6'] === 'I0NE') {
            $row['item6'] = "<img src='https://i.imgur.com/qgjOofo.gif' alt='I0NE' width='50' height='50'>";
        }
        if ($row['item6'] === 'I04T') {
            $row['item6'] = "<img src='https://i.imgur.com/HcQ9OTW.gif' alt='I04T' width='50' height='50'>";
        }
        if ($row['item6'] === 'I052') {
            $row['item6'] = "<img src='https://i.imgur.com/b0uMes9.gif' alt='I052' width='50' height='50'>";
        }
        if ($row['item6'] === 'I04M') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04M' width='50' height='50'>";
        }
        if ($row['item6'] === 'I099') {
            $row['item6'] = "<img src='https://i.imgur.com/Hinoizz.gif' alt='I099' width='50' height='50'>";
        }	    
		if ($row['item6'] === 'I0AP') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0AP' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0A5') {
            $row['item6'] = "<img src='https://i.imgur.com/OdhzhI5.gif' alt='I0A5' width='50' height='50'>";
        }
        if ($row['item6'] === 'I05Y') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05Y' width='50' height='50'>";
        }
        if ($row['item6'] === 'I04U') {
            $row['item6'] = "<img src='https://i.imgur.com/BjSHzqc.gif' alt='I0HR' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0HR') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0HR' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0P1') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0P1' width='50' height='50'>";
        }
        if ($row['item6'] === 'I02T') {
            $row['item6'] = "<img src='https://i.imgur.com/4BvIZL6.gif' alt='I02T' width='50' height='50'>";
        }		
        if ($row['item6'] === 'I04H') {
            $row['item6'] = "<img src='https://i.imgur.com/cbq6iQ6.gif' alt='I04H' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0KY') {
            $row['item6'] = "<img src='https://i.imgur.com/Vg4LgNW.gif' alt='I0KY' width='50' height='50'>";
        }
        if ($row['item6'] === 'I02O') {
            $row['item6'] = "<img src='https://i.imgur.com/cjLEIkH.gif' alt='I02O' width='50' height='50'>";
        }
        if ($row['item6'] === 'I05I') {
            $row['item6'] = "<img src='https://i.imgur.com/cRPRT6T.gif' alt='I05I' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0A3') {
            $row['item6'] = "<img src='https://i.imgur.com/ZUnHzGl.gif' alt='I0A3' width='50' height='50'>";
        }
		
        if ($row['item6'] === 'I0MI') {
            $row['item6'] = "<img src='https://i.imgur.com/m29IjCH.gif' alt='I0MI' width='50' height='50'>";
        }
        if ($row['item6'] === '') {
            $row['item6'] = "<img src='https://i.imgur.com/TxmuHuc.gif' alt='' width='50' height='50'>";
        }

        if ($row['item6'] === 'I04S') {
            $row['item6'] = "<img src='https://i.imgur.com/dbLQsZw.gif' alt='I04S' width='50' height='50'>";
        }
        if ($row['item6'] === 'I050') {
            $row['item6'] = "<img src='https://i.imgur.com/5EFOCVD.gif' alt='I050' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0AI') {
            $row['item6'] = "<img src='https://i.imgur.com/HalUhf0.gif' alt='I0AI' width='50' height='50'>";
        }
        if ($row['item6'] === 'I06L') {
            $row['item6'] = "<img src='https://i.imgur.com/EJKe0Lw.gif' alt='I06L' width='50' height='50'>";
        }
        if ($row['item6'] === 'I06B') {
            $row['item6'] = "<img src='https://i.imgur.com/fhZKKvs.gif' alt='I06B' width='50' height='50'>";
        }
        if ($row['item6'] === 'I067') {
            $row['item6'] = "<img src='https://i.imgur.com/iepxoMH.gif' alt='I067' width='50' height='50'>";
        }	
        if ($row['item6'] === 'I0BJ') {
            $row['item6'] = "<img src='https://i.imgur.com/JYgADbN.gif' alt='I0BJ' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0BJ') {
            $row['item6'] = "<img src='https://i.imgur.com/JYgADbN.gif' alt='I0BJ' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0HB') {
            $row['item6'] = "<img src='https://i.imgur.com/yg5xQxO.gif' alt='I0HB' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0P4') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0P4' width='50' height='50'>";
        }		
        if ($row['item6'] === 'I0GH') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0GH' width='50' height='50'>";
        }
        if ($row['item6'] === 'I09H') {
            $row['item6'] = "<img src='https://i.imgur.com/qJlVXha.gif' alt='I09H' width='50' height='50'>";
        }		
		
        if ($row['item6'] === 'I05Z') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I05Z' width='50' height='50'>";
        }		
        if ($row['item6'] === 'I0GH') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0GH' width='50' height='50'>";
        }			
        if ($row['item6'] === 'I04D') {
            $row['item6'] = "<img src='https://i.imgur.com/RTnUG2m.gif' alt='I04D' width='50' height='50'>";
        }
        if ($row['item6'] === 'I04N') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04N' width='50' height='50'>";
        }		
        if ($row['item6'] === 'I04F') {
            $row['item6'] = "<img src='https://i.imgur.com/Lc4BA7j.gif' alt='I04F' width='50' height='50'>";
        }		
        if ($row['item6'] === 'I0BA') {
            $row['item6'] = "<img src='https://i.imgur.com/Zg4OQtH.gif' alt='I0BA' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0IN') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I0IN' width='50' height='50'>";
        }
        if ($row['item6'] === 'I05H') {
            $row['item6'] = "<img src='https://i.imgur.com/ZDVRLKo.gif' alt='I05H' width='50' height='50'>";
        }
        if ($row['item6'] === 'I051') {
            $row['item6'] = "<img src='https://i.imgur.com/TUo49xk.gif' alt='I051' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0A9') {
            $row['item6'] = "<img src='https://i.imgur.com/4Q70HGC.gif' alt='I0A9' width='50' height='50'>";
        }	
        if ($row['item6'] === 'I0A8') {
            $row['item6'] = "<img src='https://i.imgur.com/mSymIIP.gif' alt='I0A8' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0JF') {
            $row['item6'] = "<img src='https://i.imgur.com/bZ6Wbbc.gif' alt='I0JF' width='50' height='50'>";
        }
        if ($row['item6'] === 'I053') {
            $row['item6'] = "<img src='https://i.imgur.com/h9IwCkO.gif' alt='I053' width='50' height='50'>";
        }
        if ($row['item6'] === 'I04O') {
            $row['item6'] = "<img src='https://i.imgur.com/mRzYskJ.gif' alt='I04O' width='50' height='50'>";
        }
        if ($row['item6'] === 'I04G') {
            $row['item6'] = "<img src='https://i.imgur.com/SJMdzIa.gif' alt='I04G' width='50' height='50'>";
        }
        if ($row['item6'] === 'I0O3') {
            $row['item6'] = "<img src='https://i.imgur.com/cOxY9SE.gif' alt='I0O3' width='50' height='50'>";
        }		
	
    // Eliminar el valor predeterminado "Maps\Download\" de la columna 'map'
    if (isset($row['map']) && strpos($row['map'], "Maps\\Download\\") === 0) {
        $row['map'] = substr($row['map'], strlen("Maps\\Download\\"));
    }
		
		
				
                ?>
            </select>
            <input type="submit" value="Ejecutar">
        </form>

        <p><img src="https://conurbanes.org/wp-content/uploads/2020/02/barra-separadora.png" width="514" height="60"></p>
        <p>
            <?php
        $result = $mysqli->query($query);

        if ($result && $result->num_rows > 0) {
            echo "<table>";
            echo "<tr>";
            $field_count = $result->field_count;
            $fields = $result->fetch_fields();
            foreach ($fields as $field) {
                echo "<th>{$field->name}</th>";
            }
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $data) {
                    echo "<td>$data</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No hay resultados para mostrar.</p>";
        }

        $mysqli->close();
        ?>
            </p>
</div>
	<?php include 'footer.php'; ?>

</body>
</html>
