<?php
// Función para comprobar si el puerto 6188 está en uso
function checkPort($host, $port) {
    $connection = @fsockopen($host, $port, $errno, $errstr, 2);
    if (is_resource($connection)) {
        fclose($connection);
        return true;
    }
    return false;
}

// Función para verificar si Ghost.exe está ejecutándose
function checkProcess($process) {
    $output = shell_exec('tasklist');
    return stripos($output, $process) !== false;
}

// Verificar el puerto y el proceso
$puerto_abierto = checkPort("156.244.39.172", 6188);
$ghost_en_ejecucion = checkProcess("ghost.exe");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Admin a GHost++</title>
    <style>
        .container {
            max-width: 90%;
            width: 600px;
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
<div class="container">
    <p align="center"><img src="https://latinbattle.com/wp-content/uploads/2023/03/aa.png" width="335" height="255"></p>
    
    <!-- Mostrar estado del puerto y del proceso Ghost.exe -->
    <div style="text-align: center; font-size: 1.2em; margin-top: 20px;">
        <p>PARTIDA CREADA: 
            <?php echo $puerto_abierto ? '<span style="color: green;">🟢 Online</span>' : '<span style="color: red;">🔴 Offline</span>'; ?>
        </p>
        <p>Estado de BOT PERU.exe: 
            <?php echo $ghost_en_ejecucion ? '<span style="color: green;">🟢 En ejecución</span>' : '<span style="color: red;">🔴 No encontrado</span>'; ?>
        </p>
    </div>
 </div>
    <?php
    // Datos de conexión a la base de datos GHost++
    $servername = "localhost";
    $username = "latinbattle"; // Usuario de MySQL
    $password = "H8opgZWQrs0dgt7a";
    $dbname = "latinbat_peru"; // Base de datos

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = trim($_POST["nombre"]);
        $realm = "156.244.39.172"; // Valor predeterminado del REALM

        // Validar que el nombre solo contenga letras, números y guiones bajos
        if (!empty($nombre) && preg_match("/^[a-zA-Z0-9_]+$/", $nombre)) {
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Insertar admin en la tabla
                $stmt = $conn->prepare("INSERT INTO admins (name, server) VALUES (:name, :server)");
                $stmt->bindParam(':name', $nombre, PDO::PARAM_STR);
                $stmt->bindParam(':server', $realm, PDO::PARAM_STR);
                $stmt->execute();

                echo "<p style='color: green; text-align: center;'>Administrador agregado con éxito.</p>";
				
				 // Verificar si el puerto está offline
            if (!checkPort("156.244.39.172", 6188)) {
                echo "<p style='color: red; text-align: center;'>El puerto 6188 está offline. Finalizando ghost.exe...</p>";
                
                // Finalizar ghost.exe en Windows
                shell_exec("taskkill /F /IM ghost.exe");
            }
			
            } catch (PDOException $e) {
                echo "<p style='color: red; text-align: center;'>Error: " . $e->getMessage() . "</p>";
            }
            $conn = null;
        } else {
            echo "<p style='color: red; text-align: center;'>Por favor, ingresa un nombre válido (solo letras, números y guiones bajos).</p>";
        }
    }
    ?>

    <form method="post" style="text-align: center;">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" maxlength="15" size="20" required>
        <br>
        <label for="realm">Realm:</label>
        <input type="text" id="realm" name="realm" value="156.244.39.172" readonly>
        <br>
        <button type="submit">Agregar</button>
    </form>

    <?php include 'footer.php'; ?>
</body>
</html>
