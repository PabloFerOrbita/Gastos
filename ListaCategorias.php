<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="RellenarTabla.js"></script>
    <title>Document</title>
</head>

<body>
    <?php
    require_once('inc_cabecera.php');
    ?>
    <div class="m-2">
        <h4 class="mb-5">Has elegido la opción Categorias</h4>
        <div id="mensaje"></div>
        <div class="container-fluid vh-100">
            <a class="btn btn-primary mb-3" href="nuevaCategoria.php">Crear Categoria</a>
            <div class="h-50 overflow-auto">
                <div class="container-fluid vh-100">
                    <div class="h-50 overflow-auto">
                        <div id='mensaje'></div>
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
                    url: 'src/Categorias.php',
                    dataType: 'json',
                    data: {
                        'accion': 'obtener'

                    },
                    success: (data) => {
                        RellenarTabla.RellenarCategorias(data);
                        $('.eliminar').on('click', eliminar);
                    },
                    error: () => {
                        $('#tabla').addClass('d-none');
                        $('#mensaje').empty();
                        $('#mensaje').removeClass();
                        $('#mensaje').addClass('p-3 m-3 bg-danger-subtle');
                        $('#mensaje').append('<h3>Error al conectarse al servidor</h3>');


                    }
                })



                function eliminar(e) {
                    $.ajax({
                        method: 'POST',
                        url: 'src/Categorias.php',
                        dataType: 'json',
                        data: {
                            'accion': 'eliminar',
                            'id': e.target.id

                        },
                        success: (data) => {
                            if (data) {
                                $(`#fila${e.target.id}`).remove();
                                $('#mensaje').empty();
                                $('#mensaje').removeClass();
                                $('#mensaje').addClass('p-3 m-3 bg-success-subtle');
                                $('#mensaje').append('<h3>Se ha eliminado la categoría</h3>');
                                setTimeout(() => {
                                    $('#mensaje').empty();
                                    $('#mensaje').removeClass();
                                }, 2000)
                            } else {
                                $('#mensaje').empty();
                                $('#mensaje').removeClass();
                                $('#mensaje').addClass('p-3 m-3 bg-danger-subtle');
                                $('#mensaje').append('<h3>Ha habido un error a la hora de eliminar la categoría</h3>');
                                setTimeout(() => {
                                    $('#mensaje').empty();
                                    $('#mensaje').removeClass();
                                }, 2000)

                            }
                        },
                        error: () => {
                            $('#mensaje').empty();
                            $('#mensaje').removeClass();
                            $('#mensaje').addClass('p-3 m-3 bg-danger-subtle');
                            $('#mensaje').append('<h3>Error al conectarse al servidor</h3>');
                            setTimeout(() => {
                                $('#mensaje').empty();
                                $('#mensaje').removeClass();
                            }, 2000)

                        }
                    })
                }
            </script>
            <?php

            require_once('inc_pie.php');
            ?>
</body>

</html>