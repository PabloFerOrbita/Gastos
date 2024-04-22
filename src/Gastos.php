<?php
require_once('Database.php');
class Gastos
{
    private $tabla = 'gastos';
    private Database $db;

    public function __construct(){
        $this->db = new Database('contab', 'localhost', 'root', '');
    }

    /**
     * Obtiene todos los datos de la tabla gastos
     * 
     * @return array
     * Devuelve un array con los datos de la tabla gastos
     */
    public function obtener_todos() : array
    {
        return $this->db->obtener_datos($this->tabla);
    }

    /**
     * Elimina un registro de la tabla datos según el ID que se introduzca
     * @param int $ID
     * EL ID del registro que se quiere eliminar
     * @return null|bool
     * Devolverá true si el registro se ha eliminado, false si no o null si ha habido algún error
     * 
     */
    public function eliminar_gasto(int $ID){
        return $this->db->eliminar($ID, $this->tabla);
    }

    
}
