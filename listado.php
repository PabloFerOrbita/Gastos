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
    <h4 class="mb-5">Has elegido la opción listado</h4>
    <?php
    Inc_cabecera::MostrarLista('SELECT ID, fecha, importe, descripcion FROM gastos ORDER BY fecha DESC');
    require_once('inc_pie.php');
    ?>
    </div>
</body>

</html>