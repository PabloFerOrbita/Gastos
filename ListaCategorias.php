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
                'filtro': '',
                'valor': '',

            },
            success: (data) => {
                RellenarTabla.rellenarCategorias(data);
                $('.eliminar').click(comprobarGastoRelacionado);
            },
            error: () => {
                $('#tabla').addClass('d-none');
                Mensajes.mensajeError('Error al conectarse al servidor');


            }
        })

        function comprobarGastoRelacionado(e) {
            $.ajax({
                method: 'POST',
                url: 'manejarLLamadas.php',
                dataType: 'json',
                data: {
                    'clase': 'gastos',
                    'accion': 'obtener',
                    'filtro': 'categoria_id',
                    'valor': e.target.id,

                },
                success: (data) => {
                    data.length == 0 ? eliminar(e.target.id) : Mensajes.mensajeAdvertencia('La categoría no se puede borrar: hay gastos que la tienen'); 
                }
            });
        }

        function eliminar(id) {

            $.ajax({
                method: 'POST',
                url: 'manejarLLamadas.php',
                dataType: 'json',
                data: {
                    'clase': 'categorias',
                    'accion': 'eliminar',
                    'id': id

                },
                success: (data) => {
                    if (data) {
                        $(`#fila${id}`).remove();
                        Mensajes.mensajeExito('Categoría eliminada');
                    } else {
                        Mensajes.mensajeError('Error al eliminar la categoría')

                    }
                },
                error: () => {
                    Mensajes.mensajeError('Error al conectarse al servidor');
                }
            })
        }
    </script>
    <?php

    require_once('inc_pie.php');
    ?>


</body>

</html>