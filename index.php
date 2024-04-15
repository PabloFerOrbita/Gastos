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
    require_once('inc_pie.php');
    Inc_cabecera::cabecera();
    echo '<h3>Bienvenido a mi contabilidad doméstica, actualmente hay ' . Inc_cabecera::contar() . ' gastos existentes';
    Inc_cabecera::insertarBotones();
    Inc_pie::pie();
    ?>
<script>
    $(window).on('load', () =>{
        $('#buscar').on('click', ()=>{window.location.href="buscar.php"});
        $('#listado').on('click', ()=>{window.location.href="listado.php"});
        $('#nuevo').on('click', ()=>{window.location.href="nuevo.php"});
    } )
</script>
</body>

</html>