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
}
