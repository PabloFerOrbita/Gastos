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
 
    ?>
    <h4>Has elegido la opción listado</h4>
    <?php
    Inc_cabecera::MostrarLista('SELECT fecha, importe, descripcion FROM gastos ORDER BY fecha DESC');
    Inc_pie::pie();
    ?>
</body>

</html>