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
    
    public function InstalarTabla() : bool
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


}
