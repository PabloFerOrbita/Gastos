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
        <h4 class="mb-5">Has elegido la opción Categorias</h4>
        <div class="container-fluid vh-100">
            <div class="h-50 overflow-auto" id='lista'>

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
                MostrarTabla(data)
            }
        })

        function MostrarTabla(data) {
            let tabla = $('<table class="table table-striped table-bordered">');
            let encabezado = $('<thead>');
            $(encabezado).append('<tr><th>Nombre</th><th>Editar</th><th>Eliminar</th></tr>');
            let cuerpo = $('<tbody>');
            data.forEach(element => {
                let fila = $('<tr>');
                $(fila).append(`<td>${element.nombre.replace('<', '&lt;').replace('>', '&lt;')}</td><td><a class="btn btn-primary" href="modificarCategoria.php?id=${element.id}">Editar</a></td><td><button class="btn btn-danger">Eliminar</button></td>`);
                $(cuerpo).append(fila);
            })

            $(tabla).append(encabezado);
            $(tabla).append(cuerpo);
            $('#lista').append(tabla);
        }
    </script>
</body>

</html>