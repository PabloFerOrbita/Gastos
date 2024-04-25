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
        <h4 class="m-2">Has elegido la opción Nuevo</h4>


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
                                <option value="" disabled selected>Elige una opción</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-danger w-100">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        <?php

        require_once('inc_pie.php');
        ?>
    </div>
    <script>
        $.ajax({
            method: 'POST',
            url: 'manejarLLamadas.php',
            dataType: 'json',
            data: {
                'clase': 'Categorias',
                'accion': 'obtener',

            },
            success: data => {
                data.forEach(element => {
                    $('#categoria').append(`<option value=${element.id}>${element.nombre}</option>`);
                });
            }
        })
        var numero = 0.01;

        $('#fecha').on('blur', (e) => {
            !e.target.checkValidity() && $(e.target).val("");
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
            var valores = [];
            $('#formulario').serializeArray().forEach(element => {
                valores.push(element.value);
            })
            $.ajax({
                method: 'POST',
                url: 'manejarLLamadas.php',
                dataType: 'json',
                data: {
                    'clase': 'Gastos',
                    'datos': valores

                },
                success: (data) => {
                    if (data) {
                        $('#formulario').trigger('reset');
                        Mensajes.MensajeExito('Se ha añadido el gasto')
                    } else {
                        Mensajes.MensajeError('Ha habido un error a la hora de añadir el gasto')
                    }
                },
                error: () => {
                    Mensajes.MensajeError('Error al conectarse al servidor')
                }
            })

        })
    </script>
</body>

</html>