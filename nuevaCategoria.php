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

        <h4 class="m-2">Has elegido la opción Nueva categoría</h4>
        <div id='mensaje'></div>
        <div class="container-fluid d-flex flex-row justify-content-center align-items-center h-50">
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
        <script>
            $('#formulario').on('submit', (e) => {
                e.preventDefault();
                var valores = [];
                $('#formulario').serializeArray().forEach(element => {
                    valores.push(element.value);
                })
                $.ajax({
                    method: 'POST',
                    url: 'src/Categorias.php',
                    dataType: 'json',
                    data: {
                        'accion': 'aniadir',
                        'datos': valores

                    },
                    success: (data) => {
                        if (data) {
                            $('#formulario').trigger('reset');
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
                            $('#mensaje').addClass('p-3 m-3 bg-danger-subtle');
                            $('#mensaje').append('<h3>Ha habido un error a la hora de actualizar los datos</h3>');
                            setTimeout(() => {
                                $('#mensaje').empty();
                                $('#mensaje').removeClass();
                            }, 2000)
                        }
                    }
                })
            })
        </script>
        <?php
        require_once('inc_pie.php')
        ?>
</body>

</html>