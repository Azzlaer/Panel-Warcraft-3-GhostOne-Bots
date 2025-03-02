<?php include 'header.php'; ?>

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
        width: 100%;
        padding: 10px;
        font-size: 1.2em;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .progress-container {
        margin-top: 20px;
    }
    progress {
        width: 100%;
        height: 20px;
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
<script>
        function updateProgress(event) {
            if (event.lengthComputable) {
                var percentComplete = (event.loaded / event.total) * 100;
                document.getElementById('progressBar').value = percentComplete;
                document.getElementById('status').innerText = Math.round(percentComplete) + '%';
            }
        }

        function uploadFile() {
            var form = document.getElementById('uploadForm');
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);

            xhr.upload.addEventListener('progress', updateProgress);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert('Archivo subido con éxito.');
                    form.reset();
                    document.getElementById('progressBar').value = 0;
                    document.getElementById('status').innerText = '0%';
                } else {
                    alert('Error al subir el archivo.');
                }
            };

            xhr.send(formData);
        }
    </script>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Configuración de la base de datos MySQL
    $host = 'localhost';
    $db = 'latinbat_peru';
    $user = 'latinbattle';
    $pass = 'H8opgZWQrs0dgt7a';

    // Conexión a la base de datos
    $conn = new mysqli($host, $user, $pass, $db);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener datos del formulario
    $usuario = $_POST['usuario'];
    $nombreArchivo = $_FILES['file']['name'];
    $tamano = $_FILES['file']['size'];
    $tipoArchivo = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
    $categoria = $_POST['categoria']; // Obtener la categoría seleccionada del combobox

    // Carpeta de destino
    $uploadFolder = 'C:/Games/Warcraft III/Maps/Download/';

    // Verificar si se seleccionó un archivo válido
    $allowedExtensions = ['w3x', 'w3m'];
    if (in_array($tipoArchivo, $allowedExtensions)) {
        // Generar CRC del archivo
        $crc = hash_file('crc32b', $_FILES['file']['tmp_name']);

        // Verificar si el CRC ya existe en la base de datos
        $query = $conn->prepare("SELECT usuario FROM Maps WHERE crc = ?");
        $query->bind_param('s', $crc);
        $query->execute();
        $result = $query->get_result();
        
        if ($result->num_rows > 0) {
            // El archivo ya fue subido previamente
            $row = $result->fetch_assoc();
            $usuarioPrevio = $row['usuario'];
            echo "<div class='alert'>Archivo ya fue subido anteriormente por $usuarioPrevio.</div>";
            echo "<script>window.location.href = 'ver_subidas.php?crc=$crc';</script>";
        } else {
            // Mover archivo al directorio de destino
            $destino = $uploadFolder . $nombreArchivo;
            if (move_uploaded_file($_FILES['file']['tmp_name'], $destino)) {
                // Insertar información en la base de datos
                $query = $conn->prepare("INSERT INTO Maps (usuario, nombre_archivo, tamano, tipo_archivo, crc, categoria) VALUES (?, ?, ?, ?, ?, ?)");
                $query->bind_param('ssisss', $usuario, $nombreArchivo, $tamano, $tipoArchivo, $crc, $categoria);
                if ($query->execute()) {
                    // Confirmación de subida exitosa
                    echo "<div class='alert success'>Archivo subido con éxito.</div>";
                } else {
                    echo "<div class='alert'>Error al insertar en la base de datos.</div>";
                }
            } else {
                echo "<div class='alert'>Error al mover el archivo al directorio de destino.</div>";
            }
        }
    } else {
        echo "<div class='alert'>Error: Archivo no válido.</div>";
    }

    // Cerrar conexión a la base de datos
    $conn->close();
}
?>
<div class="container">
<p><img src="https://latinbattle.com/wp-content/uploads/2023/03/aa.png" width="335" height="255"></p>
    <h1>Subir Archivos</h1>
    <form id="uploadForm" method="post" enctype="multipart/form-data" onsubmit="event.preventDefault(); uploadFile();">
        <div class="form-group">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>
        <div class="form-group">
            <label for="file">Seleccionar Archivo:</label>
            <input type="file" id="file" name="file" accept=".w3x,.w3m" required>
        </div>
        <div class="form-group">
            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria" required>
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
                <option value="Otros">Otros</option>
            </select>
        </div>
        <div class="progress-container">
            <progress id="progressBar" max="100" value="0"></progress>
            <p id="status">0%</p>
        </div>
        <button type="submit" id="submitBtn">Subir Archivo</button>
    </form>
</div>

<?php include 'footer.php'; ?>
