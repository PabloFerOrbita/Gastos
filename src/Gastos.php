<?php
require_once('Database.php');
class Gastos
{
    private $tabla = 'gastos';
    private Database $db;

    public function __construct()
    {
        $this->db = new Database('contab', 'localhost', 'root', '');
    }

    /**
     * Obtiene todos los datos de la tabla gastos
     * 
     * @return array
     * Devuelve un array con los datos de la tabla gastos
     */
    public function obtener_todos(): array
    {
        return $this->db->obtener_datos($this->tabla);
    }

    /**
     * Elimina un registro de la tabla gastos según el ID que se introduzca
     * @param int $ID
     * EL ID del registro que se quiere eliminar
     * @return null|bool
     * Devolverá true si el registro se ha eliminado, false si no o null si ha habido algún error
     * 
     */
    public function eliminar_gasto(int $ID): ?bool
    {
        return $this->db->eliminar($ID, $this->tabla);
    }

    /**
     * Obtiene un registro de la tabla gastos según el ID que se introduzca
     * @param int $ID 
     * El ID del registro que se desea obtener
     * @return array
     * Devuelve un array con los datos del registro obtenido
     */

    public function obtener_gasto(int $ID): array
    {
        return $this->db->obtener_datos($this->tabla, [], 'ID', $ID);
    }

    /**
     * Obtiene el total de todos los gastos
     * @return null|float
     * Devuelve un float con el total de todos los gastos, o null en caso de error
     */

    public function obtener_gasto_total() : ?float
    {
       return $this->db->suma($this->tabla, 'importe');
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
    public function aniadir(array $datos): bool
    {
        return $this->db->aniadir($this->tabla, $datos);
    }


}
