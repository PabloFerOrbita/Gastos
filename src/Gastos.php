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
    public function eliminar_gasto(int $ID) : ?bool
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

    public function obtener_gasto(int $ID) : array
    {
        return $this->db->obtener_datos($this->tabla, [], 'ID', $ID);
    }
}
