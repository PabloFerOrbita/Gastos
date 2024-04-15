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
    if(isset($_POST['editar'])){
        echo Inc_cabecera::actualizarRegistro('UPDATE gastos SET fecha = "' . $_POST['fecha'] . '", descripcion = "' . implode(" ", explode("+", $_POST['descripcion'])) . '", categoria = "' . $_POST['categoria'] . '", importe = ' . $_POST['importe'] . ' WHERE descripcion like "' . implode(" ", explode("+", $_POST['editar'])). '"' );
    }
    if (isset($_GET['descripcion']) || isset($_POST['descripcion'])) {
        $registro = Inc_cabecera::recibirRegistro($_POST['descripcion'] ?? $_GET['descripcion']  );
        if ( count($registro) > 0){
        echo '<form method="POST">';
        echo '<label for="descripcion">Descripcion del gasto</label><br>';
        echo '<textarea id="descripcion" name="descripcion">' . $registro[0]['descripcion'] . '</textarea><br><br>';
        echo '<label for="importe">Importe del gasto</label><br>';
        echo '<input type="number" name="importe" id="importe" min="0" step="any" value=' . doubleval($registro[0]['importe'])  . '></input><br><br>';
        echo '<label for="fecha">Fecha del gasto</label><br>';
        echo '<input type="date" name="fecha" id="fecha" value="' .  $registro[0]['fecha'] . '"></input><br><br>';
        echo '<label for="categoria">Categoria del gasto</label><br>';
        echo '<input type="text" name="categoria" id="categoria" value=' . $registro[0]['categoria'] .  '></input><br><br>';
        echo '<input type="hidden" name="editar" id="editar" value="' . $registro[0]['descripcion'] . '"/>';
        echo '<button type="submit">Guardar</button>';}
        else{
            echo 'El registro no existe';
        }
    }
    Inc_pie::pie();
    ?>
</body>

</html>