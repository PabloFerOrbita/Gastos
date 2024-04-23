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
    <div class="vh-100" >
        <div class="container-fluid d-flex flex-row justify-content-center align-items-center h-50" id='cuerpo'>
        </div>
    </div>
</body>
<script>
    var id = <?php if (isset($_GET['id'])) {
                    echo ($_GET['id']);
                } else {
                    echo 'null';
                } ?>;
    if (id !== null) {
        $.ajax({
            method: 'POST',
            url: 'src/Categorias.php',
            dataType: 'json',
            data: {
                'accion': 'obtener',
                'filtro': 'id',
                'valor': id

            },
            success: data => {
                if (data > 0) {

                } else {
                    $('#cuerpo').append('<div class="col-3 p-5 text-center"><h4>El registro no existe</h4></div>')
                }
            }
        });
    } else {
        $('#cuerpo').append('<div class="col-3 p-5 text-center"><h4>El registro no existe</h4></div>')
    }
</script>

</html>