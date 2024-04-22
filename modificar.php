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
        <?php
        if (isset($_POST['editar'])) {
            echo Inc_cabecera::actualizarRegistro('UPDATE gastos SET fecha = "' . $_POST['fecha'] . '", descripcion = "' . implode(" ", explode("+", $_POST['descripcion'])) . '", categoria = "' . $_POST['categoria'] . '", importe = ' . $_POST['importe'] . ' WHERE ID = ' . $_POST['editar']);
        }
        if (isset($_GET['ID'])) {
            $registro = Inc_cabecera::recibirRegistro($_GET['ID']);
            echo '<div class="container-fluid d-flex flex-row justify-content-center align-items-center h-50">';

            if (count($registro) > 0) {
                echo '<div class="col-3 border border-2 p-5 border-danger">';
                echo '<form method="POST">';
                echo '<div class = "mb-3 row g-2">';
                echo '<div class="col-12">';
                echo '<label for="descripcion" class="form-label">Descripcion del gasto</label>';
                echo '<textarea id="descripcion" name="descripcion" class="form-control" required>' .  $registro[0]['descripcion'] . '</textarea>';
                echo '</div>';
                echo '</div>';
                echo '<div class= "mb-3 row g-2 ">';
                echo '<div class="col-6">';
                echo '<label for="importe" class="form-label" required>Importe del gasto</label>';
                echo '<input type="number" name="importe" min="0.01" id="importe"  max="99999999" step="0.01" class="form-control" value=' . doubleval($registro[0]['importe'])  . ' required></input>';
                echo '</div>';
                echo '<div class ="col-6">';
                echo '<label for="categoria" class="form-label">Categoria del gasto</label><br>';
                echo '<select name="categoria" id="categoria" class="form-control " required>
        <option value=""  disabled selected >Elige una opción</option>
        <option value="Telefono">Telefono</option>
        <option value="Ocio">Ocio</option>
        </select>';
                echo '<input type="hidden" name="editar" id="editar" value="' . $registro[0]['ID'] . '"/>';
                echo '</div>';
                echo '</div>';
                echo '<div class ="mb-3 row g-2">';
                echo '<div class = "col-12">';
                echo '<label for="fecha" class="form-label">Fecha del gasto</label>';
                echo '<input type="date" name="fecha" id="fecha" class="form-control" value="' .  $registro[0]['fecha'] . '"  required></input>';
                echo '</div>';
                echo '</div>';
                echo '<div class="col-12">';
                echo '<button type="submit" class="btn btn-danger w-100">Guardar</button>';
                echo '</div>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="col-3 p-5 text-center">';
                echo '<h4>El registro no existe</h4>';
            }
        }
        ?>
    </div>
    </div>
    </div>
    <?php
    require_once('inc_pie.php');
    ?>


    <script>
        var numero = <?= $registro[0]['importe'] ?>;
        $('#fecha').on('blur', (e) => {
            !e.target.checkValidity() && $(e.target).val(<?= json_encode($registro[0]['fecha']) ?>);
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

        $('#categoria').val(<?= json_encode($registro[0]['categoria']) ?>)
    </script>
</body>

</html>