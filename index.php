<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <?php
    //TODO cambiar la base de datos para tener un id
    //TODO leer documentación del require_once
    //TODO mejorar el front
    //TODO fecha 31/04 por que da error
    //TODO pruebas de todo
    require_once('inc_cabecera.php');
    

    echo '<h3>Bienvenido a mi contabilidad doméstica, actualmente hay ' . Inc_cabecera::contar() . ' gastos existentes</h3><br><br>';

    require_once('inc_pie.php');
    ?>

</body>

</html>