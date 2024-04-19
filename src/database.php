<?php
class Database
{
    private $bd;
    private $servidor;
    private $usuario;
    private $contrasenia;

    public function __construct($bd, $servidor, $usuario, $contrasenia)
    {
        $this->usuario = $usuario;
        $this->contrasenia = $contrasenia;
        $this->bd = $bd;
        $this->servidor = $servidor;
    }

    /**
     * Devuelve la conexión de la base de datos
     * 
     * @return mixed
     */
    public function conexion()
    {
        try {
            $conexion = new PDO('mysql:host=' . $this->servidor . '; dbname=' . $this->bd, $this->usuario, $this->contrasenia);
            return $conexion;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }
    /**
     * Obtiene los datos de la tabla escogida
     * 
     * @return array
     * El método devolverá un array con los campos resultantes de la búsqueda, o 
     * un array vacío en el caso de no encontrar nada
     * @param string $tabla
     * La tabla de la que deseas obtener los datos
     * @param array $campos
     * Los campos que deseas obtener
     * @param string $parametroBusqueda 
     * [opcional] El campo a partir del cual se quiere filtrar la búsqueda.
     * @param mixed $valorAbuscar 
     * [opcional] El valor que el campo por el que se filtra la búsqueda debe tener.
     */
    public function obtener_datos(string $tabla, array $campos, string $parametroBusqueda = '', mixed $valorAbuscar = 0): array
    {
        $con = self::conexion();
        if (count($campos) > 0) {
            $sql = 'SELECT ';
            $ultimo = array_key_last($campos);
            foreach ($campos as $indice => $campo) {
                $sql .= $campo;
                if ($indice !== $ultimo) {
                    $sql .= ', ';
                }
            }

            $sql .= ' FROM ' . $tabla;
        } else {
            return [];
        }

        if ($parametroBusqueda !== '') {
            $sql .= ' WHERE ' . $parametroBusqueda;
            if (is_string($parametroBusqueda)) {
                $sql .= ' like "%' . $valorAbuscar . '%"';
            } else if (is_int($parametroBusqueda) || is_double($parametroBusqueda)) {
                $sql .= ' = ' . $valorAbuscar;
            }
        }
        $query = $con->prepare($sql);
        try {
            if ($query->execute()) {
                $datos = $query->fetchAll();
                return $datos;
            }
            return [];
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Eliminar el registro correspondiente
     * 
     * @param int $ID
     * @param string $tabla
     * @return bool
     */

    public function eliminar(int $ID, string $tabla): bool
    {
        $con = self::conexion();
        $query = $con->prepare('DELETE FROM ' . $tabla . ' WHERE ID = ' . $ID);
        try {
            if ($query->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}
