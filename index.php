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
    $cuenta = Inc_cabecera::contar();
    
    echo '<h3 class="m-1">Bienvenido a mi contabilidad doméstica, actualmente hay ' . $cuenta;
    if($cuenta != 1){
        echo ' gastos existentes';
    } else{
        echo ' gasto existente';
    }
    echo '</h3>';


    require_once('inc_pie.php');
    ?>

</body>

</html>