<?php

class ColorModelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function obtenerColores(){
        $query = "SELECT * FROM colores";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}