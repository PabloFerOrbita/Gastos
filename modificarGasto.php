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
    <div class="vh-100">
        <div id='mensaje'></div>
        <div class="container-fluid d-flex flex-row justify-content-center align-items-center h-50">
            <div class="col-3 border border-2 p-5 border-danger">
                <form method="POST" id='formulario'>
                    <div class="mb-3 row g-2 ">
                        <div class="col-6">
                            <label for="fecha" class="form-label">Fecha del gasto</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" required></input>
                        </div>
                        <div class="col-6">
                            <label for="importe" class="form-label" required>Importe del gasto</label>
                            <input type="number" name="importe" min="0.01" id="importe" max="99999999" step="0.01" class="form-control" required></input>
                        </div>

                    </div>
                    <div class="mb-3 row g-2">
                        <div class="col-12">
                            <label for="descripcion" class="form-label">Descripcion del gasto</label>
                            <input type="text" id="descripcion" name="descripcion" class="form-control" pattern="^[^\s]+.*$" required></input>
                        </div>
                    </div>

                    <div class="mb-3 row g-2">
                        <div class="col-12">
                            <label for="categoria" class="form-label">Categoria del gasto</label><br>
                            <select name="categoria" id="categoria" class="form-control " required>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-danger w-100">Guardar</button>
                    </div>
                </form>

            </div>

        </div>
    </div>

    </div>
    </div>
    </div>
    <?php
    require_once('inc_pie.php');
    ?>


    <script>
        var numero = 0;
        var fecha = '';
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

                },
                success: data => {
                    data.forEach(element => {
                        $('#categoria').append(`<option value=${element.id}>${element.nombre}</option>`);
                    });
                }
            });
            $.ajax({
                method: 'POST',
                url: 'src/Gastos.php',
                dataType: 'json',
                data: {
                    'accion': 'obtener_gasto',
                    'id': id

                },
                success: data => {
                    if (data.length > 0) {
                        numero = data[0].numero;
                        fecha = data[0].fecha;
                        $('#fecha').val(data[0].fecha);
                        $('#importe').val(data[0].importe);
                        $('#descripcion').val(data[0].descripcion);
                        $('#categoria').val(data[0].categoria_id);



                    } else {
                        $('#cuerpo').empty();
                        $('#cuerpo').append('<div class="col-3 p-5 text-center"><h4>El registro no existe</h4></div>')
                    }
                },
                error: () => {
                    $('#cuerpo').empty();
                    $('#mensaje').empty();
                    $('#mensaje').removeClass();
                    $('#mensaje').addClass('p-3 m-3 bg-danger-subtle');
                    $('#mensaje').append('<h3>Error al conectarse al servidor</h3>');


                }
            });

        } else {
            $('#cuerpo').empty();
            $('#cuerpo').append('<div class="col-3 p-5 text-center"><h4>El registro no existe</h4></div>')
        }

        $('#fecha').on('blur', (e) => {
            !e.target.checkValidity() && $(e.target).val(fecha);
        })

        $('#importe').on('input', (e) => {
            if (!e.target.checkValidity()) {
                if (($(e.target).val() === '' && !e.target.validity.badInput)) {
                    $(e.target).val('');
                } else if ($(e.target).val() != '0' && $(e.target).val() != '0.0') {
                    $(e.target).val(numero);
                }
            }
            numero = $(e.target).val();

        })

        $('#importe').on('blur', (e) => {
            $(e.target).val() == 0 && $(e.target).val(0.01);
        })

        $('#formulario').on('submit', (e) => {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: 'src/Gastos.php',
                dataType: 'json',
                data: {
                    'accion': 'actualizar',
                    'datos': {
                        'fecha': $('#fecha').val(),
                        'importe': $('#importe').val(),
                        'descripcion': $('#descripcion').val(),
                        'categoria_id': $('#categoria').val()
                    },
                    'filtro': 'id',
                    'valor': id

                },
                success: (data) => {
                    if (data !== null) {
                        if (data) {
                            $('#mensaje').empty();
                            $('#mensaje').removeClass();
                            $('#mensaje').addClass('p-3 m-3 bg-success-subtle');
                            $('#mensaje').append('<h3>Se han actualizado los datos</h3>');
                            setTimeout(() => {
                                $('#mensaje').empty();
                                $('#mensaje').removeClass();
                            }, 2000)

                        } else {
                            $('#mensaje').empty();
                            $('#mensaje').removeClass();
                            $('#mensaje').addClass('p-3 m-3 bg-warning-subtle');
                            $('#mensaje').append('<h3>No se ha actualizado ningún registro</h3>');
                            setTimeout(() => {
                                $('#mensaje').empty();
                                $('#mensaje').removeClass();
                            }, 2000)
                        }
                    } else {
                        $('#mensaje').empty();
                        $('#mensaje').removeClass();
                        $('#mensaje').addClass('p-3 m-3 bg-danger-subtle');
                        $('#mensaje').append('<h3>Ha habido un error a la hora de actualizar los datos</h3>');
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
        });
    </script>
</body>

</html>