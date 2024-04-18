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
     * Devuelve la conexión de la base de datos
     * 
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
    //TODO terminar obtener_datos
    public function obtener_datos($tabla, $numero){
        $con = self::conexion();
        $query = $con->prepare('SELECT * FROM ' . $tabla);
        try{
        if($query->execute()){
            $datos = $query->fetchAll();

        }
        

        }catch(PDOException $e){
            $e->getMessage();
        }
        
    }

    

     

}
?>