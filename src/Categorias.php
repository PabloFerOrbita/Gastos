<?php
class Categorias
{
    private $tabla = 'categorias';
    private Database $db;

    public function __construct()
    {
        $this->db = new Database('camb', 'localhost', 'root', '');
    }


}
