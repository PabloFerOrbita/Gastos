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
    <h4>Has elegido la opción Nuevo</h4>
    <?php
    if(isset($_GET['descripcion']) && isset($_GET['categoria']) && isset($_GET['fecha']) && isset($_GET['importe'])){
        echo Inc_cabecera::insertar('INSERT INTO gastos VALUES ("' . $_GET['fecha'] . '", ' . $_GET['importe'] . ', "' . $_GET['categoria'] .'", "' . $_GET['descripcion'] .  '")' );
    }
    echo '<form method="GET">';
    echo '<label for="descripcion">Descripcion del gasto</label><br>';
    echo '<textarea id="descripcion" name="descripcion"></textarea><br><br>';
    echo '<label for="importe">Importe del gasto</label><br>';
    echo '<input type="number" name="importe" id="importe" min="0" step="any"></input><br><br>';
    echo '<label for="fecha">Fecha del gasto</label><br>';
    echo '<input type="date" name="fecha" id="fecha"></input><br><br>';
    echo '<label for="categoria">Categoria del gasto</label><br>';
    echo '<input type="text" name="categoria" id="categoria"></input><br><br>';
    echo '<button type="submit">Guardar</button>';
    Inc_pie::pie();
    ?>
</body>

</html>