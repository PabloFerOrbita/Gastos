<?php
require_once('Database.php');
class Categorias
{
    private $tabla = 'categorias';
    private Database $db;

    public function __construct()
    {
        $this->db = new Database('contab', 'localhost', 'root', '');
    }

    /**
     * Crea la tabla Categorias si no existe
     * 
     * @return bool
     * Devuelve TRUE si la tabla se ha creado o ya existe, y FALSE si ha habido un error a la hora
     * de ejecutar la sentencia sql; 
     */

    public function InstalarTabla(): bool
    {
        $con = $this->db->conexion();
        $sql = 'CREATE TABLE IF NOT EXISTS CATEGORIAS (
            id INT(11) UNSIGNED NOT NULL auto_increment,
            nombre VARCHAR(255) NOT NULL,
            PRIMARY KEY (id))';
        $query = $con->prepare($sql);
        try {
            if ($query->execute()) {
                return true;
            }
            echo 'Ha habido un error a la hora de crear la tabla';
            return false;
        } catch (PDOException $e) {
            echo 'Ha habido un error a la hora de crear la tabla ';
            return false;
        }
    }

    /**
     * Obtiene los datos de la tabla categorias según el filtro que se aplique, o todos si no
     * se aplica ninguno.
     * 
     * @param string $filter
     * [opcional] El campo a partir del cuál se quieren filtrar los datos
     * @param mixed $valor
     * [opcional] El valor que debe tener el campo de filtro
     * @return array
     * Devuelve un array con los datos obtenidos o con un mensaje de error.
     */

    public function obtener(string $filter = '', mixed $valor = ''): array
    {
        return $this->db->obtener_datos('categorias', [], $filter, $valor);
    }

    /**
     * Elimina el registro correspondiente de la tabla categorias
     * 
     * @param int $id
     * El id del registro que se desea eliminar
     * @return null|bool
     * Devuelve true si se ha eliminado algún registro, false si no y null si ha habido algún error
     */
    public function eliminar(int $id): ?bool
    {
        return $this->db->eliminar($id, $this->tabla);
    }
    /**
     * Modifica los campos deseados
     * 
     * @param array $datos
     * Los campos que se quiere modificar junto con los valores que se les desean añadir, debe seguir la siguiente sintaxis
     * [Nombre del campo => valor nuevo]
     * @param string $filtro
     * [opcional] el parámetro que indica que registro quieres modificar, en el caso de estar vacío, se modificarán todos los registros
     * @param mixed $valor
     * [opcional] el valor que el campo del registro que se quiere modificar debe tener según el parámetro de búsqueda.
     * @return null|bool
     * Devuelve true si se ha modificado algún parámetro, false si ningún registro se ha visto afectado y NULL si ha habido un error.
     */
    public function actualizar(array $datos, string $filtro = '', mixed $valor = ''): ?bool
    {
        return $this->db->modificar($this->tabla, $datos, $filtro, $valor);
    }
    /**
     * Inserta un nuevo registro en la tabla categorias indicada con los datos indicados
     * 
     * @param array $datos
     * Los valores que se le desean dar a cada uno de las columnas de la tabla, en 
     * el orden correspondiente
     * @return bool
     * Devuelve true en el caso de que se inserten los datos o false en caso de error
     */
    public function aniadir(array $datos) : bool
    {
        return $this->db->aniadir($this->tabla, $datos);
    }

    /**
     * Obtiene el total de registros en la tabla categorias
     * @return null|int
     * Devuelve el total de registros en el caso de funcionar o null en el caso de haber
     * un error
     */
    public function total(){
        return $this->db->obtener_total($this->tabla);
    }
}
