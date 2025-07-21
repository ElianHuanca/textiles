<?php

class TipoGastoModelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function obtenerTiposGastos(){
        $query = "SELECT * FROM tipos_gastos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}