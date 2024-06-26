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
            echo 'Error al conectarse a la base de datos';
            die;
        }
    }


    /**
     * Obtiene los datos de la tabla escogida
     * 
     *
     * @param string $tabla
     * La tabla de la que deseas obtener los datos
     * @param array $campos
     * [opcional] Los campos que deseas obtener, si está vacío se buscaran todos los campos
     * @param string $parametroBusqueda 
     * [opcional] El campo a partir del cual se quiere filtrar la búsqueda.
     * @param mixed $valorAbuscar 
     * [opcional] El valor que el campo por el que se filtra la búsqueda debe tener. 
     *  @return array
     * El método devolverá un array con los campos resultantes de la búsqueda, o 
     * un array vacío en el caso de no encontrar nada
     */
    public function obtener_datos(string $tabla, array $campos = [], string $parametroBusqueda = '', mixed $valorAbuscar = '', string $join = ''): array
    {
        $con = self::conexion();
        $sql = 'SELECT ';
        if (count($campos) > 0) {
            $sql .= implode(',', $campos);
        } else {
            $sql .= '*';
        }
        $sql .= ' FROM ' . $tabla . $join;

        if ($parametroBusqueda !== '' && $valorAbuscar !== '') {
            $sql .= $this->busqueda($parametroBusqueda, $valorAbuscar, ($join !== ''));
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
     * 
     * @param int $ID
     * El id del registro que se desea eliminar
     * @param string $tabla
     * La tabla de la cual se desea eliminar el registro
     * @return null|bool
     * devolverá true si el registro se ha eliminado, false si no o null si ha habido algún error
     * 
     */

    public function eliminar(int $ID, string $tabla): ?bool
    {
        $con = self::conexion();
        $query = $con->prepare('DELETE FROM ' . $tabla . ' WHERE ID = ' . $ID);
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

    /**
     * Modifica los valores deseados de la tabla indicada
     * 
     * @param string $tabla
     * La tabla de la cual se quieren modificar los valores
     * @param array $camposAmodificar
     * Los campos que se quiere modificar junto con los valores que se les desean añadir, debe seguir la siguiente sintaxis
     * [Nombre del campo => valor nuevo]
     * @param string $parametroBusqueda
     * [opcional] el parámetro que indica que registro quieres modificar, en el caso de estar vacío, se modificarán todos los registros
     * @param mixed $valorAbuscar
     * [opcional] el valor que el campo del registro que se quiere modificar debe tener según el parámetro de búsqueda.
     * @return null|bool
     * Devuelve true si se ha modificado algún parámetro, false si ningún registro se ha visto afectado y NULL si ha habido un error.
     */

    public function modificar(string $tabla, array $camposAmodificar, string $parametroBusqueda = '', mixed $valorAbuscar = ''): ?bool
    {
        $con = self::conexion();
        if (count($camposAmodificar) > 0) {
            $sql = 'UPDATE ' . $tabla . ' SET ';
            $ultimo_indice = array_key_last($camposAmodificar);
            foreach ($camposAmodificar as $indice => $campo) {
                if (is_bool($campo)) {
                    $sql .= $indice . ' = ' . (int) $campo;
                } elseif (is_numeric($campo)) {
                    $sql .= $indice . ' = ' . $campo;
                } else if (is_string($campo)) {
                    $sql .= $indice . " = '" . str_replace("'", "''", $campo) . "'";
                }
                if ($indice !== $ultimo_indice) {
                    $sql .= ', ';
                }
            }
            if ($parametroBusqueda !== '' && $valorAbuscar !== '') {
                $sql .= $this->busqueda($parametroBusqueda, $valorAbuscar);
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

    /**
     * Obtiene el total de registros en la tabla especificada
     * 
     * 
     * @param string $tabla
     * La tabla de la cual quieres obtener el total
     * @param string $parametroBusqueda
     * [opcional] El campo a partir del cual se quiere filtrar la búsqueda
     * @param mixed $valorAbuscar
     * [opcional] El valor que el campo a partir del cual se quiere filtrar la búsqueda debe tener
     * @return null|int
     * Devuelve el un int con el total de tablas en caso de funcionar todo o NULL en caso de haber algún error
     */
    public function obtener_total(string $tabla, string $parametroBusqueda = '', mixed $valorAbuscar = ''): ?int
    {
        $con = self::conexion();
        $sql = 'SELECT COUNT(*) as total FROM ' . $tabla;
        if ($parametroBusqueda !== '' && $valorAbuscar !== '') {
            $sql .= $this->busqueda($parametroBusqueda, $valorAbuscar);
        }
        $query = $con->prepare($sql);
        try {
            if ($query->execute()) {

                $datos = $query->fetchColumn();
                return $datos;
            }
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Inserta un nuevo registro en la tabla indicada con los datos indicados
     * 
     * @param string $tabla
     * El nombre de la tabla en la que se desean introducir los datos
     * @param array $datos
     * Los valores que se le desean dar a cada uno de las columnas de la tabla, en 
     * el orden correspondiente
     * @return bool
     * Devuelve true en el caso de que se inserten los datos o false en caso de error
     */
    public function aniadir(string $tabla, array $datos): bool
    {

        if (count($datos) > 0) {
            $con = self::conexion();
            $sql = "INSERT INTO " . $tabla . " values (NULL, ";
            $ultimo_indice = array_key_last($datos);
            foreach ($datos as $indice => $dato) {
                if (is_bool($dato)) {
                    $sql .= (int) $dato;
                } elseif (is_numeric($dato)) {
                    $sql .= $dato;
                } else if (is_string($dato)) {
                    $sql .= "'" . str_replace("'", "''", $dato) . "'";
                }
                if ($indice !== $ultimo_indice) {
                    $sql .= ', ';
                }
            }
            $sql .= ')';
            $query = $con->prepare($sql);
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

    /**
     * Obtiene la suma de todos los registros del campo especificado en la tabla especificada
     * @return null|float
     * Devuelve un float con el total de todos los gastos, o null en caso de error
     */
    public function suma(string $tabla, string $campo): ?float
    {
        $con = self::conexion();
        $sql = "SELECT SUM(" . $campo . ") FROM " . $tabla;
        $query = $con->prepare($sql);
        try {
            if ($query->execute()) {
                $datos = $query->fetchColumn();
                return $datos;
            }
            return null;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }


    /**
     * Añade el WHERE a la sentencia sql correspondiente según el tipo de valor que se utilice
     * 
     * 
     * @param string $parametroBusqueda
     * El campo a partir del cual se quiere filtrar la búsqueda
     * @param mixed $valorAbuscar
     *  El valor que el campo a partir del cual se quiere filtrar la búsqueda debe tener
     * @return string
     * Devuelve el string que se debe añadir a la sentencia sql para poder filtrar los resultados
     */

    private function busqueda(string $parametroBusqueda, mixed $valorAbuscar, bool $join = false): string
    {
        if (is_bool($valorAbuscar)) {
            return ($join ? ' and ' : ' WHERE ') . $parametroBusqueda . ' = ' . (int) $valorAbuscar;
        }
        if (is_numeric($valorAbuscar)) {
            return ($join ? ' and ' : ' WHERE ') . $parametroBusqueda . ' = ' . $valorAbuscar;
        }
        if (is_string($valorAbuscar)) {
            return ($join ? ' and ' : ' WHERE ') . $parametroBusqueda . ' like "%' . $valorAbuscar . '%"';;
        }

        return '';

    }
}
