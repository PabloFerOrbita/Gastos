<button id="inicio">Inicio</button>
<button id="buscar">Buscar</button>
<button id="listado">Listado</button>
<button id="nuevo">Nuevo</button>

<h1>Ejemplo de Cabecera</h1>
<?php
class Inc_cabecera
{


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
            echo $e->getMessage();
        }
    }
    static function MostrarLista($sql)
    {
        $con = self::conectar();
        $query = $con->prepare($sql);
        $query->execute();
        $gastos = $query->fetchAll();
        if (count($gastos) > 0) {
            echo '<table border=1>';
            echo '<tr>';
            echo '<th>Fecha</th><th>Importe</th><th>Descripcion</th>';
            if (array_key_exists('categoria', $gastos[0])) {
                echo '<th>Categoria</th>';
            }
            echo '<th>Modificar</th>';
            echo '</tr>';

            foreach ($gastos as $gasto) {
                echo '<tr><td> ' . self::AMDaDMA($gasto['fecha']) . ' </td><td> ' . $gasto['importe'] . ' </td><td> ' . $gasto['descripcion'] . ' </td>';
                if (array_key_exists('categoria', $gasto)) {
                    echo '<td> ' . $gasto['categoria'] . ' </td>';
                }
                echo '<td> <a type="button" href="modificar.php?descripcion=' . $gasto['descripcion'] . '">Modificar</a> </td></tr>';
            }
            echo '</table>';
        } else {
            echo '<h4>No se han encontrado registros</h4>';
        }

        $con = null;
    }

    static function contar()
    {
        $con = self::conectar();
        $query = $con->prepare('SELECT COUNT(*) FROM gastos');
        $query->execute();
        $numero =  $query->fetchColumn();
        $con = null;
        return $numero;
    }

    static function recibirRegistro($descripcion)
    {
        $con = self::conectar();
        $query = $con->prepare('SELECT * FROM gastos WHERE descripcion like "' . $descripcion . '"');
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
            return '<h3>Se han guardado los datos correctamente';
        } catch (PDOException $e) {
            return '<h3>Ha habido un error al guardar los datos</h3> ';
        }
    }

    static function actualizarRegistro($sql)
    {
        $con = self::conectar();
        $query = $con->prepare($sql);
        try {
            $query->execute();
            $con = null;
            return '<h3>Se han editado los datos correctamente';
        } catch (PDOException $e) {
            return '<h3>Ha habido un error al editar los datos</h3> ' . $e->getMessage();
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
$('#inicio').on('click', ()=>(window.location.href="index.php"));
$('#buscar').on('click', ()=>{window.location.href="buscar.php"});
$('#listado').on('click', ()=>{window.location.href="listado.php"});
$('#nuevo').on('click', ()=>{window.location.href="nuevo.php"});
</script>
