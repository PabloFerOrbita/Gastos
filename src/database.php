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
     * [opcional] Los campos que deseas obtener, si está vacío se buscaran todos los campos
     * @param string $parametroBusqueda 
     * [opcional] El campo a partir del cual se quiere filtrar la búsqueda.
     * @param mixed $valorAbuscar 
     * [opcional] El valor que el campo por el que se filtra la búsqueda debe tener. 
     */
    public function obtener_datos(string $tabla, array $campos = [], string $parametroBusqueda = '', mixed $valorAbuscar = 0): array
    {
        $con = self::conexion();
        $sql = 'SELECT ';
        if (count($campos) > 0) {
            $ultimo = array_key_last($campos);
            foreach ($campos as $indice => $campo) {
                $sql .= $campo;
                if ($indice !== $ultimo) {
                    $sql .= ', ';
                }
            }
        } else {
            $sql .= '*';
        }
        $sql .= ' FROM ' . $tabla;

        if ($parametroBusqueda !== '') {
            $sql .= ' WHERE ' . $parametroBusqueda;
            if (is_string($valorAbuscar)) {
                $sql .= ' like "%' . $valorAbuscar . '%"';
            } else if (is_int($valorAbuscar) || is_double($valorAbuscar)) {
                $sql .= ' = ' . $valorAbuscar;
            }
        }
        $query = $con->prepare($sql);
        try {
            if ($query->execute()) {
                $datos = $query->fetchAll();
                return $datos;
            }
            return ['Error' => 'Fallo al ejecutar la sentencia'];
        } catch (PDOException $e) {
            return ['Error' => $e->getMessage()];
        }
    }

    /**
     * Eliminar el registro correspondiente
     * 
     * @param int $ID
     * El id del registro que se desea eliminar
     * @param string $tabla
     * La tabla de la cual se desea eliminar el registro
     * @return bool
     * devolverá true si el registro se ha eliminado, false si no.
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

    /**
     * Modifica los valores deseados de la tabla indicada
     * @return null|bool
     * Devuelve true si se ha modificado algún parámetro, false si ningún registro se ha visto afectado y NULL si ha habido un error.
     * @param string $tabla
     * La tabla de la cual se quieren modificar los valores
     * @param array $camposAmodificar
     * Los campos que se quiere modificar
     * @param array $valoresNuevos
     * Los valores que se desea introducir en esos campos, en el mismo orden que el de los campos que se quieren cambiar; en caso de tener claves,
     * tambíen deben ser las mismas.
     * @param string $parametroBusqueda
     * [opcional] el parámetro que indica que registro quieres modificar, en el caso de estar vacío, se modificarán todos los registros
     * @param mixed $valorAbuscar
     * [opcional] el valor que el campo del registro que se quiere modificar debe tener según el parámetro de búsqueda.
     */

    public function modificar(string $tabla, array $camposAmodificar, array $valoresNuevos, string $parametroBusqueda = '', mixed $valorAbuscar = 0): ?bool
    {
        $con = self::conexion();
        $sql = 'UPDATE ' . $tabla . ' SET ';
        if ((count($camposAmodificar) == count($valoresNuevos)) && (array_keys($camposAmodificar) == array_keys($valoresNuevos))) {
            $ultimo_indice = array_key_last($camposAmodificar);
            foreach ($camposAmodificar as $indice => $campo) {
                if (is_string($valoresNuevos[$indice])) {
                    $sql .= $campo . ' = "' . $valoresNuevos[$indice] . '"';
                } else if (is_double($valoresNuevos[$indice]) || $valoresNuevos[$indice]) {
                    $sql .= $campo . ' = ' . $valoresNuevos[$indice];
                }
                if ($indice !== $ultimo_indice) {
                    $sql .= ', ';
                }
            }
            if ($parametroBusqueda !== '') {
                $sql .= ' WHERE ' . $parametroBusqueda;
                if (is_string($valorAbuscar)) {
                    $sql .= ' like "' . $valorAbuscar . '"';
                } else if (is_int($valorAbuscar) || is_double($valorAbuscar)) {
                    $sql .= ' = ' . $valorAbuscar;
                }
            }
            $query = $con->prepare($sql);
            try {
                if ($query->execute()) {
                    if ($query->rowCount() == 0) {
                        return false;
                    }
                    return true;
                }
                return null;
            } catch (PDOException $e) {
                return null;
            }
        }
        return null;
    }

    
}
