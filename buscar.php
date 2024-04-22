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
    <div class="m-2">
        <h4 class="mb-3">Has elegido la opción Buscar</h4>
        <?php
        echo '<form method="GET" id="formulario">';
        echo '<div class="row g-3 align-items-center">';
        echo '<div class="col-auto">';
        echo '<input type="text" placeholder="Introduce la busqueda..." name="busqueda" id="busqueda" class="form-control"></input>';
        echo '</div>';
        echo '<div class="col-auto">';
        echo '<button type="submit" class="btn btn-danger">Buscar</button>';
        echo '</div>';
        echo '</div>';
        echo '</form><br>';
        if (isset($_GET['busqueda'])) {
            Inc_cabecera::MostrarLista("SELECT * FROM gastos WHERE descripcion like '%" . str_replace("'", "''", trim($_GET['busqueda'])) . "%' ORDER BY fecha DESC");
        }
        require_once('inc_pie.php');
        ?>
    </div>

    <script>
        $('#formulario').submit((e) => {
            jQuery.trim($('#busqueda').val()).length == 0 && e.preventDefault();
        })
    </script>
</body>

</html>