<?php
class Database {
    private $bd;
    private $servidor;
    private $usuario;
    private $contrasenia;

    public function __construct($bd, $servidor, $usuario, $contrasenia) {
        $this->usuario = $usuario;
        $this->contrasenia = $contrasenia;
        $this->bd = $bd;
        $this->servidor = $servidor;
    }

    /**
     * Devolver la conexion de la base de datos
     * @return mixed;
     */
    public function conexion(){
        try {
            $conexion = new PDO('mysql:host=' . $this->servidor . '; dbname=' . $this->bd, $this->usuario, $this->contrasenia);
            return $conexion;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }

}
?>