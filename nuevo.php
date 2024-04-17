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
    if(isset($_POST['descripcion']) && isset($_POST['categoria']) && isset($_POST['fecha']) && isset($_POST['importe'])){
        echo Inc_cabecera::insertar('INSERT INTO gastos VALUES ("' . $_POST['fecha'] . '", ' . $_POST['importe'] . ', "' . $_POST['descripcion'] .'", "' . $_POST['categoria'] .  '")' );
    }
    echo '<form method="POST">';
    echo '<label for="descripcion">Descripcion del gasto</label><br>';
    echo '<textarea id="descripcion" name="descripcion" required></textarea><br><br>';
    echo '<label for="importe" required>Importe del gasto</label><br>';
    echo '<input type="number" name="importe" id="importe"  max="99999999" step="0.01" required></input><br><br>';
    echo '<label for="fecha">Fecha del gasto</label><br>';
    echo '<input type="date" name="fecha" id="fecha" required></input><br><br>';
    echo '<label for="categoria">Categoria del gasto</label><br>';
    echo '<input type="text" name="categoria" id="categoria" required></input><br><br>';
    echo '<button type="submit">Guardar</button>';
    Inc_pie::pie();
    ?>
</body>

</html>