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
            url: 'src/Categorias.php',
            dataType: 'json',
            data: {
                'accion': 'total'
            },
            success: (data) => {
                if (data !== null) {
                    categorias = data;
                    $.ajax({
                        method: 'POST',
                        url: 'src/Gastos.php',
                        dataType: 'json',
                        data: {
                            'accion': 'total',

                        },
                        success: (data) => {
                            if (data !== null) {
                                $('#titulo').text(`Bienvenido a mi contabilidad doméstica, actualmente existen ${data} ${data == 1 ? 'gasto' : 'gastos' } y ${categorias} ${categorias == 1 ? 'categoria' : 'categorias' } .`);
                            } else {
                                Mensajes.MensajeError('Ha habido un error a la hora de contar los gastos');
                            }
                        },
                        error: () => {
                            Mensajes.MensajeError('Error al conectarse al servidor');

                        }


                    });
                } else {
                    Mensajes.MensajeError('Ha habido un error a la hora de contar las categorías');
                }
            },
            error: () => {
                Mensajes.MensajeError('Error al conectarse al servidor');
            }


        });
    </script>
</body>

</html>