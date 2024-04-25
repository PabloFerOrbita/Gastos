<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>



    <header class="bg-danger p-2">
        <a id="inicio" class="btn btn-link text-white" href="index.php">Inicio</a>
        <a id="buscar" class="btn btn-link text-white" href="buscarGastos.php">Buscar</a>
        <a id="listado" class="btn btn-link text-white" href="listaGastos.php">Gastos</a>
        <a id="nuevo" class="btn btn-link text-white" href="nuevoGasto.php">Nuevo Gasto</a>
        <a id="categorias" class="btn btn-link text-white" href="ListaCategorias.php">Categorias</a>

        <h1 class="text-white" id='titulo-cabecera'></h1>
    </header>
    <?php
    class Inc_cabecera
    {
        static $tabla = 'gastos';


        static function conectar()
        {
            $servidor = 'localhost';
            $usuario = 'root';
            $contrasenia = '';
            $bd = 'contab';
            try {
                $conexion = new PDO('mysql:host=' . $servidor . '; dbname=' . $bd, $usuario, $contrasenia);
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conexion;
            } catch (PDOException $e) {
                echo '<div class="p-3 m-3 bg-danger-subtle"><h3>Error al conectarse al servidor</h3></div> ';
                die;
            }
        }
        static function MostrarLista($sql)
        {
            $con = self::conectar();
            $query = $con->prepare($sql);
            $query->execute();
            $gastos = $query->fetchAll();
            if (count($gastos) > 0) {
                echo '<table class="table table-striped table-bordered">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Fecha</th><th>Importe</th><th>Descripcion</th>';
                if (array_key_exists('categoria', $gastos[0])) {
                    echo '<th>Categoria</th>';
                }
                echo '<th>Modificar</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach ($gastos as $gasto) {
                    echo '<tr><td> ' . self::AMDaDMA($gasto['fecha']) . ' </td><td> ' . $gasto['importe'] . ' </td><td> ' . str_replace('<', '&lt;', str_replace('>', '&gt;', $gasto['descripcion'])) . ' </td>';
                    if (array_key_exists('categoria', $gasto)) {
                        echo '<td> ' . str_replace('<', '&lt;', str_replace('>', '&gt;', $gasto['categoria'])) . ' </td>';
                    }
                    echo '<td> <a type="button" href="modificar.php?ID=' . $gasto['id'] . '">Modificar</a> </td></tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<h4>No se han encontrado registros</h4>';
            }
        }

        /**
         * Contar datos
         * 
         * @return int
         */
        static function contar(): int
        {
            $con = self::conectar();
            $query = $con->prepare('SELECT COUNT(*) FROM gastos');
            $query->execute();
            $numero =  $query->fetchColumn();
            return $numero;
        }

        static function recibirRegistro($ID)
        {
            $con = self::conectar();
            $query = $con->prepare('SELECT * FROM gastos WHERE id = ' . $ID);
            try {
                $query->execute();
                $registro = $query->fetchAll();
                return $registro;
            } catch (PDOException $e) {
                return array();
            }
        }

        static function insertar($sql)
        {
            $con = self::conectar();
            $query = $con->prepare($sql);
            try {
                $query->execute();
                $con = null;
                
                return '<div class="p-3 m-3 bg-success-subtle"><h3>Se han guardado los datos correctamente</h3></div>';
            } catch (PDOException $e) {
                return '<div class="p-3 m-3 bg-danger-subtle"><h3>Ha habido un error al guardar los datos</h3></div> ';
            }
        }

        static function actualizarRegistro($sql)
        {
            $con = self::conectar();
            $query = $con->prepare($sql);
            try {
                $query->execute();
                $con = null;
                return '<div class="p-3 m-3 bg-success-subtle"><h3>Se han editado los datos correctamente</h3></div>';
            } catch (PDOException $e) {
                return '<div class="p-3 m-3 bg-danger-subtle"><h3>Ha habido un error al editar los datos</h3></div> ';
            }
        }

        static function AMDaDMA($fecha)
        {
            $string = strtotime($fecha);
            return date('d-m-Y', $string);
        }
    }
    ?>
    <script>
        $('.btn').click((e) => {sessionStorage.setItem('titulo', $(e.target).text())});
       $(window).on('load', () => {
        $('#titulo-cabecera').text((sessionStorage.getItem('titulo') !== null ? sessionStorage.getItem('titulo') : 'Inicio') )
       })
    </script>
</body>

</html>