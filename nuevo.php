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
        <h4 class="m-2">Has elegido la opción Nuevo</h4>
        <?php

        if (isset($_POST['descripcion']) && isset($_POST['categoria']) && isset($_POST['fecha']) && isset($_POST['importe'])) {
            echo Inc_cabecera::insertar("INSERT INTO gastos VALUES (NULL, '" . $_POST['fecha'] . "', " . $_POST['importe'] . ", '" . str_replace("'", "''", $_POST['descripcion']) . "', '" . $_POST['categoria'] .  "')");
        }

        echo '<div class="container-fluid d-flex flex-row justify-content-center align-items-center h-50">';
        echo '<div class="col-3 border border-2 p-5 border-danger">';
        echo '<form method="POST">';
        echo '<div class = "mb-3 row g-2">';
        echo '<div class="col-12">';
        echo '<label for="descripcion" class="form-label">Descripcion del gasto</label>';
        echo '<input type ="text" id="descripcion" name="descripcion" class="form-control" pattern="^[^\s]+.*$" required></input>';
        echo '</div>';
        echo '</div>';
        echo '<div class= "mb-3 row g-2 ">';
        echo '<div class="col-6">';
        echo '<label for="importe" class="form-label" required>Importe del gasto</label>';
        echo '<input type="number" name="importe" min="0.01" id="importe"  max="99999999" step="0.01" class="form-control" required></input>';
        echo '</div>';
        echo '<div class ="col-6">';
        echo '<label for="categoria" class="form-label">Categoria del gasto</label><br>';
        echo '<select name="categoria" id="categoria" class="form-control " required>
    <option value=""  disabled selected >Elige una opción</option>
    </select>';
        echo '</div>';
        echo '</div>';
        echo '<div class ="mb-3 row g-2">';
        echo '<div class = "col-12">';
        echo '<label for="fecha" class="form-label">Fecha del gasto</label>';
        echo '<input type="date" name="fecha" id="fecha" class="form-control" required></input>';
        echo '</div>';
        echo '</div>';
        echo '<div class="col-12">';
        echo '<button type="submit" class="btn btn-danger w-100">Guardar</button>';
        echo '</div>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        require_once('inc_pie.php');
        ?>
    </div>
    <script>
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
    </script>
</body>

</html>