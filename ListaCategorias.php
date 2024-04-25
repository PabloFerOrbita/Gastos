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
        <h4 class="mb-5">Has elegido la opción Categorias</h4>
        <div class="container-fluid vh-100">
            <a class="btn btn-primary mb-3" href="nuevaCategoria.php">Crear Categoria</a>
            <div class="h-50 overflow-auto">
                <div id="mensaje"></div>

                <table class='table table-stripped table-bordered d-none' id='tabla'>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    <tbody id='cuerpoTabla'>
                    </tbody>
                    </thead>
                </table>

            </div>

        </div>
    </div>

    <script>
        $.ajax({
            method: 'POST',
            url: 'manejarLLamadas.php',
            dataType: 'json',
            data: {
                'clase': 'categorias',
                'accion': 'obtener',
                'filtro':'',
                'valor':'',

            },
            success: (data) => {
                RellenarTabla.RellenarCategorias(data);
                $('.eliminar').on('click', eliminar);
            },
            error: () => {
                $('#tabla').addClass('d-none');
                Mensajes.MensajeError('Error al conectarse al servidor');


            }
        })



        function eliminar(e) {
            $.ajax({
                method: 'POST',
                url: 'manejarLLamadas.php',
                dataType: 'json',
                data: {
                    'clase': 'categorias',
                    'accion': 'eliminar',
                    'id': e.target.id

                },
                success: (data) => {
                    if (data) {
                        $(`#fila${e.target.id}`).remove();
                        Mensajes.MensajeExito('Categoría eliminada');
                    } else {
                        Mensajes.MensajeError('Error al eliminar la categoría')

                    }
                },
                error: () => {
                    Mensajes.MensajeError('Error al conectarse al servidor');
                }
            })
        }
    </script>
    <?php

    require_once('inc_pie.php');
    ?>


</body>

</html>