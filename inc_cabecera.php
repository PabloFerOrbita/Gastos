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
        echo '<table border=1>';
        echo '<tr>';
        echo '<th>Fecha</th><th>importe</th><th>descripcion</th><th>Modificar</th>';
        echo '</tr>';
        foreach ($gastos as $gasto) {
            echo '<tr><td> ' . self::AMDaDMA($gasto['fecha']) . ' </td><td> ' .$gasto['importe'] . ' </td><td> ' . $gasto['descripcion'] . ' </td><td> <a type="button" href="modificar.php">Modificar</a> </td></tr>';
        }
        echo '</table>';
        $con = null;
    }
   

    static function AMDaDMA($fecha){
        $string = strtotime($fecha);
        return date('d-m-Y', $string);
    }
}
