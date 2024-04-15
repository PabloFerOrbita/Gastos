<?php
class Inc_cabecera
{
    static function insertarBotones()
    {
        echo '<button id="buscar">Buscar</button><br><br>';
        echo '<button id="listado">Listado</button><br><br>';
        echo '<button id="nuevo">Nuevo</button><br><br>';
    }
    static function cabecera()
    {
        echo '<h1>Ejemplo de Cabecera</h1>';
    }

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
                echo '<tr><td> ' . self::AMDaDMA($gasto['fecha']) . ' </td><td> ' . $gasto['descripcion'] . ' </td><td> ' . $gasto['importe'] . ' </td>';
                if (array_key_exists('categoria', $gasto)) {
                    echo '<td> ' . $gasto['categoria'] . ' </td>';
                }
                echo '<td> <a type="button" href="modificar.php">Modificar</a> </td></tr>';
            }
            echo '</table>';
        } else {
            echo '<h4>No se han encontrado registros</h4>';
        }

        $con = null;
    }

    static function contar(){
        $con = self::conectar();
        $query = $con->prepare('SELECT COUNT(*) FROM gastos');
        $query->execute();
        $numero =  $query->fetchColumn();
        $con = null;
        return $numero;

    }

    static function insertar($sql){
        $con = self::conectar();
        $query = $con->prepare($sql);
        try {
            $query->execute();
            $con = null;
            return '<h3>Se han guardado los datos correctamente';
        } catch(PDOException $e){
            return '<h3>Ha habido un error al guardar los datos</h3> ' . $e->getMessage();
        }
        
    }

    static function AMDaDMA($fecha)
    {
        $string = strtotime($fecha);
        return date('d-m-Y', $string);
    }
}
