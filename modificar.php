<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    require_once('inc_cabecera.php');
    require_once('inc_pie.php');
    Inc_cabecera::cabecera();
    ?>
    <?php
    if (isset($_GET['descripcion'])) {
        $registro = Inc_cabecera::recibirRegistro($_GET['descripcion']);
       
    }
    Inc_pie::pie();
    ?>
</body>

</html>