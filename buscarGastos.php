<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="RellenarTabla.js"></script>
    <script src='Mensajes.js'></script>
    <title>Document</title>
</head>

<body>
    <?php
    require_once('inc_cabecera.php');
    ?>
    <div class="m-2">
        <h4 class="mb-3">Has elegido la opción Buscar</h4>


        <form method="GET" id="formulario">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <input type="text" placeholder="Introduce la busqueda..." name="busqueda" id="busqueda" class="form-control"></input>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-danger">Buscar</button>
                </div>
            </div>
        </form><br>

        <div class="container-fluid vh-100">
            <div class="h-50 overflow-auto">
                <div id='mensaje'></div>
                <table class='table table-stripped table-bordered d-none' id='tabla'>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Importe</th>
                            <th>Descripcion</th>
                            <th>Categoria</th>
                            <th>Modificar</th>
                        </tr>
                    <tbody id='cuerpoTabla'>
                    </tbody>
                    </thead>
                </table>

            </div>
        </div>
    </div>
    <?php
    require_once('inc_pie.php');
    ?>
    <script>
        var categorias = [];
        $('#formulario').on('submit', ((e) => {
            if (jQuery.trim($('#busqueda').val()).length == 0) {
                e.preventDefault();
            } else {

                e.preventDefault();
                $.ajax({
                    method: 'POST',
                    url: 'manejarLLamadas.php',
                    dataType: 'json',
                    data: {
                        'clase': 'gastos',
                        'accion': 'obtener',
                        'filtro': 'descripcion',
                        'valor': $('#busqueda').val(),
                        'join': true


                    },
                    success: data => {
                        $('#cuerpoTabla').empty();
                        if (data.length > 0) {
                            RellenarTabla.rellenarGastos(data, categorias);
                        } else {
                            Mensajes.mensajeAdvertencia('No existen gastos con esa descripción')
                        }
                    },
                    error: () => {
                        Mensajes.mensajeError('Error al conectarse al servidor');

                    }

                });
            }
            $('#busqueda').val('');
        }));
    </script>
</body>

</html>