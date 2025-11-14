<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            margin: 0 auto;
            font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        body{
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 15px;
            background-color: bisque;
        }
    </style>
</head>
<body>
    <h1>Bienvenido <?php echo $_SESSION['nombreUsuario'];?> </h1>
    <a href="./index.html">Volver al login</a>
</body>
</html>