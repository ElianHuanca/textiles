<?php
require_once('../conexion/conexion.php');

class TipoGastoModelo
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::conectar();
    }
        
    public function obtenerTiposGastos(){
        $query = "SELECT * FROM tipos_gastos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}