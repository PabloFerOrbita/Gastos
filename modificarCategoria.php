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
    <div class="vh-100">
        <h4 class="m-2">Has elegido la opción Modificar categoría</h4>
        <div id='mensaje'></div>
        <div class="container-fluid d-flex flex-row justify-content-center align-items-center h-50" id='cuerpo'>
            <div class="col-3 border border-2 p-5 border-danger">
                <form method="POST" id="formulario">
                    <div class="mb-3 row g-2">
                        <div class="col-12">
                            <label for="nombre" class="form-label">Nombre de la categoría</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" pattern="^[^\s]+.*$" required></input>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-danger w-100">Guardar</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
    <?php

    require_once('inc_pie.php');
    ?>
</body>
<script>
    var id = <?php if (isset($_GET['id'])) {
                    echo ($_GET['id']);
                } else {
                    echo 'null';
                } ?>;
    if (id !== null) {
        $.ajax({
            method: 'POST',
            url: 'src/Categorias.php',
            dataType: 'json',
            data: {
                'accion': 'obtener',
                'filtro': 'id',
                'valor': id

            },
            success: data => {
                if (data.length > 0) {
                    $('#nombre').val(data[0].nombre);
                } else {
                    $('#cuerpo').empty();
                    $('#cuerpo').append('<div class="col-3 p-5 text-center"><h4>El registro no existe</h4></div>')
                }
            },
            error: () => {
                $('#cuerpo').empty();
                Mensajes.mensajeError('Error al conectarse al servidor');
            }
        });
    } else {
        $('#cuerpo').empty();
        $('#cuerpo').append('<div class="col-3 p-5 text-center"><h4>El registro no existe</h4></div>')
    }

    $('#formulario').on('submit', (e) => {
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: 'manejarLLamadas.php',
            dataType: 'json',
            data: {
                'clase': 'Categorias',
                'accion': 'actualizar',
                'datos': {
                    'nombre': $('#nombre').val()
                },
                'filtro': 'id',
                'valor': id

            },
            success: (data) => {
                if (data !== null) {
                    if (data) {
                        Mensajes.mensajeExito('Se ha actualizado el registro');

                    } else {
                        Mensajes.mensajeAdvertencia('No se ha actualizado nigún registro');
                    }
                } else {
                    Mensajes.mensajeError('Error a la hora de actualizar el registro');
                }
            },
            error: () => {
                Mensajes.mensajeError('Error al conectarse al servidor');
            }
        })

    })
</script>

</html>