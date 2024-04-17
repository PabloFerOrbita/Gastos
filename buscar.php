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
    ?>
    <h4>Has elegido la opción Buscar</h4>
    <?php
    echo '<form method="GET">';
    echo '<input type="text" placeholder="Buscar..." name="busqueda" id="busqueda"></input>';
    echo '<button type="submit">Buscar</button>';
    echo '</form><br>';
    if(isset($_GET['busqueda'])){
        Inc_cabecera::MostrarLista('SELECT * FROM gastos WHERE descripcion like "%' . $_GET['busqueda'] . '%" ORDER BY fecha DESC');
    }
    require_once('inc_pie.php');
    ?>
</body>

</html>