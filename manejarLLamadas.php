<?php
require_once('src/Gastos.php');
require_once('src/Categorias.php');

try {
    $reflectionClass = new ReflectionClass($_POST['clase']);
    $clase = $reflectionClass->newInstanceArgs();
    switch ($_POST['accion']) {
        case 'obtener':
            echo json_encode($clase->obtener(($_POST['filtro'] ?? ''), ($_POST['valor'] ?? ''), ($_POST['join'] ?? false)));
            break;
        case 'eliminar':
            if (isset($_POST['id'])) {
                echo json_encode($clase->eliminar($_POST['id']));
            } else {
                echo json_encode('Error: se debe especificar un id');
            }
            break;
        case 'actualizar':
            if (isset($_POST['datos']) && isset($_POST['filtro']) && isset($_POST['valor'])) {
                echo json_encode($clase->actualizar($_POST['datos'], $_POST['filtro'], $_POST['valor']));
            } else {
                echo json_encode('Error: no se han introducido datos');
            }
            break;
        case 'aniadir':
            if (isset($_POST['datos'])) {
                echo json_encode($clase->aniadir($_POST['datos']));
            } else {
                echo json_encode('Error: no se han introducido datos');
            }
            break;
        case 'total':
            echo json_encode($clase->total());
            break;
        default:
            echo json_encode('La acción no existe');
    }
} catch (ReflectionException $e) {
    echo json_encode('La clase ' . $_POST['clase'] .  ' no existe');
}
