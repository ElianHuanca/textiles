<?php
require_once('../conexion/conexion.php');
class CategoriaModelo
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::conectar();
    }
    public function obtenerCategorias(){
        $query = "SELECT * FROM categorias";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}