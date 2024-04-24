<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="RellenarTabla.js"></script>
    <script src="Mensajes.js"></script>
    <title>Document</title>
</head>

<body>
    <?php
    require_once('inc_cabecera.php');
    ?>
    <div class="m-2">
        <h4 class="mb-5">Has elegido la opción Listado</h4>
        <div class="container-fluid vh-100">
            <div class="h-50 overflow-auto">
                <div id='mensaje'></div>
                <table class='table table-stripped table-bordered d-none' id='tabla'>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Importe</th>
                            <th>Descripcion</th>
                            <th>Modificar</th>
                        </tr>
                    <tbody id='cuerpoTabla'>
                    </tbody>
                    </thead>
                </table>
                <?php
                require_once('inc_pie.php');
                ?>
            </div>
        </div>
    </div>
    <script>
        $.ajax({
            method: 'POST',
            url: 'src/Gastos.php',
            dataType: 'json',
            data: {
                'accion': 'obtener_todos',

            },
            success: (data) => {

                if (data.length > 0) {
                    RellenarTabla.RellenarGastos(data)
                } else {
                    Mensajes.MensajeAdvertencia('No hay datos')
                }
            },
            error: () => {
                Mensajes.MensajeError('Error al conectarse al servidor');

            }
        })
    </script>
</body>

</html>