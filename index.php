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
    <h3 class="m-1" id='titulo'></h3>
    <?php
    require_once('inc_pie.php');
    ?>
<script>
     $.ajax({
                method: 'POST',
                url: 'src/Categorias.php',
                dataType: 'json',
                data: {
                    'accion': 'total',

                },
                success: (data) => {
                    if (data !== null){
                        $('#titulo').text(`Bienvenido a mi contabilidad doméstica, actualmente hay ${data} ${data == 1 ? 'gasto existente' : 'gastos existentes' }.`);
                    } else{
                        $('#mensaje').empty();
                        $('#mensaje').removeClass();
                        $('#mensaje').addClass('p-3 m-3 bg-danger-subtle');
                        $('#mensaje').append('<h3>Ha habido un error a la hora de obtener el total de gastos</h3>');
                        setTimeout(() => {
                            $('#mensaje').empty();
                            $('#mensaje').removeClass();
                        }, 2000)
                    }
                },
                error: () =>{
                    $('#mensaje').empty();
                    $('#mensaje').removeClass();
                    $('#mensaje').addClass('p-3 m-3 bg-danger-subtle');
                    $('#mensaje').append('<h3>Error al conectarse al servidor</h3>');
                    
                }
            })
</script>
</body>

</html>