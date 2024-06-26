<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="Mensajes.js"></script>
    <title>Document</title>
</head>

<body>
    <?php
    require_once('inc_cabecera.php');
    ?>
    <h3 class="m-1" id='titulo'></h3>
    <div id='mensaje'></div>
    <?php
    require_once('inc_pie.php');
    ?>
    <script>
        var categorias;
        $.ajax({
            method: 'POST',
            url: 'manejarLLamadas.php',
            dataType: 'json',
            data: {
                'clase': 'Categorias',
                'accion': 'total'
            },
            success: (data) => {
                if (data !== null) {
                    categorias = data;
                    $.ajax({
                        method:'POST',
                        url: 'manejarLLamadas.php',
                        dataType: 'json',
                        data: {
                            'clase': 'Gastos',
                            'accion': 'total',

                        },
                        success: (data) => {
                            if (data !== null) {
                                $('#titulo').text(`Bienvenido a mi contabilidad doméstica, actualmente existen ${data} ${data == 1 ? 'gasto' : 'gastos' } y ${categorias} ${categorias == 1 ? 'categoria' : 'categorias' } .`);
                            } else {
                                Mensajes.mensajeError('Ha habido un error a la hora de contar los gastos');
                            }
                        },
                        error: () => {
                            Mensajes.mensajeError('Error al conectarse al servidor');

                        }


                    });
                } else {
                    Mensajes.mensajeError('Ha habido un error a la hora de contar las categorías');
                }
            },
            error: () => {
                Mensajes.mensajeError('Error al conectarse al servidor');
            }


        });
    </script>
</body>

</html>