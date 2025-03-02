<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivos - LatinBattle</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function updateProgress(evt) {
            if (evt.lengthComputable) {
                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                document.getElementById('progressBar').value = percentComplete;
                document.getElementById('status').innerText = percentComplete + '%';
            }
        }
    </script>
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
<?php include 'header.php'; ?>
    <div class="container">
        <h1>Bienvenido a LatinBattle</h1>
        <p>Descubre todo sobre Warcraft 3 Frozen Throne y juega en nuestra comunidad.</p>
        <p><img src="https://latinbattle.com/wp-content/uploads/2023/03/aa.png" width="335" height="255"></p>
        <p>Nombre: BOT-PERU</p>
        <p>Explora mapas normales y personalizados para disfrutar de la mejor experiencia.</p>
    </div>
</body>
</html>
