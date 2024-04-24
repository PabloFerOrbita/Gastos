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
        $.ajax({
            method: 'POST',
            url: 'src/Categorias.php',
            dataType: 'json',
            data: {
                'accion': 'obtener',


            },
            success: (data) => {
                categorias = data;

            }
        })
        $('#formulario').on('submit', ((e) => {
            if (jQuery.trim($('#busqueda').val()).length == 0) {
                e.preventDefault();
            } else {

                e.preventDefault();
                $.ajax({
                    method: 'POST',
                    url: 'src/Gastos.php',
                    dataType: 'json',
                    data: {
                        'accion': 'obtener',
                        'filtro': 'descripcion',
                        'valor': $('#busqueda').val()


                    },
                    success: data => {
                        $('#cuerpoTabla').empty();
                        if (data.length > 0) {

                            MostrarTabla(data);
                        } else {
                            $('#tabla').addClass('d-none');
                            $('#mensaje').empty();
                            $('#mensaje').removeClass();
                            $('#mensaje').addClass('p-3 m-3 bg-danger-subtle');
                            $('#mensaje').append('<h3>No se ha obtenido ningún dato</h3>');
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

                    }

                });
            }
            $('#busqueda').val('');
        }));




        async function MostrarTabla(data) {
            data = data.sort((a, b) => {
                return new Date(b.fecha) - new Date(a.fecha)
            });
            data.forEach(element => {
                categoria = categorias.find(categoria => categoria.id == element.categoria_id)
                let fila = $('<tr>');
                $(fila).append(`<td>${AMDaDMA(element.fecha)}</td><td>${element.importe}€</td><td>${element.descripcion.replaceAll('<', '&lt;').replaceAll('>', '&gt;')}</td><td>${categoria.nombre}</td><td><a type="button" class="btn btn-primary" href="modificar.php?ID=${element.id}">Modificar</a></td>`)
                $('#cuerpoTabla').append(fila);
            })
            $('#tabla').removeClass('d-none');

        }

        function AMDaDMA(fecha) {
            return fecha.split('-').reverse().join('-');
        }
    </script>
</body>

</html>