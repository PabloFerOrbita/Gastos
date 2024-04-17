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
    require_once('inc_cabecera.php');

    ?>
    <?php
    if (isset($_POST['editar'])) {
        echo Inc_cabecera::actualizarRegistro('UPDATE gastos SET fecha = "' . $_POST['fecha'] . '", descripcion = "' . implode(" ", explode("+", $_POST['descripcion'])) . '", categoria = "' . $_POST['categoria'] . '", importe = ' . $_POST['importe'] . ' WHERE ID = ' . $_POST['editar']);
    }
    if (isset($_GET['ID'])) {
        $registro = Inc_cabecera::recibirRegistro($_GET['ID']);
        if (count($registro) > 0) {
            echo '<form method="POST">';
            echo '<label for="descripcion">Descripcion del gasto</label><br>';
            echo '<textarea id="descripcion" name="descripcion" required>' . $registro[0]['descripcion'] . '</textarea><br><br>';
            echo '<label for="importe" required>Importe del gasto</label><br>';
            echo '<input type="number" name="importe" id="importe" min="0.01" max="99999999" step="0.01"  value=' . doubleval($registro[0]['importe'])  . ' required></input><br><br>'; //TODO cambiar step any a 0.01, poner maximo de 8 cifras
            echo '<label for="fecha">Fecha del gasto</label><br>';
            echo '<input type="date" name="fecha" id="fecha" value="' .  $registro[0]['fecha'] . '" required></input><br><br>';
            echo '<label for="categoria">Categoria del gasto</label><br>';
            echo '<input type="text" name="categoria" id="categoria" value=' . $registro[0]['categoria'] .  ' required></input><br><br>';
            echo '<input type="hidden" name="editar" id="editar" value="' . $registro[0]['ID'] . '"/>';
            echo '<button type="submit">Guardar</button>';
        } else {
            echo 'El registro no existe';
        }
    }
    require_once('inc_pie.php');
    ?>
    <script>
        $('#fecha').on('blur', (e)=>{
            !e.target.checkValidity() && $(e.target).val(<?= json_encode($registro[0]['fecha']) ?>); 
        })
    </script>
</body>

</html>