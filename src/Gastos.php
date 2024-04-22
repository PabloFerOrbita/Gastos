<?php
require_once('Database.php');
class Gastos
{
    private $tabla = 'gastos';

    /**
     * Obtiene todos los datos de la tabla gastos
     * 
     * @return array
     * Devuelve un array con los datos de la tabla gastos
     */
    public function obtener_todos()
    {
        $database = new Database('contab', 'localhost', 'root', '');
        return $database->obtener_datos($this->tabla);
    }

    
}
